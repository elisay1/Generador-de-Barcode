<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'imagen',
        'precio_compra',
        'costo_venta',
        'stock',
        'fechaven',
        'estado',
        'barcode_image' // Añadir este campo
    ];
}
