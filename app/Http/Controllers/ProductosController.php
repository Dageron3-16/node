<?php

namespace App\Http\Controllers;
use App\Models\Contenedores;
use App\Models\productos;
use App\Models\subcontenedores;
use App\Models\subproductos;
use App\Models\gastoscups;
use App\Models\gastosusds;
use App\Models\ventas;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Auth;


class ProductosController extends Controller
{
    
    public function index()
    {
        $user_id = Auth::user()->id;
        
        $productos = productos::select('productos.id', 'productos.name','productos.factura','productos.cod_producto', 'productos.cant_producto','productos.cant_cajas', 'productos.precio_caja', 'productos.precio_total','productos.porciento_total','productos.costo_flete','productos.total_gastousd','productos.unitario_gastousd','productos.precio_unitariousd', 'contenedores_id')
            ->where('users_id', '=' , $user_id)
            ->paginate(10);
       
        $contenedores = Contenedores::select('contenedores.id', 'contenedores.name','contenedores.provedor','contenedores.costo_contenedor', 'contenedores.valorusd_mercado','contenedores.costo_contenedor_limpio', 'contenedores.flete', 'contenedores.total_gastocup','contenedores.total_gastousd','contenedores.fecha_salida','contenedores.fecha_llegada','contenedores.tiempo_venta')
        ->where('users_id', '=', $user_id)
        ->get();
         
        
        return Inertia::render('Productos/index', ['productos' => $productos,
        'contenedores' => $contenedores]);
    }

    
    public function create()
    {
        return Inertia::render('SubProducto/create');

    }

    
    public function store(Request $request)
    {/*
        $request->validate([
            'nombre_producto' => 'requerid|max:150',
            'cant_producto' => 'requerid|numeric',
            'cant_parle' => 'requerid|numeric',
            'precio_total' => 'requerid|numeric',
            'precio_unitario' => 'requerid|numeric',
            'precio_producto' => 'requerid|numeric', 
            'producto_flete' => 'requerid|numeric',
            'costo_total_gasto' => 'requerid|numeric',
            'precio_total_gasto' => 'requerid|numeric',
            'precio_unitario_gasto' => 'requerid|numeric'

        ]);
        */
        $user_id = Auth::user()->id; 
        $contenedor = Contenedores::find($request->contenedores_id);
        $producto = new productos($request->input());
        $producto->factura = $contenedor->name;
        $producto->precio_total = $request->precio_caja * $request->cant_cajas;
        $producto->precio_unitariousd = (($producto->precio_total / $request->cant_cajas) / $request->cant_producto);
        $producto->users_id = $user_id;
        $producto-> save();
        return redirect('productos');
    }
    
