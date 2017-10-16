<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Talento_canciones_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    public function insert($data){
        return ($this->db->insert('talento_canciones' , $data)) ? $this->db->insert_id() : false;
    }
    public function update($id , $data){
        $this->db->where("id" , $id);
        return ($this->db->update('talento_canciones' , $data)) ? true : false;
    }
    public function delete_by_band($band_id){
        $where_clause = "select evento_banda.id from evento_banda where evento_banda.banda_id=" . $this->db->escape_str($band_id);

        $this->db->where("evento_banda_id in ($where_clause)");
        
        return ($this->db->delete('talento_canciones')) ? true : false;
    }
}

?>
