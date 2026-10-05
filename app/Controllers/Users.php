<?php

namespace App\Controllers;

use App\Models\UserModel;

class Users extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();

        $data['users'] = $userModel->findAll();

        return view('users', $data);
    }

    public function new()
    {
        return view('user_form');
    }

    public function create()
    {
        $userModel = new UserModel();

        $postData = $this->request->getPost();

        $rules = [
            'username'  => 'required|is_unique[users.username]',
            'full_name' => 'required',
            'role'      => 'permit_empty'
        ];

        if (!$this->validateData($postData, $rules)) {
        return redirect()
            ->back()
            ->withInput()
            ->with('errors', $this->validator->getErrors());
}

        $data = [
            'username'   => $postData['username'],
            'full_name'  => $postData['full_name'],
            'role'       => $postData['role'] ?? '',
            'created_at' => date('Y-m-d H:i:s')
        ];

        $userModel->insert($data);

        return redirect()->to('/users');
    }

    public function edit($id)
    {
        $userModel = new UserModel();

        $user = $userModel->find($id);

        if (! $user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(
                'User not found.'
            );
        }

        return view('user_form', [
            'user' => $user
        ]);
    }

    public function update($id)
    {
        $userModel = new UserModel();

        $user = $userModel->find($id);

        if (! $user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(
                'User not found.'
            );
        }

        $postData = $this->request->getPost();

        $rules = [
            'username'  => "required|is_unique[users.username,id,{$id}]",
            'full_name' => 'required',
            'role'      => 'permit_empty'
        ];

        if (!$this->validateData($postData, $rules)) {
        return redirect()
            ->back()
            ->withInput()
            ->with('errors', $this->validator->getErrors());
}

        $data = [
            'username'  => $postData['username'],
            'full_name' => $postData['full_name'],
            'role'      => $postData['role'] ?? ''
        ];

        /*
         * Check whether the user selected a new avatar.
         */
        $avatar = $this->request->getFile('avatar');

        if ($avatar && $avatar->getError() !== UPLOAD_ERR_NO_FILE) {

            $fileRules = [
                'avatar' => [
                    'uploaded[avatar]',
                    'is_image[avatar]',
                    'mime_in[avatar,image/jpeg,image/png]',
                    'max_size[avatar,2048]'
                ]
            ];

            if (!$this->validateData([], $fileRules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
}

            /*
             * Generate a safe random filename.
             */
            $filename = $avatar->getRandomName();

            /*
             * Temporary location of the uploaded image.
             */
            $tempPath = $avatar->getTempName();

            /*
             * Public upload directory.
             */
            $uploadPath = FCPATH . 'uploads/';

            /*
             * Make sure the directory exists.
             */
            if (! is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            /*
             * Create a display-ready 150x150 thumbnail.
             */
            service('image')
                ->withFile($tempPath)
                ->fit(150, 150, 'center')
                ->save($uploadPath . $filename);

            /*
             * Save only the filename in the database.
             */
            $data['avatar'] = $filename;
        }

        $userModel->update($id, $data);

        return redirect()->to('/users');
    }
}