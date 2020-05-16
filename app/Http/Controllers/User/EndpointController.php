<?php

namespace App\Http\Controllers\User;

use App\Endpoint;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Transport;

class EndpointController extends Controller
{

    public function index(){
        $dados       = Endpoint::all('*');
        $trans       = Transport::all('*');
        $dados_json  = array();

        foreach($dados as $dado) {
            $dados_json[] = array( $dado->id, $dado->transport, $dado->aors, $dado->auth, $dado->context, $dado->disallow, $dado->allow, $dado->direct_media, $dado->force_rport, $dado->rewrite_contact, $dado->rtp_symmetric, $dado->timers_sess_expires,
                                    '<a href="javascript:void(0)" title="Editar" onclick="editAor(event.target)"><i data-id="'.$dado->id.'" class="fa fa-edit"></i></a>&nbsp;
                                     <a href="javascript:void(0)" title="Delete" onclick="deleteAor(event.target)"><i data-id="'.$dado->id.'" class="fa fa-times"></i></a>' );
        }
        $dados_json = json_encode($dados_json);
        return view('user.endpoint.index', compact('dados_json', 'trans'));
    }

    public function save(Request $request){
        $end = Endpoint::updateOrCreate(['id'=>$request->get('edtId')],[
            'transport'             => $request->get('edtTransport'),
            'aors'                  => $request->get('edtAors'),
            'auth'                  => $request->get('edtAuth'),
            'context'               => $request->get('edtContext'),
            'disallow'              => $request->get('edtDisallow'),
            'allow'                 => $request->get('edtAllow'),
            'direct_media'          => $request->get('edtDirectMedia'),
            'force_rport'           => $request->get('edtForceRport'),
            'rewrite_contact'       => $request->get('edtRewriteContact'),
            'rtp_symmetric'         => $request->get('edtRtpSymmetric'),
            'timers_sess_expires'   => $request->get('edtTimersExpires'),
        ]);

        return response()->json(['code'=>200, 'message'=>'Endpoint criado com sucesso','data' => $end], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $aor = Endpoint::findOrFail($id);
        return response()->json(['code'=>200, 'message'=>'Endpoint alterado com sucesso','data' => $aor], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        $post = Endpoint::find($id);
        return response()->json($post);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showfile(){
        $aors = Endpoint::all('*');
        $file   = '';
        /*
        foreach($aor as $aor) {

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
        }*/

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
        Endpoint::find($id)->delete();
        return response()->json(['code'=>200, 'message'=>'Endpoint deletado com sucesso'],200);
    }

}
