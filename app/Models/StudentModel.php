<?php

namespace App\Models;

use CodeIgniter\Model;

class StudentModel extends Model
{
    protected $table      = 'students';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    
    protected $allowedFields = [
        'admission_no', 'roll_no', 'admission_date', 'firstname', 'lastname', 
        'rte', 'image', 'mobileno', 'email', 'state', 'city', 'guardian_name', 
        'guardian_relation', 'guardian_phone', 'guardian_email', 'is_active'
    ];
    
    // Get student with current session
    public function getStudentWithSession($studentId, $sessionId)
    {
        return $this->select('students.*, student_session.class_id, student_session.section_id, classes.class, sections.section')
                    ->join('student_session', 'student_session.student_id = students.id')
                    ->join('classes', 'classes.id = student_session.class_id')
                    ->join('sections', 'sections.id = student_session.section_id')
                    ->where('students.id', $studentId)
                    ->where('student_session.session_id', $sessionId)
                    ->first();
    }
    
    // Get students by class and section
    public function getStudentsByClassSection($classId, $sectionId, $sessionId)
    {
        return $this->select('students.*')
                    ->join('student_session', 'student_session.student_id = students.id')
                    ->where('student_session.class_id', $classId)
                    ->where('student_session.section_id', $sectionId)
                    ->where('student_session.session_id', $sessionId)
                    ->where('students.is_active', 'yes')
                    ->findAll();
    }
} 