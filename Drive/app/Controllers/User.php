<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\FilesModel;
use App\Models\FolderModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;


class User extends BaseController
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
        $files = $this->fileModel->where('user_id', session()->get('id'))
            ->orderBy('created_at', 'DESC')
            ->findAll();
        $folders = $this->folderModel->where('user_id', session()->get('id'))
            ->orderBy('created_at', 'DESC')
            ->findAll();

        $data['folders'] = $folders;
        $data['files'] = $files;
        return view('user/index', $data);
    }
    public function recent()
    {
        return view('user/recent');
    }
    public function upload()
    {
        return view('user/upload');
    }
    public function trash()
    {
        $folders = $this->folderModel->onlyDeleted()
            ->where('user_id', session()->get('id'))
            ->orderBy('deleted_at', 'DESC')
            ->findAll();
        $data['folders'] = $folders;
        return view('user/trash', $data);
    }
}
