<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class User extends BaseController
{
    public function index()
    {
        return view('user/index');
    }
    public function recent()
    {
        return view('user/recent');
    }
    public function upload()
    {
        return view('user/upload');
    }
}
