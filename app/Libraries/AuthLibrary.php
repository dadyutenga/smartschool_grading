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
        log_message('debug', 'AuthLibrary initialized');
    }
    
    public function login($username, $password)
    {
        log_message('debug', 'AuthLibrary::login called for username: ' . $username);
        
        try {
            $user = $this->userModel->getUserByUsername($username);
            
            if (!$user) {
                log_message('debug', 'User not found: ' . $username);
                return 'invalid_username';
            }
            
            log_message('debug', 'User found, checking password');
            
            // Check password - assuming the existing system uses password_verify
            if (password_verify($password, $user['password'])) {
                log_message('debug', 'Password verified, getting user role');
                
                // Get user with role
                $userWithRole = $this->userModel->getUserWithRole($user['id']);
                
                if (!$userWithRole) {
                    log_message('error', 'User role not found for user ID: ' . $user['id']);
                    return 'role_not_found';
                }
                
                log_message('debug', 'Setting session data for user: ' . $username);
                
                // Set session data
                $sessionData = [
                    'id'        => $user['id'],
                    'username'  => $user['username'],
                    'role'      => $userWithRole['role_name'],
                    'role_id'   => $userWithRole['role_id'],
                    'logged_in' => true
                ];
                
                $this->session->set($sessionData);
                log_message('debug', 'Session data set successfully');
                return true;
            }
            
            log_message('debug', 'Invalid password for user: ' . $username);
            return 'invalid_password';
        } catch (\Exception $e) {
            log_message('error', 'Exception in AuthLibrary::login: ' . $e->getMessage());
            return 'error';
        }
    }
    
    public function isLoggedIn()
    {
        $loggedIn = $this->session->get('logged_in') === true;
        log_message('debug', 'AuthLibrary::isLoggedIn called, result: ' . ($loggedIn ? 'true' : 'false'));
        return $loggedIn;
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
        log_message('debug', 'AuthLibrary::logout called');
        $this->session->destroy();
    }
} 