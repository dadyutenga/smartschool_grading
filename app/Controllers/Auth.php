<?php

namespace App\Controllers;

use App\Libraries\AuthLibrary;

class Auth extends BaseController
{
    public function login()
    {
        // If already logged in, redirect to dashboard
        if ($this->auth->isLoggedIn()) {
            return redirect()->to('/dashboard');
        }
        
        if ($this->request->getMethod() === 'post') {
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');
            
            // Simple validation
            if (empty($username) || empty($password)) {
                return redirect()->back()
                    ->with('error', 'Username and password are required');
            }
            
            // Attempt login
            if ($this->auth->login($username, $password)) {
                return redirect()->to('/dashboard');
            } else {
                return redirect()->back()
                    ->with('error', 'Invalid username or password');
            }
        }
        
        return view('auth/login');
    }
    
    public function logout()
    {
        $this->auth->logout();
        return redirect()->to('/auth/login')->with('success', 'You have been logged out successfully');
    }
} 