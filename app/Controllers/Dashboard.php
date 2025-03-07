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
        
        // For testing, just show the admin dashboard
        return view('dashboard/admin');
    }
} 