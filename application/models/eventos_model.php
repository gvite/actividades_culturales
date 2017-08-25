<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Eventos_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all() {
        $result = $this->db->get('eventos');
        return ($result->num_rows() > 0 ) ? $result->result_array() : array();
    }

    public function get_next_all() {
        $this->db->where("fecha >" , date("Y-m-d H:i:s"));
        $this->db->order_by("fecha");
        $result = $this->db->get('eventos');
        return ($result->num_rows() > 0 ) ? $result->result_array() : array();
    }

    public function get_next_all_by_type_user($type_user) {
        $this->db->select("ev.*");
        $this->db->join("evento_tipo_usuario as etu" , "etu.evento_id=ev.id");
        $this->db->where("etu.tipo_usuario_id" , $type_user);
        $this->db->where("ev.fecha >" ,  date("Y-m-d H:i:s"));
        $this->db->order_by("ev.fecha");
        $result = $this->db->get('eventos as ev');
        return ($result->num_rows() > 0 ) ? $result->result_array() : array();
    }

    public function get_by_type_user($event_id, $type_user) {
        $this->db->select("ev.*");
        $this->db->join("evento_tipo_usuario as etu" , "etu.evento_id=ev.id");
        $this->db->where("etu.tipo_usuario_id" , $type_user);
        $this->db->where("ev.id" , $event_id);
        $this->db->limit(1);
        $result = $this->db->get('eventos as ev');
        return ($result->num_rows() > 0 ) ? $result->row_array() : false;
    }
    public function get_by_user($event_id, $user_id) {
        $this->db->select("ev.*");
        
        $result = $this->db->get('eventos as ev');
        return ($result->num_rows() > 0 ) ? $result->row_array() : false;
    }
    public function get($id){
        $this->db->where('id' , $id);
        $this->db->limit(1);
        $result = $this->db->get('eventos');
        return ($result->num_rows() > 0) ? $result->row_array() : false ; 
    }

    public function insert($data) {
        return ($this->db->insert('eventos' , $data)) ? $this->db->insert_id() : false;
    }

}

?>
