<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;

    protected $table = 'tests';

    protected $fillable = [
        'id_Bank',
        'question_number',
        'duration_in_minutes'

    ];

    public function bank()
    {
        return $this->belongsTo(Banks::class, 'id_Bank');
    }

    public function responses()
    {
        return $this->hasMany(Responses::class,'id_Test');
    }

}
