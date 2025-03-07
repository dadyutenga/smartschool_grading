<?php

namespace App\Models;

use CodeIgniter\Model;

class AuthModel extends Model
{
    protected $table = 'auth_users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'password', 'role', 'is_active', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    public function getUserByUsername($username)
    {
        return $this->where('username', $username)
                    ->where('is_active', 1)
                    ->first();
    }
} 