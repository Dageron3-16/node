<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class productos extends Model
{
    use HasFactory;
    protected $fillable = [
        'contenedores_id',
        'name', 
        'factura',
        'cod_producto',
        'cant_producto', 
        'cant_cajas',
        'precio_caja', 
        'precio_total',
        
        
    ];
    public $timestamps = false;


}
