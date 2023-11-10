<?php

namespace App\Http\Controllers;

use App\Models\subcontenedores;
use Illuminate\Http\Request;
use App\Models\subproductos;
use Inertia\Inertia;
use App\Models\Contenedores;
use App\Models\gastoscups;
use App\Models\productos;
use App\Models\gastosusds;
use Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class SubcontenedoresController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        $subcontenedores = subcontenedores::select('subcontenedores.id', 'subcontenedores.name','subcontenedores.provedor','subcontenedores.costo_contenedor', 'subcontenedores.valorusd_mercado','subcontenedores.fecha')
            ->where('users_id', '=', $user_id)
            ->paginate(5);
        $subproductos = subproductos::select('subproductos.id', 'subproductos.name','subproductos.factura','subproductos.cod_producto', 'subproductos.cant_producto','subproductos.cant_cajas', 'subproductos.precio_caja', 'subproductos.precio_total','subproductos.porciento_total','subproductos.costo_flete','subproductos.total_gastousd','subproductos.unitario_gastousd','subproductos.precio_unitariousd', 'contenedores_id')
        ->where('users_id', '=' , $user_id)
        ->get();
             
        return Inertia::render('SubContenedor/index', ['subcontenedores' => $subcontenedores, 'subproductos' => $subproductos ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('SubContenedor/create');
    }

    public function Subpdf()
    {   
        $user_id = Auth::user()->id;
        $subcontenedores = subcontenedores::select('subcontenedores.id', 'subcontenedores.name','subcontenedores.provedor','subcontenedores.costo_contenedor', 'subcontenedores.valorusd_mercado','subcontenedores.fecha')
            ->where('users_id', '=', $user_id)
            ->get();
        $subproductos = subproductos::select('subproductos.id', 'subproductos.name','subproductos.factura','subproductos.cod_producto', 'subproductos.cant_producto','subproductos.cant_cajas', 'subproductos.precio_caja', 'subproductos.precio_total','subproductos.porciento_total','subproductos.costo_flete','subproductos.total_gastousd','subproductos.unitario_gastousd','subproductos.precio_unitariousd', 'contenedores_id')
        ->where('users_id', '=' , $user_id)
        ->get();
        $pdf = Pdf::loadView('subcontenedor.pdf',compact($subproductos));
        return Inertia::render('SubContenedor/index', ['subcontenedores' => $subcontenedores, 'subproductos' => $subproductos, $pdf->stream()]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user_id = Auth::user()->id;
        $subcontenedor = new subcontenedores($request->all());
        $subcontenedor->users_id = $user_id;
        $subcontenedor->save();
        return redirect('subcontenedor');
    }

    /**
     * Display the specified resource.
     */
    public function show(subcontenedores $subcontenedores)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(subcontenedores $subcontenedores)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, subcontenedores $subcontenedores)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {   

        $subcontenedores = subcontenedores::find($id);
        $subproductos = subproductos::where('name_subcontenedor', 'LIKE', $subcontenedores->name)->delete();
        $subcontenedores->delete(); 
        return redirect('subcontenedor');
    }

    public function SubCostoTotal($id)
    {
       $user_id = Auth::user()->id;
       $totalusd = 0 ;
       $subcontenedor = subcontenedores::find($id);
       $precio_totales = subproductos::select('subproductos.precio_total')->where('subproductos.name_subcontenedor','=',$subcontenedor->name)->where('users_id', '=' , $user_id)->get();
       
       foreach($precio_totales as $precio_total)
       {
        $totalusd+=$precio_total->precio_total;
       
       }
       
       
       $subcontenedor-> costo_contenedor = $totalusd;
       
       $subcontenedor-> update();
     
       return;
    }
       
       public function DetailsbySubContenedor ($id)
       {
        $user_id = Auth::user()->id;
        $subcontenedores = subcontenedores::find($id);
        $name = $subcontenedores->name;
        $subproductos = subproductos::where('subproductos.name_subcontenedor','LIKE', $name)
        ->where('users_id', '=' , $user_id)
        ->paginate(150);
        return Inertia::render('SubProducto/index', ['subproductos' => $subproductos]);
       }


    }













