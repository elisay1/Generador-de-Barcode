<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barcode</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="#">Barcode</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('productos.index') }}">Productos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('productos.create') }}">Crear Producto</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4">
    @yield('content')
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- jQuery Notify -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/notify.js/2.0.0/notify.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/notify.js/2.0.0/notify.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/notify.js/2.0.0/notify.min.js.map"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
