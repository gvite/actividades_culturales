<?php

/*
 * status
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Inscripcion extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('baucher_model');
        $this->load->model('usuarios_model');
        $this->load->model('taller_semestre_horario_model');
        $this->load->model('talleres_model');
        $this->load->library('archivos');
    }

    public function index() {
        $this->load->model('semestres_model');
        $this->load->model('talleres_semestre_model');
        $this->load->helper('date');
        $this->load->helper(array('url', 'sesion'));
        $data['semestre_actual'] = $this->semestres_model->get_actual();
        $data['active'] = 'inscripcion';
        $data['js'][] = 'js/inscripcion.js';
        if ($data['semestre_actual']) {
            $data['puede_inscribir'] = $this->semestres_model->puede_insc($data['semestre_actual']['id']);
        } else {
            $data['puede_inscribir'] = false;
        }
        $this->load->view('main/header_view', $data);
        $data['talleres'] = $this->talleres_semestre_model->get_by_semestre_type_user($data['semestre_actual']['id'],get_type_user());
        if (is_array($data['talleres'])) {
            //$this->load->model('baucher_model');
            foreach ($data['talleres'] as $key => $taller) {
                $this->check_status_taller($taller['id']);
                $count = $this->baucher_model->count_insc($taller['id']);
                $data['talleres'][$key]['insc_count'] = $count;
                $data['talleres'][$key]['percent'] = ($count * 100) / $taller['cupo'];
                $data['talleres'][$key]['status'] = false;
                if ($data['talleres'][$key]['percent'] < 100) {
                    $data['talleres'][$key]['status'] = $this->baucher_model->get_status_by_user($taller['id']);
                }
                $data['talleres'][$key]['puede_mas'] = true;
                if ($taller['taller_id'] == 11 && $this->baucher_model->count_taller_insc(11, $data['semestre_actual']['id']) > 0) {
                    $data['talleres'][$key]['puede_mas'] = false;
                }
                $data['talleres'][$key]['horarios'] = $this->taller_semestre_horario_model->get_by_taller_sem($taller['id']);
                $data['talleres'][$key]['costo'] = '';
                $data['talleres'][$key]['num_trabajador'] = 0;
                switch (get_type_user()) {
                    case 1:
                        $data['talleres'][$key]['costo'] = $taller['costo_alumno'];
                    case 2:
                        $data['talleres'][$key]['costo'] = $taller['costo_alumno'];
                        break;
                    case 3:
                        $data['talleres'][$key]['costo'] = $taller['costo_exalumno'];
                        break;
                    case 4:
                        $data['talleres'][$key]['num_trabajador'] = $this->baucher_model->count_trabajadores_insc($taller['id']);
                        $data['talleres'][$key]['costo'] = $taller['costo_trabajador'];
                        break;
                    case 5:
                        $data['talleres'][$key]['costo'] = $taller['costo_externo'];
                        break;
                }
            }
        }
        $data['bauchers'] = $this->baucher_model->get_by_user_with_taller();
        $this->load->view("alumnos/inscripcion_view", $data);
        $this->load->view('main/footer_view', '');
    }

    public function insert() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules("id", "Talleres", "xss|required");
        $this->form_validation->set_message("required", "Introduce %s");
        if ($this->form_validation->run() == FALSE) {
            $errors = validation_errors();
            echo json_encode(array('status' => 'MSG', 'type' => 'warning', "message" => 'Introduce Talleres'));
        } else {
            $ids = $this->input->post('id');
            if (is_array($ids)) {
                $this->load->helper('sesion');
                $exito = true;
                $errors = array();
                $this->load->model('talleres_semestre_model');
                $piano_insc = 0;
                foreach ($ids as $id) {
                    $this->check_status_taller($id);
                    $status = $this->baucher_model->get_status_by_user($id);
                    $taller = $this->talleres_semestre_model->get_with_name_type_user($id , get_type_user());
                    if (is_array($taller)) {
                        if ($taller['taller_id'] == 11) {
                            $piano_insc++;
                            if ($piano_insc > 1) {
                                $errors[] = 'Lo siento solo se puede inscribir un taller de piano.';
                                $exito = false;
                            }
                        }
                        $ids_aux[] = array('id' => $id , 'taller' => $taller['taller']);
                        if ($status == false || $status['status'] == 3) {
                            $count = $this->baucher_model->count_insc($id);
                            if ($count >= $taller['cupo']) {
                                $errors[] = 'El cupo esta lleno para ' . $taller['taller'] . 'Intenta ser mas r&aacute;pido para la pr&oacute;xima XD.';
                                //$errors[count($errors) - 1]['id'] = $id;
                                $exito = false;
                            }
                            if (get_type_user() == 4 && $this->baucher_model->count_trabajadores_insc($id) >= 2) {
                                $errors[] = 'Lo siento solo se pueden inscribir un maximo de 2 trabajadores en cada taller.';
                                //$errors[count($errors) - 1]['id'] = $id;
                                $exito = false;
                            }
                        } else {
                            if ($status['status'] == 0) {
                                $errors[] = 'Materia inscrita anteriormente (Sin validaci&oacute;n): ' . $taller['taller'];
                            } else if ($status['status'] == 1) {
                                $errors[] = 'Materia inscrita anterior mente: ' . $taller['taller'];
                            } else {
                                $errors[] = 'Aun no puedes inscribir la materia, intentalo mas tarde: ' . $taller['taller'];
                            }
                            $exito = false;
                        }
                    } else {
                        $errors [] = 'Taller no Encontrado o no lo puedes inscribir. No Jueges con el sistema.';
                    }
                }
                if ($exito) {
                    $bauchers = array();
                    foreach ($ids_aux as $id) {
                        $folio = -1;
                        $exito = true;
                        while ($exito) {
                            $folio = mt_rand(1, 2147483647);
                            if ($this->baucher_model->check_folio_free($folio)) {
                                $exito = false;
                            }
                        }
                        $ts = $this->talleres_semestre_model->get($id['id'] , 'taller_id');
                        $data = array(
                            'usuario_id' => get_id(),
                            'folio' => $folio,
                            'fecha_expedicion' => date('Y-m-d H:i:s'),
                            'taller_semestre_id' => $id['id'],
                            'aportacion' => $this->talleres_model->get_costo_by_tipo($ts['taller_id'] , get_type_user()),
                            'status' => 0
                        );
                        $baucher_id = $this->baucher_model->insert($data);
                        
                            $bauchers[] = array(
                                'id' => $baucher_id,
                                'folio' => str_pad($data['folio'], 11, "0", STR_PAD_LEFT),
                                'fecha_expedicion' => $data['fecha_expedicion'],
                                'taller' => $id['taller'],
                                'taller_id' => $id['id']
                            );
                        
                    }
                    echo json_encode(array('status' => 'MSG', 'type' => 'success', 'message' => 'La inscripción ha finalizado.', 'bauchers' => $bauchers));
                } else {
                    echo json_encode(array('status' => 'MSG', 'type' => 'warning', "message" => implode('<br />', $errors)));
                }
            } else {
                echo json_encode(array('status' => 'MSG', 'type' => 'warning', "message" => 'Ingresa talleres a incribir.'));
            }
        }
    }

    public function check_status_taller($id_taller) {
        $bauchers = $this->baucher_model->get_by_taller_status($id_taller, 2 , 0);
        if (is_array($bauchers)) {
            $now = mktime();
            $termina_hora = 20;
            foreach ($bauchers as $baucher) {
                $date_aux = getdate(strtotime($baucher['fecha_expedicion']));
                if ($date_aux['wday'] > 3) {
                    $date_termino_insc = mktime($termina_hora, 0, 0, $date_aux['mon'], $date_aux['mday'] + 5, $date_aux['year']);
                } else if ($date_aux['wday'] == 0) {
                    $date_termino_insc = mktime($termina_hora, 0, 0, $date_aux['mon'], $date_aux['mday'] + 4, $date_aux['year']);
                } else {
                    $date_termino_insc = mktime($termina_hora, 0, 0, $date_aux['mon'], $date_aux['mday'] + 3, $date_aux['year']);
                }
                $result = $now - $date_termino_insc;
                if ($result > 0) {
                    if($result > 60*60*24){
                        $this->baucher_model->update_status($baucher['id'], 3);
                    }else{
                        $this->baucher_model->update_status($baucher['id'], 2);
                    }
                }
            }
        }
    }

    public function get_pdf($baucher_id) {

        $data['baucher'] = $this->baucher_model->get_with_all($baucher_id);
        if ($data['baucher']) {
            $this->load->helper('sesion');
            $route = str_replace("\\", "/", FCPATH) . "uploads/comprobantes/" . get_id() . '/';
            $this->load->helper('url');
            if (file_exists($route . 'pdf_' . $baucher_id . '.pdf')) {
                unlink($route . 'pdf_' . $baucher_id . '.pdf');
            }
            $this->load->helper('date');
            $termina_hora = 20;
            $data['baucher']['horarios'] = $this->taller_semestre_horario_model->get_by_taller_sem($data["baucher"]['ts_id']);
            $date_aux = getdate(strtotime($data['baucher']['fecha_expedicion']));
            if ($date_aux['wday'] > 3) {
                $date_termino_insc = mktime($termina_hora, 0, 0, $date_aux['mon'], $date_aux['mday'] + 4, $date_aux['year']);
            } else if ($date_aux['wday'] == 0) {
                $date_termino_insc = mktime($termina_hora, 0, 0, $date_aux['mon'], $date_aux['mday'] + 3, $date_aux['year']);
            } else {
                $date_termino_insc = mktime($termina_hora, 0, 0, $date_aux['mon'], $date_aux['mday'] + 2, $date_aux['year']);
            }
            $data['usuario'] = $this->usuarios_model->get(get_id());
            $data['usuario']['count_talleres_insc'] = get_talleres_inscritos();
            $data['date_fin'] = getdate($date_termino_insc);
            $data['termina_hora'] = $termina_hora;
            $content = $this->load->view('alumnos/comprobante_view', $data, true);
            $css = $this->load->view('alumnos/comprobante_css', $data, true);
            $this->load->library('mpdf');
            $mpdf = new mPDF();
            $mpdf->SetProtection(array('copy' , 'print'));
            $mpdf->SetHTMLHeader($header);
            $mpdf->WriteHTML($css, 1);
            $mpdf->WriteHTML($content, 2);
            if ($this->archivos->create_folder($route)) {
                $mpdf->Output($route . "pdf_" . $baucher_id . '.pdf', 'F');
                echo json_encode(array('status' => 'OK', 'url' => base_url() . 'uploads/comprobantes/' . get_id() . '/pdf_' . $baucher_id . '.pdf'));
            } else {
                echo json_encode(array('status' => 'MSG', 'type' => 'error', "message" => 'No se pudo crear la carpeta de usuario'));
            }
        } else {
            echo json_encode(array('status' => 'MSG', 'type' => 'error', "message" => 'Se encontro una inconsistencia con el baucher solicitado.'));
        }
    }

}

?>