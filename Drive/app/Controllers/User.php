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

    public function addFolder()
    {
        helper('text');
        $this->folderModel->save([
            'folder_name' => $this->request->getVar('folder'),
            'user_id' => $this->request->getVar('userId'),
            'slug' => random_string('alnum', 35),
        ]);

        session()->setFlashdata('success_message', 'Folder added successfully!');
        return redirect()->to('/user');
    }

    public function showFolders()
    {
        // Assuming you have a model called FolderModel to interact with the folder table

        // Retrieve folder data from the database
        $folders = $folderModel->where('user_id', session('id'))->findAll();

        // Pass folder data to the view
        $data['folders'] = $folders;

        // Load the view and pass the data to it
        return view('folders_view', $data);
    }
}
