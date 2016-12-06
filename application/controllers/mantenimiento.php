<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mantenimiento extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $data['active'] = false;
        $this->load->helper(array('sesion' , 'url'));
        $this->load->view('main/mantenimiento_header_view', "");
        $this->load->view("main/mantenimiento_view" , "");
        $this->load->view('main/footer_view', '');
    }

}
