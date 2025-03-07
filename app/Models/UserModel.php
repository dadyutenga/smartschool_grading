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
        return $this->where('username', $username)
                    ->where('is_active', 'yes')
                    ->first();
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
} 