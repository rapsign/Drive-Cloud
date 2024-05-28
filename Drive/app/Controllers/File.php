<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\FilesModel;
use App\Models\FolderModel;
use CodeIgniter\HTTP\ResponseInterface;

class File extends BaseController
{

    protected $fileModel;
    protected $folderModel;

    public function __construct()
    {
        $this->fileModel = new FilesModel();
        $this->folderModel = new FolderModel();
    }
    public function addFile()
    {
        $files = $this->request->getFiles();

        foreach ($files as $file) {
            // Dapatkan informasi pengguna
            $userId = session()->get('id');
            $username = session()->get('name');

            // Tentukan direktori untuk menyimpan file
            $userDir = FCPATH . 'files/' . $username;

            // Buat direktori jika belum ada
            if (!is_dir($userDir)) {
                mkdir($userDir, 0777, true);
            }

            // Dapatkan nama file asli
            $originalName = $file->getName();

            // Inisialisasi nama file baru
            $newName = $originalName;

            // Periksa apakah file dengan nama yang sama sudah ada
            $counter = 1;
            while (file_exists($userDir . '/' . $newName)) {
                $newName = pathinfo($originalName, PATHINFO_FILENAME) . '_' . $counter . '.' . pathinfo($originalName, PATHINFO_EXTENSION);
                $counter++;
            }

            // Pindahkan file ke direktori dengan nama baru
            $file->move($userDir, $newName);
            // Simpan informasi file ke database
            $this->fileModel->save([
                'user_id' => $userId,
                'file_name' => $newName,
                'file_size' => $file->getSize(),
                'file_type' => $file->getClientMimeType(),
                'file_path' => $userDir . '/'
            ]);
            session()->setFlashdata('success_message', 'File added successfully!');
        }
    }
    public function renameFile()
    {
        $fileId = $this->request->getVar('id');
        $newFileName = $this->request->getVar('file_name');
        $fileExt = $this->request->getVar('ext');
        $username = session()->get('name');

        // Get old file details from the database
        $file = $this->fileModel->find($fileId);
        if (!$file) {
            session()->setFlashdata('error_message', 'File not found!');
            return redirect()->to('/user');
        }

        $oldFileName = $file['file_name'];
        $baseFilePath = $file['file_path'];
        $oldFilePath = $baseFilePath . '/' . $oldFileName;
        $newFilePath = $baseFilePath . '/' . $newFileName . '.' . $fileExt;

        // Check if the new file name is the same as the old one
        if ($newFileName === pathinfo($oldFileName, PATHINFO_FILENAME)) {
            session()->setFlashdata('error_message', 'New file name is the same as the old one.');
            return redirect()->to('/user');
        }
        $newFileNameWithCounter = $newFileName;
        // Append suffix if the new file already exists

        $counter = 1;
        while (file_exists($newFilePath)) {
            $newFileNameWithCounter = $newFileName . '_' . $counter;
            $newFilePath = $baseFilePath . $newFileNameWithCounter . '.' . $fileExt;
            $counter++;
        }

        // Attempt to rename the file
        if (rename($oldFilePath, $newFilePath)) {
            // Update database only if rename is successful
            $this->fileModel->save([
                'id' => $fileId,
                'file_name' => $newFileNameWithCounter . '.' . $fileExt,
                'file_path' => $baseFilePath
            ]);

            session()->setFlashdata('success_message', 'File renamed successfully!');
        } else {
            session()->setFlashdata('error_message', 'Failed to rename the file.');
        }

        return redirect()->to('/user');
    }
    public function moveToTrash()
    {
        $fileId = $this->request->getVar('fileId');
        $this->fileModel->where('id', $fileId)->delete();
        session()->setFlashdata('success_message', 'File move to trash');
        return redirect()->to('/user');
    }
    public function restoreFile()
    {
        $fileId = $this->request->getVar('fileId');

        $this->fileModel->save([
            'id' => $fileId,
            'deleted_at' => null,
        ]);

        session()->setFlashdata('success_message', 'File restored successfully!');
        return redirect()->to('/user/trash');
    }

    public function deleteFile()
    {
        $fileId = $this->request->getVar('fileId');
        $file = $this->fileModel->getFileById($fileId);
        $username = session()->get('name');
        $fileName = $this->request->getVar('fileName');
        $filePath = $file['file_path'];

        // Hapus file dari server
        if (file_exists($filePath)) {
            unlink($filePath); // Menghapus file
            session()->setFlashdata('success_message', 'File deleted successfully!');
            $this->fileModel->withDeleted()->where('id', $fileId)->purgeDeleted();
            return redirect()->to('/user/trash');
        } else {
            session()->setFlashdata('error_message', 'File not found!');
        }
    }


    public function moveFile()
    {
        $fileId = $this->request->getPost('file_id');
        $targetFolderSlug = $this->request->getPost('target_folder');
        $file = $this->fileModel->where('id', $fileId)->first();
        $fileName = $this->request->getPost('file_name');
        $username = session()->get('name');
        $folder = $this->folderModel->getFolderBySlug($targetFolderSlug);

        $fileDir = $file['file_path'] . '/' . $fileName;
        $userDir = FCPATH . 'files/' . $username . '/';
        $targetDir = $userDir . $folder['folder_name'];

        $newFileName = $fileName; // Nama file baru, default sama dengan yang ada
        $file = new \CodeIgniter\Files\File($fileDir);
        // Cek apakah file dengan nama yang sama sudah ada di folder tujuan
        $i = 1;
        while (is_file($targetDir . '/' . $newFileName)) {
            // Jika file dengan nama yang sama ditemukan, tambahkan _1, _2, dst. ke nama file
            $path_parts = pathinfo($fileDir); // Menggunakan $fileDir di sini
            $newFileName = $path_parts['filename'] . '_' . $i . '.' . $path_parts['extension'];
            $i++;
        }

        // Move file to target directory with new file name
        if ($file->move($targetDir . '/', $newFileName)) {
            // Perbarui nilai $fileDir setelah pemindahan file
            $fileDir = $targetDir . '/' . $newFileName;

            // Simpan informasi file yang dipindahkan ke basis data
            $this->fileModel->save([
                'id' => $fileId,
                'file_name' => $newFileName,
                'folder_id' => $folder['id'],
                'file_path' => $targetDir
            ]);

            session()->setFlashdata('success_message', 'File moved successfully!');
        } else {
            session()->setFlashdata('error_message', 'Failed to move file!');
        }

        return redirect()->to('/user');
    }
}
