@extends('layout')

@section('content')
    <h1>Crear Nuevo Producto</h1>
    <form action="{{ route('productos.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Código de barras</label>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="generate_barcode" name="generate_barcode" checked>
                <label class="form-check-label" for="generate_barcode">Generar automáticamente</label>
            </div>
        </div>
    
        <div class="mb-3" id="manual_barcode_input" style="display: none;">
            <label for="product_code_manual" class="form-label">Código de barras manual</label>
            <input type="text" class="form-control @error('product_code_manual') is-invalid @enderror" id="product_code_manual" name="product_code_manual" value="{{ old('product_code_manual') }}">
            @error('product_code_manual')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    
        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    
        <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    
        <div class="mb-3">
            <label for="price" class="form-label">Precio</label>
            <input type="text" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}">
            @error('price')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    
        <button type="submit" class="btn btn-primary">Crear Producto</button>
    </form>
    <script>
        document.getElementById('generate_barcode').addEventListener('change', function() {
        var checked = this.checked;
        var manualBarcodeInput = document.getElementById('manual_barcode_input');
        manualBarcodeInput.style.display = checked ? 'none' : 'block';
    });
    </script>
@endsection
