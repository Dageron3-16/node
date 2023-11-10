<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use App\Models\Contenedores;
use App\Models\gastoscups;
use App\Models\productos;
use App\Models\gastosusds;
use Illuminate\Http\Request;
use Auth;

class ContenedoresController extends Controller
{
    public function index()
    {
       $user_id = Auth::user()->id;
       $contenedores = Contenedores::select('contenedores.id', 'contenedores.name','contenedores.provedor','contenedores.costo_contenedor', 'contenedores.valorusd_mercado','contenedores.costo_contenedor_limpio', 'contenedores.flete', 'contenedores.total_gastocup','contenedores.total_gastousd','contenedores.fecha_salida','contenedores.fecha_llegada','contenedores.tiempo_venta')
            ->where('users_id', '=', $user_id)
            ->paginate(10);
                    
            $producto = productos::select('productos.id', 'productos.name','productos.factura','productos.cod_producto', 'productos.cant_producto','productos.cant_cajas', 'productos.precio_caja', 'productos.precio_total','productos.porciento_total','productos.costo_flete','productos.total_gastousd','productos.unitario_gastousd','productos.precio_unitariousd', 'contenedores_id')
            ->where('users_id', '=' , $user_id)
            ->get();
       return Inertia::render('Contenedores/index', ['contenedores' => $contenedores, 'productos' => $producto ]);
    }

    
    public function create()
    {
        
        
        return Inertia::render('Contenedores/create');
    }

    
    public function store(Request $request)
    {
       $user_id = Auth::user()->id; 
       $contenedor = new Contenedores($request->all());
       $contenedor->users_id = $user_id;        
       $contenedor->save();
       return redirect('contenedor');
    }

    
    
    

   
    public function edit(Contenedores $contenedor)
    {
        return Inertia::render('Contenedores/edit', ['contenedores' => $contenedor] );
    }

   
    public function update(Request $request, Contenedores $contenedor)
    {
        $contenedor->update($request->all());
        return redirect('contenedor');
    }

   
    public function destroy(Contenedores $contenedor)
    {
      $user_id = Auth::user()->id;  
      $factura = $contenedor->name;
      $gastosusd = gastosusds::select('gastosusds.id','users_id', 'gastosusds.factura_gastosusd','gastosusds.nombre_gastousd', 'gastosusds.valor_gastousd', 'contenedores_id')
      ->where('factura_gastosusd','=',$factura)
      ->where('users_id','=', $user_id)
      ->delete();
      $gastoscup  = gastoscups::select('gastoscups.id','gastoscups.users_id','gastoscups.factura_gastoscup', 'gastoscups.nombre_gastocup', 'gastoscups.valor_gastocup', 'contenedores_id')
      ->where('factura_gastoscup','=',$factura)
      ->where('users_id','=', $user_id)
      ->delete();
      $producto = productos::select('productos.id','productos.users_id','productos.name','productos.factura','productos.cod_producto', 'productos.cant_producto','productos.cant_cajas', 'productos.precio_caja', 'productos.precio_total','productos.porciento_total','productos.costo_flete','productos.total_gastousd','productos.unitario_gastousd','productos.precio_unitariousd', 'contenedores_id')
      ->where('factura','=',$factura)
      ->where('users_id','=', $user_id)
      ->delete();
      
      $contenedor->delete(); 
      return redirect('contenedor');
    }
    public function DetailsbyContenedor($id) {
        $contenedores = Contenedores::find($id);
        $factura = $contenedores->name;
        $productos = productos::where('productos.factura','LIKE', $factura)
        ->paginate(15);
    
    
    return Inertia::render('Productos/detalles', ['productos' => $productos]);
    }
    
