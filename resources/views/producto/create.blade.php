@extends('layout')

@section('content')
    <h1>Crear Nuevo Producto</h1>
    <form action="{{ route('productos.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="product_code" class="form-label">Código de barras</label>
            <input type="text" class="form-control" id="product_code" name="product_code">
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Precio</label>
            <input type="text" class="form-control" id="price" name="price">
        </div>
        <button type="submit" class="btn btn-primary">Crear Producto</button>
    </form>
@endsection
