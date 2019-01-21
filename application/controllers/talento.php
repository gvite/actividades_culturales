<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Talento extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index(){
        $this->load->helper("date");
        $data['hide_menu'] = true;
        $data['active'] = true;
        $this->load->helper(array('sesion' , 'url'));
        $this->load->model('semestres_model');
        $data['semestre_actual'] = $this->semestres_model->get_actual();
        if ($data['semestre_actual']) {
            $data['puede_inscribir'] = $this->semestres_model->puede_insc($data['semestre_actual']['id']);
        } else {
            $data['puede_inscribir'] = false;
        }
        
        $data['js'][] = 'js/talento_aragones.js';
        $this->load->model('carreras_model');
        $this->load->view('main/header_view', $data);
        $data['carreras'] = $this->carreras_model->get_all();
        $this->load->view('main/talento_aragones_view', $data);
        $this->load->view('main/footer_view', '');
    }

    public function registro($event_id) {
        $this->load->helper("date");
        $data['hide_menu'] = true;
        $data['active'] = true;
        $data["evento_id"] = $event_id;
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
            $data['js'][] = 'js/registro_modal_alumnos.js';
        }else{
            $data['js'][] = 'js/talento.js';
        }
        $this->load->model('carreras_model');
        $this->load->view('main/header_view', $data);
        $data['carreras'] = $this->carreras_model->get_all();
        if (!get_id()) {
            $this->load->model('carreras_model');
            $data['carreras'] = $this->carreras_model->get_all();
            $this->load->view('main/talento_login_view', $data);
            $this->load->view('acceso/login_view', $data);
            $this->load->view('modals/registro_alumnos');
        }else{
            $this->load->model("banda_model");
            $this->load->model("integrantes_banda_model");
            $this->load->model("canciones_banda_model");
            $data["banda"] = $this->banda_model->get_by_user(get_id());
            if($data["banda"]){
                $data["banda"]["integrantes"] = $this->integrantes_banda_model->get_by_band($data["banda"]["id"]);
                $data["banda"]["canciones"] = $this->canciones_banda_model->get_by_band($data["banda"]["id"]);
            }
            $this->load->view('main/talento_view', $data);
        }
        $this->load->view('main/footer_view', '');
    }
    public function insert(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules("banda", "Nombre de la Banda", "xss|required");
        $this->form_validation->set_rules("genero", "Genero de la Banda", "xss|required");
        $this->form_validation->set_rules("descripcion", "Descripción de la Banda", "xss|required");
        //$this->form_validation->set_rules("integrantes[0][nombre]", "Nombre de integrante", "xss|required");
        //$this->form_validation->set_rules("integrantes[0][edad]", "Edad de integrante", "xss|required|integer");
        //$this->form_validation->set_rules("integrantes[0][instrumento]", "Instrumento de integrante", "xss|required");

        $this->form_validation->set_message("required", "Introduce %s");
        $this->form_validation->set_message("integer", "%s debe ser un número");
        $this->form_validation->set_message("email", "Ingresa un email válido");
        $this->form_validation->set_message("exact_length", "El %s debe de ser de 9 digitos");
        if ($this->form_validation->run() === FALSE) {
            echo json_encode(array("status" => "MSG" , "type"=>"warning" , "message" => validation_errors()));
        } else {  
            $this->load->model('banda_model');
            $this->load->model('integrantes_banda_model');
            $this->load->model('canciones_banda_model');
            $this->load->model('evento_banda_model');
            $this->load->model('talento_canciones_model');
            $evento_id = $this->input->post("evento_id");
            $banda = array(
                "nombre" => $this->input->post("banda"),
                "genero" => $this->input->post("genero"),
                "descripcion" => $this->input->post("descripcion"),
                "encargado_id" => get_id()
            ); 
            $banda_id = $this->input->post("banda_id");
            if($banda_id){
                if($this->banda_model->update($banda_id, $banda)){
                    $banda["id"] = $banda_id;
                }
            }else{
                $banda['id'] = $this->banda_model->insert($banda);
            }
            if($banda['id']){
                $eb = $this->evento_banda_model->get_by_evento_banda($evento_id,$banda["id"]);
                if($eb === false){
                    $eb = array("evento_id" => $evento_id,"banda_id" => $banda["id"]);
                    $eb["id"] = $this->evento_banda_model->insert($eb);
                }
                $integrantes = $this->input->post("integrantes");
                if($banda_id){
                    $this->talento_canciones_model->delete_by_band($banda["id"]);
                    $this->integrantes_banda_model->delete_by_band($banda["id"]);
                    $this->canciones_banda_model->delete_by_band($banda["id"]);
                }
                foreach($integrantes as $integrante){
                    $integrante["banda_id"] = $banda["id"];
                    $this->integrantes_banda_model->insert($integrante);
                }
                $canciones = $this->input->post("canciones");
                foreach($canciones as $cancion){
                    $cancion["banda_id"] = $banda["id"];
                    $cancion["id"] = $this->canciones_banda_model->insert($cancion);
                    $tc = array(
                        'evento_banda_id' => $eb["id"],
                        'cancion_banda_id' => $cancion["id"]
                    );
                    $this->talento_canciones_model->insert($tc);
                }
                echo json_encode(array("status" => "OK" , "evento_id" => $evento_id , "banda_id" => $banda["id"]));
            }else{
                echo json_encode(array("status" => "MSG" , "type"=>"warning" , "message" =>"No se guardo Correctamente"));
            }
        }
    }
    public function pdf($evento_id , $banda_id){
        $this->load->helper("date");
        $this->load->model('banda_model');
        $this->load->model('integrantes_banda_model');
        $this->load->model('canciones_banda_model');
        $this->load->model('evento_banda_model');
        $this->load->model('talento_canciones_model');
        $this->load->model('usuarios_model');
        $this->load->model('datos_alumnos_ex_model');
        $eb = $this->evento_banda_model->get_by_evento_banda($evento_id,$banda_id);
        if($eb){
            $data["banda"] = $this->banda_model->get_by_id($banda_id);
            $data["banda"]["integrantes"] = $this->integrantes_banda_model->get_by_band($banda_id);
            $data["banda"]["canciones"] = $this->canciones_banda_model->get_by_band($banda_id);
            $data["alumno"] = $this->usuarios_model->get($data["banda"]["encargado_id"]);
            $data["alumno"]["datos"] = $this->datos_alumnos_ex_model->get_all_by_user($data["banda"]["encargado_id"]);

            $content = $this->load->view('alumnos/talento_view', $data, true);
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

    public function imprimir(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules("nombre", "Nombre de la Banda", "xss|required");
        
        //$this->form_validation->set_rules("integrantes[0][nombre]", "Nombre de integrante", "xss|required");
        //$this->form_validation->set_rules("integrantes[0][edad]", "Edad de integrante", "xss|required|integer");
        //$this->form_validation->set_rules("integrantes[0][instrumento]", "Instrumento de integrante", "xss|required");

        $this->form_validation->set_message("required", "Introduce %s");
        $this->form_validation->set_message("integer", "%s debe ser un número");
        $this->form_validation->set_message("email", "Ingresa un email válido");
        $this->form_validation->set_message("exact_length", "El %s debe de ser de 9 digitos");
        if ($this->form_validation->run() === FALSE) {
            echo json_encode(array("status" => "MSG" , "type"=>"warning" , "message" => validation_errors()));
        } else {  
            $this->load->helper('url');
            $this->load->helper('date');
            $data = array(
                "nombre" => $this->input->post("nombre"),
                "carrera" => $this->input->post("carrera"),
                "semestre" => $this->input->post("semestre"),
                "no_cta" => $this->input->post("no_cta"),
                "email" => $this->input->post("email"),
                "celular" => $this->input->post("celular"),
                "telefono" => $this->input->post("telefono"),
                "artes" => $this->input->post("artes"),
                "actividad_artistica" => $this->input->post("actividad_artistica"),
                "nombre_grupo" => $this->input->post("nombre_grupo"),
                "genero" => $this->input->post("genero"),
                "integrantes" => $this->input->post("integrantes"),
                "duracion" => $this->input->post("duracion"),
                "equipo_lista" => $this->input->post("equipo_lista"),
                "escenografia" => $this->input->post("escenografia"),
                "iluminacion" => $this->input->post("iluminacion"),
                "audio_video" => $this->input->post("audio_video"),
                "duracion_montaje" => $this->input->post("duracion_montaje"),
                "duracion_desmontaje" => $this->input->post("duracion_desmontaje")
            );
            $content = $this->load->view('alumnos/talento_pdf_view', $data, true);
            $content2 = $this->load->view('alumnos/talento_ft_pdf_view', $data, true);
            $css = $this->load->view('alumnos/talento_pdf_css', $data, true);
            $this->load->library('mpdf');
            $mpdf = new mPDF();
            $mpdf->SetProtection(array('copy' , 'print'));
            $mpdf->WriteHTML($css, 1);
            $mpdf->WriteHTML($content, 2);
            $mpdf->AddPage();
            $mpdf->WriteHTML($content2, 2);
            $mpdf->Output("FichaTalento", "D");
            // echo json_encode($data);
        }
    }

}
