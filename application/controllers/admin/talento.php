<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Talento extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->load->helper("date");
        $data['active'] = "talento";
        $this->load->helper(array('sesion' , 'url'));
        $this->load->model('semestres_model');
        $data['semestre_actual'] = $this->semestres_model->get_actual();
        if ($data['semestre_actual']) {
            $data['puede_inscribir'] = $this->semestres_model->puede_insc($data['semestre_actual']['id']);
        } else {
            $data['puede_inscribir'] = false;
        }
        $this->load->view('main/header_view', $data);
        $this->load->model('talento_model');
        $data["alumnos"] = $this->talento_model->get_all_wdata();
        $this->load->view('admin/talento_view', $data);
        $this->load->view('main/footer_view', '');
    }

    public function edit($id){
        $this->load->helper("date");
        $data['active'] = "talento";
        $this->load->helper(array('sesion' , 'url'));
        $this->load->model('semestres_model');
        $this->load->model('talento_model');
        $data["talento"] = $this->talento_model->get($id);
        $data['semestre_actual'] = $this->semestres_model->get_actual();
        if ($data['semestre_actual']) {
            $data['puede_inscribir'] = $this->semestres_model->puede_insc($data['semestre_actual']['id']);
        } else {
            $data['puede_inscribir'] = false;
        }
        if (!get_id()) {
            $data['js'][] = 'js/acceso.js';
        }
        $this->load->model('carreras_model');
        $this->load->view('main/header_view', $data);
        $data['carreras'] = $this->carreras_model->get_all();
        $this->load->view('admin/talento_edit_view', $data);
        if (!get_id()) {
            $this->load->view('acceso/login_view', $data);
        }
        $this->load->view('main/footer_view', '');
    }

    public function update($id){
        $this->load->library('form_validation');
        $this->form_validation->set_rules("nombre", "Nombre", "xss|required");
        $this->form_validation->set_rules("num_cta", "N&uacute;mero de Cuenta", "xss|required|exact_length[9]");
        $this->form_validation->set_rules("carrera", "Carrera", "xss|required");
        $this->form_validation->set_rules("semestre", "Semestre", "xss|required");
        $this->form_validation->set_rules("banda", "Banda", "xss|required");
        $this->form_validation->set_rules("integrantes", "Integrantes", "xss|required|integer");
        $this->form_validation->set_message("required", "Introduce %s");
        $this->form_validation->set_message("integer", "%s debe ser un número");
        $this->form_validation->set_message("exact_length", "El %s debe de ser de 9 digitos");

        $this->load->helper("date");
        $data['active'] = "talento";
        $this->load->helper(array('sesion' , 'url'));
        $this->load->model('semestres_model');
        $data['semestre_actual'] = $this->semestres_model->get_actual();
        if ($data['semestre_actual']) {
            $data['puede_inscribir'] = $this->semestres_model->puede_insc($data['semestre_actual']['id']);
        } else {
            $data['puede_inscribir'] = false;
        }
        $data['talento'] = array(
            'nombre' => $this->input->post('nombre'),
            'no_cta' => $this->input->post('num_cta'),
            'carrera_id' => $this->input->post('carrera'),
            'semestre' => $this->input->post('semestre'),
            'banda' => $this->input->post('banda'),
            'no_integrantes' => $this->input->post('integrantes'),
            'fecha' => date('Y-m-d H:i:s')
        );
        if ($this->form_validation->run() === FALSE) {
            $data['errors'] = validation_errors();
            $this->load->model('carreras_model');
            $this->load->view('main/header_view', $data);
            $data['carreras'] = $this->carreras_model->get_all();
            $this->load->view('admin/talento_edit_view', $data);
            $this->load->view('main/footer_view', '');
        } else {  
            $this->load->model('talento_model');
            if($this->talento_model->update($id, $data['talento'])){
                $data['talento']['id'] = $id;
                $this->load->view('main/header_view', $data);
                $this->load->view('main/talento_show', $data);
                $this->load->view('main/footer_view', '');
            }else{
                show_404();
            }
        }
    }

}
