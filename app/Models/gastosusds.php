<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class gastosusds extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre_gastousd',
        'valor_gastousd',
        'contenedores_id'
    ];
    public $timestamps = false;
}
