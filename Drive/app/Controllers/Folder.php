<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\FolderModel;

class Folder extends BaseController
{
    protected $folderModel;

    public function __construct()
    {
        $this->folderModel = new FolderModel();
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
        $baseFolderPath = FCPATH . 'files/' . $username . '/';
        $oldFolderPath = $baseFolderPath . $oldFolderName;
        $newFolderPath = $baseFolderPath . $newFolderName;

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
        $this->folderModel->where('slug', $folderSlug)->delete();
        session()->setFlashdata('success_message', 'Folder move to trash');
        return redirect()->to('/user');
    }
    public function restoreFolder()
    {
        $folderId = $this->request->getVar('folderId');

        $this->folderModel->save([
            'id' => $folderId,
            'deleted_at' => null,
        ]);

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

        session()->setFlashdata('success_message', 'Folder deleted successfully!');
        return redirect()->to('/user');
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
}
