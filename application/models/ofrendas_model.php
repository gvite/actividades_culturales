<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ofrendas_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    public function insert($data){
        return ($this->db->insert('ofrendas' , $data)) ? $this->db->insert_id() : false;
    }
    public function update($id , $data){
        $this->db->where("id" , $id);
        return ($this->db->update('ofrendas' , $data)) ? true : false;
    }
    public function get($id){
        $this->db->where('id' , $id);
        $this->db->limit(1);
        $result = $this->db->get('ofrendas');
        return ($result->num_rows() > 0) ? $result->row_array() : false;
    }
    public function get_by_event($event_id){
        $this->db->where('evento_id' , $event_id);
        $result = $this->db->get('ofrendas');
        return ($result->num_rows() > 0) ? $result->result_array() : array() ;
    }
}

?>
