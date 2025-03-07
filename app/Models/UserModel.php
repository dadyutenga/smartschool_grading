<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'password', 'role', 'is_active'];
    
    public function getUserByUsername($username)
    {
        return $this->where('username', $username)
                    ->where('is_active', 'yes')
                    ->first();
    }
    
    public function getUserWithRole($userId)
    {
        // For simplicity, we'll just return a hardcoded role for now
        // In a real application, you would join with the roles table
        $user = $this->find($userId);
        if (!$user) {
            return null;
        }
        
        // Hardcoded role for testing
        return [
            'id' => $user['id'],
            'username' => $user['username'],
            'role_name' => 'admin',
            'role_id' => 1
        ];
    }
} 