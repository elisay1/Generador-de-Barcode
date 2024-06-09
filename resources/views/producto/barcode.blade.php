@extends('layout')

<title>Barcode &nbsp; {{ $product->name }}</title>
<style>
    .barcode-box {
        width: 25%;
        border: 3px solid #000;
        padding: 10px;
        margin: 5px;
        display: inline-block;
        text-align: center;
    }

    .product-name {
        margin-bottom: 5px;
    }

    .barcode {
        font-size: 0;
        position: relative;
        width: 180px;
        height: 30px;
        margin: auto;
    }

    .product-code {
        text-align: center;
    }

    .product-price {
        margin-top: 5px;
        color: red;
    }

    .product-price span {
        font-weight: bold;
    }
</style>

@section('content')
    <h1>Lista de etiquetas de&nbsp; &nbsp;{{ $product->name }}</h1>
    <br>
    @for ($i = 0; $i < $quantity; $i++)
        <div class="barcode-box">
            <div class="product-name">Producto: {{ strtoupper($product->name) }}</div>
            <div class="barcode">{!! $barcode !!}</div>
            <div class="product-code">Codigo: {{ $product->product_code }}</div>
            <div class="product-price"><span>Precio: S/.{{ $product->price }}</span></div>
        </div>
    @endfor
    <br>
    <br>
    <a class="btn btn-primary" href="{{ route('productos.index') }}">Atras</a>
@endsection
