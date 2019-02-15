<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Datos_externo_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function insert($data) {
        return ($this->db->insert('datos_externo' , $data)) ? $this->db->insert_id() : false;
    }
    public function get_all_by_user($user_id){
        $this->db->select('d.*');
        $this->db->where("d.usuario_id" , $user_id);
        $this->db->limit(1);
        $result = $this->db->get('datos_externo as d');
        return ($result->num_rows() > 0) ? $result->row_array() : false;
    }

}

?>
