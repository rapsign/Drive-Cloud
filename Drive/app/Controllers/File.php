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

        // Check if session data exists
        $userId = session()->get('id');
        $username = session()->get('name');
        if (!$userId || !$username) {
            // Handle session data absence
            session()->setFlashdata('error_message', 'Session data not found!');
            return;
        }

        // Get total file size for the user
        $size = $this->fileModel->getTotalFileSize($userId);
        $maxStorage = 16106127360; // 15 GB in bytes

        foreach ($files as $file) {
            // Check if adding the file exceeds storage limit
            if ($size + $file->getSize() > $maxStorage) {
                session()->setFlashdata('error_message', 'Your storage is full!');
                return;
            }

            // Determine directory to save file
            $userDir = FCPATH . 'files' .  DIRECTORY_SEPARATOR  . $username;

            // Create directory if not exists
            if (!is_dir($userDir)) {
                mkdir($userDir, 0777, true);
            }

            // Get original file name
            $originalName = $file->getName();

            // Initialize new file name
            $newName = $originalName;

            // Ensure unique file name
            $counter = 1;
            while (file_exists($userDir . DIRECTORY_SEPARATOR . $newName)) {
                $newName = pathinfo($originalName, PATHINFO_FILENAME) . '_' . $counter . '.' . pathinfo($originalName, PATHINFO_EXTENSION);
                $counter++;
            }

            // Move file to directory with new name
            $file->move($userDir, $newName);

            // Save file information to database
            $this->fileModel->save([
                'user_id' => $userId,
                'file_name' => $newName,
                'file_size' => $file->getSize(),
                'file_type' => $file->getClientMimeType(),
                'file_path' => 'files' .  DIRECTORY_SEPARATOR . $username .  DIRECTORY_SEPARATOR,
            ]);
        }

        // Display success message
        session()->setFlashdata('success_message', 'File(s) added successfully!');
    }

    public function addFileInFolder($slug)
    {
        $files = $this->request->getFiles();
        $folder = $this->folderModel->where('slug', $slug)->first();

        if (!$folder) {
            // Handle folder not found
            session()->setFlashdata('error_message', 'Folder not found!');
            return;
        }

        // Get user information
        $userId = session()->get('id');
        $username = session()->get('name');

        foreach ($files as $file) {
            // Determine directory to save file
            $userDir = FCPATH . $folder['folder_path'] . $folder['folder_name'];

            // Create directory if not exists
            if (!is_dir($userDir)) {
                mkdir($userDir, 0777, true);
            }

            // Get original file name
            $originalName = $file->getName();

            // Initialize new file name
            $newName = $originalName;

            // Ensure unique file name
            $counter = 1;
            while (file_exists($userDir . DIRECTORY_SEPARATOR . $newName)) {
                $newName = pathinfo($originalName, PATHINFO_FILENAME) . '_' . $counter . '.' . pathinfo($originalName, PATHINFO_EXTENSION);
                $counter++;
            }

            // Move file to directory with new name
            $file->move($userDir, $newName);

            // Save file information to database
            $this->fileModel->save([
                'user_id' => $userId,
                'file_name' => $newName,
                'file_size' => $file->getSize(),
                'file_type' => $file->getClientMimeType(),
                'file_path' =>  $folder['folder_path'] . $folder['folder_name'] . DIRECTORY_SEPARATOR,
                'folder_id' => $folder['id']
            ]);
        }

        // Display success message
        session()->setFlashdata('success_message', 'File(s) added successfully!');
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
            return redirect()->back();
        }

        $oldFileName = $file['file_name'];
        $baseFilePath = $file['file_path'];
        $oldFilePath = FCPATH .  DIRECTORY_SEPARATOR . $baseFilePath . DIRECTORY_SEPARATOR . $oldFileName;
        $newFilePath = FCPATH .  DIRECTORY_SEPARATOR . $baseFilePath . DIRECTORY_SEPARATOR . $newFileName . '.' . $fileExt;

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
            $newFilePath = FCPATH .  DIRECTORY_SEPARATOR . $baseFilePath . $newFileNameWithCounter . '.' . $fileExt;
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

        return redirect()->back();
    }
    public function moveToTrash()
    {
        $fileId = $this->request->getVar('fileId');
        $this->fileModel->where('id', $fileId)->delete();
        session()->setFlashdata('success_message', 'File move to trash');
        return redirect()->back();
    }
    public function restoreFile()
    {
        $fileId = $this->request->getVar('fileId');

        $this->fileModel->save([
            'id' => $fileId,
            'deleted_at' => null,
        ]);

        session()->setFlashdata('success_message', 'File restored successfully!');
        return redirect()->back();
    }

    public function deleteFile()
    {
        $fileId = $this->request->getVar('fileId');
        $file = $this->fileModel->getFileById($fileId);
        $username = session()->get('name');
        $fileName = $this->request->getVar('fileName');
        $filePath = FCPATH . $file['file_path'] . $fileName;
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

        $fileDir = FCPATH .  DIRECTORY_SEPARATOR . $file['file_path'] . DIRECTORY_SEPARATOR . $fileName;
        $userDir = FCPATH .  DIRECTORY_SEPARATOR . $folder['folder_path'];
        $targetDir = $userDir . $folder['folder_name'];

        $newFileName = $fileName; // Nama file baru, default sama dengan yang ada
        $file = new \CodeIgniter\Files\File($fileDir);
        // Cek apakah file dengan nama yang sama sudah ada di folder tujuan
        $i = 1;
        while (is_file($targetDir . DIRECTORY_SEPARATOR . $newFileName)) {
            // Jika file dengan nama yang sama ditemukan, tambahkan _1, _2, dst. ke nama file
            $path_parts = pathinfo($fileDir); // Menggunakan $fileDir di sini
            $newFileName = $path_parts['filename'] . '_' . $i . '.' . $path_parts['extension'];
            $i++;
        }

        // Move file to target directory with new file name
        if ($file->move($targetDir . DIRECTORY_SEPARATOR, $newFileName)) {
            // Perbarui nilai $fileDir setelah pemindahan file
            $fileDir = $targetDir . DIRECTORY_SEPARATOR . $newFileName;

            // Simpan informasi file yang dipindahkan ke basis data
            $this->fileModel->save([
                'id' => $fileId,
                'file_name' => $newFileName,
                'folder_id' => $folder['id'],
                'file_path' => $folder['folder_path'] . $folder['folder_name'] . DIRECTORY_SEPARATOR
            ]);

            session()->setFlashdata('success_message', 'File moved successfully!');
        } else {
            session()->setFlashdata('error_message', 'Failed to move file!');
        }

        return redirect()->back();
    }

    public function downloadFile($fileName)
    {
        $file = $this->fileModel->where('file_name', $fileName)->first();
        // Lokasi file untuk di-download
        $filePath = FCPATH . $file['file_path'] . DIRECTORY_SEPARATOR . $fileName;

        // Pastikan file ada
        if (file_exists($filePath)) {
            // Konfigurasi header untuk tipe konten
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $fileName . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filePath));

            // Baca file
            readfile($filePath);
            exit;
        } else {
            // File tidak ditemukan
            die('File not found.');
        }
    }
}
