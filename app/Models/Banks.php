<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banks extends Model
{
    use HasFactory;

    protected $table = 'banks';

    protected $fillable = [
        'id_Planification',
        'questions_json',
    ];


    public function planification()
    {
        return $this->belongsTo(Planification::class,'id_Planification');
    }

    public function tests()
    {
        return $this->hasMany(Test::class, 'id_Bank');
    }


}
