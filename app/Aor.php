<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aor extends Model
{
    protected $table    = 'ps_aors';
    public $fillable    = ['id', 'contact', 'default_expiration', 'mailboxes', 'max_contacts', 'minimum_expiration', 'remove_existing', 'qualify_frequency', 'authenticate_qualify', 'maximum_expiration', 'outbound_proxy', 'support_path', 'qualify_timeout', 'voicemail_extension'];
    protected $primarykey = 'id';
    protected $keyType  = 'string';
    public $timestamps  = false;
}
