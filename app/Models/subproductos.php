<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subproductos extends Model
{
    use HasFactory;
    protected $fillable = [
        'subcontenedores_id',
        'factura',
        'cod_producto',
        'name', 
        'cant_producto', 
        'cant_cajas',
        'precio_caja', 
        'precio_total',
        
        
    ];
    public $timestamps = false;

}
