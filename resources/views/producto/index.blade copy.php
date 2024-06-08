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
                        <button type="button" class="btn btn-danger" onclick="printEtiquetaProducto({{ $product->id }})"><i
                                class="fas fa-print"></i> Imprimir Etiqueta</button>
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
@endsection

@section('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
        function printEtiquetaProducto(productId) {
            Swal.fire({
                title: "Submit your Github username",
                input: "text",
                inputAttributes: {
                    autocapitalize: "off"
                },
                showCancelButton: true,
                confirmButtonText: "Look up",
                showLoaderOnConfirm: true,
                preConfirm: async (login) => {
                    try {
                        const githubUrl = `https://api.github.com/users/${login}`;
                        const response = await fetch(githubUrl);
                        if (!response.ok) {
                            return Swal.showValidationMessage(
                                `${JSON.stringify(await response.json())}`
                            );
                        }
                        return response.json();
                    } catch (error) {
                        Swal.showValidationMessage(`Request failed: ${error}`);
                    }
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    // Aquí puedes hacer la lógica para imprimir la etiqueta del producto
                    console.log(`Imprimiendo etiqueta del producto con ID: ${productId}`);
                    Swal.fire({
                        title: `${result.value.login}'s avatar`,
                        imageUrl: result.value.avatar_url
                    });
                }
            });
        }





        function etiquetaProducto(id) {
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
                                id: id,
                                num_etiquetas: num_etiquetas
                            },
                            success: function(response) {
                                console.log(response);
                                $('#modal-body-content-etiquetaProducto').html(response);
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
                            }
                        });
                    }
                }
            });
        }

        function printEtiquetaProducto() {
            var modalContent = document.querySelector("#modal-body-content-etiquetaProducto").innerHTML;
            var iframe = document.createElement('iframe');
            iframe.style.display = 'none'; // Oculta el iframe
            document.body.appendChild(iframe);
            var doc = iframe.contentDocument;
            doc.open();
            doc.write(modalContent);
            doc.close();

            var style = doc.createElement('style');
            style.innerHTML = "@page { size: 8.5in 11in; margin: 0.5in; }";
            doc.head.appendChild(style);

            var img = doc.querySelector('img');
            img.src = 'reportes/codigoBarras/PRLG9PN.png?' + new Date()
        .getTime(); // Actualiza la imagen con el nuevo código de barras

            img.onload = function() {
                iframe.contentWindow.focus(); // Asegúrate de que el iframe tenga el enfoque
                iframe.contentWindow.print();
                document.body.removeChild(iframe); // Elimina el iframe después de la impresión

                // Cierra el modal después de la impresión
                closeModal();
            };

            // Cierra el modal si se cancela la impresión
            window.onafterprint = function() {
                closeModal();
            };
        }



        // Función para cerrar el modal
        function closeModal() {
            var modal = document.getElementById("modalEtiquetaProducto"); // Reemplaza "myModal" con el ID de tu modal
            if (modal) {
                modal.style.display = "none";
                document.body.classList.remove(
                    "modal-open"); // Remueve la clase "modal-open" del body para cerrar el fondo oscuro del modal
                var modalBackdrop = document.querySelector(".modal-backdrop"); // Remueve el fondo oscuro del modal
                if (modalBackdrop) {
                    modalBackdrop.parentNode.removeChild(modalBackdrop);
                }
            }
        }
    </script>
@endsection
