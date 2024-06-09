@extends('layout')


@section('content')
<div class="container">
    <h1>Lista de Productos</h1>
    <a href="{{ route('productos.create') }}" class="btn btn-primary">Crear Producto</a>
    <table class="table mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Código</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio de Compra</th>
                <th>Costo de Venta</th>
                <th>Stock</th>
                <th>Fecha de Vencimiento</th>
                <th>Estado</th>
                <th>Imagen</th>
                <th>Código de Barras</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($productos as $producto)
            <tr>
                <td>{{ $producto->id }}</td>
                <td>{{ $producto->codigo }}</td>
                <td>{{ $producto->nombre }}</td>
                <td>{{ $producto->descripcion }}</td>
                <td>{{ $producto->precio_compra }}</td>
                <td>{{ $producto->costo_venta }}</td>
                <td>{{ $producto->stock }}</td>
                <td>{{ $producto->fechaven }}</td>
                <td>{{ $producto->estado ? 'Activo' : 'Inactivo' }}</td>
                <td>
                    @if($producto->imagen)
                    <img src="{{ asset('storage/product/'.$producto->imagen) }}" width="50" alt="product0">
                        {{-- <img src="{{ Storage::url($producto->imagen) }}" width="50"> --}}
                    @endif
                </td>
                <td>
                    @if($producto->barcode_image)
                    {{-- <img src="{{ asset('storage/barcodes/'.$producto->barcode_image) }}" alt="barcode_img"> --}}
                    {{-- <img src="{{ Storage::url($producto->barcode_image) }}" width="100"> --}}
                    <img src="{{ asset('storage/app/barcodes/' . $producto->barcode_image) }}" alt="Código de Barras">
                        {{-- <img src="{{ Storage::url($producto->barcode_image) }}" width="100"> --}}
                    @endif
                </td>
                <td>
                    <a href="{{ route('productos.show', $producto->id) }}" class="btn btn-info">Ver</a>
                    <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-warning">Editar</a>
                    <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection