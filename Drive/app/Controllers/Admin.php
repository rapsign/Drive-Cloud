<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UsersModel;

class Admin extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UsersModel();
    }
    public function index()
    {
        $data['users'] = $this->userModel->getUsers();
        return view('admin/index', $data);
    }
    public function register()
    {
        // Mendefinisikan rules validasi
        $validationRules = [
            'username' => [
                'rules' => 'required|numeric|min_length[3]|max_length[20]|is_unique[users.username]',
                'errors' => [
                    'required' => 'Username is required.',
                    'alpha_numeric' => 'Username can only contain alphanumeric characters.',
                    'min_length' => 'Username must be at least 3 characters long.',
                    'max_length' => 'Username cannot be longer than 20 characters.',
                    'is_unique' => 'Username is already taken.'
                ]
            ],
            'name' => [
                'rules' => 'required|alpha_space|min_length[3]|max_length[100]',
                'errors' => [
                    'required' => 'Name is required.',
                    'alpha_space' => 'Name can only contain alphabetic characters and spaces.',
                    'min_length' => 'Name must be at least 3 characters long.',
                    'max_length' => 'Name cannot be longer than 100 characters.'
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[8]',
                'errors' => [
                    'required' => 'Password is required.',
                    'min_length' => 'Password must be at least 8 characters long.'
                ]
            ],
            'password_confirm' => [
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => 'Password confirmation is required.',
                    'matches' => 'Password confirmation does not match the password.'
                ]
            ]
        ];

        // Memvalidasi input
        if (!$this->validate($validationRules)) {
            // Jika validasi gagal
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors())->with('showModal', true);
        }

        // Jika validasi berhasil
        $this->userModel->save([
            'username' => $this->request->getVar('username'),
            'name' => $this->request->getVar('name'),
            'role_id' => 2,
            'password' => password_hash($this->request->getVar('password'), PASSWORD_BCRYPT)
        ]);

        session()->setFlashdata('success_message', 'Registration successful!');
        return redirect()->to('/admin');
    }

    public function changeRole()
    {
        $userId = $this->request->getPost('user_id');
        $newRoleId = $this->request->getPost('role_id');

        // Validasi input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'user_id' => 'required|numeric',
            'role_id' => 'required|numeric|in_list[1,2]', // Misalkan 1 = Admin, 2 = User
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            // Kembali dengan error jika validasi gagal
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Update role_id di database
        $this->userModel->update($userId, ['role_id' => $newRoleId]);

        // Set flashdata untuk pesan sukses
        session()->setFlashdata('success_message', 'Role updated successfully!');
        return redirect()->back();
    }
    public function uploadRegister()
    {
    }
}
