<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use TCPDF;

class ProductoController extends Controller
{ // Mostrar lista de productos
    public function index()
    {
        $productos = Producto::all();
        return view('productos.index', compact('productos'));
    }

    // Mostrar formulario para crear un nuevo producto
    public function create()
    {
        // Aquí debes cargar las categorías, monedas y medidas desde la base de datos
        // $categorias = Categoria::all();
        // $monedas = Moneda::all();
        // $medidas = Medida::all();

        return view('productos.create'); // , compact('categorias', 'monedas', 'medidas'));
    }

    // Almacenar un nuevo producto
    public function store(Request $request)
    {
        // Validar los datos recibidos del formulario
        $validatedData = $request->validate([
            'codigo' => 'required|string|max:50',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio_compra' => 'required|numeric',
            'costo_venta' => 'required|numeric',
            'stock' => 'required|integer',
            'fechaven' => 'nullable|date',
            'estado' => 'required|boolean',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Crear una instancia de TCPDF
        $pdf = new TCPDF();

        // Añadir una página (necesaria para generar el código de barras)
        $pdf->AddPage();

        // Generar el código de barras
        $barcodeStyle = [
            'position' => '',
            'align' => 'C',
            'stretch' => false,
            'fitwidth' => true,
            'cellfitalign' => '',
            'border' => true,
            'hpadding' => 'auto',
            'vpadding' => 'auto',
            'fgcolor' => [0, 0, 0],
            'bgcolor' => false,
            'text' => true,
            'font' => 'helvetica',
            'fontsize' => 8,
            'stretchtext' => 4
        ];
        $pdf->write1DBarcode($validatedData['codigo'], 'C128', '', '', '', 18, 0.4, $barcodeStyle, 'N');

        // Guardar el código de barras como una imagen
        $barcodePath = 'public/barcodes/' . $validatedData['codigo'] . '.pdf';
        $pdf->Output(storage_path('app/' . $barcodePath), 'F');

        // Almacenar la ruta del código de barras en los datos validados
        $validatedData['barcode_image'] = $barcodePath;

        // Manejar la carga de la imagen del producto
        if ($file = $request->file('imagen')) {
            $fileName = hexdec(uniqid()) . '.' . $file->getClientOriginalExtension();
            $path = 'public/product/';

            $file->storeAs($path, $fileName);
            $validatedData['imagen'] = $fileName;
        }

        // Crear un nuevo producto en la base de datos
        Producto::create($validatedData);

        // Redirigir a la página de índice de productos con un mensaje de éxito
        return redirect()->route('productos.index')->with('success', 'Producto creado exitosamente.');
    }

    // Mostrar un producto específico
    public function show($id)
    {
        $producto = Producto::findOrFail($id);

        // Generar código de barras
        $barcodePath = public_path('barcodes/' . $producto->codigo . '.png');
        $pdf = new TCPDF();
        $pdf->write1DBarcode($producto->codigo, 'C128', '', '', '', 18, 0.4, [], 'N');
        $pdf->Output($barcodePath, 'F');

        return view('productos.show', compact('producto', 'barcodePath'));
    }

    // Mostrar formulario para editar un producto
    public function edit($id)
    {
        $producto = Producto::findOrFail($id);

        // Aquí debes cargar las categorías, monedas y medidas desde la base de datos
        // $categorias = Categoria::all();
        // $monedas = Moneda::all();
        // $medidas = Medida::all();

        return view('productos.edit', compact('producto')); // , 'categorias', 'monedas', 'medidas'));
    }

    // Actualizar un producto existente
    public function update(Request $request, $id)
    {
        $rules = [
            'codigo' => 'required|string|max:50',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio_compra' => 'required|numeric',
            'costo_venta' => 'required|numeric',
            'stock' => 'required|integer',
            'fechaven' => 'nullable|date',
            'estado' => 'required|boolean',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        $validatedData = $request->validate($rules);

        $producto = Producto::findOrFail($id);

        // Actualizar código de barras si el código ha cambiado
        if ($producto->codigo !== $validatedData['codigo']) {
            // Crear una instancia de TCPDF
            $pdf = new TCPDF();

            // Añadir una página (necesaria para generar el código de barras)
            $pdf->AddPage();

            // Generar el código de barras
            $barcodeStyle = [
                'position' => '',
                'align' => 'C',
                'stretch' => false,
                'fitwidth' => true,
                'cellfitalign' => '',
                'border' => true,
                'hpadding' => 'auto',
                'vpadding' => 'auto',
                'fgcolor' => [0, 0, 0],
                'bgcolor' => false,
                'text' => true,
                'font' => 'helvetica',
                'fontsize' => 8,
                'stretchtext' => 4
            ];

            $pdf->write1DBarcode($validatedData['codigo'], 'C128', '', '', '', 18, 0.4, $barcodeStyle, 'N');

            // Guardar el código de barras como una imagen
            $barcodePath = 'public/barcodes/' . $validatedData['codigo'] . '.png';
            $pdf->Output(storage_path('app/' . $barcodePath), 'F');

            // Almacenar la ruta del código de barras en la base de datos
            $validatedData['barcode_image'] = $barcodePath;
        }

        // Manejar la carga de la imagen
        if ($file = $request->file('imagen')) {
            $fileName = hexdec(uniqid()) . '.' . $file->getClientOriginalExtension();
            $path = 'public/product/';

            $file->storeAs($path, $fileName);
            $validatedData['imagen'] = $fileName;
        }

        $producto->update($validatedData);

        return redirect()->route('productos.index')->with('success', 'Producto actualizado exitosamente.');
    }

    // Eliminar un producto
    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->delete();

        return redirect()->route('productos.index')->with('success', 'Producto eliminado exitosamente.');
    }
}
