<?php

namespace App\Http\Controllers;

use App\Models\subproductos;
use App\Models\productos;
use App\Models\subcontenedores;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Contenedores;
use App\Models\gastoscups;
use App\Models\gastosusds;
use App\Models\ventas;
use Auth;

class SubproductosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        $subproductos = subproductos::select('subproductos.id', 'subproductos.name','subproductos.name_subcontenedor', 'subproductos.cant_producto','subproductos.cant_cajas', 'subproductos.precio_caja', 'subproductos.precio_total','subproductos.porciento_total','subproductos.costo_flete','subproductos.total_gastousd','subproductos.unitario_gastousd','subproductos.precio_unitariousd', 'contenedores_id')
        ->where('users_id', '=' , $user_id)
        ->paginate(10);
        $subcontenedores = subcontenedores::select('subcontenedores.id', 'subcontenedores.name','subcontenedores.costo_contenedor', 'subcontenedores.valorusd_mercado','subcontenedores.fecha')
            ->where('users_id', '=', $user_id)
            ->get();
        
    
        return Inertia::render('SubProducto/index', ['subproductos' => $subproductos, 'subcontenedores' => $subcontenedores]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $user_id = Auth::user()->id;
       $contenedores = Contenedores::select('contenedores.id', 'contenedores.name','contenedores.provedor','contenedores.costo_contenedor', 'contenedores.valorusd_mercado','contenedores.costo_contenedor_limpio', 'contenedores.flete', 'contenedores.total_gastocup','contenedores.total_gastousd','contenedores.fecha_salida','contenedores.fecha_llegada','contenedores.tiempo_venta')
            ->where('users_id', '=', $user_id)
            ->get();

        $productos = productos::select('productos.id', 'productos.name','productos.factura','productos.cod_producto', 'productos.cant_producto','productos.cant_cajas', 'productos.precio_caja', 'productos.precio_total','productos.porciento_total','productos.costo_flete','productos.total_gastousd','productos.unitario_gastousd','productos.precio_unitariousd', 'contenedores_id')
            ->where('users_id', '=' , $user_id)
            
            ->get();
        $subproductos = subproductos::select('subproductos.id','subproductos.factura','subproductos.cod_producto','subproductos.name', 'subproductos.cant_producto','subproductos.cant_cajas', 'subproductos.precio_caja', 'subproductos.precio_total','subproductos.porciento_total','subproductos.costo_flete','subproductos.total_gastousd','subproductos.unitario_gastousd','subproductos.precio_unitariousd', 'contenedores_id')
        ->join('contenedores', 'contenedores.id', '=' ,'subproductos.contenedores_id')
        ->get();
        $subcontenedores = subcontenedores::select('subcontenedores.id', 'subcontenedores.name','subcontenedores.costo_contenedor', 'subcontenedores.valorusd_mercado','subcontenedores.fecha')
            ->where('users_id', '=', $user_id)
            ->get();
        $search_producto = productos::where('productos.name','LIKE','%'.$request->buscador.'%')->get();
        $newproductos = productos::select('productos.id', 'productos.name','productos.factura','productos.cod_producto', 'productos.cant_producto','productos.cant_cajas', 'productos.precio_caja', 'productos.precio_total','productos.porciento_total','productos.costo_flete','productos.total_gastousd','productos.unitario_gastousd','productos.precio_unitariousd', 'contenedores_id')
        ->where('contenedores_id', '=' , $request->contenedores_id)
        ->paginate(5);
        return Inertia::render('SubProducto/create', ['contenedores' => $contenedores,'productos' => $productos, 'subproductos' => $subproductos, 'subcontenedores' => $subcontenedores, 'search_producto' => $search_producto, 'newproductos' => $newproductos]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {}


    public function Adicionar(Request $request, $id)
    {
        $user_id = Auth::user()->id;
        
        $aux = productos::find($id);
        
        $id_subcontenedor = $request->subcontenedor_id;
        $subcontenedor = subcontenedores::find($id_subcontenedor);
        $subproductos = new subproductos();
        $subproductos->users_id = $user_id;
        $subproductos->subcontenedores_id = $request->subcontenedor_id;
        $subproductos->name_subcontenedor = $subcontenedor->name;
        $subproductos->name = $aux->name;
        $subproductos->contenedores_id = $aux->contenedores_id;
        $subproductos->factura = $aux->factura;
        $subproductos->unitario_gastousd = $aux->unitario_gastousd;
        $subproductos->cod_producto = $aux->cod_producto;
        $subproductos->cant_cajas = $request->cant_cajas;
        $subproductos->cant_producto = $aux->cant_producto;
        $subproductos->precio_caja = $aux->precio_caja;
        $subproductos->precio_total = $aux->cant_producto * $request->cant_cajas * $aux->unitario_gastousd;
        $subproductos->precio_unitariousd = $aux->precio_unitariousd;
        $subproductos->porciento_total = $aux->porciento_total;
        $subproductos->costo_flete = $aux->costo_flete;
        $subproductos->total_gastousd = $aux->total_gastousd;
               
        $subproductos->users_id = $user_id;
        $subproductos->save();


        
        $user_id = Auth::user()->id;
       $contenedores = Contenedores::select('contenedores.id', 'contenedores.name','contenedores.provedor','contenedores.costo_contenedor', 'contenedores.valorusd_mercado','contenedores.costo_contenedor_limpio', 'contenedores.flete', 'contenedores.total_gastocup','contenedores.total_gastousd','contenedores.fecha_salida','contenedores.fecha_llegada','contenedores.tiempo_venta')
            ->where('users_id', '=', $user_id)
            ->get();

        $productos = productos::select('productos.id', 'productos.name','productos.factura','productos.cod_producto', 'productos.cant_producto','productos.cant_cajas', 'productos.precio_caja', 'productos.precio_total','productos.porciento_total','productos.costo_flete','productos.total_gastousd','productos.unitario_gastousd','productos.precio_unitariousd', 'contenedores_id')
            ->where('users_id', '=' , $user_id)
            
            ->get();
        $subproductos = subproductos::select('subproductos.id','subproductos.factura','subproductos.cod_producto','subproductos.name', 'subproductos.cant_producto','subproductos.cant_cajas', 'subproductos.precio_caja', 'subproductos.precio_total','subproductos.porciento_total','subproductos.costo_flete','subproductos.total_gastousd','subproductos.unitario_gastousd','subproductos.precio_unitariousd', 'contenedores_id')
        ->join('contenedores', 'contenedores.id', '=' ,'subproductos.contenedores_id')
        ->get();
        $subcontenedores = subcontenedores::select('subcontenedores.id', 'subcontenedores.name','subcontenedores.costo_contenedor', 'subcontenedores.valorusd_mercado','subcontenedores.fecha')
            ->where('users_id', '=', $user_id)
            ->get();
        $search_producto = productos::where('productos.name','LIKE','%'.$request->buscador.'%')->get();
        $newproductos = productos::select('productos.id', 'productos.name','productos.factura','productos.cod_producto', 'productos.cant_producto','productos.cant_cajas', 'productos.precio_caja', 'productos.precio_total','productos.porciento_total','productos.costo_flete','productos.total_gastousd','productos.unitario_gastousd','productos.precio_unitariousd', 'contenedores_id')
        ->where('contenedores_id', '=' , $aux->contenedores_id)
        ->paginate(5);
        return Inertia::render('SubProducto/create', ['contenedores' => $contenedores,'productos' => $productos, 'subproductos' => $subproductos, 'subcontenedores' => $subcontenedores, 'search_producto' => $search_producto, 'newproductos' => $newproductos]);
        
        
        
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
       
           
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(subproductos $subproductos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $subproducto = subproductos::find($id);
        $subproducto->name = $request->name;
        $subproducto->cant_cajas = $request->cant_cajas;        
        $subproducto->precio_total = $subproducto->cant_producto * $request->cant_cajas * $subproducto->unitario_gastousd;
        
        $subproducto -> update();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $subproducto = subproductos::find($id);
        $subproducto->delete();
        return redirect ('subproducto');
    }


    public function subcalcular($id)
    {
       $subproducto = subproductos::find($id);
       $idcon = $subproducto->contenedores_id;
       $subcontenedor = Contenedores::find($idcon);
       
       $subproducto-> update();  
       return redirect('subproducto');
    }






}
