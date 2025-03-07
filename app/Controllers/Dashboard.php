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
            return redirect()->to('/auth/login');
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
            return view('dashboard/index');
        }
    }
    
    public function admin()
    {
        // Check if user is admin
        if ($this->auth->getRole() != 'Super Admin') {
            return redirect()->to('/dashboard');
        }
        
        return view('dashboard/admin');
    }
    
    public function student()
    {
        // Check if user is student
        if ($this->auth->getRole() != 'student') {
            return redirect()->to('/dashboard');
        }
        
        return view('dashboard/student');
    }
    
    public function parent()
    {
        // Check if user is parent
        if ($this->auth->getRole() != 'parent') {
            return redirect()->to('/dashboard');
        }
        
        return view('dashboard/parent');
    }
} 