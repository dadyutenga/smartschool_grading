<?php

namespace App\Libraries;

class AuthLibrary
{
    protected $session;
    protected $authModel;
    
    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->authModel = new \App\Models\AuthModel();
    }
    
    public function login($username, $password)
    {
        $user = $this->authModel->getUserByUsername($username);
        
        if (!$user) {
            return false;
        }
        
        // Check if password matches (plain text comparison for now)
        if ($user['password'] !== $password) {
            return false;
        }
        
        // Set session data
        $sessionData = [
            'id' => $user['id'],
            'username' => $user['username'],
            'role' => $user['role'],
            'logged_in' => true
        ];
        
        $this->session->set($sessionData);
        
        return true;
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