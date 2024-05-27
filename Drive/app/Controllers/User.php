<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\FilesModel;
use App\Models\FolderModel;
use App\Models\UsersModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;


class User extends BaseController
{
    protected $folderModel;
    protected $fileModel;
    protected $userModel;


    public function __construct()
    {
        $this->folderModel = new FolderModel();
        $this->fileModel = new FilesModel();
        $this->userModel = new UsersModel();
        helper(['file']);
    }
    public function index()
    {
        $user_id = session()->get('id');
        $keyword = $this->request->getGet('q');

        if ($keyword) {
            $files = $this->fileModel->search($keyword, $user_id);
            $folders = $this->folderModel->search($keyword, $user_id);
        } else {
            $files = $this->fileModel->where('user_id', $user_id,)->where('folder_id is null')
                ->orderBy('created_at', 'DESC')
                ->findAll();
            $folders = $this->folderModel->where('user_id', $user_id,)->where('parent_id is null')
                ->orderBy('created_at', 'DESC')
                ->findAll();
        }

        $data['keyword'] = $keyword;
        $data['folders'] = $folders;
        $data['files'] = $files;
        return view('user/index', $data);
    }
    public function upload()
    {
        $user_id = session()->get('id');
        $keyword = $this->request->getGet('q');

        if ($keyword) {
            $files = $this->fileModel->search($keyword, $user_id);
            $folders = $this->folderModel->search($keyword, $user_id);
        } else {
            $files = $this->fileModel->where('user_id', $user_id,)->where('folder_id is null')
                ->orderBy('created_at', 'DESC')
                ->findAll();
            $folders = $this->folderModel->where('user_id', $user_id,)->where('parent_id is null')
                ->orderBy('created_at', 'DESC')
                ->findAll();
        }

        $data['keyword'] = $keyword;
        $data['folders'] = $folders;
        $data['files'] = $files;
        return view('user/upload', $data);
    }
    public function trash()
    {
        $user_id = session()->get('id');
        $keyword = $this->request->getGet('q');

        if ($keyword) {
            $folders = $this->folderModel->onlyDeleted()
                ->where('user_id', $user_id)
                ->like('folder_name', $keyword)
                ->orderBy('deleted_at', 'DESC')
                ->findAll();
            $files = $this->fileModel->onlyDeleted()
                ->where('user_id', $user_id)
                ->like('file_name', $keyword)
                ->orderBy('deleted_at', 'DESC')
                ->findAll();
        } else {
            $folders = $this->folderModel->onlyDeleted()
                ->where('user_id', $user_id)
                ->orderBy('deleted_at', 'DESC')
                ->findAll();
            $files = $this->fileModel->onlyDeleted()
                ->where('user_id', $user_id)
                ->orderBy('deleted_at', 'DESC')
                ->findAll();
        }

        $data['keyword'] = $keyword;
        $data['folders'] = $folders;
        $data['files'] = $files;
        return view('user/trash', $data);
    }

    public function emptyTrash()
    {
        // Ambil daftar semua file yang ada di sampah
        $deletedFolders = $this->folderModel->onlyDeleted()->findAll();
        $deletedFiles = $this->fileModel->onlyDeleted()->findAll();;

        // Hapus file dari server
        foreach ($deletedFiles as $file) {
            $username = $this->userModel->getUsernameById($file['user_id']);
            $filePath = FCPATH . 'files/' . $username . '/' . $file['file_name'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        // Hapus folder dari server
        foreach ($deletedFolders as $folder) {
            $username = $this->userModel->getUsernameById($folder['user_id']);
            $folderPath = FCPATH . 'files/' . $username . '/' . $folder['folder_name'];
            if (is_dir($folderPath)) {
                $this->deleteDirectory($folderPath);
            }
        }

        // Setelah menghapus file dan folder dari server, hapus juga data dari database
        $this->fileModel->onlyDeleted()->purgeDeleted();
        $this->folderModel->onlyDeleted()->purgeDeleted();

        session()->setFlashdata('success_message', 'Trash has been emptied successfully!');
        return redirect()->to('/user/trash');
    }

    // Fungsi untuk menghapus direktori secara rekursif
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
