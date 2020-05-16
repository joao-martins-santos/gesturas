<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cdr extends Model
{
    protected $table    = 'cdr';
    public $fillable    = ['calldate', 'clid', 'src', 'dst', 'dcontext', 'channel', 'dstchannel', 'lastapp', 'lastdata', 'duration', 'billsec', 'disposition', 'amaflags', 'accountcode', 'uniqueid', 'peeraccount', 'linkedid', 'sequence', 'userfield'];
    protected $primarykey = '';
    protected $keyType  = '';
    public $timestamps  = false;
}



