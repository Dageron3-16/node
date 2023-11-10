<?php

namespace App\Http\Controllers;
use App\Models\Contenedores;
use App\Models\gastoscups;
use App\Models\gastosusds;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Auth;
class GastosusdController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        $gastosusd = gastosusds::select('gastosusds.id', 'gastosusds.factura_gastosusd','gastosusds.nombre_gastousd', 'gastosusds.valor_gastousd', 'contenedores_id')
        ->where('users_id', '=', $user_id)->paginate(10);
        $contenedores = Contenedores::select('contenedores.id', 'contenedores.name','contenedores.provedor','contenedores.costo_contenedor', 'contenedores.valorusd_mercado','contenedores.costo_contenedor_limpio', 'contenedores.flete', 'contenedores.total_gastocup','contenedores.total_gastousd','contenedores.fecha_salida','contenedores.fecha_llegada','contenedores.tiempo_venta')
            ->where('users_id', '=', $user_id)
            ->get();
        
        
        return Inertia::render('Gastos/index', ['gastosusd' => $gastosusd, 'contenedores' => $contenedores]);
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
    public function store(Request $request)
    {
        
        $user_id = Auth::user()->id;
        $id = $request->contenedores_id;
        $contenedores = Contenedores::find($id);
        $gastosusd = new gastosusds($request->input());
        $gastosusd->users_id = $user_id;
        $gastosusd->factura_gastosusd = $contenedores->name;
        $gastosusd-> save();
        return redirect('gastosusd');
    }

    /**
     * Display the specified resource.
     */
    public function show(gastosusds $gastos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(gastosusds $gastos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $gastousd = gastosusds::find($id);
        $id = $request->contenedores_id;
        $contenedores = Contenedores::find($id);
        $gastousd->factura_gastosusd = $contenedores->name;
        $gastousd->nombre_gastousd = $request->nombre_gastousd;
        $gastousd->valor_gastousd = $request->valor_gastousd; 
        
        //$producto->precio_total = $request->cant_producto * $request->precio_producto;
        //$producto->precio_unitario = $request->precio_producto / $request->cant_parle / $request->cant_cajas / $request->cant_producto;
        $gastousd -> save();
        
        return redirect('gastosusd');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $gasto = gastosusds::find($id);
        $gasto->delete();
        return redirect ('gastosusd');
    }
}
