<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/productos', [ProductController::class, 'index'])->name('productos.index');
Route::get('/productos/crear', [ProductController::class, 'create'])->name('productos.create');
Route::post('/productos', [ProductController::class, 'store'])->name('productos.store');
Route::get('/productos/{id}/editar', [ProductController::class, 'edit'])->name('productos.edit');
Route::delete('/productos/{id}', [ProductController::class, 'destroy'])->name('productos.destroy');
Route::put('/productos/{id}', [ProductController::class, 'update'])->name('productos.update');

Route::post('/printBarcode', [ProductController::class, 'printBarcode'])->name('printBarcode');

// Route::post('/generar-etiqueta-producto', 'ProductController@generarEtiquetaProducto')->name('generarEtiquetaProducto');
// Route::get('/generar-etiqueta-producto', [ProductController::class, 'generarEtiquetaProducto'])->name('generar-etiqueta-producto');
Route::get('/generar-etiqueta-producto', [ProductController::class, 'generarEtiquetaProducto'])->name('generar-etiqueta-producto');

Route::get('/products/{id}/barcode', [ProductController::class, 'generateBarcode'])->name('productos.barcode');


