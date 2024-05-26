<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\FilesModel;
use CodeIgniter\HTTP\ResponseInterface;

class File extends BaseController
{

    protected $fileModel;

    public function __construct()
    {
        $this->fileModel = new FilesModel();
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
            ]);
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
        $baseFilePath = FCPATH . 'files/' . $username . '/';
        $oldFilePath = $baseFilePath . $oldFileName;
        $newFilePath = $baseFilePath . $newFileName . '.' . $fileExt;

        // Check if the new file name is the same as the old one
        if ($newFileName === pathinfo($oldFileName, PATHINFO_FILENAME)) {
            session()->setFlashdata('error_message', 'New file name is the same as the old one.');
            return redirect()->to('/user');
        }

        // Check if the new file already exists
        if (file_exists($newFilePath)) {
            session()->setFlashdata('error_message', 'A file with the same name already exists.');
            return redirect()->to('/user');
        }

        // Attempt to rename the file
        if (rename($oldFilePath, $newFilePath)) {
            // Update database only if rename is successful
            $this->fileModel->save([
                'id' => $fileId,
                'file_name' => $newFileName . '.' . $fileExt,
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
        $username = session()->get('name');
        $fileName = $this->request->getVar('fileName');
        $filePath = FCPATH . 'files/' . $username . '/' . $fileName;

        // Hapus file dari server
        if (file_exists($filePath)) {
            unlink($filePath); // Menghapus file
            session()->setFlashdata('success_message', 'File deleted successfully!');
            $this->fileModel->withDeleted()->where('id', $fileId)->purgeDeleted();
            return redirect()->to('/user');
        } else {
            session()->setFlashdata('error_message', 'File not found!');
        }
    }
}
