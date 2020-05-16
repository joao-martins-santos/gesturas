<?php

namespace App\Http\Controllers\User;

use App\Aor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use Datatables;
use App\Branch;
use App\Endpoint;
use App\Transport;
use App\Ramal;
use App\Auth;

use Exception;
//use Illuminate\Support\Facades\Auth;

class RamalController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $trans = Transport::all('*');

        $dados = DB::table('ps_endpoints')
            ->join('ps_auths', 'ps_endpoints.id', '=', 'ps_auths.id')
            ->join('ps_aors', 'ps_endpoints.id', '=', 'ps_aors.id')
            ->select(['ps_endpoints.id','ps_endpoints.transport', 'ps_endpoints.context', 'ps_endpoints.allow','ps_auths.password', 'ps_auths.username','ps_aors.max_contacts'])
            ->get();

       foreach($dados as $dado) {
            $dados_json[] = array( $dado->id, $dado->transport, $dado->context, $dado->allow, @$dado->password, @$dado->username, @$dado->max_contacts,
                                    '<a href="javascript:void(0)" title="Editar" onclick="editRamal(event.target)"><i data-id="'.$dado->id.'" class="fa fa-edit"></i></a>&nbsp;
                                     <a href="javascript:void(0)" title="Delete" onclick="deleteRamal(event.target)"><i data-id="'.$dado->id.'" class="fa fa-times"></i></a>' );
        }

        $dados_json = json_encode($dados_json);
        return view('user.ramal.index', compact('dados_json', 'trans'));
    }


    public function save(Request $request){
        try {
            $obj = new Ramal($request->get('edtId'), $request->get('edtPassword'), $request->get('edtUsername'), $request->get('edtTransport'), $request->get('edtContexto'), $request->get('edtAllow'), $request->get('edtWebRTC'), $request->get('edtNat') );
            
            $aor = Aor::updateOrCreate(['id'=>$obj->id],[
                'default_expiration'  => $obj->default_expiration,
                'max_contacts'        => $obj->max_contacts,
                'minimum_expiration'  => $obj->minimum_expiration,
                'remove_existing'     => $obj->remove_existing,
                'qualify_frequency'   => $obj->qualify_frequency,
                'authenticate_qualify'=> $obj->authenticate_qualify,
                'maximum_expiration'  => $obj->maximum_expiration, 
                'webrtc'              => $obj->webrtc, 
            ]);

            $auth = Auth::updateOrCreate(['id'=>$obj->id],[
                'auth_type'=> $obj->auth_type,
                'password' => $obj->password,
                'username' => $obj->username
            ]);
            $endpoint = Endpoint::updateOrCreate(['id'=>$obj->id],[
                'transport'          => $obj->transport,
                'context'            => $obj->contexto,
                'aors'               =>$obj->id,
                'auth'               =>$obj->id,
                'allow'              => $obj->allow,
                'disallow'           => $obj->disallow,
                'direct_media'       => $obj->direct_media,
                'timers_sess_expires'=> $obj->timers_sess_expires,
                'force_rport'        => $obj->force_rport,
                'rewrite_contact'    => $obj->rewrite_contact,
                'rtp_symmetric'      => $obj->rtp_symmetric
            ]);

            return response()->json(['code'=>200, 'message'=>'Ramal criado com sucesso','data' => $aor], 200);
        } catch( Exception $e) {
            var_dump($e->getMessage());
            die;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $trans = Transport::all('*');
        $dados = DB::table('ps_endpoints')
            ->join('ps_auths', 'ps_endpoints.id', '=', 'ps_auths.id')
            ->join('ps_aors', 'ps_endpoints.id', '=', 'ps_aors.id')
            ->select(['ps_endpoints.id','ps_endpoints.transport', 'ps_endpoints.context', 'ps_endpoints.allow','ps_auths.password', 'ps_auths.username','ps_aors.max_contacts'])
            ->where('ps_endpoints.id', '=', $id)
            ->get();

        return response()->json(['code'=>200, 'message'=>'Ramal alterado com sucesso', 'data'=>[$dados] ], 200);
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
