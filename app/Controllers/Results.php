<?php

namespace App\Controllers;

use App\Models\ExamResultModel;
use App\Models\StudentModel;
use App\Models\ClassModel;
use App\Models\SectionModel;

class Results extends BaseController
{
    protected $examResultModel;
    protected $studentModel;
    protected $classModel;
    protected $sectionModel;
    
    public function __construct()
    {
        $this->examResultModel = new ExamResultModel();
        $this->studentModel = new StudentModel();
        $this->classModel = new ClassModel();
        $this->sectionModel = new SectionModel();
    }
    
    public function index()
    {
        // Require login
        $this->requireLogin();
        
        $data = [
            'title' => 'Exam Results',
            'classes' => $this->classModel->getActiveClasses()
        ];
        
        return view('results/index', $data);
    }
    
    public function viewClassResults($examId, $classId, $sectionId)
    {
        // Require teacher or admin role
        $this->requireRole(['admin', 'teacher']);
        
        $data = [
            'title' => 'Class Results',
            'results' => $this->examResultModel->getClassResults($examId, $classId, $sectionId),
            'class' => $this->classModel->find($classId),
            'section' => $this->sectionModel->find($sectionId)
        ];
        
        return view('results/class_results', $data);
    }
    
    public function viewStudentResults($studentId, $examId)
    {
        // Require login
        $this->requireLogin();
        
        // Check if current user is the student or has admin/teacher role
        $userId = $this->auth->getUserId();
        $userRole = $this->auth->getRole();
        
        if ($userRole === 'student' && $userId != $studentId) {
            return redirect()->to('/dashboard')->with('error', 'You can only view your own results');
        }
        
        $data = [
            'title' => 'Student Results',
            'student' => $this->studentModel->find($studentId),
            'results' => $this->examResultModel->getResultsByStudent($studentId, $examId)
        ];
        
        return view('results/student_results', $data);
    }
    
    public function getSections()
    {
        // AJAX request to get sections by class
        $classId = $this->request->getPost('class_id');
        $sections = $this->sectionModel->getSectionsByClass($classId);
        
        return $this->response->setJSON($sections);
    }
} 