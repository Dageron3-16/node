<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\subproductos;
use App\Models\productos;
use App\Models\subcontenedores;
use Inertia\Inertia;
use App\Models\Contenedores;
use App\Models\gastoscups;
use App\Models\gastosusds;
use App\Models\ventas;
use Auth;

class SearchController extends Controller
{
    public function searchProducto(Request $request){
        $productos = productos::where('productos.name','LIKE','%'.$request->buscador.'%')
        ->orwhere('productos.factura','LIKE', '%'.$request->buscador.'%')
        ->paginate(120);
        //return $productos;
        
        return Inertia::render('Productos/index', ['productos' => $productos]);
    } 

    public function searchContenedor(Request $request){
        $contenedores = Contenedores::where('contenedor.name','LIKE','%'.$request->buscador.'%')->paginate(30);
        //return $productos;
        return Inertia::render('Contenedores/index', ['contenedores' => $contenedores]);
    } 

    public function searchSubContenedor(Request $request){
        $subcontenedores = subcontenedores::where('subcontenedores.name','LIKE','%'.$request->buscador.'%')->paginate(30);
        //return $productos;
        return Inertia::render('SubContenedor/index', ['subcontenedores' => $subcontenedores]);
    } 

    public function searchSubProductoCreate(Request $request){
        
        //return $productos;
        $user_id = Auth::user()->id;
        $contenedores = Contenedores::select('contenedores.id', 'contenedores.name','contenedores.provedor','contenedores.costo_contenedor', 'contenedores.valorusd_mercado','contenedores.costo_contenedor_limpio', 'contenedores.flete', 'contenedores.total_gastocup','contenedores.total_gastousd','contenedores.fecha_salida','contenedores.fecha_llegada','contenedores.tiempo_venta')
             ->where('users_id', '=', $user_id)
             ->get();
 
         
         
         $subcontenedores = subcontenedores::select('subcontenedores.id', 'subcontenedores.name','subcontenedores.costo_contenedor', 'subcontenedores.valorusd_mercado','subcontenedores.fecha')
             ->where('users_id', '=', $user_id)
             ->get();
         $newproductos = productos::where('productos.name','LIKE','%'.$request->buscador.'%')->where('users_id', '=', $user_id)->paginate(120);
         
        return Inertia::render('SubProducto/create', ['contenedores' => $contenedores, 'subcontenedores' => $subcontenedores,'newproductos' => $newproductos]);
    } 
    public function searchSubProducto(Request $request){
        $subproductos = subproductos::where('subproductos.name','LIKE','%'.$request->buscador.'%')->paginate(120);
        //return $productos;
        return Inertia::render('SubProducto/index', ['subproductos' => $subproductos]);
    } 

    public function searchgastousd(Request $request){
        $gastosusds = gastosusds::where('nombre_gastousd ','LIKE','%'.$request->buscador.'%')->paginate(30);
        //return $productos;
        return Inertia::render('Gastos/index', ['gastosusds' => $gastosusds]);
    } 

    public function searchgastocup(Request $request){
        $gastoscups = gastoscups::where('nombre_gastocup','LIKE','%'.$request->buscador.'%')->paginate(30);
        //return $productos;
        return Inertia::render('Gastos/gastoscup', ['gastoscups' => $gastoscups]);
    } 
}
