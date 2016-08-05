<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Datos_trabajador_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function insert($data) {
        return ($this->db->insert('datos_trabajador' , $data)) ? $this->db->insert_id() : false;
    }

}

?>
