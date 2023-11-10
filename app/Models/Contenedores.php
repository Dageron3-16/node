<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contenedores extends Model
{
    use HasFactory;
    protected $fillable = ['id','costo_contenedor', 'flete','total_gastocup','total_gastousd','costo_contenedor_limpio','name','valorusd_mercado','provedor', 'fecha_llegada','fecha_salida','tiempo_venta'];
    public $timestamps = false;
}
