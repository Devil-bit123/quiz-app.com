<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $table = 'courses';

    protected $fillable = [
        'id',
        'name',
        'description'
    ];


    public function courseUsers()
    {
        return $this->hasMany(CourseUser::class, 'id_Course');
    }


}
