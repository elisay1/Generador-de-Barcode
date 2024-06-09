<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Milon\Barcode\DNS1D;

class ProductController extends Controller
{

    public function index()
    {
        $products = Product::all();
        return view('producto.index', compact('products'));
    }

    public function create()
    {
        return view('producto.create');
    }

    public function store(Request $request)
    {
        // $number = mt_rand(1000000000, 9999999999);

        // $request['product_code'] = $number;
        // Product::create($request->all());

        // return redirect()->route('productos.index');
        // Validar los datos del formulario
        ///**************************Crear manual eñ codigo */
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'description' => 'nullable|string',
        //     'price' => 'required|numeric',
        //     'product_code' => 'required|string|max:255', // Añade la validación para el código de barras
        // ]);

        // // Crear un nuevo producto
        // $product = new Product();
        // $product->name = $request->input('name');
        // $product->description = $request->input('description');
        // $product->price = $request->input('price');
        // $product->product_code = $request->input('product_code'); // Asignar el código de barras
        // $product->save();

        // // Redirigir a alguna ruta después de crear el producto
        // return redirect()->route('productos.index')->with('success', 'Producto creado exitosamente');

        //******************************Generar codigo manual y automatico */
        // Validar los datos del formulario
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'product_code_manual' => 'nullable|string|max:255', 
            'generate_barcode' => 'required|string|max:255', 
        ]);

        // Obtener el valor del campo "Generar automáticamente" (checkbox)
        $generateBarcodeAutomatically = $request->has('generate_barcode');

        // Si se ha seleccionado generar automáticamente, generar un código de barras aleatorio
        if ($generateBarcodeAutomatically) {
            $productCode = mt_rand(1000000000, 9999999999);
        } else {
            // Si no, obtener el código de barras ingresado manualmente
            $productCode = $request->input('product_code_manual');
        }

        // Crear un nuevo producto con los datos del formulario
        Product::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'product_code' => $productCode, // Asignar el código de barras
        ]);

        // Redirigir a alguna ruta después de crear el producto
        return redirect()->route('productos.index')->with('success', 'Producto creado exitosamente');
    }

    public function productCodeExists($number)
    {
        return Product::whereProductCode($number)->exists();
    }


    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('producto.show', compact('product'));
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('producto.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $product->update($request->all());

        return redirect()->route('productos.index');
    }
    // Obtener el ID del producto y el número de etiquetas del request
    //$numEtiquetas = $request->input('num_etiquetas');
    public function generarEtiquetaProducto(Request $request)
    {

        // $idProducto = $request->query('idProducto');
        // $num_etiquetas = $request->query('num_etiquetas', 1);
        // $product = Product::findOrFail($idProducto);

        // $barcodeGenerator = new DNS1D();
        // $barcodeGenerator->setStorPath(__DIR__.'/cache/');
        // $barcode = $barcodeGenerator->getBarcodeHTML($product->product_code, 'C128');

        // $html = view('producto.index', [
        //     'product' => $product,
        //     'barcode' => $barcode,
        //     'num_etiquetas' => $num_etiquetas
        // ])->render();

        // return response()->json(['html' => $html]);
        //************************************************************** */
        $idProducto = $request->input('idProducto');
        $num_etiquetas = $request->input('num_etiquetas', 1); // Valor predeterminado de 1 si no se proporciona

        // Obtener el producto
        $producto = Product::findOrFail($idProducto);

        // Devolver los datos de producto y número de etiquetas como respuesta
        return response()->json([
            'product' => $producto,
            'num_etiquetas' => $num_etiquetas,
        ]);
    }
    // public function generateBarcode($id)
    // {
    //     $product = Product::findOrFail($id);

    //     $barcodeGenerator = new DNS1D();
    //     $barcodeGenerator->setStorPath(__DIR__.'/cache/');
    //     $barcode = $barcodeGenerator->getBarcodeHTML($product->product_code, 'C128');

    //     return view('producto.barcode', compact('product', 'barcode'));
    // }
    // public function generateBarcode($id, $quantity = 1)
    // {
    //     $product = Product::findOrFail($id);

    //     $barcodeGenerator = new DNS1D();
    //     $barcodeGenerator->setStorPath(__DIR__.'/cache/');
    //     $barcode = $barcodeGenerator->getBarcodeHTML($product->product_code, 'C128');

    //     return view('producto.barcode', compact('product', 'barcode', 'quantity'));
    // }

    public function generateBarcode(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $quantity = $request->input('quantity', 1);

        $barcodeGenerator = new DNS1D();
        $barcodeGenerator->setStorPath(__DIR__ . '/cache/');
        $barcode = $barcodeGenerator->getBarcodeHTML($product->product_code, 'C128');

        return view('producto.barcode', compact('product', 'barcode', 'quantity'));
    }
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('productos.index');
    }
}
