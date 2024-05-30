<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\FilesModel;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\FolderModel;

class Folder extends BaseController
{
    protected $folderModel;
    protected $fileModel;

    public function __construct()
    {
        $this->folderModel = new FolderModel();
        $this->fileModel = new FilesModel();
    }
    public function index()
    {
        //
    }

    public function addFolder()
    {
        helper('text');

        $foldername = $this->request->getVar('folder');
        $userId = $this->request->getVar('userId');
        $username = session()->get('name');

        // Path dasar untuk folder pengguna
        $baseFolderPath = FCPATH . 'files/' . $username . '/';
        $folderPath = $baseFolderPath . $foldername;

        // Tambahkan nomor di belakang nama folder jika sudah ada
        $counter = 2;
        while (is_dir($folderPath)) {
            $foldername = $this->request->getVar('folder') . '_' . $counter;
            $folderPath = $baseFolderPath . $foldername;
            $counter++;
        }

        // Simpan data folder ke database
        $this->folderModel->save([
            'folder_name' => $foldername,
            'user_id' => $userId,
            'slug' => random_string('alnum', 35),
            'folder_path' => $baseFolderPath
        ]);

        // Buat folder di sistem file
        mkdir($folderPath, 0777, true);

        // Set flashdata dan redirect
        session()->setFlashdata('success_message', 'Folder added successfully!');
        return redirect()->to('/user');
    }

    public function renameFolder()
    {
        $folderId = $this->request->getVar('id');
        $newFolderName = $this->request->getVar('folder_name');
        $username = session()->get('name');

        // Dapatkan folder lama dari database
        $folder = $this->folderModel->find($folderId);
        if (!$folder) {
            session()->setFlashdata('error_message', 'Folder not found!');
            return redirect()->to('/user');
        }

        $oldFolderName = $folder['folder_name'];
        $baseFolderPath = $folder['folder_path'];
        $oldFolderPath = $baseFolderPath . '/' . $oldFolderName;
        $newFolderPath = $baseFolderPath . '/' . $newFolderName;

        // Tambahkan nomor di belakang nama folder jika sudah ada
        $counter = 2;
        while (is_dir($newFolderPath) && $newFolderName != $oldFolderName) {
            $newFolderName = $this->request->getVar('folder_name') . '_' . $counter;
            $newFolderPath = $baseFolderPath . $newFolderName;
            $counter++;
        }

        // Ubah nama folder di sistem file
        if (is_dir($oldFolderPath)) {
            rename($oldFolderPath, $newFolderPath);
        }

        // Simpan perubahan nama folder ke database
        $this->folderModel->save([
            'id' => $folderId,
            'folder_name' => $newFolderName,
        ]);

        session()->setFlashdata('success_message', 'Folder renamed successfully!');
        return redirect()->to('/user');
    }

    public function moveToTrash()
    {
        $folderSlug = $this->request->getVar('folderSlug');
        $folder = $this->folderModel->getFolderBySlug($folderSlug);
        $this->folderModel->where('slug', $folderSlug)->delete();
        $this->folderModel->where('parent_id', $folder['id'])->delete();
        session()->setFlashdata('success_message', 'Folder move to trash');
        return redirect()->to('/user');
    }
    public function restoreFolder()
    {
        $folderId = $this->request->getVar('folderId');
        $subFolders = $this->folderModel->withDeleted()->where('parent_id', $folderId)->findAll();

        $this->folderModel->save([
            'id' => $folderId,
            'deleted_at' => null,
        ]);
        foreach ($subFolders as $subFolder) {
            $this->folderModel->save([
                'id' => $subFolder['id'],
                'deleted_at' => null,
            ]);
        }

        session()->setFlashdata('success_message', 'Folder restored successfully!');
        return redirect()->to('/user/trash');
    }
    public function deleteFolder()
    {
        $folderId = $this->request->getVar('folderId');
        $username = session()->get('name');


        $folderName = $this->request->getVar('folderName');
        $folderPath = FCPATH . 'files/' . $username . '/' . $folderName;

        // Hapus direktori dan isinya dari sistem file
        $this->deleteDirectory($folderPath);

        // Soft delete folder dari database
        $this->folderModel->withDeleted()->where('id', $folderId)->purgeDeleted();
        $this->folderModel->withDeleted()->where('parent_id', $folderId)->purgeDeleted();
        session()->setFlashdata('success_message', 'Folder deleted successfully!');
        return redirect()->to('/user/trash');
    }

