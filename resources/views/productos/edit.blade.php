@extends('layout')


@section('content')
<div class="container">
    <h1>Editar Producto</h1>
    <form action="{{ route('productos.update', $producto->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="codigo">Código</label>
            <input type="text" name="codigo" id="codigo" class="form-control" value="{{ $producto->codigo }}" required>
        </div>
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $producto->nombre }}" required>
        </div>
        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea name="descripcion" id="descripcion" class="form-control">{{ $producto->descripcion }}</textarea>
        </div>
        <div class="form-group">
            <label for="precio_compra">Precio de Compra</label>
            <input type="number" name="precio_compra" id="precio_compra" class="form-control" value="{{ $producto->precio_compra }}" required>
        </div>
        <div class="form-group">
            <label for="costo_venta">Costo de Venta</label>
            <input type="number" name="costo_venta" id="costo_venta" class="form-control" value="{{ $producto->costo_venta }}" required>
        </div>
        <div class="form-group">
            <label for="stock">Stock</label>
            <input type="number" name="stock" id="stock" class="form-control" value="{{ $producto->stock }}" required>
        </div>
        <div class="form-group">
            <label for="fechaven">Fecha de Vencimiento</label>
            <input type="date" name="fechaven" id="fechaven" class="form-control" value="{{ $producto->fechaven }}">
        </div>
        {{-- <div class="form-group">
            <label for="id_categoria">Categoría</label>
            <select name="id_categoria" id="id_categoria" class="form-control" required>
                <!-- Aquí debes cargar las categorías desde la base de datos -->
            </select>
        </div>
        <div class="form-group">
            <label for="id_moneda">Moneda</label>
            <select name="id_moneda" id="id_moneda" class="form-control" required>
                <!-- Aquí debes cargar las monedas desde la base de datos -->
            </select>
        </div>
        <div class="form-group">
            <label for="id_medida">Medida</label>
            <select name="id_medida" id="id_medida" class="form-control" required>
                <!-- Aquí debes cargar las medidas desde la base de datos -->
            </select>
        </div> --}}
        <div class="form-group">
            <label for="estado">Estado</label>
            <select name="estado" id="estado" class="form-control" required>
                <option value="1" {{ $producto->estado ? 'selected' : '' }}>Activo</option>
                <option value="0" {{ !$producto->estado ? 'selected' : '' }}>Inactivo</option>
            </select>
        </div>
        <div class="form-group">
            <label for="imagen">Imagen</label>
            <input type="file" name="imagen" id="imagen" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
</div>
@endsection