<?php

namespace App\Http\Controllers;

use App\Models\gastoscups;
use App\Models\gastosusds;
use Illuminate\Http\Request;
use App\Models\Contenedores;
use App\Models\productos;
use Inertia\Inertia;
use Auth;

class GastoscupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id = Auth::user()->id; 
        $gastoscup  = gastoscups::select('gastoscups.id','gastoscups.factura_gastoscup', 'gastoscups.nombre_gastocup', 'gastoscups.valor_gastocup', 'contenedores_id')
        ->where('users_id', '=' ,$user_id)->paginate(10);
        $contenedores = Contenedores::select('contenedores.id', 'contenedores.name','contenedores.provedor','contenedores.costo_contenedor', 'contenedores.valorusd_mercado','contenedores.costo_contenedor_limpio', 'contenedores.flete', 'contenedores.total_gastocup','contenedores.total_gastousd','contenedores.fecha_salida','contenedores.fecha_llegada','contenedores.tiempo_venta')
            ->where('users_id', '=', $user_id)
            ->get();
                
        return Inertia::render('Gastos/gastoscup', ['gastoscup' => $gastoscup, 'contenedores' => $contenedores]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user_id = Auth::user()->id;
        $id = $request->contenedores_id;
        $contenedores = Contenedores::find($id);
        $gastocup = new gastoscups($request->input());
        $gastocup->users_id = $user_id;
        $gastocup->factura_gastoscup = $contenedores->name;
        $gastocup-> save();
        return redirect('gastoscup');
    }

    /**
     * Display the specified resource.
     */
    public function show(gastoscups $gastosprod)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(gastoscups $gastosprod)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $gastoscup = gastoscups::find($id);
        $id = $request->contenedores_id;
        $contenedores = Contenedores::find($id);
        $gastoscup->nombre_gastocup = $request->nombre_gastocup;
        $gastoscup->valor_gastocup = $request->valor_gastocup; 
        $gastoscup->factura_gastoscup = $contenedores->name;
        $gastoscup -> save();
        
        return redirect('gastoscup');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $gasto = gastoscups::find($id);
        $gasto->delete();
        return redirect ('gastoscup');
    }
}
