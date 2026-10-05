<?php

defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class ProductController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->call->database();
        $this->call->model('ProductModel');
        $this->call->model('UsersModel');
    }

    private function requireLogin()
    {
        $session_user = $_SESSION['user'] ?? null;
        if (!is_array($session_user) || !isset($session_user['id'])) {
            redirect('login', false, false);
            exit;
        }

        $user = $this->UsersModel->getActiveById($session_user['id']);
        if (!$user) {
            $this->session->sess_destroy();
            redirect('login', false, false);
            exit;
        }

        $_SESSION['user'] = [
            'id' => $user['id'],
            'username' => $user['username'],
            'role' => $user['role'],
        ];
    }

    private function requireAdmin()
    {
        $this->requireLogin();

        if ($_SESSION['user']['role'] !== 'admin') {
            http_response_code(403);
            exit('Administrator access required.');
        }
    }

    public function index()
    {
        $this->requireLogin();

        $data['products'] = $this->ProductModel->getAll();
        $data['is_admin'] = $_SESSION['user']['role'] === 'admin';

        $this->call->view('products/index', $data);
    }

    public function create()
    {
        $this->requireAdmin();

        $this->call->view('products/create');
    }

    public function store()
    {
        $this->requireAdmin();

        $data = [
            'product_name' => $this->io->post('product_name'),
            'description'  => $this->io->post('description'),
            'price'        => $this->io->post('price'),
            'quantity'     => $this->io->post('quantity')
        ];

        $this->ProductModel->create($data);

        redirect('products');
    }

    public function edit($id)
    {
        $this->requireAdmin();

        $data['product'] = $this->ProductModel->getById($id);

        $this->call->view('products/edit', $data);
    }

    public function update($id)
    {
        $this->requireAdmin();

        $data = [
            'product_name' => $this->io->post('product_name'),
            'description'  => $this->io->post('description'),
            'price'        => $this->io->post('price'),
            'quantity'     => $this->io->post('quantity')
        ];

        $this->ProductModel->updateProduct($id, $data);

        redirect('products');
    }

    public function delete($id)
    {
        $this->requireAdmin();

        $this->ProductModel->deleteProduct($id);

        redirect('products');
    }
}