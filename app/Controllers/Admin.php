<?php

namespace App\Controllers;

class Admin extends BaseController
{
    public function login()
    {
        // If already logged in, redirect to dashboard
        if ($this->auth->isLoggedIn()) {
            return redirect()->to('dashboard');
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
                return redirect()->to('dashboard');
            } else {
                return redirect()->back()
                    ->with('error', 'Invalid username or password');
            }
        }
        
        // Create the login view if it doesn't exist
        if (!file_exists(APPPATH . 'Views/admin/login.php')) {
            $this->createLoginView();
        }
        
        return view('admin/login', [
            'title' => 'Admin Login'
        ]);
    }
    
    public function dashboard()
    {
        // Require login
        if (!$this->auth->isLoggedIn()) {
            return redirect()->to('admin/login');
        }
        
        // Create the dashboard view if it doesn't exist
        if (!file_exists(APPPATH . 'Views/admin/dashboard.php')) {
            $this->createDashboardView();
        }
        
        return view('admin/dashboard', [
            'title' => 'Admin Dashboard',
            'username' => $this->session->get('username')
        ]);
    }
    
    public function logout()
    {
        $this->auth->logout();
        return redirect()->to('admin/login')->with('success', 'You have been logged out successfully');
    }
    
    public function register()
    {
        // If already logged in, redirect to dashboard
        if ($this->auth->isLoggedIn()) {
            return redirect()->to('dashboard');
        }
        
        if ($this->request->getMethod() === 'post') {
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');
            $confirm_password = $this->request->getPost('confirm_password');
            $role = $this->request->getPost('role');
            
            // Simple validation
            if (empty($username) || empty($password) || empty($confirm_password)) {
                return redirect()->back()
                    ->with('error', 'All fields are required');
            }
            
            if ($password !== $confirm_password) {
                return redirect()->back()
                    ->with('error', 'Passwords do not match');
            }
            
            // Check if username already exists
            $authModel = new \App\Models\AuthModel();
            $existingUser = $authModel->getUserByUsername($username);
            
            if ($existingUser) {
                return redirect()->back()
                    ->with('error', 'Username already exists');
            }
            
            // Create new user with hashed password
            $data = [
                'username' => $username,
                'password' => $this->auth->hashPassword($password), // Hash the password
                'role' => $role,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            $authModel->insert($data);
            
            return redirect()->to('admin/login')
                ->with('success', 'Registration successful! You can now login.');
        }
        
        return view('admin/register');
    }
}   