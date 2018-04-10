<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Confirmar extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->load->helper(array('url', 'sesion', 'date'));
        if (get_id()) {
            $data['no_menu'] = true;
            $data['active'] = "";
            $data['hide_menu'] = true;
            $data['js'][] = 'js/confirmar.js';
            $this->load->model("usuarios_model");
            $this->load->view('main/header_view', $data);
            $data["return_url"] = $this->input->get("return_url");
            $data["usuario"] = $this->usuarios_model->get(get_id());
            $this->load->view("alumnos/confirmar_view", $data);
            $this->load->view('main/footer_view', '');
        }else{
            show_404();
        }
    }

    public function update(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules("direccion", "Domicilio", "xss|required");
        $this->form_validation->set_rules("celular", "Teléfono Celular", "xss|required");
        $this->form_validation->set_rules("telefono_fijo", "Teléfono Fijo", "xss");
        $this->form_validation->set_rules("clinica", "Clínica", "xss|required");
        $this->form_validation->set_rules("num_clinica", "Número de clínica", "xss|required");
        $this->form_validation->set_message("required", "Introduce %s");
        $this->form_validation->set_message("valid_email", "Introduce un correo v&aacute;lido");
        $this->form_validation->set_message("is_natural_no_zero", "Introduce un %s v&aacute;lido");
        if ($this->form_validation->run() === FALSE) {
            $errors = validation_errors();
            echo json_encode(array('status' => 'MSG', 'type' => 'warning', "message" => $errors));
        } else {
            $data = array(
                'telefono_fijo' => $this->input->post('telefono_fijo'),
                'celular' => $this->input->post('celular'),
                'clinica' => $this->input->post("clinica"),
                'num_clinica' => $this->input->post("num_clinica"),
                'direccion' => $this->input->post("direccion")
            );
            $this->load->model('usuarios_model');
            $return_url = $this->input->post("return_url");
            if($this->usuarios_model->update(get_id(), $data)){
                echo json_encode(array("status" => "OK", "return_url" => $return_url));
            }else{
                echo json_encode(array("status" => "MSG" , "type" => "error", "message" => "Error al actualizar"));
            }
        }
    }

}

?>
