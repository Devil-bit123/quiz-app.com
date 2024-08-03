<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanificationCourse extends Model
{
    use HasFactory;

    protected $table = 'planification_courses';

    protected $fillable = [
        'id_Course',
        'id_Planification'
    ];

    // PlanificationCourse.php
    public function planification()
    {
        return $this->belongsTo(Planification::class, 'id_Planification');
    }

    public function courses()
    {
        return $this->belongsTo(Course::class, 'id_Course');
    }



}
