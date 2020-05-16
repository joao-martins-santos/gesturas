<?php

namespace App\Http\Controllers\User;

use App\Aor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class AorController extends Controller
{

    public function index(){
        $aors       = Aor::all('*');
        $aors_json  = array();

        foreach($aors as $aor) {
            $aors_json[] = array( $aor->id, $aor->default_expiration, $aor->max_contacts, $aor->minimum_expiration, $aor->remove_existing, $aor->qualify_frequency, $aor->authenticate_qualify, $aor->maximum_expiration,
                                    '<a href="javascript:void(0)" title="Editar" onclick="editAor(event.target)"><i data-id="'.$aor->id.'" class="fa fa-edit"></i></a>&nbsp;
                                     <a href="javascript:void(0)" title="Delete" onclick="deleteAor(event.target)"><i data-id="'.$aor->id.'" class="fa fa-times"></i></a>' );
        }

        $aors_json = json_encode($aors_json);
        return view('user.aor.index', compact('aors_json'));
    }

    public function save(Request $request){
        $aor = Aor::updateOrCreate(['id'=>$request->get('edtId')],[
            'default_expiration'    => $request->get('edtDefaultExpiration'),
            'max_contacts'          => $request->get('edtMaxContacts'),
            'minimum_expiration'    => $request->get('edtMinimumExpiration'),
            'remove_existing'       => $request->get('edtRemoveExisting'),
            'qualify_frequency'     => $request->get('edtQualifyFrequency'),
            'authenticate_qualify'  => $request->get('edtAuthenticateQualify'),
            'maximum_expiration'    => $request->get('edtMaximumExpiration'),
        ]);

        return response()->json(['code'=>200, 'message'=>'Aor criado com sucesso','data' => $aor], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $aor = Aor::findOrFail($id);
        return response()->json(['code'=>200, 'message'=>'Aor alterado com sucesso','data' => $aor], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        $post = Aor::find($id);
        return response()->json($post);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showfile(){
        $aors = Aor::all('*');
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
        Aor::find($id)->delete();
        return response()->json(['code'=>200, 'message'=>'Aor deletado com sucesso'],200);
    }

}
