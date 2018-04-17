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
    public function get_users_by_concurso($concurso_id){
        $this->db->select('u.*,dae.no_cuenta, dae.semestre, f.facultad, c.carrera');
        $this->db->where('p.concurso_id' , $concurso_id);
        $this->db->join('usuarios as u','u.id=p.usuario_id');
        $this->db->join('datos_alumnos_ex as dae','u.id=dae.usuario_id','LEFT');
        $this->db->join('facultad as f','f.id=dae.facultad_id','LEFT');
        $this->db->join('carreras as c','c.id=dae.carrera_id','LEFT');
        $result = $this->db->get('participantes as p');
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
