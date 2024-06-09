@extends('layout')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    .barcode-box {
        width: 45%;
        border: 3px solid #000;
        padding: 10px;
        margin: 5px;
        display: inline-block;
        text-align: center;
    }
    @media print {
        .barcode-box {
            width: 24.6%;
            margin: 3 auto;
            spacing: 2rem;

        }
    }
    .product-name {
        /* font-weight: bold; */
        margin-bottom: 5px;
    }
    .product-code {
        margin-top: 5px;
    }
    .product-price {
        margin-top: 3px;
        color: red;
    }
    .product-price span {
        font-weight: bold;    
    }
</style>
@section('content')
    <h1>Lista de Productos</h1>
    <br>
    <br>
    <table class="table table-bordered border-primary">
        <thead class="table-primary">
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Código</th>
                <th></th>
                <th>Generar codigo barras</th>
                <th>Código de Barras</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td class="align-middle text-center">{{ $product->name }}</td>
                    <td class="align-middle text-center">{{ $product->description }}</td>
                    <td class="align-middle text-center">{{ $product->price }}</td>
                    <td class="align-middle text-center">{{ $product->product_code }}</td>
                    {{-- <td><img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($product->product_code, "C128B")}}" alt="barcode" /></td> --}}
                    <td></td>
                    <td class="align-middle text-center">
                        <form action="{{ route('productos.barcode', $product->id) }}" method="get">
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="number" class="form-control" name="quantity" placeholder="cantidad"
                                        min="1">
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary">Generate Barcode</button>
                                </div>
                            </div>
                        </form>
                    </td>
                    <td class="align-middle text-center">{!! DNS1D::getBarcodeHTML($product->product_code, 'C128', 2, 50) !!}</td>
                    <td class="align-middle text-center">
                        <button type="button" class="btn btn-success" onclick="etiquetaProducto({{ $product->id }})">
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

                <div class="modal-header">
                    <h2 class="modal-title titulo-modal" id="myModalLabelProducto">Etiqueta de Producto</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body" id="modal-body-content-etiquetaProducto">
                </div>
                <div class="btn-group " style="padding: 0.75rem;" role="group" aria-label="Basic mixed styles example">
                    <button type="button" class="btn btn-danger" onclick="printEtiquetaProducto()"><i
                            class="fas fa-print"></i> Imprimir Etiqueta</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function etiquetaProducto(idProducto) {
            Swal.fire({
                title: 'Ingrese la cantidad de etiquetas que necesita:',
                input: 'number',
                inputAttributes: {
                    min: 1,
                    value: 2
                },
                showCancelButton: true,
                confirmButtonColor: '#00852E', // Cambia el color del botón Confirmar
                cancelButtonColor: '#EF1313', // Cambia el color del botón Cancelar
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
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Por favor, ingrese una cantidad válida y mayor a cero.'
                        });

                        var audio = new Audio('{{ asset('sound/error.mp3') }}');
                        audio.play();
                        /**************************************************/
                    } else {

                        //lógica para manejar una cantidad válida de etiquetas
                        $.ajax({
                            url: "{{ route('generar-etiqueta-producto') }}",
                            type: "GET",
                            data: {
                                idProducto: idProducto,
                                num_etiquetas: num_etiquetas
                            },
                            success: function(response) {
                                console.log(response);
                                var product = response.product;
                                var numEtiquetas = response.num_etiquetas;

                                var modalContent = '';
                                for (var i = 0; i < numEtiquetas; i++) {
                                    modalContent += `
                                <div class="barcode-box">
                                    <div class="product-name">${product.name}</div> 
                                    <img src="data:image/png;base64,{{DNS1D::getBarcodePNG($product->product_code, 'C128', 2, 50)}}" alt=" ${product.name}">
                                    <div class="product-price"><span>Precio: S/.${product.price}</span></div>
                                </div>
                            `;
                                }

                                $('#modal-body-content-etiquetaProducto').html(modalContent);

                                // Lógica para mostrar los códigos de barras en los canvas

                                var modalEtiquetaProducto = new bootstrap.Modal(document.getElementById(
                                    'modalEtiquetaProducto'));
                                modalEtiquetaProducto.show();

                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Error al cargar el contenido: ' + errorThrown
                                });
                                $('#modal-body-content-etiquetaProducto').html(
                                    'Error al cargar el contenido: ' + errorThrown);
                                var audio = new Audio('{{ asset('sound/error.mp3') }}');
                                audio.play();
                            }
                        });
                    }
                }

            });

            // function printEtiquetaProducto() {
            //     var contenido = document.getElementById('modal-body-content-etiquetaProducto').innerHTML;
            //     var contenidoOriginal = document.body.innerHTML;
            //     document.body.innerHTML = contenido;
            //     window.print();
            //     document.body.innerHTML = contenidoOriginal;
            //     $('#modalEtiquetaProducto').modal('hide');
            // }

        }

      

        function printEtiquetaProducto() {
            // Obtén el contenido del modal con el código de barras
            var contenido = document.getElementById('modal-body-content-etiquetaProducto').innerHTML;
            console.log(contenido);

            // Copia el contenido al cuerpo del documento
            var contenidoOriginal = document.body.innerHTML;
            document.body.innerHTML = contenido;

            // Imprime el documento
            window.print();

            // Restaura el contenido original del cuerpo del documento
            document.body.innerHTML = contenidoOriginal;

            // Cierra el modal
            $('#modalEtiquetaProducto').modal('hide');
        }
    </script>
@endsection
