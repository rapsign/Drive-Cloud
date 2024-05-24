<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\FolderModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;


class User extends BaseController
{
    protected $folderModel;
    protected $userId;


    public function __construct()
    {
        $this->folderModel = new FolderModel();
        $this->userId = session()->get('id');
    }
    public function index()
    {
        $folders = $this->folderModel->where('user_id', session()->get('id'))
            ->orderBy('created_at', 'DESC')
            ->findAll();

        $data['folders'] = $folders;
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
        return view('user/trash');
    }
}
