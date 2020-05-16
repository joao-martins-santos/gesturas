<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $table    = 'ps_registrations';
    public $fillable    = ['id', 'auth_rejection_permanent', 'client_uri', 'contact_user', 'expiration', 'max_retries', 'outbound_auth', 'outbound_proxy', 'retry_interval', 'forbidden_retry_interval', 'server_uri', 'transport', 'support_path', 'fatal_retry_interval', 'line', 'endpoint'];    protected $primarykey = 'id';
    protected $keyType  = 'string';
    public $timestamps  = false;
}

