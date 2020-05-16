<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trunk extends Model
{
    //
    public $fillable = [ 'name', 'type', 'outbound_auth', 'server_uri', 'client_uri', 
                        'context', 'retry_interval',  'disallow', 'allow', 'aors', 'endpoint', 
                        'match', 'auth_type','password', 'username', 'protocol', 'bind', 'contact' ];
}
