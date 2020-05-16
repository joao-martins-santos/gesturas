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
use App\Tronco;
use App\Auth;
use App\EndpointIp;
use App\Registration;
use Exception;
//use Illuminate\Support\Facades\Auth;

class TroncoController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $trans = Transport::all('*');

        $dados = DB::table('ps_endpoint_id_ips')
            ->join('ps_auths', 'ps_endpoint_id_ips.id', '=', 'ps_auths.id')
            ->leftjoin('ps_aors', 'ps_endpoint_id_ips.id', '=', 'ps_aors.id')
            ->leftjoin('ps_registrations', 'ps_endpoint_id_ips.id', '=', 'ps_registrations.id')
            ->leftjoin('ps_endpoints', 'ps_endpoints.id', '=', 'ps_endpoint_id_ips.id')
            ->select(['ps_endpoints.id','ps_endpoints.transport', 'ps_endpoints.context', 'ps_endpoints.allow', 'ps_endpoints.connected_line_method','ps_endpoints.force_rport','ps_endpoints.rewrite_contact','ps_endpoints.rtp_symmetric',
                      'ps_auths.password', 'ps_auths.username',
                      'ps_aors.max_contacts', 
                      'ps_registrations.client_uri', 'ps_registrations.server_uri',
                      'ps_endpoint_id_ips.match'])->get();

        $nat = null;

        foreach($dados as $dado) {
            if ( $dado->force_rport == 'yes' && $dado->rewrite_contact  == 'yes' && $dado->rtp_symmetric == 'yes' ){
                $nat = 'yes';
            } else if ( $dado->force_rport == 'no' && $dado->rewrite_contact  == 'no' && $dado->rtp_symmetric == 'no' ){
                $nat = 'no';
            } else if ( $dado->force_rport == 'yes' && $dado->rewrite_contact  == 'yes' && $dado->rtp_symmetric == 'no' ){
                $nat = 'roteado';
            }

            $dados_json[] = array( $dado->id, $dado->transport, $dado->context, $dado->allow, $dado->connected_line_method, $dado->client_uri, $dado->server_uri,$nat,
                                    "<a href='javascript:void(0)' title='Visualizar' onclick='showTronco(\"".trim($dado->id)."\")'><i data-id='".$dado->id."' class='fa fa-search'></i></a>&nbsp;
                                     <a href='javascript:void(0)' title='Editar' onclick='editTronco(event.target)'><i data-id='".$dado->id."' class='fa fa-edit'></i></a>&nbsp;
                                     <a href='javascript:void(0)' title='Delete' onclick='deleteTronco(event.target)'><i data-id='".$dado->id."' class='fa fa-times'></i></a>" );
        }

        $dados_json = json_encode($dados_json);
        return view('user.tronco.index', compact('dados_json', 'trans'));
    }

    public function save(Request $request){
        try {
            $obj = new Tronco( $request->get('edtId'), $request->get('edtContact'), $request->get('edtPassword'), $request->get('edtTransport'), $request->get('edtContext'), 
                               $request->get('edtAllow'), $request->get('edtLineMethod'), $request->get('edtClientUri'), $request->get('edtServerUri'), $request->get('edtNat'));


            $aor = Aor::updateOrCreate(['id'=>$obj->id],[
                'contact'               => $obj->contact,
                'default_expiration'    => $obj->default_expiration,
                'max_contacts'          => $obj->max_contacts,
                'minimum_expiration'    => $obj->minimum_expiration,
                'remove_existing'       => $obj->remove_existing,
                'qualify_frequency'     => $obj->qualify_frequency,
                'authenticate_qualify'  => $obj->authenticate_qualify,
                'maximum_expiration'    => $obj->maximum_expiration,
            ]);

            $auth = Auth::updateOrCreate(['id'=>$obj->id],[
                'auth_type'=> $obj->auth_type,
                'password' => $obj->password,
                'username' => $obj->id
            ]);

            $endpoint = Endpoint::updateOrCreate(['id'=>$obj->id],[
                'transport'             => $obj->transport,
                'context'               => $obj->context,
                'disallow'              => $obj->disallow,
                'allow'                 => $obj->allow,
                'direct_media'          => $obj->direct_media,
                'connected_line_method' => $obj->connected_line_method,
                'force_rport'           => $obj->force_rport,
                'rewrite_contact'       => $obj->rewrite_contact,
                'rtp_symmetric'         => $obj->rtp_symmetric,
                'timers_sess_expires'   => $obj->timers_sess_expires,
            ]);

            $regi = Registration::updateOrCreate(['id'=>$obj->id],[
                'client_uri'                => $obj->client_uri,
                //'contact_user'              => $obj->contact_user,
                'expiration'                => $obj->expiration,
                'retry_interval'            => $obj->retry_interval,
                'forbidden_retry_interval'  => $obj->forbidden_retry_interval,
                'server_uri'                => $obj->server_uri,
                'transport'                 => $obj->transport
            ]);

            $ip = EndpointIp::updateOrCreate(['id'=>$obj->id],[
                'endpoint' => $obj->id,
                'match'    => $obj->match
            ]);

            return response()->json(['code'=>200, 'message'=>'Tronco criado com sucesso','data' => $aor], 200);
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
        //$trans = Transport::all('*');
        $dados = DB::table('ps_endpoint_id_ips')
            ->join('ps_auths', 'ps_endpoint_id_ips.id', '=', 'ps_auths.id')
            ->leftjoin('ps_aors', 'ps_endpoint_id_ips.id', '=', 'ps_aors.id')
            ->leftjoin('ps_registrations', 'ps_endpoint_id_ips.id', '=', 'ps_registrations.id')
            ->leftjoin('ps_endpoints', 'ps_endpoints.id', '=', 'ps_endpoint_id_ips.id')
            ->select(['ps_endpoints.id','ps_endpoints.transport', 'ps_endpoints.context', 'ps_endpoints.disallow', 'ps_endpoints.allow', 'ps_endpoints.direct_media', 
                      'ps_endpoints.connected_line_method','ps_endpoints.force_rport','ps_endpoints.rewrite_contact','ps_endpoints.rtp_symmetric', 'ps_endpoints.timers_sess_expires',
                      'ps_auths.password', 'ps_auths.username', 'ps_auths.auth_type',
                      'ps_aors.contact', 'ps_aors.max_contacts', 'ps_aors.minimum_expiration', 'ps_aors.default_expiration', 'ps_aors.remove_existing', 'ps_aors.qualify_frequency', 'ps_aors.authenticate_qualify', 'ps_aors.maximum_expiration',
                      'ps_registrations.client_uri', 'ps_registrations.server_uri','ps_registrations.contact_user', 'ps_registrations.expiration', 'ps_registrations.retry_interval', 'ps_registrations.forbidden_retry_interval', 
                      'ps_endpoint_id_ips.match'])->where('ps_endpoint_id_ips.id', '=', $id)->get();

        return response()->json(['code'=>200, 'message'=>'Ramal alterado com sucesso', 'data'=>$dados ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        $dados = DB::table('ps_endpoint_id_ips')
            ->join('ps_auths', 'ps_endpoint_id_ips.id', '=', 'ps_auths.id')
            ->leftjoin('ps_aors', 'ps_endpoint_id_ips.id', '=', 'ps_aors.id')
            ->leftjoin('ps_registrations', 'ps_endpoint_id_ips.id', '=', 'ps_registrations.id')
            ->leftjoin('ps_endpoints', 'ps_endpoints.id', '=', 'ps_endpoint_id_ips.id')
            ->select(['ps_endpoints.id','ps_endpoints.transport', 'ps_endpoints.context', 'ps_endpoints.disallow', 'ps_endpoints.allow', 'ps_endpoints.direct_media', 
                      'ps_endpoints.connected_line_method','ps_endpoints.force_rport','ps_endpoints.rewrite_contact','ps_endpoints.rtp_symmetric', 'ps_endpoints.timers_sess_expires',
                      'ps_auths.password', 'ps_auths.username', 'ps_auths.auth_type',
                      'ps_aors.contact', 'ps_aors.max_contacts', 'ps_aors.minimum_expiration', 'ps_aors.default_expiration', 'ps_aors.remove_existing', 'ps_aors.qualify_frequency', 'ps_aors.authenticate_qualify', 'ps_aors.maximum_expiration',
                      'ps_registrations.client_uri', 'ps_registrations.server_uri','ps_registrations.contact_user', 'ps_registrations.expiration', 'ps_registrations.retry_interval', 'ps_registrations.forbidden_retry_interval', 
                      'ps_endpoint_id_ips.match'])->where('ps_endpoint_id_ips.id', '=', $id)->get();

        return response()->json(['code'=>200,'data' =>$dados]);
    }


    public function validator($id){
        $dados   = DB::table('ps_endpoint_id_ips')->select(['ps_endpoint_id_ips.id','ps_endpoint_id_ips.match'])->where('ps_endpoint_id_ips.id', '=', $id)->get();
        $message = false;
        
        if ( is_object(@$dados[0]) ){
            $message = 'Tronco já existente !!!';
        } 

        return response()->json(['code'=>200, 'message'=>$message]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id){
        Endpoint::find($id)->delete();
        Auth::find($id)->delete();
        Aor::find($id)->delete();
        Registration::find($id)->delete();
        EndpointIp::find($id)->delete();
        return response()->json(['code'=>200, 'message'=>'Ramal deletado com sucesso'],200);
    }

}
