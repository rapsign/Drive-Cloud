<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UsersModel;

class Authentication extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UsersModel();
    }
    public function index()
    {

        return view('authentication/login');
    }

    public function loginProcess()
    {
        // Validasi input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Ambil data input
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Cek apakah user ada di database
        $user = $this->userModel->where('username', $username)->first();

        if (isset($user['password']) && password_verify($password, $user['password'])) {
            $data = [
                'isLoggedIn' => TRUE,
                'id' => $user['id'],
                'username' => $user['username'],
                'name' => $user['name'],
                'role' => $user['role_id']
            ];
            session()->set($data);

            if ($data['role'] == 1) {
                return redirect()->to('/admin');
            } else {
                return redirect()->to('/user');
            }
        } else {
            return redirect()->back()->withInput()->with('error', 'Invalid username or password.');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}