    public function storenew(Request $request)
    {/*
        $request->validate([
            'nombre_producto' => 'requerid|max:150',
            'cant_producto' => 'requerid|numeric',
            'cant_parle' => 'requerid|numeric',
            'precio_total' => 'requerid|numeric',
            'precio_unitario' => 'requerid|numeric',
            'precio_producto' => 'requerid|numeric',
            'producto_flete' => 'requerid|numeric',
            'costo_total_gasto' => 'requerid|numeric',
            'precio_total_gasto' => 'requerid|numeric',
            'precio_unitario_gasto' => 'requerid|numeric'

        ]);
        */
        $producto = new productos($request->input());
        $producto->precio_total = $request->precio_caja * $request->cant_cajas;
        $producto->precio_unitariousd = (($producto->precio_total / $request->cant_cajas) / $request->cant_producto);
        $producto-> save();
        $id = $request->contenedores_id;
        $productos = productos::select('productos.id', 'productos.name', 'productos.cant_producto','productos.cant_cajas', 'productos.precio_caja', 'productos.precio_total','productos.precio_unitariousd','productos.porciento_total','productos.costo_flete','productos.total_gastousd','productos.gastousd', 'contenedores_id')
        ->where('contenedores_id', '=' , $id)
        ->get();
        $contenedor = Contenedores::all();
        return Inertia::render('Productos/editarnew', ['contenedores' => $contenedor, 'productos' => $productos] );
        
    }
   
    
    

    
    public function update(Request $request, $id)
    {/*
        $request->validate([
            'nombre_producto' => 'requerid|max:150',
            'cant_producto' => 'requerid|numeric',
            'cant_parle' => 'requerid|numeric',
            'cant_cajas' 
            'precio_total' => 'requerid|numeric',
            'precio_unitario' => 'requerid|numeric',
            'precio_producto' => 'requerid|numeric',
            'producto_flete' => 'requerid|numeric',
            'costo_total_gasto' => 'requerid|numeric',
            'precio_total_gasto' => 'requerid|numeric',
            'precio_unitario_gasto' => 'requerid|numeric'

        ]);
        */
        $producto = productos::find($id);
        $producto->name = $request->name;
        $producto->cant_producto = $request->cant_producto; 
        $producto->cant_cajas = $request->cant_cajas;        
        $producto->precio_caja = $request->precio_caja;
        $producto->precio_total = $request->cant_producto * $request->precio_caja;
        $producto->precio_unitariousd  = (($producto->precio_total / $request->cant_cajas) / $request->cant_producto);
        $producto -> save();
        
        return;
          
    }
    public function updatenew(Request $request, $id)
    {/*
        $request->validate([
            'nombre_producto' => 'requerid|max:150',
            'cant_producto' => 'requerid|numeric',
            'cant_parle' => 'requerid|numeric',
            'cant_cajas' 
            'precio_total' => 'requerid|numeric',
            'precio_unitario' => 'requerid|numeric',
            'precio_producto' => 'requerid|numeric',
            'producto_flete' => 'requerid|numeric',
            'costo_total_gasto' => 'requerid|numeric',
            'precio_total_gasto' => 'requerid|numeric',
            'precio_unitario_gasto' => 'requerid|numeric'

        ]);
        */
        $producto = productos::find($id);
        $producto->name = $request->name;
        $producto->cant_producto = $request->cant_producto; 
        $producto->cant_cajas = $request->cant_cajas;        
        $producto->precio_producto = $request->precio_producto;
        $producto->precio_total = $request->cant_producto * $request->precio_caja;
        $producto->precio_unitariousd  = (($request->precio_total / $request->cant_cajas) / $request->cant_producto); 
        $producto -> update();
        $id = $producto->contenedores_id;
        $productos = productos::select('productos.id', 'productos.name', 'productos.cant_producto','productos.cant_cajas', 'productos.cant_parle', 'productos.precio_producto', 'productos.precio_total','productos.precio_unitario','productos.porciento_total','productos.costo_flete', 'contenedores_id')
        ->where('contenedores_id', '=' , $id)
        ->get();
        $contenedor = Contenedores::all();
        return Inertia::render('Productos/editarnew', ['contenedores' => $contenedor, 'productos' => $productos] );
          
    }

   
    public function destroy($id)
    {
        $producto = productos::find($id);
        $producto->delete();
        return redirect ('productos');

    }
    public function destroynew($id)
    {
        $producto = productos::find($id);
        $producto->delete();
        $id = $producto->contenedores_id;
        $productos = productos::select('productos.id', 'productos.name', 'productos.cant_producto','productos.cant_cajas', 'productos.cant_parle', 'productos.precio_producto', 'productos.precio_total','productos.precio_unitario','productos.porciento_total','productos.costo_flete', 'contenedores_id')
        ->where('contenedores_id', '=' , $id)
        ->get();
        $contenedor = Contenedores::all();
        return Inertia::render('Productos/editarnew', ['contenedores' => $contenedor, 'productos' => $productos] );
        return redirect ('productos');

    }
    public function ProductoByContenedor()
    {
        $data = productos::select(DB::raw('count(productos.id) as count, contenedores.id'))
        ->join('contenedores', 'contenedores.id', '=' ,'productos.contenedores_id')
        ->groupBy('contenedores_id')->get();
        return Inertia::render('Productos/graphic', ['data' => $data]);
    }
    public function calculate($id)
    {
       $producto = productos::find($id);
       $idcon = $producto->contenedores_id;
       $contenedor = Contenedores::find($idcon);
       $producto->porciento_total = $producto->precio_total / $contenedor->costo_contenedor_limpio * 100 ;
       $producto->costo_flete = $contenedor-> total_gastousd * $producto->porciento_total / 100;
       $producto->total_gastousd = $producto->precio_total + $producto->costo_flete;
       $producto->unitario_gastousd = $producto->total_gastousd / $producto->cant_cajas / $producto->cant_producto;
       $producto-> update();  
       return;
    }
    public function calculatenew($id)
    {
       $producto = productos::find($id);
       $idcon = $producto->contenedores_id;
       $contenedor = Contenedores::find($idcon);
       $producto->porciento_total = $producto->precio_total / $contenedor->costo_contenedor_limpio * 100 ;
       $producto->costo_flete = $contenedor-> total_gasto * $producto->porciento_total / 100;
       $producto-> update();
       $id = $producto->contenedores_id;
       $productos = productos::select('productos.id', 'productos.name', 'productos.cant_producto','productos.cant_cajas', 'productos.precio_caja', 'productos.precio_total','productos.precio_unitario','productos.porciento_total','productos.costo_flete', 'contenedores_id')
       ->where('contenedores_id', '=' , $id)
       ->get();
       $contenedor = Contenedores::all();
       return Inertia::render('Productos/editarnew', ['contenedores' => $contenedor, 'productos' => $productos] );
    }
    public function datosventa(){
        $contenedor = Contenedores::all();
        $productos = productos::all();
        return Inertia::render('Productos/datos', ['contenedores' => $contenedor, 'productos' => $productos] );
    }
    
    
    public function reporte()
    {
            
        $user_id = Auth::user()->id;
           
        $productos = productos::select('productos.id', 'productos.name','productos.factura','productos.cod_producto', 'productos.cant_producto','productos.cant_cajas', 'productos.precio_caja', 'productos.precio_total','productos.porciento_total','productos.costo_flete','productos.total_gastousd','productos.unitario_gastousd','productos.precio_unitariousd', 'contenedores_id')
            ->where('users_id', '=' , $user_id)
            ->get();
           
        $contenedores = Contenedores::select('contenedores.id', 'contenedores.name','contenedores.provedor','contenedores.costo_contenedor', 'contenedores.valorusd_mercado','contenedores.costo_contenedor_limpio', 'contenedores.flete', 'contenedores.total_gastocup','contenedores.total_gastousd','contenedores.fecha_salida','contenedores.fecha_llegada','contenedores.tiempo_venta')
            ->where('users_id', '=', $user_id)
            ->get();
          
        $gastosusd = gastosusds::select('gastosusds.id', 'gastosusds.nombre_gastousd', 'gastosusds.valor_gastousd', 'contenedores_id')
            ->where('users_id', '=', $user_id)
            ->get();
           
        $gastoscup  = gastoscups::select('gastoscups.id', 'gastoscups.nombre_gastocup', 'gastoscups.valor_gastocup', 'contenedores_id')
            ->where('users_id', '=' ,$user_id)
            ->get();
          
        $ventas = ventas::select('ventas.id', 'ventas.users_id', 'ventas.valorcup_producto', 'ventas.venta_propuesta', 'ventas.porciento_ganancia', 'ventas.precio_venta')
            ->where('users_id', '=', $user_id)
            ->get();
           
        $subcontenedores = subcontenedores::select('subcontenedores.id', 'subcontenedores.name','subcontenedores.provedor','subcontenedores.costo_contenedor', 'subcontenedores.valorusd_mercado','subcontenedores.fecha')
            ->where('users_id', '=', $user_id)
            ->get();
           
        $subproductos = subproductos::select('subproductos.id', 'subproductos.name','subproductos.name_subcontenedor','subproductos.cod_producto', 'subproductos.cant_producto','subproductos.cant_cajas', 'subproductos.precio_caja', 'subproductos.precio_total','subproductos.porciento_total','subproductos.costo_flete','subproductos.total_gastousd','subproductos.unitario_gastousd','subproductos.precio_unitariousd', 'contenedores_id')
            ->where('users_id', '=' , $user_id)
            ->get();
           
        return Inertia::render('Productos/report', ['productos' => $productos,
            'contenedores' => $contenedores, 'gastosusd' => $gastosusd, 'gastoscup' => $gastoscup,'ventas' => $ventas,'subproductos' => $subproductos, 'subcontenedores' => $subcontenedores ]);
    }
}
