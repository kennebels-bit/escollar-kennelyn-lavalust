<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class AuthController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->call->database();
        $this->call->library('session');
        $this->call->model('UsersModel');
    }

    public function login()
    {
        if ($this->io->method() == 'post') {

            $username = $this->io->post('username');
            $password = $this->io->post('password');

            $user = $this->UsersModel->getByUsername($username);

            if ($user && password_verify($password, $user['password'])) {

                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'username' => $user['username']
                ];

                redirect('products');
                return;
            }

            $data['error'] = 'Invalid username or password.';
        }

        $this->call->view('auth/login', $data ?? []);
    }

    public function logout()
    {
        unset($_SESSION['user']);

        redirect('login');
    }
}