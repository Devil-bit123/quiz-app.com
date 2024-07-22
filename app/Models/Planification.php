<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planification extends Model
{
    use HasFactory;

    protected $table = 'planifications';

    protected $fillable = [
        'name',
        'description',
        'type',
        'date',
    ];

    // Constantes para tipos
    const TYPE_TASK = 'task';
    const TYPE_TEST = 'test';
    const TYPE_CLASS = 'class';

     /**
     * Obtener todos los tipos de planificación posibles.
     *
     * @return array
     */
    public static function getTypes()
    {
        return [
            self::TYPE_TASK,
            self::TYPE_TEST,
            self::TYPE_CLASS,
        ];
    }

}
