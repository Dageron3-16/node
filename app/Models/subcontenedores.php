<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subcontenedores extends Model
{
    use HasFactory;
    
    protected $fillable = ['id','costo_contenedor', 'flete','total_gastocup','total_gastousd','costo_contenedor_limpio','name','valorusd_mercado','provedor', 'fecha'];
    public $timestamps = false;

}
