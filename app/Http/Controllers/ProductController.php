<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Milon\Barcode\DNS1D;
use Dompdf\Dompdf;
use Dompdf\Options;

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
        $number = mt_rand(1000000000, 9999999999);

        $request['product_code'] = $number;
        Product::create($request->all());

        return redirect()->route('productos.index');
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
