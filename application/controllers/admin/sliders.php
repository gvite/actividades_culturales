<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sliders extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->load->helper(array('url', 'sesion'));
        $this->load->model('semestres_model');
        $data['semestre_actual'] = $this->semestres_model->get_actual();
        if ($data['semestre_actual']) {
            $data['puede_inscribir'] = $this->semestres_model->puede_insc($data['semestre_actual']['id']);
        } else {
            $data['puede_inscribir'] = false;
        }
        $this->load->model('sliders_model');
        $data['active'] = 'sliders';
        $data['js'] = 'js/sliders.js';
        $data['sliders'] = $this->sliders_model->get_all();
        $this->load->view('main/header_view', $data);
        $this->load->view("admin/sliders_view", $data);
        $this->load->view('main/footer_view', '');
    }

    public function insert(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules("titulo", "Título", "xss|required");
        $this->form_validation->set_rules("orden", "Orden", "xss|required");
        $this->form_validation->set_message("required", "Introduce %s");
        if ($this->form_validation->run() === FALSE) {
            $errors = validation_errors();
            echo json_encode(array('status' => 'MSG', 'type' => 'warning', "message" => $errors));
        } else {
            $this->load->model('sliders_model');
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
                        $targetPath = $route = str_replace("\\", "/", FCPATH) . "uploads/sliders/" . $newName; // Target path where file is to be stored
                        move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
                        $data = array(
                            "titulo" => $this->input->post("titulo"),
                            "orden" => $this->input->post("orden"),
                            "img" => $newName,
                            "status" => ($this->input->post("visible")) ? 1:0,
                            "alt" => $this->input->post("titulo"),
                            "link" => $this->input->post("link")
                        );
                        if($this->sliders_model->insert($data)){
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

    public function getone($id){
        $this->load->model('sliders_model');
        $slider = $this->sliders_model->get($id);
        if($slider){
            echo json_encode(array("status" => "OK","slider" => $slider));
        }else{
            echo json_encode(array("status" => "MSG","type" => "warning" , "message" => "No se encontró el slider"));
        }
    }

    public function update(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules("id", "Hay un error, recarga la pagina", "xss|required");
        $this->form_validation->set_rules("titulo", "Título", "xss|required");
        $this->form_validation->set_rules("orden", "Orden", "xss|required");
        $this->form_validation->set_message("required", "Introduce %s");
        if ($this->form_validation->run() === FALSE) {
            $errors = validation_errors();
            echo json_encode(array('status' => 'MSG', 'type' => 'warning', "message" => $errors));
        } else {
            $newName = false;
            $this->load->model('sliders_model');
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
                        $targetPath = $route = str_replace("\\", "/", FCPATH) . "uploads/sliders/" . $newName; // Target path where file is to be stored
                        move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
                    }
                }else{
                    echo json_encode(array("status" => "MSG","type" => "warning" , "message" => "Formato no autorizado"));
                    exit;
                }
            }
            $data = array(
                "titulo" => $this->input->post("titulo"),
                "orden" => $this->input->post("orden"),
                "status" => ($this->input->post("visible")) ? 1:0,
                "alt" => $this->input->post("titulo"),
                "link" => $this->input->post("link")
            );
            if($newName){
                $data["img"] = $newName;
            }
            if($this->sliders_model->update($this->input->post("id"),$data)){
                echo json_encode(array("status" => "OK"));
            }else{
                echo json_encode(array("status" => "MSG","type" => "error" , "message" => "Error al guardar en base de datos"));
            }
        }
    }

}

?>
