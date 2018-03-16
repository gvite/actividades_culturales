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
    public function get_votos($ofrenda_id){
        $this->db->select("id");
        $this->db->where('ofrenda_id' , $ofrenda_id);
        $result = $this->db->get('votos_ofrendas');
        return $result->num_rows();
    }
    public function status_voto($evento_id,$user_id){
        $this->db->select("vo.*");
        $this->db->join("votos_ofrendas as vo" , "vo.ofrenda_id=o.id");
        $this->db->where("o.evento_id" , $evento_id);
        $this->db->where("vo.usuario_id" , $user_id);
        $this->db->limit(1);
        $result = $this->db->get('ofrendas as o');
        return ($result->num_rows() > 0) ? $result->row_array() : false;
    }
    public function votar($data){
        return ($this->db->insert('votos_ofrendas' , $data)) ? $this->db->insert_id() : false;
    }
    public function get_votos_with_users($ofrenda_id){
        $this->db->select("u.*,dae.no_cuenta,c.carrera,tu.usuario as tipo_usuario, dt.no_trabajador, dt.area,vo.fecha as fecha_voto");
        $this->db->join("usuarios as u" , "vo.usuario_id=u.id");
        $this->db->join("tipo_usuario as tu" , "tu.id=u.tipo_usuario_id");
        $this->db->join("datos_alumnos_ex as dae" , "dae.usuario_id=u.id","LEFT");
        $this->db->join("datos_trabajador as dt" , "dt.usuario_id=u.id","LEFT");
        $this->db->join("carreras as c" , "dae.carrera_id=c.id","LEFT");
        $this->db->where("vo.ofrenda_id" , $ofrenda_id);
        $result = $this->db->get('votos_ofrendas as vo');
        return ($result->num_rows() > 0) ? $result->result_array() : false;

    }
}

?>
