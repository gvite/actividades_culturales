<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Banda_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    public function insert($data){
        return ($this->db->insert('bandas' , $data)) ? $this->db->insert_id() : false;
    }
    public function update($id , $data){
        $this->db->where("id" , $id);
        return ($this->db->update('bandas' , $data)) ? true : false;
    }
    public function get_by_id($id){
        $this->db->where("id" , $id);
        $this->db->limit(1);
        $result = $this->db->get('bandas');
        return ($result->num_rows() > 0 ) ? $result->row_array() : false;
    }
    public function get_by_user($user_id) {
        $this->db->where("encargado_id" , $user_id);
        $this->db->limit(1);
        $result = $this->db->get('bandas');
        return ($result->num_rows() > 0 ) ? $result->row_array() : false;
    }

}

?>
