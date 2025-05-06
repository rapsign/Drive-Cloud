<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UsersModel;

/**
 * Authentication class handles user authentication processes such as login and logout.
 */
class Authentication extends BaseController
{
    /**
     * @var UsersModel $userModel The user model instance.
     */
    protected $userModel;

    /**
     * Constructor to initialize the UsersModel.
     */
    public function __construct()
    {
        $this->userModel = new UsersModel();
    }

    /**
     * Displays the login form.
     *
     * @return \CodeIgniter\HTTP\ResponseInterface Response object containing the login view.
     */
    public function index()
    {
        return view('authentication/login');
    }

    /**
     * Processes the login request.
     *
     * @return \CodeIgniter\HTTP\ResponseInterface Redirects user to appropriate dashboard or back to login with error message.
     */
    public function loginProcess()
    {
        // Validation
        $validation = \Config\Services::validation();
        $validation->setRules([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Retrieve input data
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Check if user exists in the database
        $user = $this->userModel->where('username', $username)->first();

        if (isset($user['password']) && password_verify($password, $user['password'])) {
            $data = [
                'isLoggedIn' => true,
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

    /**
     * Logs out the user by destroying the session.
     *
     * @return \CodeIgniter\HTTP\ResponseInterface Redirects user to the homepage after logout.
     */
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}
