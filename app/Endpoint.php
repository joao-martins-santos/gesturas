<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Endpoint extends Model
{
    protected $table    = 'ps_endpoints';
    public $fillable    = ['id', 'transport', 'aors', 'auth', 'context', 'disallow', 'allow', 'direct_media', 'force_rport', 'rewrite_contact', 'rtp_symmetric', 'timers_sess_expires','connected_line_method'];
    protected $primarykey = 'id';
    protected $keyType  = 'string';
    public $timestamps  = false;
}