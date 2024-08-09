<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Responses extends Model
{
    use HasFactory;

    protected $table = 'responses';

    protected $fillable = [
        'id_Test',
        'id_User',
        'responses',
        'score',
        'status'
    ];

    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_User');
    }


}
