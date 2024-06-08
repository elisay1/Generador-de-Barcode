{{-- @extends('layout')

@section('content')
    <h1>Lista de Productos</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Código de Producto</th>
                <th>Código de Barras</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->description }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->product_code }}</td>
                    <td>{!! DNS1D::getBarcodeHTML($product->product_code, 'C128', 2, 50) !!}</td>
                    <td>
                        <a href="{{ route('productos.edit', $product->id) }}" class="btn btn-primary">Editar</a>
                        <form action="{{ route('productos.destroy', $product->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection --}}


@extends('layout')
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')
    <h1>Lista de Productos</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Código de Producto</th>
                <th>Código de Barras</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->description }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->product_code }}</td>
                    <td>{!! DNS1D::getBarcodeHTML($product->product_code, 'C128', 2, 50) !!}</td>
                    <td>
                        <button type="button" class="btn btn-danger" onclick="etiquetaProducto({{ $product->id }})">
                            <i class="fas fa-print"></i> Imprimir Etiqueta
                        </button>
                        <a href="{{ route('productos.edit', $product->id) }}" class="btn btn-primary">Editar</a>
                        <form action="{{ route('productos.destroy', $product->id) }}" method="POST"
                            style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="modal fade" id="modalEtiquetaProducto" tabindex="-1" aria-labelledby="myModalLabelProducto"
        aria-hidden="true">
        <div class="modal-dialog modal-ticket modal-dialog-scrollable">
            <div class="modal-content">
                <form method="POST" action="{{ route('generar-etiqueta-producto') }}">
                    @csrf
                    <div class="modal-header">
                        <h2 class="modal-title titulo-modal" id="myModalLabelProducto">Etiqueta de Producto</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body" id="modal-body-content-etiquetaProducto">
                    </div>
                    <div class="btn-group " style="padding: 0.75rem;" role="group"
                        aria-label="Basic mixed styles example">
                        <button type="button" class="btn btn-danger" onclick="printEtiquetaProducto()"><i
                                class="fas fa-print"></i> Imprimir Etiqueta</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    // 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    var csrfToken = $('meta[name="csrf-token"]').attr('content');
                }

            })

            function etiquetaProducto(idProducto) {
                Swal.fire({
                    title: 'Ingrese la cantidad de etiquetas que necesita:',
                    input: 'number',
                    inputAttributes: {
                        min: 1,
                        value: 2
                    },
                    showCancelButton: true,
                    confirmButtonColor: '#f6c23e', // Cambia el color del botón Confirmar
                    cancelButtonColor: '#e74a3b', // Cambia el color del botón Cancelar
                    confirmButtonText: '<i class="fas fa-check"></i> Aceptar',
                    cancelButtonText: '<i class="fas fa-times"></i> Cancelar',
                    showLoaderOnConfirm: true,
                    allowOutsideClick: false,
                    customClass: {
                        confirmButton: 'custom-confirm-button', // Clase personalizada para el botón Confirmar
                        cancelButton: 'custom-confirm-button', // Clase personalizada para el botón Confirmar
                    },
                    preConfirm: (num_etiquetas) => {
                        return num_etiquetas;
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        var num_etiquetas = result.value;
                        if (num_etiquetas === '' || num_etiquetas < 1) {
                            /**************************************************/
                            $.notify({
                                title: `<span style="font-size:16px;">Por favor, ingrese una cantidad válida</span>`,
                                text: '<span style="font-size:13px;"> Por favor, int&eacute;ntelo otra vez</span>',
                                image: "<i class='fa fa-2x fa-times'></i>"
                            }, {
                                style: 'metro',
                                className: 'error',
                                autoHide: true,
                                autoHideDelay: 3000,
                                showDuration: 0, // Agrega esta propiedad para hacer que aparezca lentamente
                                hideDuration: 0,
                                clickToHide: true,
                            });

                            //Reproducir sonido
                            var audio = new Audio('song/error.mp3');
                            audio.play();
                            /**************************************************/
                        } else {

                            $.ajax({
                                url: '/generar-etiqueta-producto',
                                method: 'POST',
                                data: {
                                    idProducto: idProducto,
                                    num_etiquetas: num_etiquetas
                                },
                                headers: {
                                    'X-CSRF-TOKEN': csrfToken
                                }
                                success: function(response) {
                                    console.log(response);
                                    $('#modal-body-content-etiquetaProducto').html(response);
                                    var modalEtiquetaProducto = new bootstrap.Modal(document
                                        .getElementById(
                                            'modalEtiquetaProducto'));
                                    modalEtiquetaProducto.show();
                                },
                                error: function(jqXHR, textStatus, errorThrown) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: 'Error al cargar el contenido: ' +
                                            errorThrown
                                    });
                                    $('#modal-body-content-etiquetaProducto').html(
                                        'Error al cargar el contenido: ' + errorThrown);
                                }
                            });
                        }
                    }
                });
            }
        });
    </script>
@endsection
