<?php

namespace App\Http\Controllers\Vet;

use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Product;
use App\Ration;
use App\Medicine;
use App\User;



use Validator;

class ServiceController extends Controller
{

   //

    public function userIndex(){
        return view('vet.consult.filter');
    }

    public function usersList(){
        
        $usersQuery = User::query();

        $start_date = (!empty($_GET["start_date"])) ? ($_GET["start_date"]) : ('');
        $end_date   = (!empty($_GET["end_date"])) ? ($_GET["end_date"]) : ('');

        if($start_date && $end_date){
         $start_date = date('Y-m-d', strtotime($start_date));
         $end_date   = date('Y-m-d', strtotime($end_date));
         
         $usersQuery->whereRaw("date(users.birtdate) >= '" . $start_date . "' AND date(users.birtdate) <= '" . $end_date . "'");
        }

        $users = $usersQuery->select('*');
        return datatables()->of($users)->make(true);
    }

    public function petUserCod($codigo){

        if( $codigo ){
            $users = DB::table('pets')
            ->join('users', 'pets.id_user', '=', 'users.id')
            ->join('breeds', 'pets.id_breed', '=', 'breeds.id')
            ->select('pets.name as namePET', 'pets.birtdate as birtdatePET', 'pets.genre as genrePET', 'pets.weight as weightPET', 
                    'users.name as nameUser', 'users.cpf as cpfUser', 'users.birtdate as birtdateUser', 'users.email as emailUser', 
                    'breeds.name')
                    ->whereRaw("pets.id = " . $codigo)
                    ->get();

            $date       = new \DateTime( $users[0]->birtdatePET );
            $interval   = $date->diff( new \DateTime( date("Y-m-d") ) );
            $users[0]->timelifePET = $interval->format( '%Y Anos, %m Meses e %d Dias' ); 
            $users[0]->birtdatePET = date("d/m/Y", strtotime($users[0]->birtdatePET));
            $users[0]->birtdateUser = date("d/m/Y", strtotime($users[0]->birtdateUser));
            $users[0]->cpfUser = preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $users[0]->cpfUser);

            return \Response::json($users[0]);
        }
        return \Response::json(false);
    }

    public function graficoTemperatura( $dt_ini, $dt_fim ){
        //if( $codigo ){
            /*
            $users = DB::table('pets')
            ->join('users', 'pets.id_user', '=', 'users.id')
            ->join('breeds', 'pets.id_breed', '=', 'breeds.id')
            ->select('pets.name as namePET', 'pets.birtdate as birtdatePET', 'pets.genre as genrePET', 'pets.weight as weightPET', 
                    'users.name as nameUser', 'users.cpf as cpfUser', 'users.birtdate as birtdateUser', 'users.email as emailUser', 
                    'breeds.name')
                    ->whereRaw("pets.id = " . $codigo)
                    ->get();

            $date       = new \DateTime( $users[0]->birtdatePET );
            $interval   = $date->diff( new \DateTime( date("Y-m-d") ) );
            $users[0]->timelifePET = $interval->format( '%Y Anos, %m Meses e %d Dias' ); 
            $users[0]->birtdatePET = date("d/m/Y", strtotime($users[0]->birtdatePET));
            $users[0]->birtdateUser = date("d/m/Y", strtotime($users[0]->birtdateUser));
            $users[0]->cpfUser = preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $users[0]->cpfUser);
            */

            $dados[] = array("year"=>'2015-05-17', "value"=>"18");
            $dados[] = array("year"=>'2015-05-18', "value"=>"20");
            $dados[] = array("year"=>'2015-05-19', "value"=>"22");

            return \Response::json($dados);
       // }
        //return \Response::json(false);
    }

    


    public function index(){
        die('index');
        $product_type = ProductType::pluck('name','id');
        return view('shop.product.index', compact('product_type'));
    }

    public function all(){
        die('all');
        return response()->json( ["data"=> ""]) ;
    }

    public function allRation(){
        die('allRation');
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
        die('allMedicine');
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
        die('destroy');
        Product::destroy($id);
        return response()->json(['success'=>'Data is successfully destroied']);
    }

    public function show(Product $request, $id){
        die('show');
        $product = Product::with('product_type')->find($id);

        return response()->json(['success' => $product]);
    }

    public function store(Request $request) {
        die('store');
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
        die('update');
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
