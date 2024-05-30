<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UsersModel;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Admin extends BaseController
{
    protected $userModel;
    /**
     * Constructor for Admin Controller.
     */

    public function __construct()
    {
        $this->userModel = new UsersModel();
        /**
         * Displays the main admin page with a list of users.
         *
         * @return ResponseInterface
         */
    }
    public function index()
    {
        $data['users'] = $this->userModel->getUsers();
        return view('admin/index', $data);
    }
    /**
     * Handles user registration.
     *
     * @return ResponseInterface
     */
    public function register()
    {
        // Validation rules for registration
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

        // Validate input
        if (!$this->validate($validationRules)) {
            // Redirect back with errors if validation fails
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors())->with('showModalAdd', true);
        }

        // Successful validation, proceed with registration
        $this->userModel->save([
            'username' => $this->request->getVar('username'),
            'name' => $this->request->getVar('name'),
            'role_id' => 2,
            'password' => password_hash($this->request->getVar('password'), PASSWORD_BCRYPT),
        ],);
        // Create a folder for the new user
        $foldername = $this->request->getVar('name');
        $folderPath = FCPATH . 'files/' . $foldername;
        mkdir($folderPath, 0777, true);
        // Redirect with success message
        session()->setFlashdata('success_message', 'Registration successful!');
        return redirect()->to('/admin');
    }
    /**
     * Changes the role of a user.
     *
     * @return ResponseInterface
     */
    public function changeRole()
    {
        // Get user_id and new role_id from POST request
        $userId = $this->request->getPost('user_id');
        $newRoleId = $this->request->getPost('role_id');

        // Validate input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'user_id' => 'required|numeric',
            'role_id' => 'required|numeric|in_list[1,2]', // Misalkan 1 = Admin, 2 = User
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            if ($newRoleId === null) {
                return redirect()->back()->withInput()->with('roleError', 'Please select a role')->with('showModalRole', true);
            } else {
                $errors = $validation->getErrors();
                return redirect()->back()->withInput()->with('errors', $errors)->with('showModalRole', true);
            }
        }

        // Update role_id in the database
        $this->userModel->update($userId, ['role_id' => $newRoleId]);

        // Redirect with success message
        session()->setFlashdata('success_message', 'Role updated successfully!');
        return redirect()->back();
    }
    /**
     * Deletes a user and associated folder.
     *
     * @return ResponseInterface
     */
    public function deleteUser()
    {
        // Get user ID and name from request
        $userId = $this->request->getVar('userId');
        $name = $this->request->getVar('name');

        // Validate user ID
        if (!empty($userId)) {
            // Delete user from database and associated folder
            $deleted = $this->userModel->delete($userId);
            if ($deleted) {
                $foldername = $name;
                $folderPath = FCPATH . 'files/' . $foldername;
                rmdir($folderPath);
                session()->setFlashdata('success_message', 'User deleted successfully!');
            } else {
                session()->setFlashdata('error_message', 'Failed to delete user!');
            }
        } else {
            session()->setFlashdata('error_message', 'Invalid user ID!');
        }
        // Redirect back
        return redirect()->back();
    }
    /**
     * Adds users from an Excel file.
     *
     * @return ResponseInterface
     */
    public function addUsersFromExcel()
    {
        // Validate uploaded Excel file
        $validation = \Config\Services::validation();
        $validation->setRules([
            'excelFile' => [
                'rules' => 'uploaded[excelFile]|max_size[excelFile,1024]|ext_in[excelFile,xls,xlsx]',
                'errors' => [
                    'uploaded' => 'The uploaded file is required.',
                    'max_size' => 'The uploaded file exceeds the maximum file size limit of 1024 KB.',
                    'ext_in'   => 'The uploaded file must be a .xls or .xlsx file.'
                ]
            ]
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Read Excel file and add users
        $excelFile = $this->request->getFile('excelFile');
        $reader = IOFactory::createReader('Xlsx');
        $spreadsheet = $reader->load($excelFile->getTempName());
        $worksheet = $spreadsheet->getActiveSheet();

        foreach ($worksheet->getRowIterator(2) as $row) {
            $rowData = [];
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false); // Loop through all cells, even if cell value is not set

            foreach ($cellIterator as $cell) {
                $rowData[] = $cell->getValue();
            }

            // Create a folder for each new user
            $username = $rowData[0]; // Misalnya kolom pertama adalah username
            $name = $rowData[1]; // Misalnya kolom kedua adalah nama
            $password = $rowData[2]; // Misalnya kolom ketiga adalah password

            // ... Lanjutkan untuk kolom lainnya

            // Contoh menyimpan ke dalam tabel users menggunakan model
            if (empty($username) || empty($name) || empty($password)) {
                // Jika data kosong, lewati baris ini dan lanjutkan ke baris berikutnya
                continue;
            }

            // Validasi username
            if (strlen($username) < 6 || strlen($username) > 20) {
                // Jika panjang username tidak sesuai, kembali dengan pesan kesalahan
                return redirect()->back()->withInput()->with('errors', ['username' => 'Username must be between 6 and 20 characters.']);
            }

            // Validasi password
            if (strlen($password) < 8) {
                // Jika panjang password kurang dari 8 karakter, kembali dengan pesan kesalahan
                return redirect()->back()->withInput()->with('errors', ['password' => 'Password must be at least 8 characters long.']);
            }

            // Validasi nama
            if (strlen($name) < 2) {
                // Jika panjang nama kurang dari 2 karakter, kembali dengan pesan kesalahan
                return redirect()->back()->withInput()->with('errors', ['name' => 'Name must be at least 2 characters long.']);
            }

            // Validasi apakah username sudah ada dalam database
            if ($this->userModel->where('username', $username)->countAllResults() > 0) {
                // Jika username sudah ada, kembali dengan pesan kesalahan
                return redirect()->back()->withInput()->with('errors', ['username' => 'Username already exists.']);
            }
            $this->userModel->save([
                'username' => $username,
                'name' => $name,
                'password' => password_hash($password, PASSWORD_BCRYPT),
                'role_id' => 2
            ]);
            $foldername = $name;
            $folderPath = FCPATH . 'files/' . $foldername;
            mkdir($folderPath, 0777, true);
        }

        // Tampilkan pesan sukses jika berhasil
        session()->setFlashdata('success_message', 'Users added successfully!');
        return redirect()->back();
    }
}
