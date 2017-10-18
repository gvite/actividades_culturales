<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ofrendas extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }
    public function index($evento_id){
        
        echo $evento_id;
    }
}