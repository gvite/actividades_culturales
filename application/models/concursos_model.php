<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Concursos_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all() {
        $result = $this->db->get('concursos');
        return ($result->num_rows() > 0 ) ? $result->result_array() : array();
    }
    
    public function get($id){
        $this->db->where('id' , $id);
        $this->db->limit(1);
        $result = $this->db->get('concursos');
        return ($result->num_rows() > 0) ? $result->row_array() : false ;
    }
    public function get_by_slug($slug){
        $this->db->where('slug' , $slug);
        $this->db->limit(1);
        $result = $this->db->get('concursos');
        return ($result->num_rows() > 0) ? $result->row_array() : false ;
    }

}

?>
