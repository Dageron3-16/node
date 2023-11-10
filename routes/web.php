<?php

use App\Http\Controllers\ContenedoresController;
use App\Http\Controllers\GastosController;
use App\Http\Controllers\GastoscupController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\GastosusdController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubcontenedoresController;
use App\Http\Controllers\SubproductosController;
use App\Http\Controllers\VentasController;
use App\Http\Controllers\SearchController;
use App\Models\Contenedores;
use App\Models\gastos;
use App\Models\productos;
use Illuminate\Foundation\Application;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});
//Route::get('/api', [App\Http\Controllers\ApiController::class, 'exportar'])->name('api.index');
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::middleware('auth')->group(function () {
    Route::get('/about', fn () => Inertia::render('About'))->name('about');
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('exportar', [App\Http\Controllers\ApiController::class, 'exportar'])->name('exportar');
    Route::post('/import', [App\Http\Controllers\ApiController::class, 'import'])->name('import');
    Route::post('/pintar', [App\Http\Controllers\ApiController::class, 'pintar'])->name('pintar');
    Route::resource('contenedor',ContenedoresController::class);
    Route::resource('productos',ProductosController::class);
    Route::resource('gastoscup',GastoscupController::class);
    Route::resource('gastosusd',GastosusdController::class);
    Route::resource('ventas',VentasController::class);
    Route::get('datos',[ProductosController::class, 'datosventa'])->name('datos');
    Route::get('/buscarProducto',[SearchController::class,'searchProducto'])->name('searchProducto');
    Route::get('/buscarContenedor',[SearchController::class,'searchContenedor'])->name('searchContenedor');
    Route::get('/buscarSubContenedor',[SearchController::class,'searchSubContenedor'])->name('searchSubContenedor');
    Route::get('/buscarSubProducto',[SearchController::class,'searchSubProducto'])->name('searchSubProducto');
    Route::get('/buscarSubProductoCreate',[SearchController::class,'searchSubProductoCreate'])->name('searchSubProductoCreate');
    Route::get('/buscarGastousd',[SearchController::class,'searchgastousd'])->name('searchgastousd');
    Route::get('/buscarGastoscup',[SearchController::class,'searchgastocup'])->name('searchgastocup');
    //Route::get('/buscar',[SearchController::class,'searchSubProducto'])->name('searchSubProducto');
    Route::get('/descargar/{name}',[ContenedoresController::class,'downloadFile'])->name('descargar');
    Route::get('file', [ContenedoresController::class, 'export'])->name('file');
    Route::get('Subdetalle/{id}', [SubcontenedoresController::class, 'DetailsbySubContenedor'])->name('subdetalle');
    Route::get('Subpdf', [SubcontenedoresController::class, 'Subpdf'])->name('subpdf');
    Route::get('importar', [ContenedoresController::class, 'importar'])->name('importar');
    Route::get('graphic', [ProductosController::class, 'ProductoByContenedor'])->name('graphic');
    Route::get('reporte', [ProductosController::class, 'reporte'])->name('reporte');
    Route::patch('costo_limpio/{id}', [ContenedoresController::class, 'CostoLimpio'])->name('costo_limpio');
    Route::patch('costo_total/{id}', [ContenedoresController::class, 'CostoTotal'])->name('costo_total');
    Route::patch('subcosto_total/{id}', [SubContenedoresController::class, 'SubCostoTotal'])->name('subcosto_total');
    Route::patch('calcular/{id}', [ProductosController::class, 'calculate'])->name('calcular');
    Route::get('editar/{id}', [ContenedoresController::class, 'DuplicarCon'])->name('editar');
    Route::get('detalle/{id}', [ContenedoresController::class, 'DetailsbyContenedor'])->name('detalle');
    Route::get('graphic', [ProductosController::class, 'ProductoByContenedor'])->name('graphic');
    Route::patch('calcularpro/{id}', [ProductosController::class, 'calculatenew'])->name('calcularpro');
    Route::delete('deletepro/{id}', [ProductosController::class, 'destroynew'])->name('deletepro');
    Route::patch('editarpro/{id}', [ProductosController::class, 'updatenew'])->name('editarpro');
    Route::get('create/{id}',[SubproductosController::class, 'Adicionar'])->name('Adicionar');
    Route::get('subcalcular',[SubproductosController::class, 'subcalcular'])->name('subcalcular');
    Route::resource('subcontenedor',SubcontenedoresController::class);
    Route::resource('subproducto',SubproductosController::class);
    


}); 

require __DIR__.'/auth.php';
