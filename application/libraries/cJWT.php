<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once APPPATH . "/third_party/php-jwt/src/JWT.php";

class cJWT extends JWT {

    public function __construct() {
        //parent::__construct();
    }

}
