<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Trunk;
use App\PetVetPrescription;
use App\PetVetPrescriptionDrugs;
use Datatables;
use App\Branch;

class BranchController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $branchs      = Branch::all('*');
        $branchs_json = array();

        foreach($branchs as $branch) {
            $branchs_json[] = array( $branch->name, $branch->type,  
                                    '<a href="javascript:void(0)" title="Editar" onclick="editTrunk(event.target)"><i data-id="'.$branch->id.'" class="fa fa-edit"></i></a>&nbsp;
                                     <a href="javascript:void(0)" title="Delete" onclick="deleteTrunk(event.target)"><i data-id="'.$branch->id.'" class="fa fa-times"></i></a>' );
        }

        $branchs_json = json_encode($branchs_json);
        return view('user.branch.index', compact('branchs_json'));
    }


    public function save(Request $request){

        $branch = Branch::updateOrCreate(['id'=>$request->get('edtId')],[
            'name'      => $request->get('edtName'),
            'type'      => $request->get('edtType'),
            'protocol'  => $request->get('edtProtocol'),
            'bind'      => $request->get('edtBind'),
            'context'   => $request->get('edtContext'),
            'disallow'  => $request->get('edtDisallow'),
            'allow'     => $request->get('edtAllow'),
            'aors'      => $request->get('edtAors'),
            'auth'      => $request->get('edtAuth'),
            'max_contacts' => $request->get('edtMaxContacts'),
            'auth_type' => $request->get('edtAuthtype'),
            'password'  => $request->get('edtPassword'),
            'username'  => $request->get('edtUsername'),
            'contact'   => $request->get('edtContact'),
        ]);
        return response()->json(['code'=>200, 'message'=>'Ramal criado com sucesso','data' => $branch], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $branch = Branch::findOrFail($id);
        return response()->json(['code'=>200, 'message'=>'Ramal alterado com sucesso','data' => $branch], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        $post = Branch::find($id);
        return response()->json($post);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showfile(){
        $trunks = Branch::all('*');
        $file   = '';
        foreach($trunks as $trunk) {

            switch ($trunk->type) {
                case 'transport':
                    $file .=
                    "[$trunk->name]
                    type=$trunk->type
                    protocol=$trunk->protocol
                    bind=$trunk->bind

                    ";
                break;
                case 'registration':
                    $file .= 
                    "[$trunk->name]
                    type=$trunk->type
                    outbound_auth=$trunk->outbound_auth
                    server_uri=$trunk->server_uri
                    client_uri=$trunk->client_uri

                    ";
                break;
                case 'auth':
                    $file .= 
                    "[$trunk->name]
                    type=$trunk->type
                    auth_type=$trunk->auth_type
                    password=$trunk->password
                    username=$trunk->username
                      
                    ";
                break;
                case 'aor':
                    $file .= 
                    "[$trunk->name]
                    type=$trunk->type
                    contact=$trunk->contact

                    ";
                break;
                case 'endpoint':
                    $file .= 
                    "[$trunk->name]
                    type=$trunk->type
                    context=$trunk->context
                    disallow=$trunk->disallow
                    allow=$trunk->allow
                    outbound_auth=$trunk->outbound_auth
                    aors=$trunk->aors
                      
                    ";
                break;
                case 'identify':
                    $file .= 
                    "[$trunk->name]
                    type=$trunk->type
                    endpoint=$trunk->endpoint
                    match=$trunk->match

                    ";
                break;
            }

        }
        return response()->json(['code'=>200, 'message'=>'successfully','data'=>$file], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id){
        Branch::find($id)->delete();
        return response()->json(['code'=>200, 'message'=>'Ramal deletado com sucesso'],200);
    }

}
