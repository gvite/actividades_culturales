<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Evento_banda_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    public function insert($data){
        return ($this->db->insert('evento_banda' , $data)) ? $this->db->insert_id() : false;
    }

    public function get_by_evento_banda($event_id , $band_id){
        $this->db->where("evento_id" , $event_id);
        $this->db->where("banda_id" , $band_id);
        $this->db->limit(1);
        $result = $this->db->get('evento_banda');
        return ($result->num_rows() > 0) ? $result->row_array() : false;
    }

}

?>
