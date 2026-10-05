<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        return view('login');
    }

    public function authenticate()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $userModel = new UserModel();

        $user = $userModel
            ->where('username', $username)
            ->first();

        if (!$user) {
            return redirect()
                ->to(base_url('login'))
                ->withInput()
                ->with('error', 'Invalid username or password.');
        }

        if (!password_verify($password, $user['password'])) {
            return redirect()
                ->to(base_url('login'))
                ->withInput()
                ->with('error', 'Invalid username or password.');
        }

        session()->set([
            'user_id'   => $user['id'],
            'username'  => $user['username'],
            'logged_in' => true
        ]);

        return redirect()->to(base_url('users'));
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to(base_url('login'));
    }
}