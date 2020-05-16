<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EndpointIp extends Model
{
    protected $table    = 'ps_endpoint_id_ips';
    public $fillable    = ['id', 'endpoint', 'match'];
    protected $primarykey = 'id';
    protected $keyType  = 'string';
    public $timestamps  = false;
}
