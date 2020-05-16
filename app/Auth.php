<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Auth extends Model
{
    protected $table    = 'ps_auths';
    public $fillable    = ['id', 'auth_type', 'password',  'username'];
    protected $primarykey = 'id';
    protected $keyType  = 'string';
    public $timestamps  = false;
}