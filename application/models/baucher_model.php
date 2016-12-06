<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Baucher_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('sesion');
    }

    public function get_by_taller_status($taller_semestre_id, $status , $status2 = '') {
        $this->db->select('b.*');
        $this->db->where('b.taller_semestre_id', $taller_semestre_id);
        $this->db->where('status', $status);
        if($status2 !== ''){
            $this->db->or_where('status', $status2);
        }
        $result = $this->db->get('baucher as b');
        return ($result->num_rows() > 0) ? $result->result_array() : false;
    }

    public function get_by_status_user($status) {
        $this->db->where('status', $status);
        $this->db->where('usuario_id', get_id());
        $result = $this->db->get('baucher');
        return ($result->num_rows() > 0) ? $result->result_array() : FALSE;
    }

    public function get_by_taller_user_insc($taller_semestre_id) {
        $this->db->select('b.*');
        $this->db->where('b.taller_semestre_id', $taller_semestre_id);
        $this->db->where('b.usuario_id', get_id());
        $result = $this->db->get('baucher as b');
        return ($result->num_rows() > 0) ? $result->row_array() : false;
    }

    public function get_status_by_user($taller_semestre_id, $user_id = '') {
        $this->db->select('b.status');
        $this->db->where('b.taller_semestre_id', $taller_semestre_id);
        if ($user_id === '') {
            $this->db->where('b.usuario_id', get_id());
        } else {
            $this->db->where('b.usuario_id', $user_id);
        }
        $this->db->limit(1);
        $result = $this->db->get('baucher as b');
        return ($result->num_rows() > 0) ? $result->row_array() : false;
    }

    public function count_inscripcion_by_taller($taller_semestre_id) {
        $this->db->select('b.status');
        $this->db->where('b.taller_semestre_id', $taller_semestre_id);
        $this->db->where('b.usuario_id', get_id());
        $this->db->limit(1);
        $result = $this->db->get('baucher as b');
        return ($result->num_rows() > 0) ? $result->row_array() : false;
    }

    public function update_status($id, $status) {
        $data = array(
            'status' => $status
        );
        $this->db->where('id', $id);
        return ($this->db->update('baucher', $data)) ? true : false;
    }

    public function update($id , $data){
        $this->db->where('id' , $id);
        return ($this->db->update('baucher' , $data)) ? true : false;
    }
    
    public function check_folio_free($folio) {
        $this->db->select('id');
        $this->db->where('folio', $folio);
        $this->db->limit(1);
        $result = $this->db->get('baucher');
        return ($result->num_rows() == 0) ? true : false;
    }

    public function insert($data) {
        return ($this->db->insert('baucher', $data)) ? $this->db->insert_id() : false;
    }
    
    public function delete($id) {
        return ($this->db->delete('baucher', array("id"=>$id))) ? true : false;
    }

    public function get($id) {
        $this->db->where('id', $id);
        $this->db->limit(1);
        $result = $this->db->get('baucher');
        return ($result->num_rows() > 0) ? $result->row_array() : false;
    }
    public function get_with_all($id) {
        $this->db->select('b.*,ts.id as ts_id, ts.grupo,t.taller,t.costo_alumno,t.costo_exalumno,t.costo_trabajador,t.costo_externo,p.nombre,p.paterno,p.materno,s.salon');
        $this->db->join('taller_semestre as ts', 'b.taller_semestre_id=ts.id');
        $this->db->join('talleres as t', 't.id=ts.taller_id');
        $this->db->join('profesores as p', 'p.id=ts.profesor_id');
        $this->db->join('salones as s', 's.id=ts.salon_id');
        $this->db->where('b.id', $id);
        $this->db->limit(1);
        $result = $this->db->get('baucher as b');
        return ($result->num_rows() > 0) ? $result->row_array() : FALSE;
    }
    public function get_by_folio($folio) {
        //$this->db->select('b.* , u.tipo_usuario_id as tipo');
        $this->db->select('b.*,u.tipo_usuario_id as tipo,ts.id as ts_id, ts.grupo,t.taller,t.costo_alumno,t.costo_exalumno,t.costo_trabajador,t.costo_externo,p.nombre,p.paterno,p.materno,s.salon');
        $this->db->join('taller_semestre as ts', 'b.taller_semestre_id=ts.id');
        $this->db->join('talleres as t', 't.id=ts.taller_id');
        $this->db->join('profesores as p', 'p.id=ts.profesor_id');
        $this->db->join('salones as s', 's.id=ts.salon_id');
        $this->db->join('usuarios as u', 'u.id=b.usuario_id');
        $this->db->where('b.folio', $folio);
        $this->db->limit(1);
        $result = $this->db->get('baucher as b');
        return ($result->num_rows() > 0) ? $result->row_array() : false;
    }

    function get_by_user_semestre($semestre_id, $user_id = '') {
        //$this->db->select('b.*,t.taller');
        $this->db->select('b.*');
        $this->db->join('taller_semestre as ts', 'ts.id=b.taller_semestre_id');
        $this->db->where('ts.semestre_id', $semestre_id);
        if ($user_id === '') {
            $this->db->where('b.usuario_id', get_id());
        } else {
            $this->db->where('b.usuario_id', $user_id);
        }
        $this->db->group_by('b.id');
        $result = $this->db->get('baucher as b');
        return ($result->num_rows() > 0) ? $result->result_array() : false;
    }

    function get_by_user_with_taller($user_id = '') {
        //$this->db->select('b.*,t.taller');
        $this->db->select('b.* , t.taller');
        $this->db->join('taller_semestre as ts', 'ts.id=b.taller_semestre_id');
        $this->db->join('talleres as t', 'ts.taller_id=t.id');
        if ($user_id === '') {
            $this->db->where('b.usuario_id', get_id());
        } else {
            $this->db->where('b.usuario_id', $user_id);
        }
        $result = $this->db->get('baucher as b');
        return ($result->num_rows() > 0) ? $result->result_array() : false;
    }
    
    function get_by_user_semestre_fake($semestre_id) {
        //$this->db->select('b.*,t.taller');
        $this->db->select('b.*,ts.id as ts_id, ts.grupo,t.taller,t.costo_alumno,t.costo_exalumno,t.costo_trabajador,t.costo_externo,p.nombre,p.paterno,p.materno,s.salon');
        $this->db->join('taller_semestre as ts', 'b.taller_semestre_id=ts.id');
        $this->db->join('talleres as t', 't.id=ts.taller_id');
        $this->db->join('profesores as p', 'p.id=ts.profesor_id');
        $this->db->join('salones as s', 's.id=ts.salon_id');
        $this->db->where('ts.semestre_id', $semestre_id);
        $this->db->where('s.ini_insc >= b.fecha_expedicion');
        $this->db->where('s.ini_sem <= b.fecha_expedicion');
        $this->db->group_by('b.id');
        $result = $this->db->get('baucher as b');
        return ($result->num_rows() > 0) ? $result->result_array() : false;
    }
    
    function get_user_by_baucher($baucher_id){
        $this->db->select('u.*');
        $this->db->join('usuarios as u' , 'b.usuario_id = u.id');
        $this->db->limit(1);
        $this->db->where('b.id' , $baucher_id);
        $result = $this->db->get('baucher as b');
        return ($result->num_rows() > 0) ? $result->row_array() : false;
    }
    function get_all($select = "*"){
        $this->db->select('');
        $result = $this->db->get('baucher as b');
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
    public function check_punish($taller_semestre_id) {
        $this->load->helper('sesion');
        $this->db->select('b.id');
        $this->db->where('b.taller_semestre_id', $taller_semestre_id);
        $this->db->where('b.usuario_id', get_id());
        $this->db->limit(1);
        $result = $this->db->get('baucher as b');
        return ($result->num_rows() === 0) ? true : false;
    }

    public function count_insc($id) {
        $result = $this->db->query('SELECT u.id FROM usuarios AS u INNER JOIN baucher AS b ON b.usuario_id = u.id WHERE b.taller_semestre_id = ' . $id . ' AND (b.`status` = 0 OR b.`status` = 1) GROUP BY b.id');
        return $result->num_rows();
    }
    
    public function count_insc_validados($id) {
        $result = $this->db->query('SELECT u.id FROM usuarios AS u INNER JOIN baucher AS b ON b.usuario_id = u.id WHERE b.taller_semestre_id = ' . $id . ' AND b.`status` = 1 GROUP BY b.id');
        return $result->num_rows();
    }

    public function count_trabajadores_insc($id) {
        $result = $this->db->query('SELECT u.id FROM usuarios AS u INNER JOIN baucher AS b ON b.usuario_id = u.id WHERE b.taller_semestre_id = ' . $id . ' AND (b.`status` = 0 OR b.`status` = 1) AND u.tipo_usuario_id=4 GROUP BY b.id');
        return $result->num_rows();
    }

    public function count_taller_insc($id, $semestre_id , $user_id = '') {
        $this->load->helper('sesion');
        $this->db->select('u.id');
        $this->db->join('baucher AS b', 'b.usuario_id = u.id');
        $this->db->join('taller_semestre as ts', 'ts.id = b.taller_semestre_id');
        $this->db->where('ts.taller_id', $id);
        $this->db->where('b.status !=', 3);
        $this->db->where('ts.semestre_id', $semestre_id);
        if($user_id === ''){
            $this->db->where('u.id' , get_id());
        }else{
            $this->db->where('u.id' , $user_id);
        }
        $result = $this->db->get('usuarios AS u');
        return $result->num_rows();
    }
    function count_validadas_by_usuario($usuario_id) {
        $this->db->select('b.id');
        $this->db->where('b.status', 1);
        $this->db->where('b.usuario_id', $usuario_id);
        $result = $this->db->get('baucher as b');
        return $result->num_rows();
    }
    function get_by_baucher_taller($baucher_id , $taller_id){
        $this->db->where('id' , $baucher_id);
        $this->db->where('taller_semestre_id' , $taller_id);
        $this->db->limit(1);
        $result = $this->db->get('baucher');
        return ($result->num_rows() > 0) ? $result->row_array() : false;
    }
    function count_no_validadas_by_usuario($usuario_id) {
        $this->db->select('b.id');
        $this->db->where('(b.status=3 OR b.status=2 OR b.status=0)');
        $this->db->where('b.usuario_id', $usuario_id);
        $result = $this->db->get('baucher as b');
        return $result->num_rows();
    }
    function update_by_baucher_taller($baucher_id , $taller_ant , $taller_new){
        $this->db->where('id' , $baucher_id);
        $this->db->where('taller_semestre_id' , $taller_ant);
        return ($this->db->update('baucher', array('taller_semestre_id' => $taller_new))) ? true : false;
    }

    function get_by_semestre($semestre_id){
        $this->db->select('b.id,u.tipo_usuario_id,t.costo_alumno,t.costo_exalumno,t.costo_trabajador,t.costo_externo');
        $this->db->join('usuarios AS u', 'b.usuario_id = u.id');
        $this->db->join('taller_semestre AS ts', 'b.taller_semestre_id = ts.id');
        $this->db->join('talleres AS t', 'ts.taller_id = t.id');
        $this->db->where('ts.semestre_id' , $semestre_id);
        $result = $this->db->get('baucher AS b');
        return ($result->num_rows() > 0) ? $result->result_array() : false;
    }
    public function get_by_taller($id) {
        $result = $this->db->query('SELECT u.nombre, u.paterno, u.materno , b.folio , b.status FROM usuarios AS u INNER JOIN baucher AS b ON b.usuario_id = u.id WHERE b.taller_semestre_id = ' . $id . ' AND (b.`status` = 0 OR b.`status` = 1) GROUP BY b.id ORDER BY u.paterno ASC');
        return ($result->num_rows() > 0) ? $result->result_array() : false;
    }

    public function get_by_taller_insc($id) {
        $result = $this->db->query('SELECT u.nombre, u.paterno, u.materno , b.folio , b.status FROM usuarios AS u INNER JOIN baucher AS b ON b.usuario_id = u.id WHERE b.taller_semestre_id = ' . $id . ' AND (b.`status` = 1) GROUP BY b.id ORDER BY u.paterno ASC');
        return ($result->num_rows() > 0) ? $result->result_array() : false;
    }
}

?>
