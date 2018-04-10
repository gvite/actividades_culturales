<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Concursos extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->load->helper(array('url', 'sesion'));
        $this->load->model(array('concursos_model','semestres_model','participantes_model'));
        $this->load->helper('date');
        $data['semestre_actual'] = $this->semestres_model->get_actual();
        $data['active'] = 'concursos';
        $data['js'][] = 'js/concursos.js';
        $data['css'][] = 'css/concursos.css';
        if (!get_id()) {
            $data['js'][] = 'js/acceso.js';
        } else {
            if ($data['semestre_actual']) {
                $data['puede_inscribir'] = $this->semestres_model->puede_insc($data['semestre_actual']['id']);
            } else {
                $data['puede_inscribir'] = false;
            }
        }
        $this->load->view('main/header_view', $data);
        $data['concursos'] = $this->concursos_model->get_all();
        foreach($data['concursos'] as $key => $concurso){
            $data["concursos"][$key]["participantes"] = $this->participantes_model->count_by_concurso($concurso["id"]);
            $porcentaje = ($data["concursos"][$key]["participantes"] * 100) / $concurso["cupo"];
            if($porcentaje < 60){
                $data["concursos"][$key]["asistentes_label"] = "success";
            }else if($porcentaje < 90){
                $data["concursos"][$key]["asistentes_label"] = "warning";
            }else{
                $data["concursos"][$key]["asistentes_label"] = "danger";
            }
        }
        $this->load->view("main/concursos_view", $data);
        if (!get_id()) {
            $this->load->view('acceso/login_view', '');
        }
        $this->load->view('main/footer_view', '');
    }
    public function get($slug){
        $this->load->helper(array('url', 'sesion','date'));
        $this->load->model(array('concursos_model','semestres_model','participantes_model'));
        $this->load->library("CParsedown");
        $data['concurso'] = $this->concursos_model->get_by_slug($slug);
        if($data['concurso']){
            $data['semestre_actual'] = $this->semestres_model->get_actual();
            $data['active'] = 'concursos';
            $data['js'][] = 'js/concursos.js';
            if (!get_id()) {
                $data['js'][] = 'js/acceso.js';
            } else {
                if ($data['semestre_actual']) {
                    $data['puede_inscribir'] = $this->semestres_model->puede_insc($data['semestre_actual']['id']);
                } else {
                    $data['puede_inscribir'] = false;
                }
            }
            $this->load->view('main/header_view', $data);
            $parsedown = new CParsedown();
            $data["concurso"]["format_bases"] = $parsedown->text($data["concurso"]["bases"]);
            $data["concurso"]["participantes"] = $this->participantes_model->count_by_concurso($data["concurso"]["id"]);
            $porcentaje = ($data["concurso"]["participantes"] * 100) / $data["concurso"]["cupo"];
            if($porcentaje < 60){
                $data["concurso"]["asistentes_label"] = "success";
            }else if($porcentaje < 90){
                $data["concurso"]["asistentes_label"] = "warning";
            }else{
                $data["concurso"]["asistentes_label"] = "danger";
            }
            $this->load->view("main/concurso_view", $data);
            if (!get_id()) {
                $this->load->view('acceso/login_view', '');
            }
            $this->load->view('main/footer_view', '');
        }else{
            show_404();
        }
    }
    public function registro($concurso_id){
        $this->load->helper(array('url', 'sesion','date'));
        $this->load->model(array('concursos_model','semestres_model','participantes_model'));
        $data['concurso'] = $this->concursos_model->get($concurso_id);
        if($data['concurso'] && get_id()){
            $data['semestre_actual'] = $this->semestres_model->get_actual();
            $data['active'] = 'concursos';
            $data['js'][] = 'js/concursos.js';
            if ($data['semestre_actual']) {
                $data['puede_inscribir'] = $this->semestres_model->puede_insc($data['semestre_actual']['id']);
            } else {
                $data['puede_inscribir'] = false;
            }
            $this->load->view('main/header_view', $data);

            $count = $this->participantes_model->count_by_concurso($concurso_id);
            if($data['concurso']['cupo'] > $count){
                $concurso_usuario = $this->participantes_model->get_by_concurso_usuario($concurso_id, get_id());
                if($concurso_usuario){
                    $data["status"] = "OK";
                    //$data["message"] = "Ya estás registrado";
                }else{
                    $participacion = array(
                        "usuario_id" => get_id(),
                        "concurso_id" => $concurso_id
                    );
                    $id = $this->participantes_model->insert($participacion);
                    if($id){
                        $data["status"] = "OK";
                    }else{
                        $data["status"] = "MSG";
                        $data["message"] = "Ocurrió un error al guardar";        
                    }
                }
            }else{
                $data["status"] = "MSG";
                $data["message"] = "Ya no hay cupo";
            }
            $this->load->view("main/concurso_registro_view", $data);
            $this->load->view('main/footer_view', '');
        }else{
            show_404();
        }
    }

}

?>
