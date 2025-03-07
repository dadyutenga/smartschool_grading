<?php

namespace App\Models;

use CodeIgniter\Model;

class SessionModel extends Model
{
    protected $table      = 'sessions';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    
    protected $allowedFields = [
        'session', 'is_active', 'created_at', 'updated_at'
    ];
    
    // Get current session
    public function getCurrentSession()
    {
        return $this->where('is_active', 'yes')->first();
    }
} 