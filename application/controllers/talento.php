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
        if (!get_id()) {
            $data['js'][] = 'js/acceso.js';
        }
        $this->load->model('carreras_model');
        $this->load->view('main/header_view', $data);
        $data['carreras'] = $this->carreras_model->get_all();
        $this->load->view('main/talento_view', $data);
        if (!get_id()) {
            $this->load->view('acceso/login_view', $data);
        }
        $this->load->view('main/footer_view', '');
    }
    public function insert(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules("nombre", "Nombre", "xss|required");
        $this->form_validation->set_rules("num_cta", "N&uacute;mero de Cuenta", "xss|required|exact_length[9]|callback_valida_nocta");
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
            $this->load->view('main/talento_view', $data);
            $this->load->view('main/footer_view', '');
        } else {  
            $this->load->model('talento_model');
            $data['talento']['id'] = $this->talento_model->insert($data['talento']);
            if($data['talento']['id']){
                $this->load->view('main/header_view', $data);
                $this->load->view('main/talento_show', $data);
                $this->load->view('main/footer_view', '');
            }else{
                show_404();
            }
        }
    }
    public function valida_nocta($no_cuenta){
        $this->load->model('talento_model');
        if($this->talento_model->check_cta($no_cuenta)){
            return true;
        }else{
            $this->form_validation->set_message('valida_nocta', 'El número de cuenta que proporcionaste ya existe, intenta poner uno nuevo.');
            return false;
        }
    }
    public function pdf($id){
        $this->load->helper("date");
        $this->load->model('talento_model');
        $talento = $this->talento_model->get_wdata($id);
        if($talento){
            $content = $this->load->view('alumnos/talento_view', $talento, true);
            $css = $this->load->view('alumnos/talento_css', $talento, true);
            $this->load->library('mpdf');
            $mpdf = new mPDF();
            //$header = '<img src="images/logo_pdf.jpg" style="padding-left:20px;" />';
            
            $mpdf->SetProtection(array('copy' , 'print'));
            //$mpdf->Image('images/eventos/odiseo-y-los-mesoneros-aragon-degrade.png',0,0,210,297,'png','',true, false);
            //$mpdf->SetHTMLHeader($header);
            $mpdf->WriteHTML($css, 1);
            
            $mpdf->WriteHTML($content, 2);

            //copia del alumno
            $mpdf->Image('images/logo_pdf_e.jpg',160,25,22,22,'jpg','',true, true);
            $mpdf->Image('images/logo_unam.png',30,25,22,22,'png','',true, true);
            $mpdf->SetTitle("Talento Aragones");
            $mpdf->Output("Talento_Aragones.pdf","I");
        }else{
            show_404();
        }
    }

}
