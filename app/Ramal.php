<?php

namespace App;

class Ramal 
{
    public $id;
    public $password;
    public $username;
    public $transport;
    public $contexto;
    public $allow;
    public $webrtc;

    public $default_expiration   = 600;
    public $max_contacts         = 1;
    public $minimum_expiration   = 600;
    public $remove_existing      = 'yes';
    public $qualify_frequency    = 1;
    public $authenticate_qualify = 'no';
    public $maximum_expiration   = 7200;
    public $auth_type            = 'userpass';
    public $disallow             = 'all';
    public $direct_media         = 'no';
    public $timers_sess_expires  = 600;

    public $force_rport;
    public $rewrite_contact;
    public $rtp_symmetric;

    public function __construct($id, $password, $username, $transport, $contexto, $allow, $webrtc, $nat)
    {
        $this->id           = $id;
        $this->password     = $password; 
        $this->username     = $username;
        $this->transport    = $transport;
        $this->contexto     = $contexto;
        $this->allow        = $allow;
        $this->webrtc       = $webrtc;
        
        switch ($nat) {
            case 'S':
                $this->force_rport      = 'yes';
                $this->rewrite_contact  = 'yes';
                $this->rtp_symmetric    = 'yes';
            break;
            case 'N':
                $this->force_rport      = 'no';
                $this->rewrite_contact  = 'no';
                $this->rtp_symmetric    = 'no';
            break;
            case 'R':
                $this->force_rport      = 'yes';
                $this->rewrite_contact  = 'yes';
                $this->rtp_symmetric    = 'no';
            break;
        }
    }

    
}
