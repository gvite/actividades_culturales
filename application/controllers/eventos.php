<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Eventos extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("eventos_model");
        $this->load->model("asistentes_model");
    }

    public function index() {
        $data['active'] = "eventos";
        $this->load->helper(array('sesion' , 'url'));
        if(get_type_user()){
            $data['js'][] = 'js/eventos.js';
            $data["eventos"] = $this->eventos_model->get_all_by_type_user(get_type_user());
        }else{
            $data['js'][] = 'js/acceso.js';
            $data["eventos"] = $this->eventos_model->get_all();
        }
        foreach($data["eventos"] as $key => $evento){
            $data["eventos"][$key]["asistentes"] = $this->asistentes_model->count($evento["id"]);
            $porcentaje = ($data["eventos"][$key]["asistentes"] * 100) / $evento["cupo"];
            if($porcentaje < 60){
                $data["eventos"][$key]["asistentes_label"] = "success";
            }else if($porcentaje < 90){
                $data["eventos"][$key]["asistentes_label"] = "warning";
            }else{
                $data["eventos"][$key]["asistentes_label"] = "danger";
            }
            $data["eventos"][$key]["has_event"] = false;
            if(get_type_user()){
                $insc = $this->asistentes_model->get_by_user($evento["id"] , get_id());
                $data["eventos"][$key]["has_event"] = ($insc) ? true : false;
            }
        }
        $this->load->view('main/header_view', $data);
        $this->load->view('main/eventos_view', $data);
        if(!get_type_user()){
            $this->load->view('acceso/login_view', $data);
        }
        $this->load->view('main/footer_view', '');
    }

    public function inscripcion(){
        $evento_id = $this->input->post("evento");
        $event = $this->eventos_model->get_by_type_user($evento_id , get_type_user());
        if(is_array($event)){
            $insc = $this->asistentes_model->get_by_user($evento_id , get_id());
            if($insc === false){
                $count = $this->asistentes_model->count($evento_id);
                if($count < $event["cupo"]){
                    $data = array("usuario_id" => get_id(),"evento_id" => $evento_id,"folio" => $count + 1);
                    $id = $this->asistentes_model->insert($data);
                    if($id){
                        $this->load->library("cJWT");
                        $time = time();
                        $token = array(
                            'iat' => $time, // Tiempo que inició el token
                            'data' => [ // información del usuario
                                'id' => $id,
                                'folio' => $data["folio"]
                            ]
                        );
                        $cJWT = new cJWT();
                        $jwt = $cJWT->encode($token, JWT_KEY);
                        include(APPPATH . "/third_party/phpqrcode/qrlib.php");
                        QRcode::png($jwt , str_replace("\\", "/", FCPATH) . "uploads/qr/$id.png");
                        echo json_encode(array("status" => "OK" , "evento_id" => $evento_id));
                    }else{
                        echo json_encode(array("status" => "MSG" , "type" => "warning","message" => "ocurrió un error, intentalo de nuevo."));    
                    }
                }else{
                    echo json_encode(array("status" => "MSG" , "type" => "warning","message" => "Ya no hay cupo"));
                }
            }else{
                echo json_encode(array("status" => "MSG" , "type" => "warning","message" => "Ya vas a asistir al evento."));    
            }
        }else{
            echo json_encode(array("status" => "MSG" , "type" => "warning","message" => "No se puede inscribir al taller."));
        }
    }

    public function detalle($id){
        $data["evento"] = $this->asistentes_model->get_data_by_user($id , get_id());
        if($data["evento"]){
            $this->load->helper("date");
            $data['active'] = "eventos";
            $this->load->helper(array('sesion' , 'url'));
            $data['js'][] = 'js/evento_detalle.js';
            $this->load->view('main/header_view', $data);
            $this->load->view('main/evento_detalle_view', $data);
            $this->load->view('main/footer_view', '');
        }else{
            show_404();
        }
    }
    public function pdf($id){

        $data["evento"] = $this->asistentes_model->get_data_by_user($id , get_id());
        $content = $this->load->view('alumnos/evento_view', $data, true);
        $css = $this->load->view('alumnos/evento_css', $data, true);
        $this->load->library('mpdf');
        $mpdf = new mPDF();
        $header = '<img src="images/logo_pdf.jpg" style="padding-left:20px;" />';
        $mpdf->SetProtection(array('copy' , 'print'));
        $mpdf->SetHTMLHeader($header);
        $mpdf->WriteHTML($css, 1);
        $mpdf->WriteHTML($content, 2);
        $mpdf->Output();
    }

}
