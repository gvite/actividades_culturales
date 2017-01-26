<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Procesa extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('semestres_model');
    }

    public function index() {
        $this->load->helper(array('url', 'sesion', 'date'));
        $data['active'] = '';
        $data['semestres'] = $this->semestres_model->get_all();
        $data['semestre_actual'] = $this->semestres_model->get_actual();
        if ($data['semestre_actual']) {
            $data['puede_inscribir'] = $this->semestres_model->puede_insc($data['semestre_actual']['id']);
        } else {
            $data['puede_inscribir'] = false;
        }
        
        $this->load->model("baucher_model");
        $this->load->model("baucher_talleres_model");
        $data['bauchers'] = $this->baucher_model->get_all();

        foreach($data['bauchers'] as $key => $baucher){
            $baucher_talleres = $this->baucher_talleres_model->get_by_baucher_id($baucher['id']);
            $data['bauchers'][$key]['count_talleres'] = count($baucher_talleres);
        }

        $this->load->view('main/header_view', $data);
        $this->load->view('admin/procesa_view', $data);
        $this->load->view('main/footer_view', '');
    }

}

?>