    // Fungsi untuk menghapus direktori dan semua isinya
    private function deleteDirectory($dir)
    {
        if (!is_dir($dir)) {
            return;
        }

        $files = array_diff(scandir($dir), ['.', '..']);
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? $this->deleteDirectory("$dir/$file") : unlink("$dir/$file");
        }
        rmdir($dir);
    }
    public function moveFolder()
    {
        $folderId = $this->request->getPost('folder_id');
        $targetFolderSlug = $this->request->getPost('target_folder');
        $folder = $this->folderModel->where('id', $folderId)->first();
        $folderName = $this->request->getPost('folder_name');
        $username = session()->get('name');
        $targetFolder = $this->folderModel->getFolderBySlug($targetFolderSlug);

        $folderDir = $folder['folder_path'] . '/' . $folder['folder_name'];
        $targetDir = FCPATH . 'files/' . $username . '/' . $targetFolder['folder_name'];

        $newFolderName = $folderName;
        $i = 1;
        while (is_dir($targetDir . '/' . $newFolderName)) {
            $newFolderName = $folderName . '_' . $i;
            $i++;
        }

        // Move folder and its contents to target directory with new folder name
        if ($this->moveDirectory($folderDir, $targetDir . '/' . $newFolderName)) {
            // Update file paths in the database for all files within the moved folder
            $this->updateFilePaths($folder['id'], $targetFolder['id'], $targetDir . '/' . $newFolderName);

            // Update folder information in the database
            $this->folderModel->save([
                'id' => $folderId,
                'folder_name' => $newFolderName,
                'parent_id' => $targetFolder['id'],
                'folder_path' => $targetDir
            ]);

            session()->setFlashdata('success_message', 'Folder moved successfully!');
        } else {
            session()->setFlashdata('error_message', 'Failed to move folder!');
        }

        return redirect()->to('/user');
    }

    private function moveDirectory($src, $dst)
    {
        $dir = opendir($src);
        @mkdir($dst);
        while (false !== ($file = readdir($dir))) {
            if (($file != '.') && ($file != '..')) {
                if (is_dir($src . '/' . $file)) {
                    $this->moveDirectory($src . '/' . $file, $dst . '/' . $file);
                } else {
                    rename($src . '/' . $file, $dst . '/' . $file);
                }
            }
        }
        closedir($dir);
        rmdir($src);
        return true;
    }

    private function updateFilePaths($oldFolderId, $newFolderId, $newFolderPath)
    {
        $files = $this->fileModel->where('folder_id', $oldFolderId)->findAll();
        foreach ($files as $file) {
            $filePath = str_replace($file['file_path'], $newFolderPath, $file['file_path']);
            $this->fileModel->save([
                'id' => $file['id'],
                'file_path' => $filePath,
            ]);
        }

        // Recursively update subfolders' files paths
        $subfolders = $this->folderModel->where('parent_id', $oldFolderId)->findAll();
        foreach ($subfolders as $subfolder) {
            $oldSubfolderPath = FCPATH . 'folders/' . session()->get('name') . '/' . $subfolder['folder_name'];
            $newSubfolderPath = $newFolderPath . '/' . $subfolder['folder_name'];
            $this->updateFilePaths($subfolder['id'], $newFolderId, $newSubfolderPath);
        }
    }
}
