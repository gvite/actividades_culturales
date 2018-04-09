<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once APPPATH . "/third_party/Parsedown.php";

class CParsedown extends Parsedown {

    public function __construct() {
        //parent::__construct();
    }

}
