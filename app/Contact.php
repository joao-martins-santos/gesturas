<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table    = 'ps_contacts';
    public $fillable    = ['uri', 'expiration_time', 'qualify_frequency', 'outbound_proxy', 'path', 'user_agent', 'qualify_timeout', 'reg_server', 'authenticate_qualify', 'via_addr', 'via_port', 'call_id', 'endpoint', 'prune_on_boot'];
    protected $primarykey = 'id';
    protected $keyType  = 'string';
    public $timestamps  = false;
}