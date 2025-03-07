<?php

namespace App\Controllers;

use App\Models\StudentModel;
use App\Models\ExamResultModel;

class Dashboard extends BaseController
{
    protected $studentModel;
    protected $examResultModel;
    
    public function __construct()
    {
        $this->studentModel = new StudentModel();
        $this->examResultModel = new ExamResultModel();
    }
    
    public function index()
    {
        // Require login
        if (!$this->auth->isLoggedIn()) {
            return redirect()->to('/admin/login');
        }
        
        $role = $this->auth->getRole();
        
        if ($role == 'Super Admin') {
            return $this->admin();
        } else if ($role == 'student') {
            return $this->student();
        } else if ($role == 'parent') {
            return $this->parent();
        } else {
            // Default dashboard
            return view('admin/dashboard');
        }
    }
    
} 