<?php

namespace App\Http\Controllers;

use App\Models\Contenedores;
use App\Models\productos;
use App\Models\gastoscups;
use App\Models\gastosusds;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Requests;
use Inertia\Inertia;
use Auth;

class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $user_id = Auth::user()->id;
       $contenedores = Contenedores::select('contenedores.id', 'contenedores.name','contenedores.provedor','contenedores.costo_contenedor', 'contenedores.valorusd_mercado','contenedores.costo_contenedor_limpio', 'contenedores.flete', 'contenedores.total_gastocup','contenedores.total_gastousd','contenedores.fecha_salida','contenedores.fecha_llegada','contenedores.tiempo_venta')
            ->where('users_id', '=', $user_id)
            ->get();
                    
            $productos = productos::select('productos.id', 'productos.name','productos.factura','productos.cod_producto', 'productos.cant_producto','productos.cant_cajas', 'productos.precio_caja', 'productos.precio_total','productos.porciento_total','productos.costo_flete','productos.total_gastousd','productos.unitario_gastousd','productos.precio_unitariousd', 'contenedores_id')
            ->where('users_id', '=' , $user_id)
            ->get();
        $gastoscup  = gastoscups::select('gastoscups.id', 'gastoscups.nombre_gastocup', 'gastoscups.valor_gastocup', 'contenedores_id')
            ->where('users_id', '=' ,$user_id)->get();
            $gastosusd = gastosusds::select('gastosusds.id', 'gastosusds.nombre_gastousd', 'gastosusds.valor_gastousd', 'contenedores_id')
            ->where('users_id', '=', $user_id)->get();
        
        $data = ['success'=>true,
             'contenedores' => $contenedores,
             'productos' => $productos,
             'gastosusd' => $gastosusd,
             'gastoscup' => $gastoscup];
         
         return response()->json($data, 200, []);    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function exportar(Request $request)
    {
        
        $id = $request->contenedores_id;
        $name = Contenedores::select('contenedores.name')->where('id', '=', $id)->get();
        $contenedores = Contenedores::select('contenedores.id', 'contenedores.name','contenedores.provedor','contenedores.costo_contenedor', 'contenedores.valorusd_mercado','contenedores.costo_contenedor_limpio', 'contenedores.flete', 'contenedores.total_gastocup','contenedores.total_gastousd','contenedores.fecha_salida','contenedores.fecha_llegada','contenedores.tiempo_venta')
            ->where('id', '=', $id)
            ->get();

        $productos =  $productos = productos::select('productos.id', 'productos.name','productos.factura','productos.cod_producto', 'productos.cant_producto','productos.cant_cajas', 'productos.precio_caja', 'productos.precio_total','productos.precio_unitariousd','productos.porciento_total','productos.costo_flete', 'productos.total_gastousd','productos.unitario_gastousd','contenedores_id')
        ->where('contenedores_id', '=' , $id)
        ->get();
        $gastosusd = gastosusds::select('gastosusds.factura_gastosusd','gastosusds.nombre_gastousd', 'gastosusds.valor_gastousd', 'contenedores_id')
        ->where('contenedores_id', '=' , $id)
        ->get();
        $gastoscup = gastoscups::select('gastoscups.factura_gastoscup','gastoscups.nombre_gastocup', 'gastoscups.valor_gastocup', 'contenedores_id');
        $data = ['success'=>true,
             'contenedores' => $contenedores,
             'productos' => $productos,
             'gastosusd' => $gastosusd,
             'gastoscup' => $gastoscup];

             
    return Inertia::render('Contenedores/exportar', ['contenedores' => $contenedores, 'productos' => $productos, 'gastosusd' => $gastosusd, 'gastoscup'=> $gastoscup ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contenedores $contenedores)
    {
        
    }
    public function pintar(Request $request){
        $content_current = file_get_contents($request->file);
        $json_current = json_decode($content_current, true);


         $json = print_r($json_current['productos']);
        return $json;
        
    }

    public function import(Request $request)
    {
        $user_id = Auth::user()->id;
        
        
        
        //$json = file_get_contents($request->file);
        //$data = json_decode($json);
        $content_current = file_get_contents($request->file);
        $json_current = json_decode($content_current, true);
        //print_r($json_current);
        
        
        
        //los datos del contenedor
            $contenedor = new Contenedores();
            $contenedor->users_id = $user_id;
            $contenedor->name = $json_current['contenedores'][0]['name'];
            $contenedor->provedor = $json_current['contenedores'][0]['provedor'];
            $contenedor->costo_contenedor = $json_current['contenedores'][0]['costo_contenedor'];
            $contenedor->valorusd_mercado = $json_current['contenedores'][0]['valorusd_mercado'];
            $contenedor->costo_contenedor_limpio = $json_current['contenedores'][0]['costo_contenedor_limpio'];
            $contenedor->flete = $json_current['contenedores'][0]['flete'];
            $contenedor->total_gastocup = $json_current['contenedores'][0]['total_gastocup'];
            $contenedor->fecha_salida = $json_current['contenedores'][0]['fecha_salida'];
            $contenedor->fecha_llegada = $json_current['contenedores'][0]['fecha_llegada'];
            $contenedor->tiempo_venta = $json_current['contenedores'][0]['tiempo_venta'];
            $contenedor->save();
        
            



//los datos de 1 producto
       
       foreach($json_current['productos'] as $row ){
            $producto = new productos();
            $producto->users_id = $user_id;
            $producto->name = $row['name'];
            $producto->factura = $row['factura'];
            $producto->cod_producto = $row['cod_producto'];
            $producto->cant_producto = $row['cant_producto'];
            $producto->cant_cajas  = $row['cant_cajas'];
            $producto->precio_caja  = $row['precio_caja'];
            $producto->precio_total = $row['precio_total'];
            $producto->precio_unitariousd = $row['precio_unitariousd'];
            $producto->porciento_total = $row['porciento_total'];
            $producto->costo_flete = $row['costo_flete'];
            $producto->total_gastousd = $row['total_gastousd'];
            $producto->unitario_gastousd  = $row['unitario_gastousd'];
            $producto->contenedores_id = $row['contenedores_id'];
            $producto->save();
       }

//los datos de los gastosusd
        foreach($json_current['gastosusd'] as $row ){
            $gastosusd = new gastosusds();
            $gastosusd->users_id = $user_id;
            $gastosusd->factura_gastosusd = $row['factura_gastosusd'];
            $gastosusd->nombre_gastousd = $row['nombre_gastousd'];
            $gastosusd->valor_gastousd = $row['valor_gastousd'];
            $gastosusd->contenedores_id = $row['contenedores_id'];
            $gastosusd->save();
}
//los datos de los gastosusd    
        foreach($json_current['gastoscup'] as $row ){
            $gastoscup = new gastoscups();
            $gastoscup->users_id = $user_id;
            $gastoscup->factura_gastoscup = $row['factura_gastoscup'];
            $gastoscup->nombre_gastoscup = $row['nombre_gastoscup'];
            $gastoscup->valor_gastoscup = $row['valor_gastoscup'];
            $gastoscup->contenedores_id = $row['contenedores_id'];
            $gastoscup->save();
        }
        return redirect('contenedor');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contenedores $contenedores)
    {
        //
    }
}
