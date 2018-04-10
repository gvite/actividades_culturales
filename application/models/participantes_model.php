<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Participantes_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all() {
        $result = $this->db->get('participantes');
        return ($result->num_rows() > 0 ) ? $result->result_array() : array();
    }
    
    public function get($id){
        $this->db->where('id' , $id);
        $this->db->limit(1);
        $result = $this->db->get('participantes');
        return ($result->num_rows() > 0) ? $result->row_array() : false ;
    }
    public function get_by_concurso($concurso_id){
        $this->db->where('concurso_id' , $concurso_id);
        $result = $this->db->get('participantes');
        return ($result->num_rows() > 0) ? $result->result_array() : array() ;
    }
    public function insert($data){
        return ($this->db->insert('participantes' , $data)) ? $this->db->insert_id() : false;
    }
    public function get_by_concurso_usuario($concurso_id, $usuario_id){
        $this->db->where('concurso_id' , $concurso_id);
        $this->db->where('usuario_id' , $usuario_id);
        $this->db->limit(1);
        $result = $this->db->get('participantes');
        return ($result->num_rows() > 0) ? $result->row_array() : false ;
    }

    public function count_by_concurso($concurso_id){
        $this->db->select("id");
        $this->db->where('concurso_id' , $concurso_id);
        $result = $this->db->get('participantes');
        return $result->num_rows();
    }

}

?>
