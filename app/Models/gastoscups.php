<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class gastoscups extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre_gastocup',
        'valor_gastocup',
        'contenedores_id'
    ];
    public $timestamps = false;
}
