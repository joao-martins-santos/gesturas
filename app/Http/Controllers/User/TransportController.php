<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Transport;


class TransportController extends Controller
{

    public function index(){
        $trans = Transport::all('*');
        $trans_json = array();

        foreach($trans as $tran) {
            $trans_json[] = array( $tran->id, $tran->bind, $tran->protocol, $tran->method,
                                    '<a href="javascript:void(0)" title="Editar" onclick="editTransport(event.target)"><i data-id="'.$tran->id.'" class="fa fa-edit"></i></a>&nbsp;
                                     <a href="javascript:void(0)" title="Delete" onclick="deleteTransport(event.target)"><i data-id="'.$tran->id.'" class="fa fa-times"></i></a>' );
        }

        $trans_json = json_encode($trans_json);
        return view('user.transport.index', compact('trans_json'));
    }

    public function save(Request $request){
        $trunk = Transport::updateOrCreate(['id'=>$request->get('edtId')],[
            'protocol'  => $request->get('edtProtocol'),
            'bind'      => $request->get('edtBind'),
            'method'    => $request->get('edtMethod'),
            'allow_reload' => 'yes',
        ]);
        return response()->json(['code'=>200, 'message'=>'Transporte criado com sucesso','data' => $trunk], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $trunk = Transport::findOrFail($id);
        return response()->json(['code'=>200, 'message'=>'Transporte alterado com sucesso','data' => $trunk], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        $post = Transport::find($id);
        return response()->json($post);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showfile(){
        $trunks = Transport::all('*');
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

/*        $out = fopen("extension.conf", "w");
        fwrite($out, $file);
        fclose($out);

        Storage::disk('sftp')->put('extension.conf', '/var/www/');
        var_dump("as");
        die;
  */      
        return response()->json(['code'=>200, 'message'=>'successfully','data'=>$file], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id){
        Transport::find($id)->delete();
        return response()->json(['code'=>200, 'message'=>'Transporte deletado com sucesso'],200);
    }

}
