<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Asistentes_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all() {
        $result = $this->db->get('asistentes');
        return ($result->num_rows() > 0 ) ? $result->result_array() : array();
    }

    public function count($event_id) {
        $this->db->select("id");
        $this->db->where("evento_id" , $event_id);
        $result = $this->db->get("asistentes");
        return $result->num_rows();
    }
    
    public function get_by_user($event_id, $user_id) {
        $this->db->select("id");
        $this->db->where("evento_id" , $event_id);
        $this->db->where("usuario_id" , $user_id);
        $result = $this->db->get("asistentes");
        return ($result->num_rows() > 0) ? $result->row_array() : false;
    }
    public function get($id){
        $this->db->where('id' , $id);
        $this->db->limit(1);
        $result = $this->db->get('asistentes');
        return ($result->num_rows() > 0) ? $result->row_array() : false ; 
    }

    public function insert($data) {
        return ($this->db->insert('asistentes' , $data)) ? $this->db->insert_id() : false;
    }

    public function update($id , $data){
        $this->db->where('id' , $id);
        return ($this->db->update('asistentes' , $data)) ? true : false;
    }
    
    public function get_data_by_user($event_id, $user_id){
        $this->db->select("ev.*,a.folio,a.id as asistente_id,u.nombre as usuario_nombre,u.paterno as usuario_paterno,u.materno as usuario_materno, s.nombre as sala, l.nombre as lugar");
        $this->db->join("eventos as ev", "a.evento_id=ev.id");
        $this->db->join("usuarios as u" , "u.id=a.usuario_id");
        $this->db->join("salas as s" , "s.id=ev.sala_id");
        $this->db->join("lugares as l" , "l.id=s.lugar_id");
        $this->db->where("a.usuario_id" , $user_id);
        $this->db->where("ev.id" , $event_id);
        $this->db->limit(1);
        $result = $this->db->get("asistentes as a");
        return ($result->num_rows() > 0) ? $result->row_array() : false;
    }

    public function get_by_event($event_id){
        $this->db->select("ev.*,a.folio,a.id as asistente_id,a.asistencia,u.nombre as usuario_nombre,u.paterno as usuario_paterno,u.materno as usuario_materno, s.nombre as sala, l.nombre as lugar");
        $this->db->join("eventos as ev", "a.evento_id=ev.id");
        $this->db->join("usuarios as u" , "u.id=a.usuario_id");
        $this->db->join("salas as s" , "s.id=ev.sala_id");
        $this->db->join("lugares as l" , "l.id=s.lugar_id");
        $this->db->where("ev.id" , $event_id);
        $result = $this->db->get("asistentes as a");
        return ($result->num_rows() > 0) ? $result->result_array() : array();
    }

    public function get_by_event_asis($event_id){
        $this->db->select("ev.*,a.folio,a.id as asistente_id,u.nombre as usuario_nombre,u.paterno as usuario_paterno,u.materno as usuario_materno, s.nombre as sala, l.nombre as lugar");
        $this->db->join("eventos as ev", "a.evento_id=ev.id");
        $this->db->join("usuarios as u" , "u.id=a.usuario_id");
        $this->db->join("salas as s" , "s.id=ev.sala_id");
        $this->db->join("lugares as l" , "l.id=s.lugar_id");
        $this->db->where("ev.id" , $event_id);
        $this->db->where("a.asistencia" , 1);
        $result = $this->db->get("asistentes as a");
        return ($result->num_rows() > 0) ? $result->result_array() : array();
    }

    public function get_last_query() {
        $last_query = '';
        if (isset($this->db->queries)) {
            foreach ($this->db->queries AS $query) {
                $last_query .= "\n\n" . $query;
            }
        }
        return $last_query;
    }

}

?>
