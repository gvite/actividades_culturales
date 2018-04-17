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
        $data['semestre_actual'] = $this->semestres_model->get_actual();
        if ($data['semestre_actual']) {
            $data['puede_inscribir'] = $this->semestres_model->puede_insc($data['semestre_actual']['id']);
        } else {
            $data['puede_inscribir'] = false;
        }
        $data['active'] = 'concursos';
        $data['js'] = 'js/actividades.js';
        $this->load->view('main/header_view', $data);
        $this->load->helper('date');
        $data['concursos'] = $this->concursos_model->get_all();
        foreach($data['concursos'] as $key => $concurso){
            $data["concursos"][$key]["participantes"] = $this->participantes_model->count_by_concurso($concurso["id"]);
        }
        $this->load->view("admin/concursos_view", $data);
        $this->load->view('main/footer_view', '');
    }

    public function get($slug) {
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
            $data["concurso"]["participantes"] = $this->participantes_model->get_users_by_concurso($data["concurso"]["id"]);
            $this->load->view("admin/concurso_view", $data);
            if (!get_id()) {
                $this->load->view('acceso/login_view', '');
            }
            $this->load->view('main/footer_view', '');
        }else{
            show_404();
        }
    }

}

?>
