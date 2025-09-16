<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\Products;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index()
    {
      $product = Products::select('id', 'name', 'barcode', 'purchase_price', 'sale_price')
        ->get();
      return view('Product.index', compact('product'));
    }


    public function create()
    {
      return view('Product.store');
    }


    public function store(Request $request)
    {
      $request->validate([
        'name' => 'required|string|max:255',
        'barcode' => 'required|string|unique:products,barcode',
        'purchase_price' => 'required|numeric|min:0',
        'sale_price' => 'required|numeric|min:0',
      ]);

      try {
        Products::create([
          'name' => $request->input('name'),
          'barcode' => $request->input('barcode'),
          'purchase_price' => $request->input('purchase_price'),
          'sale_price' => $request->input('sale_price'),
        ]);
        return redirect()->route('product.index')->with('success', 'تم حفظ المنتج بنجاح');
      } catch (\Exception $e) {
        return redirect()->route('product.index')->with('error', 'حدث خطأ أثناء حفظ البيانات');
      }
    }


    public function edit($id)
    {
      $product = Products::select('id', 'name', 'barcode', 'purchase_price', 'sale_price')
        ->where('id', $id)->first();
      
      return view('Product.edit', compact('product'));
    }



    public function update(Request $request, $id)
    {
      $request->validate([
        'name' => 'required|string|max:255',
        'barcode' => 'required|string|unique:products,barcode,' . $id,
        'purchase_price' => 'required|numeric|min:0',
        'sale_price' => 'required|numeric|min:0',
      ]);

      try {
        Products::where('id', $id)->update([
          'name' => $request->input('name'),
          'barcode' => $request->input('barcode'),
          'purchase_price' => $request->input('purchase_price'),
          'sale_price' => $request->input('sale_price'),
        ]);
        return redirect()->route('product.index')->with('success', 'تم تعديل بيانات المنتج');
      } catch (\Exception $e) {
        return redirect()->route('product.index')->with('error', 'حدث خطأ أثناء تعديل بيانات المنتج');
      }
    }


    public function destroy($id)
    {
      try {
        $product = Products::where('id', $id)->delete();
        return redirect()->route('product.index')->with('success', 'تم حذف المنتج بنجاح');
      } catch (\Exception $e) {
        return redirect()->route('product.index')->with('error', 'حدث خطأ أثناء حذف المنتج');
      }
    }
}
