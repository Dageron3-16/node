<?php

namespace App\Http\Controllers;


use App\Models\Contenedores;
use App\Models\gastoscups;
use App\Models\gastosusds;
use App\Models\productos;
use App\Models\ventas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Auth;

class VentasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        $ventas = ventas::select('ventas.id', 'ventas.users_id', 'ventas.valorcup_producto', 'ventas.venta_propuesta', 'ventas.porciento_ganancia', 'ventas.precio_venta')
        ->where('users_id', '=', $user_id)->get();
        
       return Inertia::render('Productos/ventas', ['ventas' => $ventas ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request){
        $aux = 0;
        $user_id = Auth::user()->id;
        $id = $request->name;
        $productos = productos::find($id);
        $idcon = $productos->contenedores_id;
        $contenedores = Contenedores::find($idcon);
        $ventanew = new ventas();
        $ventanew->users_id = $user_id;
        $ventanew->contenedores_id = $idcon;
        $ventanew->productos_id = $id;
        $ventanew->name = $productos->name;
        $ventanew->venta_propuesta = $request->propuesta;
        $ventanew->valorcup_producto = $productos->unitario_gastousd * $contenedores->valorusd_mercado;
        $aux = $ventanew->valorcup_producto  / $ventanew->venta_propuesta ;
        $ventanew->porciento_ganancia = 100 - $aux * 100;
        $ventanew->precio_venta = $ventanew->venta_propuesta;
        $ventanew->save();
        return redirect('ventas');
    }

    /**
     * Display the specified resource.
     */
    public function show(ventas $ventas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ventas $ventas)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $venta = ventas::find($id);
        $idpro = $venta->productos_id;
        $productos = productos::find($idpro);
        $idcon = $productos->contenedores_id;
        $contenedores = Contenedores::find($idcon);
        $venta->venta_propuesta = $request->venta_propuesta;
        $venta->valorcup_producto = $productos->unitario_gastousd * $contenedores->valorusd_mercado;
        $venta->porciento_ganancia = 100 - ($venta->valorcup_producto /$venta->venta_propuesta) * 100;
        $venta->precio_venta = $request->venta_propuesta;
        $venta->update();
        return redirect('ventas');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $ventas = ventas::find($id);
        $ventas->delete();
        return redirect ('ventas');
    }
}
