<?php

namespace App;

class Tronco 
{
    public $id;
    public $contact;
    public $password;
    public $transport;
    public $context;
    public $allow;
    public $connected_line_method;
    public $force_rport;
    public $rewrite_contact;
    public $rtp_symmetric;
    public $match = '0.0.0.0';
        
	public $client_uri;
    public $server_uri;
    
    //ps_aors
    public $default_expiration   = 600;
    public $max_contacts         = 1;
    public $minimum_expiration   = 600;
    public $remove_existing      = 'yes';
    public $qualify_frequency    = 15;
    public $authenticate_qualify = 'no';
    public $maximum_expiration   = 7200;

    //ps_auths
    public $auth_type = 'userpass';

    //ps_endpoints
    public $disallow            = 'all';
    public $direct_media        = 'no';
    public $timers_sess_expires = 600;

    //ps_registrations
    public $expiration               = 3600;
    public $retry_interval           = 30;
    public $forbidden_retry_interval = 600;

	
    public function __construct( $id, $contact, $password, $transport, $context, $allow, $connected_line_method, $client_uri, $server_uri, $nat )
    {

        $this->id                    = $id;
        $this->contact               = $contact;
        $this->password              = $password;
        $this->transport             = $transport;
        $this->context               = $context;
        $this->allow                 = $allow;
        $this->connected_line_method = $connected_line_method;
        $this->client_uri            = $client_uri;
        $this->server_uri            = $server_uri;

        switch ( $nat ) {
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
