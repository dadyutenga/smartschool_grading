<?php

namespace App\Models;

use CodeIgniter\Model;

class SectionModel extends Model
{
    protected $table      = 'sections';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    
    protected $allowedFields = [
        'section', 'is_active', 'created_at', 'updated_at'
    ];
    
    // Get sections by class
    public function getSectionsByClass($classId)
    {
        return $this->select('sections.*')
                    ->join('class_sections', 'class_sections.section_id = sections.id')
                    ->where('class_sections.class_id', $classId)
                    ->where('sections.is_active', 'yes')
                    ->findAll();
    }
} 