<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    
    protected $allowedFields = [
        'username', 'password', 'role', 'verification_code', 'is_active', 'created_at', 'updated_at'
    ];
    
    // Get user by username
    public function getUserByUsername($username)
    {
        error_log("Looking up user by username: $username");
        
        $user = $this->where('username', $username)
                    ->first();
        
        if (!$user) {
            error_log("No user found with username: $username");
            return null;
        }
        
        error_log("User found: " . json_encode($user));
        return $user;
    }
    
    // Get user with role
    public function getUserWithRole($userId)
    {
        return $this->select('users.*, roles.name as role_name')
                    ->join('user_roles', 'user_roles.user_id = users.id')
                    ->join('roles', 'roles.id = user_roles.role_id')
                    ->where('users.id', $userId)
                    ->first();
    }

    public function logUserLogin($user, $role)
    {
        error_log("Logging user login: $user, role: $role");
        
        $db = \Config\Database::connect();
        $data = [
            'user' => $user,
            'role' => $role,
            'ipaddress' => $_SERVER['REMOTE_ADDR'],
            'user_agent' => $_SERVER['HTTP_USER_AGENT'],
            'login_datetime' => date('Y-m-d H:i:s')
        ];
        
        try {
            $db->table('userlog')->insert($data);
            error_log("Login logged successfully");
        } catch (\Exception $e) {
            error_log("Error logging login: " . $e->getMessage());
            // Continue even if logging fails
        }
    }
} 