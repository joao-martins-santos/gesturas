<?php

namespace App\Http\Controllers\Shop;

use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Product;
use App\Ration;
use App\Medicine;
use App\ShopMedicine;
use App\ShopRation;
use App\ProductType;
use Validator;

class ProductController extends Controller
{

    public function index(){

        $product_type = ProductType::pluck('name','id');

        return view('shop.product.index', compact('product_type'));
    }

    public function all(){
        return response()->json( ["data"=> ""]) ;
    }

    public function allRation(){

        $rations =  Ration::with(['provider' => function($query){
            $query->select('id','name');
        }, 'rationCategory' => function($query){
            $query->select('id','name');
        },'rationType' => function($query){
            $query->select('id','name');
        }])->orderBy('created_at', 'desc')->get();

        $total = count($rations);

        return response()->json([
            "draw"=> 2,
            "recordsTotal"=> $total,
            "recordsFiltered"=> $total,
            "data"=>$rations]);
    }

    public function allMedicine(){

        $products =  Medicine::with(['provider' => function($query){
            $query->select('id','name');
        }, 'medicineCategory' => function($query){
            $query->select('id','name');
        },'breedType' => function($query){
            $query->select('id','name');
        },'breedSpecie' => function($query){
            $query->select('id','name');
        }])->orderBy('created_at', 'desc')->get();

        $total = count($products);

        return response()->json([
            "draw"=> 2,
            "recordsTotal"=> $total,
            "recordsFiltered"=> $total,
            "data"=>$products]);
    }

    public function destroy(Product $products, $id){
        Product::destroy($id);

        return response()->json(['success'=>'Data is successfully destroied']);
    }

    public function show(Product $request, $id){
        $product = Product::with('product_type')->find($id);

        return response()->json(['success' => $product]);
    }

    public function store(Request $request)
    {
        var_dump($request);
        die('BBBBBB');
        
        $validator =  Validator::make($request->all(), [
            'price' => 'required',
            'description' => 'required',
            'qtd' => 'required',
            'product_type_id' => 'required',
        ]);

        if ($validator->fails())
            return response()->json(['errors'=>$validator->errors()->all()]);

        //$request['shop_id'] = Auth::id();

        Product::create($request->all());

        return response()->json(['success'=>'Data is successfully added']);
    }

    public function update(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'price' => 'required',
            'description' => 'required',
            'qtd' => 'required',
            'product_type_id' => 'required',
        ]);

        if ($validator->fails())
            return response()->json(['errors'=>$validator->errors()->all()]);

        $product = Product::find($id);

        $product->product_type_id = $request->product_type_id;
        $product->description = $request->description;
        $product->qtd = $request->qtd;
        $product->price = $request->price;

        $product->save();

        return response()->json(['success'=>'Data is successfully updated']);
    }

}
