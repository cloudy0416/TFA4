<?php

namespace App\Controllers;

use App\Models\CustomerModel;

class Customers extends BaseController
{
    public function index()
    {
        $customerModel = new CustomerModel();

        $data['customers'] = $customerModel->findAll();

        return view('customers', $data);
    }

    public function new()
    {
        return view('customer_form');
    }

    public function create()
    {
        $customerModel = new CustomerModel();

        $postData = $this->request->getPost();

        $rules = [
            'full_name' => 'required',
            'email'     => 'required|valid_email',
            'phone'     => 'permit_empty'
        ];

        if (! $this->validateData($postData, $rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = [
            'full_name'  => $postData['full_name'],
            'email'      => $postData['email'],
            'phone'      => $postData['phone'] ?? '',
            'created_at' => date('Y-m-d H:i:s')
        ];

        $customerModel->insert($data);

        return redirect()->to('/customers');
    }

    public function edit($id)
    {
        $customerModel = new CustomerModel();

        $customer = $customerModel->find($id);

        if (!$customer) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(
                'Customer not found.'
            );
        }

        return view('customer_form', [
            'customer' => $customer
        ]);
    }

    public function update($id)
    {
        $customerModel = new CustomerModel();

        $customer = $customerModel->find($id);

        if (!$customer) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(
                'Customer not found.'
            );
        }

        $postData = $this->request->getPost();

        $rules = [
            'full_name' => 'required',
            'email'     => 'required|valid_email',
            'phone'     => 'permit_empty'
        ];

        if (! $this->validateData($postData, $rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = [
            'full_name' => $postData['full_name'],
            'email'     => $postData['email'],
            'phone'     => $postData['phone'] ?? ''
        ];

        $customerModel->update($id, $data);

        return redirect()->to('/customers');
    }
}