<?php

namespace App\Libraries;

use App\Models\UserModel;

class AuthLibrary
{
    protected $session;
    protected $userModel;
    
    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->userModel = new UserModel();
    }
    
    public function login($username, $password)
    {
        $user = $this->userModel->getUserByUsername($username);
        
        if (!$user) {
            return false;
        }
        
        // Check password - assuming the existing system uses password_verify
        if (password_verify($password, $user['password'])) {
            // Get user with role
            $userWithRole = $this->userModel->getUserWithRole($user['id']);
            
            // Set session data
            $sessionData = [
                'id'        => $user['id'],
                'username'  => $user['username'],
                'role'      => $userWithRole['role_name'],
                'role_id'   => $userWithRole['role_id'],
                'logged_in' => true
            ];
            
            $this->session->set($sessionData);
            return true;
        }
        
        return false;
    }
    
    public function isLoggedIn()
    {
        return $this->session->get('logged_in') === true;
    }
    
    public function getUserId()
    {
        return $this->session->get('id');
    }
    
    public function getRole()
    {
        return $this->session->get('role');
    }
    
    public function logout()
    {
        $this->session->destroy();
    }
} 