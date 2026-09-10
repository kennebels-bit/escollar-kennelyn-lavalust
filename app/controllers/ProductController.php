<?php

defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class ProductController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->call->database();
        $this->call->model('ProductModel');
    }

    private function requireLogin()
    {
        if (!isset($_SESSION['user'])) {
            redirect('login');
            exit;
        }
    }

    public function index()
    {
        $this->requireLogin();

        $data['products'] = $this->ProductModel->getAll();

        $this->call->view('products/index', $data);
    }

    public function create()
    {
        $this->requireLogin();

        $this->call->view('products/create');
    }

    public function store()
    {
        $this->requireLogin();

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
        $this->requireLogin();

        $data['product'] = $this->ProductModel->getById($id);

        $this->call->view('products/edit', $data);
    }

    public function update($id)
    {
        $this->requireLogin();

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
        $this->requireLogin();

        $this->ProductModel->deleteProduct($id);

        redirect('products');
    }
}