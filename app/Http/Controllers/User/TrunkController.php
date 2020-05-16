<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\PetConsult;
use App\PetVetPrescription;
use App\PetVetPrescriptionDrugs;
use App\Transport;
use App\Trunk;

class TrunkController extends Controller
{
    public function index(){
        $trunks      = Trunk::all('*');
        $trunks_json = array();
        //$trunk->outbound_auth, $trunk->server_uri, $trunk->client_uri, $trunk->context, $trunk->retry_interval, $trunk->disallow, $trunk->allow, $trunk->aors, $trunk->endpoint, $trunk->match, $trunk->auth_type, $trunk->password, $trunk->username,

        foreach($trunks as $trunk) {
            $trunks_json[] = array( $trunk->name, $trunk->type,  
                                    '<a href="javascript:void(0)" title="Editar" onclick="editTrunk(event.target)"><i data-id="'.$trunk->id.'" class="fa fa-edit"></i></a>&nbsp;
                                     <a href="javascript:void(0)" title="Delete" onclick="deleteTrunk(event.target)"><i data-id="'.$trunk->id.'" class="fa fa-times"></i></a>' );
        }

        $trunks_json = json_encode($trunks_json);
        return view('user.trunk.index', compact('trunks_json'));
    }

    public function save(Request $request){
        $trunk = Trunk::updateOrCreate(['id'=>$request->get('edtId')],[
            'name' => $request->get('edtName'),
            'type' => $request->get('edtType'),
            'outbound_auth' => $request->get('edtOutboundAuth'),
            'server_uri' => $request->get('edtServerUri'),
            'client_uri' => $request->get('edtClientUri'),
            'context' => $request->get('edtContext'),
            'disallow' => $request->get('edtDisallow'),
            'allow' => $request->get('edtAllow'),
            'aors' => $request->get('edtAors'),
            'endpoint' => $request->get('edtEndpoint'),
            'match' => $request->get('edtMatch'),
            'auth_type' => $request->get('edtAuthtype'),
            'password' => $request->get('edtPassword'),
            'username' => $request->get('edtUsername'),
            'protocol' => $request->get('edtProtocol'),
            'bind' => $request->get('edtBind'),
            'contact' => $request->get('edtContact'),
        ]);
        return response()->json(['code'=>200, 'message'=>'Tronco criado com sucesso','data' => $trunk], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $trunk = Trunk::findOrFail($id);
        return response()->json(['code'=>200, 'message'=>'Tronco alterado com sucesso','data' => $trunk], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        $post = Trunk::find($id);
        return response()->json($post);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showfile(){
        $trunks = Trunk::all('*');
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

        $out = fopen("extension.conf", "w");
        fwrite($out, $file);
        fclose($out);

        Storage::disk('sftp')->put('extension.conf', '/var/www/');
        var_dump("as");
        die;
        
        return response()->json(['code'=>200, 'message'=>'successfully','data'=>$file], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id){
        Trunk::find($id)->delete();
        return response()->json(['code'=>200, 'message'=>'Tronco deletado com sucesso'],200);
    }

}
