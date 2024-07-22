<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseUser extends Model
{
    use HasFactory;

    protected $table = 'course_user';

    protected $fillable = [
        'id_Course',
        'id_User',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class, 'id_Course');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_User');
    }

}
