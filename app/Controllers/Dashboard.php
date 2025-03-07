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
        $this->requireLogin();
        
        $userRole = $this->auth->getRole();
        $userId = $this->auth->getUserId();
        
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