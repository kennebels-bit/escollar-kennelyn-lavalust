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

            $user = is_string($username)
                ? $this->UsersModel->getByUsername($username)
                : null;

            if ($user && is_string($password) && password_verify($password, $user['password'])) {
                $this->session->after_successful_login();

                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'role' => $user['role'],
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
        $this->session->sess_destroy();

        redirect('login');
    }
}