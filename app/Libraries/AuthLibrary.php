<?php

namespace App\Libraries;

class AuthLibrary
{
    protected $session;
    
    public function __construct()
    {
        $this->session = \Config\Services::session();
    }
    
    public function login($username, $password)
    {
        // For testing purposes, accept any username/password
        // In production, you would verify against the database
        
        // Set session data
        $sessionData = [
            'id'        => 1,
            'username'  => $username,
            'role'      => 'admin',
            'role_id'   => 1,
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