    public function CostoTotal($id)
    {

       $totalusd = 0 ;
       $totalcup = 0 ;
       $contenedor = Contenedores::find($id);
       $factura = $contenedor->name;
       $costototalusd = gastosusds::select('valor_gastousd')
       ->where('factura_gastosusd', '=', $factura)
       ->get();
       $costototalcup = gastoscups::select('valor_gastocup')
       ->where('factura_gastoscup', '=', $factura)
       ->get();
       
       foreach($costototalusd as $costousd)
       {
        $totalusd+=$costousd->valor_gastousd;
       }
       foreach($costototalcup as $costocup)
       {
        $totalcup+=$costocup->valor_gastocup;
       }
       $totalusd += $contenedor->flete; 
       $contenedor-> total_gastousd = $totalusd;
       $contenedor-> total_gastocup = $totalcup;
       $contenedor->costo_contenedor_limpio = $contenedor->costo_contenedor - $contenedor-> total_gastousd ;
       $contenedor-> update();
     
       return ;
    }
     public function DuplicarCon($id)
    {   //duplicar contenedor
        $contenedor = Contenedores::find($id);
        $duplicados = $contenedor->replicate();
        $duplicados->push();
        $contenedor = Contenedores::all();
        //duplicar producto
        $productos = productos::select('productos.id', 'productos.nombre_producto', 'productos.cant_producto','productos.cant_cajas', 'productos.precio_caja', 'productos.precio_total','productos.precio_unitariousd','productos.porciento_total','productos.costo_flete','productos.producto_gastousd','productos.unitario_gastousd', 'contenedores_id')
        ->where('contenedores_id', '=' , $id)
        ->get();
        $id = $duplicados->id;
        foreach($productos as $producto){
            $producto->replicate()->save();
            $producto->contenedores_id = $id;
            $producto->update();
        }
        $productos = productos::select('productos.id', 'productos.nombre_producto', 'productos.cant_producto','productos.cant_cajas', 'productos.precio_caja', 'productos.precio_total','productos.precio_unitariousd','productos.porciento_total','productos.costo_flete','productos.producto_gastousd','productos.unitario_gastousd', 'contenedores_id')
        ->where('contenedores_id', '=' , $id)
        ->get();
        //duplicar gasto USD
        $gastousd = gastosusds::select('gastosusds.id', 'gastosusds.nombre_gastousd', 'gastosusds.valor_gastousd', 'contenedores_id')
        ->where('contenedores_id', '=' , $id)
        ->get();
        $id = $gastousd->id;
        foreach($gastousd as $gasto){
            $gasto->replicate()->save();
            $gasto->contenedores_id = $id;
            $gasto->update();
        }
        $gastousd = gastosusds::select('gastosusds.id', 'gastosusds.nombre_gastousd', 'gastosusds.valor_gastousd', 'contenedores_id')
        ->where('contenedores_id', '=' , $id)
        ->get();
        //duplicar gasto cup
        $gastocup = gastoscups::select('gastoscups.id', 'gastoscups.nombre_gastocup', 'gastoscups.valor_gastocup', 'contenedores_id')
        ->where('contenedores_id', '=' , $id)
        ->get();
        $id = $gastocup->id;
        foreach($gastocup as $gasto){
            $gasto->replicate()->save();
            $gasto->contenedores_id = $id;
            $gasto->update();
        }
        $gastocup = gastoscups::select('gastoscups.id', 'gastoscups.nombre_gastocup', 'gastoscups.valor_gastocup', 'contenedores_id')
        ->where('contenedores_id', '=' , $id)
        ->get();
        return Inertia::render('Productos/editarnew', ['contenedores' => $contenedor, 'productos' => $productos, 'gastosusd' => $gastousd,'gastoscup' => $gastocup] );
    }
    public function nuevoPro(Request $request)
    {
       $producto = new Productos($request->input());
       $producto->save();
       return redirect('Productos/editarnew');
    }
    public function subcontenedor(){
        $contenedor = Contenedores::all();
        return Inertia::render('Contenedores/createSub', ['contenedores' => $contenedor] );
    }
    
    public function export()
    {
        $user_id = Auth::user()->id;
        $contenedores = Contenedores::select('contenedores.id', 'contenedores.name','contenedores.provedor','contenedores.costo_contenedor', 'contenedores.valorusd_mercado','contenedores.costo_contenedor_limpio', 'contenedores.flete', 'contenedores.total_gastocup','contenedores.total_gastousd','contenedores.fecha_salida','contenedores.fecha_llegada','contenedores.tiempo_venta')
             ->where('users_id', '=', $user_id)
             ->get();
        return Inertia::render('Contenedores/file', ['contenedores' => $contenedores]);
    }

    public function importar(Request $request)
    {
        
        return Inertia::render('Contenedores/importar');
    }



}

