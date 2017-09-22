<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Talento_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    public function insert($data){
        return ($this->db->insert('talento' , $data)) ? $this->db->insert_id() : false;
    }
    public function update($id , $data){
        $this->db->where("id" , $id);
        return ($this->db->update('talento' , $data)) ? true : false;
    }
    public function check_cta($cta){
        $this->db->select('id');
        $this->db->where('no_cta', $cta);
        $this->db->limit(1);
        $result = $this->db->get('talento');
        return ($result->num_rows() > 0) ? false : true;
    }
    public function get_wdata($id){
        $this->db->select('t.*,c.carrera');
        $this->db->join('carreras as c' , 'c.id=t.carrera_id');
        $this->db->where('t.id' , $id);
        $this->db->limit(1);
        $result = $this->db->get('talento as t');
        return ($result->num_rows() > 0) ? $result->row_array() : false;
    }
}

?>
