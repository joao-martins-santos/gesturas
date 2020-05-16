<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    public $fillable = ['name', 'type', 'protocol', 'bind', 'context', 
                        'disallow', 'allow', 'aors', 'auth', 'max_contacts', 
                        'auth_type', 'password', 'username', 'contact'];

}
