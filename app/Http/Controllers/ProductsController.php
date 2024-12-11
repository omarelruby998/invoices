<?php

namespace App\Http\Controllers;

use App\products;
use Illuminate\Support\Str;
use Illuminate\Http\Request;


class ProductsController extends Controller
{
    public function index()
    {
        $data['products'] = products::all();
        return view('products.products', $data);
    }

    public function create()
    {
        //
    }
    public function store(Request $request)
    {

        $request->validate([
            'name.en' => 'required|string|max:255',
            'name.ar' => 'required|string|max:255',
            'price' => 'required|numeric',
        ]);
        $slug = Str::slug($request->input('name.en'));
        $existingProduct = products::where('slug', $slug)->first();
        if ($existingProduct) {
            return redirect()->route('products.index')->with('Error', 'المنتج موجود.');
        }

        $product = new products();
        $product->name = [
            'en' => $request->input('name.en'),
            'ar' => $request->input('name.ar'),
        ];
        $product->slug = $slug;
        $product->price = $request->input('price');
        $product->save();
        session()->flash('Add', 'تم اضافة المنتج بنجاح ');
        return redirect('/products');
    }



    public function show(products $products)
    {
        //
    }


    public function edit(products $product)
    {
        $data['product'] = $product;
        return view('products.edit_product',$data);

    }



        public function update(Request $request, products $product)
    {
        $validatedData = $request->validate([
            'name.ar' => 'required|string|max:255',
            'name.en' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);
        $slug = Str::slug($request->input('name.en'));
        $existingProduct = products::where('slug', $slug)->first();
        if ($existingProduct) {
            return redirect()->back()->with('Error', 'المنتج موجود.');
        }

         
        $product->setTranslations('name', [
            'ar' => $validatedData['name']['ar'],
            'en' => $validatedData['name']['en'],
        ]);
        $product->price = $validatedData['price'];
        $product->slug = $slug;
        $product->save();
        return redirect()->route('products.index')->with('success', 'تم تعديل المنتج بنجاح.');
    }

    public function destroy(products $product)
    {
        //  $Products = products::findOrFail($id);
         $product->delete();
         session()->flash('delete', 'تم حذف المنتج بنجاح');
         return redirect('products');
    }
}
