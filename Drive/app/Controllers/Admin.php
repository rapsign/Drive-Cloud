<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UsersModel;
use PhpOffice\PhpSpreadsheet\IOFactory;

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
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors())->with('showModalAdd', true);
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
            if ($newRoleId === null) {
                return redirect()->back()->withInput()->with('roleError', 'Please select a role')->with('showModalRole', true);
            } else {
                // Dapatkan pesan kesalahan validasi
                $errors = $validation->getErrors();
                return redirect()->back()->withInput()->with('errors', $errors)->with('showModalRole', true);
            }
        }

        // Update role_id di database
        $this->userModel->update($userId, ['role_id' => $newRoleId]);

        // Set flashdata untuk pesan sukses
        session()->setFlashdata('success_message', 'Role updated successfully!');
        return redirect()->back();
    }

    public function deleteUser()
    {
        $userId = $this->request->getVar('userId');

        // Pastikan ID pengguna yang akan dihapus valid
        if (!empty($userId)) {
            // Lakukan penghapusan pengguna dari database
            $deleted = $this->userModel->delete($userId);
            if ($deleted) {
                // Kirim pesan sukses jika penghapusan berhasil
                session()->setFlashdata('success_message', 'User deleted successfully!');
            } else {
                // Kirim pesan kesalahan jika gagal menghapus pengguna
                session()->setFlashdata('error_message', 'Failed to delete user!');
            }
        } else {
            // Kirim pesan kesalahan jika ID pengguna kosong
            session()->setFlashdata('error_message', 'Invalid user ID!');
        }

        // Redirect kembali ke halaman sebelumnya
        return redirect()->back();
    }
    public function addUsersFromExcel()
    {
        // Validasi unggahan file
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
            // Kembali ke halaman sebelumnya dengan pesan kesalahan jika validasi gagal
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Ambil file Excel yang diunggah
        $excelFile = $this->request->getFile('excelFile');

        // Load file Excel menggunakan PhpSpreadsheet
        $reader = IOFactory::createReader('Xlsx'); // Ubah sesuai ekstensi file Excel
        $spreadsheet = $reader->load($excelFile->getTempName());
        $worksheet = $spreadsheet->getActiveSheet();

        // Looping baris-baris Excel, mulai dari baris kedua (baris pertama biasanya berisi header)
        foreach ($worksheet->getRowIterator(2) as $row) {
            $rowData = [];
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false); // Loop through all cells, even if cell value is not set

            foreach ($cellIterator as $cell) {
                $rowData[] = $cell->getValue(); // Mengambil nilai dari setiap sel dalam baris
            }

            // Simpan data pengguna ke dalam database
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
        }

        // Tampilkan pesan sukses jika berhasil
        session()->setFlashdata('success_message', 'Users added successfully!');
        return redirect()->back();
    }
}
