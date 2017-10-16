<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Canciones_banda_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function insert($data){
        return ($this->db->insert('canciones_banda' , $data)) ? $this->db->insert_id() : false;
    }
    public function update($id , $data){
        $this->db->where("id" , $id);
        return ($this->db->update('canciones_banda' , $data)) ? true : false;
    }
    public function get_by_band($band_id) {
        $this->db->where("banda_id" , $band_id);
        $result = $this->db->get('canciones_banda');
        return ($result->num_rows() > 0 ) ? $result->result_array() : array();
    }
    public function delete_by_band($band_id){
        $this->db->where('banda_id' , $band_id);
        return ($this->db->delete('canciones_banda')) ? true : false;
    }

}

?>
