<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transport extends Model
{
    protected $table      = 'ps_transports';
    public $fillable      = ['id', 'protocol', 'bind', 'method', 'allow_reload'];
    protected $primarykey = 'id';
    protected $keyType    = 'string';
    public $timestamps    = false;
}
