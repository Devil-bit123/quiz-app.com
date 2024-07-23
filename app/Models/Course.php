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


    public function banks()
    {
        return $this->hasMany(Banks::class);
    }


    public function users()
    {
        return $this->belongsToMany(User::class, 'course_user', 'id_Course', 'id_User');
    }

}
