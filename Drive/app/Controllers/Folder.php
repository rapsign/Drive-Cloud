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
        $this->folderModel->save([
            'folder_name' => $this->request->getVar('folder'),
            'user_id' => $this->request->getVar('userId'),
            'slug' => random_string('alnum', 35),
        ]);

        session()->setFlashdata('success_message', 'Folder added successfully!');
        return redirect()->to('/user');
    }

    public function renameFolder()
    {
        $this->folderModel->save([
            'id' => $this->request->getVar('id'),
            'folder_name' => $this->request->getVar('folder_name'),
        ]);

        session()->setFlashdata('success_message', 'Folder renamed successfully!');

        return redirect()->to('/user');
    }
    public function deleteFolder()
    {
    }
}
