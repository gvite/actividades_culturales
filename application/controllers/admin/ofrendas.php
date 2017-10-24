<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ofrendas extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }
    public function index(){
        $this->load->helper("date");
        $data['active'] = "ofrendas";
        $this->load->helper(array('sesion' , 'url'));
        $this->load->model('semestres_model');
        $this->load->model("eventos_model");
        $data['semestre_actual'] = $this->semestres_model->get_actual();
        if ($data['semestre_actual']) {
            $data['puede_inscribir'] = $this->semestres_model->puede_insc($data['semestre_actual']['id']);
        } else {
            $data['puede_inscribir'] = false;
        }
        $this->load->view('main/header_view', $data);
        $data["eventos"] = $this->eventos_model->get_by_offering();
        $this->load->view("admin/ofrendas/list",$data);
        $this->load->view('main/footer_view', '');
    }

    public function lista($evento_id){
        $this->load->helper("date");
        $data['active'] = "ofrendas";
        $this->load->helper(array('sesion' , 'url'));
        $this->load->model('semestres_model');
        $this->load->model("ofrendas_model");
        $data['semestre_actual'] = $this->semestres_model->get_actual();
        if ($data['semestre_actual']) {
            $data['puede_inscribir'] = $this->semestres_model->puede_insc($data['semestre_actual']['id']);
        } else {
            $data['puede_inscribir'] = false;
        }
        $data['js'] = 'js/ofrendas.js';
        $this->load->view('main/header_view', $data);
        $data["ofrendas"] = $this->ofrendas_model->get_by_event($evento_id);
        foreach($data["ofrendas"] as $key => $ofrenda){
            $data["ofrendas"][$key]["votos"] = $this->ofrendas_model->get_votos($ofrenda["id"]);
        }
        $data["evento_id"] = $evento_id;
        $this->load->view("admin/ofrendas/list_by_event",$data);
        $this->load->view('main/footer_view', '');
    }

    public function getone($id){
        $this->load->model('ofrendas_model');
        $ofrenda = $this->ofrendas_model->get($id);
        if($ofrenda){
            echo json_encode(array("status" => "OK","ofrenda" => $ofrenda));
        }else{
            echo json_encode(array("status" => "MSG","type" => "warning" , "message" => "No se encontró el slider"));
        }
    }

    public function insert(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules("nombre", "Título", "xss|required");
        $this->form_validation->set_rules("descripcion", "Descripción", "xss");
        $this->form_validation->set_rules("numero", "Número", "xss|required|is_natural_no_zero");
        $this->form_validation->set_rules("evento_id", "Error con Evento", "xss|requred");
        $this->form_validation->set_message("required", "Introduce %s");
        $this->form_validation->set_message("is_natural_no_zero", "%s debe ser numérico");
        if ($this->form_validation->run() === FALSE) {
            $errors = validation_errors();
            echo json_encode(array('status' => 'MSG', 'type' => 'warning', "message" => $errors));
        } else {
            $this->load->model('ofrendas_model');
            if(isset($_FILES["file"]["type"])){
                $validextensions = array("jpeg", "jpg", "png");
                $temporary = explode(".", $_FILES["file"]["name"]);
                $file_extension = end($temporary);
                if (in_array($file_extension, $validextensions)) {
                    if ($_FILES["file"]["error"] > 0){
                        echo json_encode(array("status" => "MSG","type" => "error" , "message" => "No hay imagen"));
                    }else{
                        $sourcePath = $_FILES['file']['tmp_name']; // Storing source path of the file in a variable
                        $newName = date("Y-m-d_H_s_i") . $_FILES['file']['name'];
                        $targetPath = $route = str_replace("\\", "/", FCPATH) . "uploads/ofrendas/" . $newName; // Target path where file is to be stored
                        move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
                        $data = array(
                            "nombre" => $this->input->post("nombre"),
                            "descripcion" => $this->input->post("descripcion"),
                            "numero" => $this->input->post("numero"),
                            "evento_id" => $this->input->post("evento_id"),
                            "img" => $newName
                        );
                        if($this->ofrendas_model->insert($data)){
                            echo json_encode(array("status" => "OK"));
                        }else{
                            echo json_encode(array("status" => "MSG","type" => "error" , "message" => "Error al guardar en base de datos"));
                        }
                    }
                }else{
                    echo json_encode(array("status" => "MSG","type" => "warning" , "message" => "Sólo los siguientes formatos son permitidos: png, jpg, jpeg"));
                }
            }else{
                echo json_encode(array("status" => "MSG","type" => "warning" , "message" => "No hay imagen"));
            }
        }
    }

    public function update($id){
        $this->load->library('form_validation');
        $this->form_validation->set_rules("nombre", "Título", "xss|required");
        $this->form_validation->set_rules("descripcion", "Descripción", "xss");
        $this->form_validation->set_rules("evento_id", "Error con Evento", "xss|requred");
        $this->form_validation->set_rules("numero", "Número", "xss|required|is_natural_no_zero");
        $this->form_validation->set_message("is_natural_no_zero", "%s debe ser numérico");
        $this->form_validation->set_message("required", "Introduce %s");
        if ($this->form_validation->run() === FALSE) {
            $errors = validation_errors();
            echo json_encode(array('status' => 'MSG', 'type' => 'warning', "message" => $errors));
        } else {
            $newName = false;
            $this->load->model('ofrendas_model');
            if(isset($_FILES["file"]["type"]) && $_FILES['file']['name'] != ""){
                $validextensions = array("jpeg", "jpg", "png");
                $temporary = explode(".", $_FILES["file"]["name"]);
                $file_extension = end($temporary);
                if (in_array($file_extension, $validextensions)) {
                    if ($_FILES["file"]["error"] > 0){
                        echo json_encode(array("status" => "MSG","type" => "error" , "message" => "No hay imagen", "error" => $_FILES["file"]["error"]));
                        exit;
                    }else{
                        $sourcePath = $_FILES['file']['tmp_name']; // Storing source path of the file in a variable
                        $newName = date("Y-m-d_H_s_i") . $_FILES['file']['name'];
                        $targetPath = $route = str_replace("\\", "/", FCPATH) . "uploads/ofrendas/" . $newName; // Target path where file is to be stored
                        move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
                    }
                }else{
                    echo json_encode(array("status" => "MSG","type" => "warning" , "message" => "Formato no autorizado"));
                    exit;
                }
            }
            $data = array(
                "nombre" => $this->input->post("nombre"),
                "descripcion" => $this->input->post("descripcion"),
                "numero" => $this->input->post("numero")
            );
            if($newName){
                $data["img"] = $newName;
            }
            if($this->ofrendas_model->update($id,$data)){
                echo json_encode(array("status" => "OK"));
            }else{
                echo json_encode(array("status" => "MSG","type" => "error" , "message" => "Error al guardar en base de datos"));
            }
        }
    }
    public function votos($ofrenda_id){
        $this->load->helper("date");
        $data['active'] = "ofrendas";
        $this->load->helper(array('sesion' , 'url'));
        $this->load->model('semestres_model');
        $this->load->model("ofrendas_model");
        $data['semestre_actual'] = $this->semestres_model->get_actual();
        if ($data['semestre_actual']) {
            $data['puede_inscribir'] = $this->semestres_model->puede_insc($data['semestre_actual']['id']);
        } else {
            $data['puede_inscribir'] = false;
        }
        $this->load->view('main/header_view', $data);
        $data["votos"] = $this->ofrendas_model->get_votos_with_users($ofrenda_id);
        $this->load->view("admin/ofrendas/votos",$data);
        $this->load->view('main/footer_view', '');
    }
}