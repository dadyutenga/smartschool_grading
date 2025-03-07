<?php

namespace App\Models;

use CodeIgniter\Model;

class ExamResultModel extends Model
{
    protected $table      = 'exam_results';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    
    protected $allowedFields = [
        'exam_schedule_id', 'student_id', 'get_marks', 'note', 
        'is_absent', 'created_at', 'updated_at'
    ];
    
    // Get results by student
    public function getResultsByStudent($studentId, $examId)
    {
        return $this->select('exam_results.*, exam_schedules.exam_id, exam_schedules.date_of_exam, 
                             exam_schedules.start_to, exam_schedules.end_from, exam_schedules.room_no, 
                             exam_schedules.full_marks, exam_schedules.passing_marks, subjects.name as subject_name')
                    ->join('exam_schedules', 'exam_schedules.id = exam_results.exam_schedule_id')
                    ->join('subjects', 'subjects.id = exam_schedules.subject_id')
                    ->where('exam_results.student_id', $studentId)
                    ->where('exam_schedules.exam_id', $examId)
                    ->findAll();
    }
    
    // Get class results
    public function getClassResults($examId, $classId, $sectionId)
    {
        return $this->select('exam_results.*, students.firstname, students.lastname, 
                             students.roll_no, exam_schedules.subject_id')
                    ->join('exam_schedules', 'exam_schedules.id = exam_results.exam_schedule_id')
                    ->join('students', 'students.id = exam_results.student_id')
                    ->join('student_session', 'student_session.student_id = students.id')
                    ->where('exam_schedules.exam_id', $examId)
                    ->where('student_session.class_id', $classId)
                    ->where('student_session.section_id', $sectionId)
                    ->findAll();
    }
} 