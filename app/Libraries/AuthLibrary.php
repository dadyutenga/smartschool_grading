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
        // Debug
        log_message('debug', "Login attempt for username: $username");
        
        $user = $this->authModel->getUserByUsername($username);
        
        if (!$user) {
            log_message('debug', "User not found: $username");
            return false;
        }
        
        log_message('debug', "User found, checking password");
        log_message('debug', "Input password: $password, DB password: {$user['password']}");
        
        // IMPORTANT: Direct plain text comparison - only for testing!
        // In production, you should use password_verify() with hashed passwords
        if ($user['password'] === $password) {
            log_message('debug', "Password matched, setting session");
            
            // Set session data
            $sessionData = [
                'id' => $user['id'],
                'username' => $user['username'],
                'role' => $user['role'],
                'logged_in' => true
            ];
            
            $this->session->set($sessionData);
            log_message('debug', "Session data set: " . json_encode($sessionData));
            
            return true;
        } else {
            log_message('debug', "Password mismatch for user: $username");
            return false;
        }
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