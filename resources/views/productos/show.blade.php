<!-- resources/views/productos/show.blade.php -->

@extends('layout')

@section('content')
<div class="container">
    <h1>Detalles del Producto</h1>
    <ul>
        <li><strong>ID:</strong> {{ $producto->id }}</li>
        <li><strong>Código:</strong> {{ $producto->codigo }}</li>
        <li><strong>Nombre:</strong> {{ $producto->nombre }}</li>
        <li><strong>Descripción:</strong> {{ $producto->descripcion }}</li>
        <li><strong>Precio de Compra:</strong> {{ $producto->precio_compra }}</li>
        <li><strong>Costo de Venta:</strong> {{ $producto->costo_venta }}</li>
        <li><strong>Stock:</strong> {{ $producto->stock }}</li>
        <li><strong>Fecha de Vencimiento:</strong> {{ $producto->fechaven }}</li>
        <li><strong>Estado:</strong> {{ $producto->estado ? 'Activo' : 'Inactivo' }}</li>      
       <!-- Mostrar código de barras -->
       <li><strong>Código de Barras:</strong></li>
       <img src="{{ asset('storage/app/barcodes/' . $producto->barcode_image) }}" alt="Código de Barras">
    </ul>
    <a href="{{ route('productos.index') }}" class="btn btn-primary">Volver a la lista de productos</a>
</div>
@endsection
