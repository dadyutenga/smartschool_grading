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
        // Debug: Check if this method is being called
        log_message('debug', 'Dashboard::index method called');
        
        // Require login
        if (!$this->auth->isLoggedIn()) {
            log_message('debug', 'User not logged in, redirecting to login page');
            return redirect()->to('/auth/login');
        }
        
        $userRole = $this->auth->getRole();
        $userId = $this->auth->getUserId();
        
        log_message('debug', 'User role: ' . $userRole . ', User ID: ' . $userId);
        
        $data = [
            'title' => 'Dashboard'
        ];
        
        // Different dashboard based on role
        if ($userRole === 'student') {
            // Get student info and recent results
            $student = $this->studentModel->getStudentWithSession($userId, $this->currentSession['id']);
            $data['student'] = $student;
            
            return view('dashboard/student', $data);
        } else if ($userRole === 'teacher') {
            // Get teacher's classes and sections
            return view('dashboard/teacher', $data);
        } else {
            // Admin dashboard
            return view('dashboard/admin', $data);
        }
    }
} 