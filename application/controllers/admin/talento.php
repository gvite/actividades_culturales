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

}
