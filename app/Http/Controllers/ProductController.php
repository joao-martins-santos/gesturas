<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Product_line;

class ProductController extends Controller
{
    public function index(){
        //$products = Product::all();
        $products = Product::orderBy('created_at', 'desc')->paginate(10);

        return view('shop.index', compact('products'));
        //return view('shops.index',['pets' => $pets]);
    }

    public function show(Product $product){
        return view('the_product',compact('product'));
    }

    public function store(){
        $data = [ 'product_line_id' => request('product_line_id'),
                  'description' => request('description'),
                  'expiration_time' => request('expiration_time'),
                  'price' => request('price')
                ];
        Product::create($data);
        return redirect('product');
    }

    public function edit(Product $product){
        $product_lines = Product_line::all();
        return view('product_edit',compact('product','product_lines'));
    }

    public function update(Product $product, Request $request){
        $product->product_line_id = $request->product_line_id;
        $product->description = $request->description;
        $product->expiration_time = $request->expiration_time;
        $product->price = $request->price;
        $product->save();
        return redirect('product');
    }

    public function destroy(Product $product){
        $product->delete();
        return redirect('products');
    }

}
