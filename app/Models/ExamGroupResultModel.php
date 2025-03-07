<?php

namespace App\Models;

use CodeIgniter\Model;

class ExamGroupResultModel extends Model
{
    protected $table      = 'exam_group_exam_results';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    
    protected $allowedFields = [
        'exam_group_student_id', 'exam_group_exam_subject_id', 'attendence', 
        'get_marks', 'note', 'is_absent', 'created_at', 'updated_at'
    ];
    
    // Get group results by student
    public function getGroupResultsByStudent($studentId, $examGroupId)
    {
        return $this->select('exam_group_exam_results.*, exam_group_exam_subjects.subject_id, 
                             exam_group_exam_subjects.max_marks, exam_group_exam_subjects.min_marks, 
                             subjects.name as subject_name')
                    ->join('exam_group_exam_subjects', 'exam_group_exam_subjects.id = exam_group_exam_results.exam_group_exam_subject_id')
                    ->join('exam_group_students', 'exam_group_students.id = exam_group_exam_results.exam_group_student_id')
                    ->join('subjects', 'subjects.id = exam_group_exam_subjects.subject_id')
                    ->where('exam_group_students.student_id', $studentId)
                    ->where('exam_group_exam_subjects.exam_group_id', $examGroupId)
                    ->findAll();
    }
} 