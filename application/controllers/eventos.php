<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Eventos extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("eventos_model");
        $this->load->model("asistentes_model");
        $this->load->model("usuarios_model");
    }

    public function index() {
        $this->load->helper("date");
        $data['active'] = "eventos";
        $this->load->helper(array('sesion' , 'url'));
        $this->load->model('semestres_model');
        $data['semestre_actual'] = $this->semestres_model->get_actual();
        if ($data['semestre_actual']) {
            $data['puede_inscribir'] = $this->semestres_model->puede_insc($data['semestre_actual']['id']);
        } else {
            $data['puede_inscribir'] = false;
        }
        if(get_type_user()){
            $data['js'][] = 'js/eventos.js';
            if(get_type_user() == 1){
                $data["eventos"] = $this->eventos_model->get_all();
            }else{
                $data["eventos"] = $this->eventos_model->get_next_all_by_type_user(get_type_user());
            }
        }else{
            $data['js'][] = 'js/acceso.js';
            $data["eventos"] = $this->eventos_model->get_next_all();
        }
        $eventInsc = false;
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
                if($insc && ($evento["id"] == 6 || $evento["id"] == 7)) {
                    $eventInsc = true;
                    $data["eventos"][$key]["show_detalle"] = true;
                } else if(!$insc&& ($evento["id"] == 6 || $evento["id"] == 7)){
                    $data["eventos"][$key]["show_detalle"] = false;
                } else {
                    $data["eventos"][$key]["show_detalle"] = true;
                }
            }
        }
        if($eventInsc) {
            foreach($data["eventos"] as $key => $evento){
                $data["eventos"][$key]["has_event"] = true;
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
        $puedeFacultad = true;
        /*if($evento_id >= 8 || $evento_id <= 14) {
            if(get_type_user() == 2){
                $alumno = $this->usuarios_model->get_alumno(get_id());
            } else if(get_type_user() == 3) {
                $alumno = $this->usuarios_model->get_exalumno(get_id());
            } else if(get_type_user() == 4) {
                $alumno = $this->usuarios_model->get_trabajador(get_id());
            }
            if($alumno && $alumno['facultad_id'] == 1) {
                $puedeFacultad = true;
            } else {
                $puedeFacultad = false;
            }
        }*/
        if($puedeFacultad) {
            if(is_array($event)){
                /*if( $evento_id == 8 || $evento_id == 9 || $evento_id == 10) {
                    $insc = $this->asistentes_model->get_by_user(array(8,9,10) , get_id());
                } else if ($evento_id == 11 || $evento_id == 12) {
                    $insc = $this->asistentes_model->get_by_user(array(11,12) , get_id());
                } else if ($evento_id == 13 || $evento_id == 14) {
                    $insc = $this->asistentes_model->get_by_user(array(13,14) , get_id());
                }*/
                $insc = $this->asistentes_model->get_by_user($evento_id , get_id());
                if($insc === false){
                    $count = $this->asistentes_model->count($evento_id);
                    if($count < $event["cupo"]){
                        $data = array(
                            "usuario_id" => get_id(),
                            "evento_id" => $evento_id,
                            "folio" => $count + 490,
                            "fecha_inscripcion" => date("Y-m-d H:i:s")
                        );
                        $id = $this->asistentes_model->insert($data);
                        if($id){
                            $this->load->library("Cjwt");
                            $time = time();
                            $token = array(
                                'iat' => $time, // Tiempo que inició el token
                                'data' => array( // información del usuario
                                    'id' => $id,
                                    'folio' => $data["folio"]
                                )
                            );
                            $cJWT = new Cjwt();
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
                echo json_encode(array("status" => "MSG" , "type" => "warning","message" => "No se puede inscribir al evento."));
            }
        } else {
            echo json_encode(array("status" => "MSG" , "type" => "warning","message" => "Sólo la comunidad de la Fes Aragón se puede Inscribir al evento."));
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
    public function alumnos($id){
        $data["evento"] = $this->eventos_model->get($id);
        if($data["evento"]){
            $data["asistentes"] = $this->asistentes_model->get_by_event($id);
            $this->load->helper("date");
            $data['active'] = "eventos";
            $this->load->helper(array('sesion' , 'url'));
            $data['js'][] = 'js/plugins/jquery.dataTables.min.js';
            $data['js'][] = 'js/evento_alumnos.js';
            $this->load->view('main/header_view', $data);
            $this->load->view('main/evento_alumnos_view', $data);
            $this->load->view('main/footer_view', '');
        }else{
            show_404();
        }
    }
    public function asistencia(){
        $asistencia = $this->input->post("asistencia");
        $status = $this->input->post("status");
        $data = array("asistencia" => ($status === 'true') ? 1 : 0) ;
        if($this->asistentes_model->update($asistencia ,$data)){
            echo json_encode(array("status" => "OK" , "data" => $data));
        }else{
            echo json_encode(array("status" => "MSG" , "message" => "Error al actualizar" , "type" => "danger"));
        }
    }
    public function email($event_id){
        $as = $this->asistentes_model->get_emails_by_event($event_id);
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'ssl://smtp.googlemail.com'; # Not tls://
        $config['smtp_port'] = 465;
        $config['starttls'] = TRUE;
        $config['smtp_user'] = 'actividades.culturales.fesa@gmail.com';
        $config['smtp_pass'] = 'actividades2014';
        $config['smtp_timeout'] = 5;
        $config['newline'] = "\r\n";
        $config['charset'] = 'utf-8';
        $config['mailtype'] = 'html';
        $asunto = 'Compañía Nacional de Danza';
        $this->load->library('email', $config);
        $exito = true;
        $i = 0;
        foreach($as as $a){
            if($i > 300 && $i <= 369){
                $data = array(
                    'name' => $a['nombre'],
                    'msg' => "Te recordamos que en la presentación de la Compañía Nacional de Danza deberás presentar tu boleto 15 minutos antes de la función."
                );
                $mensaje = $this->load->view('main/evento_email_view', $data, TRUE);
                
                $this->email->from("fesar_cultura@unam.mx", "");
                $this->email->to($a['email']);
                $this->email->subject($asunto);
                $this->email->message($mensaje);
                if(!$this->email->send()){
                    $exito = false;
                    $messageError = $this->email->print_debugger();
                }
            }
            $i++;
        }
        if($exito) {
            echo "Exito";
        } else {
            echo $messageError;
        }

    }
    public function pdf($id){
        $this->load->helper("date");
        $data["evento"] = $this->asistentes_model->get_data_by_user($id , get_id());
        if($data["evento"]){
            if($this->asistentes_model->update($data["evento"]["asistente_id"],array("imprimir" => 1))){
                $content = $this->load->view('alumnos/evento_view', $data, true);
                $css = $this->load->view('alumnos/evento_css', $data, true);
                $this->load->library('mpdf');
                $mpdf = new mPDF();
                //$header = '<img src="images/logo_pdf.jpg" style="padding-left:20px;" />';
                
                $mpdf->SetProtection(array('copy' , 'print'));
                //$mpdf->Image('images/eventos/odiseo-y-los-mesoneros-aragon-degrade.png',0,0,210,297,'png','',true, false);
                //$mpdf->SetHTMLHeader($header);
                $mpdf->WriteHTML($css, 1);
                
                $mpdf->WriteHTML($content, 2);

                //copia del alumno
                $mpdf->Image('images/logo_pdf_e.jpg',165,40,22,22,'jpg','',true, true);
                $mpdf->Image('images/logo_unam.png',68,40,22,22,'png','',true, true);
                $mpdf->Image('images/eventos/ticket.png',15,25,230,140,'png','',true, true);
                $mpdf->Image('images/eventos/' . $data["evento"]["img_pdf"],18.5,29,47,90.5,'jpg','',true, true);
                $mpdf->Image('uploads/qr/' . $data["evento"]["asistente_id"] . ".png",151.4,84.2,35,35,'png','',true, true);

                //copia del personal
                $mpdf->Image('images/logo_pdf_e.jpg',165,176.5,22,22,'jpg','',true, true);
                $mpdf->Image('images/logo_unam.png',68,176.5,22,22,'png','',true, true);
                $mpdf->Image('images/eventos/ticket.png',15,162,230,140,'png','',true, true);
                $mpdf->Image('images/eventos/' . $data["evento"]["img_pdf"],18.5,166,47,90.5,'jpg','',true, true);
                $mpdf->Image('uploads/qr/' . $data["evento"]["asistente_id"] . ".png",151,221.3,35,35,'png','',true, true);
                
                $mpdf->SetTitle($data["evento"]["nombre"]);
                $mpdf->Output($data["evento"]["nombre"] . ".pdf","I");
            }else{
                show_404();
            }
        }else{
            show_404();
        }
    }

    public function pdf_admin($id, $user_id){
        $this->load->helper("date");
        $data["evento"] = $this->asistentes_model->get_data_by_user($id , $user_id);
        if($data["evento"]){
            if($this->asistentes_model->update($data["evento"]["asistente_id"],array("imprimir" => 1))){
                $content = $this->load->view('alumnos/evento_view', $data, true);
                $css = $this->load->view('alumnos/evento_css', $data, true);
                $this->load->library('mpdf');
                $mpdf = new mPDF();
                //$header = '<img src="images/logo_pdf.jpg" style="padding-left:20px;" />';
                
                $mpdf->SetProtection(array('copy' , 'print'));
                //$mpdf->Image('images/eventos/odiseo-y-los-mesoneros-aragon-degrade.png',0,0,210,297,'png','',true, false);
                //$mpdf->SetHTMLHeader($header);
                $mpdf->WriteHTML($css, 1);
                
                $mpdf->WriteHTML($content, 2);

                //copia del alumno
                $mpdf->Image('images/logo_pdf_e.jpg',165,40,22,22,'jpg','',true, true);
                $mpdf->Image('images/logo_unam.png',68,40,22,22,'png','',true, true);
                $mpdf->Image('images/eventos/ticket.png',15,25,230,140,'png','',true, true);
                $mpdf->Image('images/eventos/' . $data["evento"]["img"],18.5,29,47,90.5,'jpg','',true, true);
                $mpdf->Image('uploads/qr/' . $data["evento"]["asistente_id"] . ".png",151.4,84.2,35,35,'png','',true, true);

                //copia del personal
                $mpdf->Image('images/logo_pdf_e.jpg',165,176.5,22,22,'jpg','',true, true);
                $mpdf->Image('images/logo_unam.png',68,176.5,22,22,'png','',true, true);
                $mpdf->Image('images/eventos/ticket.png',15,162,230,140,'png','',true, true);
                $mpdf->Image('images/eventos/' . $data["evento"]["img"],18.5,166,47,90.5,'jpg','',true, true);
                $mpdf->Image('uploads/qr/' . $data["evento"]["asistente_id"] . ".png",151,221.3,35,35,'png','',true, true);
                
                $mpdf->SetTitle($data["evento"]["nombre"]);
                $mpdf->Output($data["evento"]["nombre"] . ".pdf","I");
            }else{
                show_404();
            }
        }else{
            show_404();
        }
    }

}
