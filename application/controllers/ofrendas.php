<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ofrendas extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }
    public function index($evento_id){
        
        echo $evento_id;
    }
    public function casilla($evento_id){
        $this->load->helper("date");
        $this->load->helper(array('sesion' , 'url'));
        $this->load->model('semestres_model');
        $data["active"] = "";
        $data["hide_menu"] = true;
        $data['semestre_actual'] = $this->semestres_model->get_actual();
        if ($data['semestre_actual']) {
            $data['puede_inscribir'] = $this->semestres_model->puede_insc($data['semestre_actual']['id']);
        } else {
            $data['puede_inscribir'] = false;
        }
        $this->load->model("ofrendas_model");
        $data["js"] = "js/ofrendas_votos.js";
        if(get_id()){
            $data["voto"] = $this->ofrendas_model->status_voto($evento_id,get_id());
        }else{
            $data["voto"] = false;
        }
        
        $this->load->view('main/header_view', $data);
        $data["ofrendas"] = $this->ofrendas_model->get_by_event($evento_id);
        foreach($data["ofrendas"] as $key => $ofrenda){
            $data["ofrendas"][$key]["votos"] = $this->ofrendas_model->get_votos($ofrenda["id"]);
        }
        //shuffle($data["ofrendas"]);
        $this->load->view('main/ofrendas_view', $data);
        $this->load->view('modals/ofrenda_img');
        if(!get_type_user()){
            $this->load->view('acceso/login_view', $data);
        }
        $this->load->view('main/footer_view', '');
    }
    public function vota(){
        $this->load->model("ofrendas_model");
        $this->load->model("eventos_model");
        $id = $this->input->post("ofrenda_id");
        $ofrenda = $this->ofrendas_model->get($id);
        if($ofrenda){
            $evento = $this->eventos_model->get_by_type_user($ofrenda["evento_id"],get_type_user());
            if($evento){
                $statusVoto = $this->ofrendas_model->status_voto($ofrenda["evento_id"],get_id());
                if($statusVoto){
                    echo json_encode(array("status" => "MSG" , "type"=>"warning","message" => "Ya se registró tu voto. Gracias por participar"));
                }else{
                    if($this->ofrendas_model->votar(array("ofrenda_id" => $ofrenda["id"],"usuario_id" => get_id(),"fecha" => date("Y-m-d H:i:s")))){
                        echo json_encode(array("status" => "MSG" , "type"=>"success","message" => "Tu voto ha sido registrado"));
                    }else{  
                        echo json_encode(array("status" => "MSG" , "type"=>"error","message" => "No se puede votar"));        
                    }
                }
            }else{
                echo json_encode(array("status" => "MSG" , "type"=>"error","message" => "No puedes participar es este evento"));    
            }
        }else{
            echo json_encode(array("status" => "MSG" , "type"=>"error","message" => "No existe la ofrenda"));
        }
    }
}