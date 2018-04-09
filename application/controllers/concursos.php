<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Concursos extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->load->helper(array('url', 'sesion'));
        $this->load->model(array('concursos_model','semestres_model'));
        $this->load->helper('date');
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
        $data['concursos'] = $this->concursos_model->get_all();
        $this->load->view("alumnos/concursos_view", $data);
        if (!get_id()) {
            $this->load->view('acceso/login_view', '');
        }
        $this->load->view('main/footer_view', '');
    }
    public function get($slug){
        $this->load->helper(array('url', 'sesion'));
        $this->load->model(array('concursos_model','semestres_model'));
        $this->load->helper('date');
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
            
            $this->load->view("alumnos/concurso_view", $data);
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
