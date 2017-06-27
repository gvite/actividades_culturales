<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sliders_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all($select = '') {
        if($select != ''){
            $this->db->select($select);
        }
        $result = $this->db->get('sliders');
        return ($result->num_rows() > 0) ? $result->result_array() : FALSE;
    }
    public function get_all_show($select = '') {
        if($select != ''){
            $this->db->select($select);
        }
        $this->db->order_by("orden");
        $this->db->where("status" , 1);
        $result = $this->db->get('sliders');
        return ($result->num_rows() > 0) ? $result->result_array() : FALSE;
    }
    public function insert($data){
        return ($this->db->insert('sliders' , $data)) ? $this->db->insert_id() : false;
    }
    public function update($id , $data){
        $this->db->where("id" , $id);
        return ($this->db->update('sliders' , $data)) ? true : false;
    }

    public function get($id , $select = ''){
        if($select != ''){
            $this->db->select($select);
        }
        $this->db->where("id" , $id);
        $this->db->limit(1);
        $result = $this->db->get('sliders');
        return ($result->num_rows() > 0) ? $result->row_array() : FALSE;
    }
}

?>
