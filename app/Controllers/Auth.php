<?php

namespace App\Controllers;

use App\Libraries\AuthLibrary;

class Auth extends BaseController
{
    public function login()
    {
        // Debug: Check if this method is being called
        log_message('debug', 'Auth::login method called');
        
        // If already logged in, redirect to dashboard
        if ($this->auth->isLoggedIn()) {
            log_message('debug', 'User already logged in, redirecting to dashboard');
            return redirect()->to('/dashboard');
        }
        
        if ($this->request->getMethod() === 'post') {
            log_message('debug', 'Processing POST request for login');
            
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');
            
            log_message('debug', 'Login attempt for username: ' . $username);
            
            // Validate input
            $validation = \Config\Services::validation();
            $validation->setRules([
                'username' => 'required',
                'password' => 'required'
            ]);
            
            if (!$validation->run($this->request->getPost())) {
                log_message('debug', 'Validation failed: ' . json_encode($validation->getErrors()));
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Please check your input')
                    ->with('username_error', $validation->getError('username'))
                    ->with('password_error', $validation->getError('password'));
            }
            
            // Attempt login
            log_message('debug', 'Attempting login with AuthLibrary');
            if ($this->auth->login($username, $password)) {
                // Successful login
                $role = $this->auth->getRole();
                
                if ($role == 'Super Admin') {
                    log_message('debug', 'Login successful, redirecting to admin dashboard');
                    return redirect()->to('/dashboard/admin');
                } else if ($role == 'student') {
                    log_message('debug', 'Login successful, redirecting to student dashboard');
                    return redirect()->to('/dashboard/student');
                } else if ($role == 'parent') {
                    log_message('debug', 'Login successful, redirecting to parent dashboard');
                    return redirect()->to('/dashboard/parent');
                } else {
                    log_message('debug', 'Login successful, redirecting to default dashboard');
                    return redirect()->to('/dashboard');
                }
            } else {
                // Failed login
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Invalid username or password');
            }
        }
        
        log_message('debug', 'Displaying login form');
        return view('auth/login');
    }
    
    public function logout()
    {
        $this->auth->logout();
        return redirect()->to('/auth/login')->with('success', 'You have been logged out successfully');
    }
} 