<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Municipios extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all() {
        $this->db->order_by('estado_id');
        $result = $this->db->get('municipios');
        return ($result->num_rows() > 0 ) ? $result->result_array() : false;
    }

}

?>
