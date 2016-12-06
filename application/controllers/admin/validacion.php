<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Validacion extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('usuarios_model');
        $this->load->model('semestres_model');
    }

    public function index() {
        $this->load->helper(array('url', 'sesion'));
        $data['active'] = 'validacion';
        $this->load->model('semestres_model');
        $data['semestre_actual'] = $this->semestres_model->get_actual();
        if ($data['semestre_actual']) {
            $data['puede_inscribir'] = $this->semestres_model->puede_insc($data['semestre_actual']['id']);
        } else {
            $data['puede_inscribir'] = false;
        }
        $data['js'] = 'js/validacion.js';
        $this->load->view('main/header_view', $data);
        $this->load->view("admin/validacion_view", '');
        $this->load->view('main/footer_view', '');
    }

    public function verifica_folio() {
        $folio = $this->input->post('folio');
        if ($folio != '') {
            $this->load->model('baucher_model');
            $baucher = $this->baucher_model->check_folio_free($folio, 'id');
            if (!$baucher) {
                echo json_encode(array('status' => 'OK', 'folio' => $folio));
            } else {
                echo json_encode(array('status' => 'MSG', 'type' => 'warning', 'message' => 'Folio no encontrado.'));
            }
        } else {
            echo json_encode(array('status' => 'MSG', 'type' => 'warning', 'message' => 'Ingresa un Folio.'));
        }
    }

    public function get_baucher($folio = '') {
        if ($folio != '') {
            $this->load->model('baucher_model');
            $data['baucher'] = $this->baucher_model->get_by_folio($folio);
            if ($data['baucher']) {
                $this->load->helper('sesion');
                $this->load->helper('date');
                $this->check_status_taller($data['baucher']['ts_id']);
                
                $data['usuario'] = $this->usuarios_model->get($data['baucher']['usuario_id']);
                $this->load->helper(array('url', 'sesion'));
                $data['active'] = 'validacion';
                $data['semestre_actual'] = $this->semestres_model->get_actual();
                if ($data['semestre_actual']) {
                    $data['puede_inscribir'] = $this->semestres_model->puede_insc($data['semestre_actual']['id']);
                } else {
                    $data['puede_inscribir'] = false;
                }
                $data['js'][] = 'js/validacion.js';
                $data['js'][] = 'js/validacion_valida.js';
                $this->load->view('main/header_view', $data);
                $this->load->view("admin/validacion_view", '');
                $this->load->view('admin/validacion_datos_view', $data);
                $this->load->view('main/footer_view', '');
            } else {
                show_404();
            }
        } else {
            show_404();
        }
    }

    public function valida_insc($baucher_id = '') {
        $this->load->helper('sesion');
        if (get_type_user() == 1) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules("numero_caja", "Numero de recibo", "xss");
            $this->form_validation->set_rules("fecha_caja", "Fecha de recibo", "xss|callback_date_form");
            if($this->input->post('bbeca') == 1){
                $this->form_validation->set_rules("beca", "Porcentaje de beca", "xss|required");
            }
            if($this->input->post('baportacion') == 1){
                $this->form_validation->set_rules("aportacion", "Aportación", "xss|required");
            }
            $this->form_validation->set_message("required", "Ingresa %s");
            if ($this->form_validation->run() === FALSE) {
                $errors = validation_errors();
                echo json_encode(array('status' => 'MSG', 'type' => 'warning', "message" => $errors));
            } else {
                $this->load->model('baucher_model');
                $baucher = $this->baucher_model->get($baucher_id);
                $this->load->helper('date');
                if (is_array($baucher) && $baucher['status'] == 0) {
                    $data = array(
                        'status' => 1,
                        'folio_caja' => $this->input->post('numero_caja'),
                        'fecha_caja' => exchange_date($this->input->post('fecha_caja')),
                        'extra' => ($this->input->post('baportacion') == 1)?$this->input->post('aportacion'):0,
                        'beca' => ($this->input->post('bbeca') == 1) ? $this->input->post('beca'):0
                    );
                    if ($this->baucher_model->update($baucher_id, $data)) {
                        echo json_encode(array('status' => 'MSG', 'type' => 'success', 'message' => 'La inscripci&oacute;n se finaliz&oacute; con &eacute;xito.'));
                    } else {
                        echo json_encode(array('status' => 'MSG', 'type' => 'error', "message" => 'Ocurrio un error al actualizar la inscripci&oacute;n'));
                    }
                } else {
                    echo json_encode(array('status' => 'MSG', 'type' => 'warning', "message" => 'Ya no tiene permisos para validar este baucher, actualiza la pagina por favor.'));
                }
            }
        } else {
            echo json_encode(array('status' => 'MSG', 'type' => 'warning', "message" => 'No tienes permisos para poder realizar esta operaci&oacute;n.'));
        }
    }
    
    public function edit($baucher_id = '') {
        $this->load->helper('sesion');
        if (get_type() == 1) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules("numero_caja", "Numero de recibo", "xss|required");
            $this->form_validation->set_rules("fecha_caja", "Fecha de recibo", "xss|required|callback_date_form");
            if($this->input->post('bbeca') == 1){
                $this->form_validation->set_rules("beca", "Beca", "xss|required");
            }
            if($this->input->post('baportacion') == 1){
                $this->form_validation->set_rules("aportacion", "Aportación", "xss|required");
            }
            $this->form_validation->set_message("required", "Ingresa %s");
            if ($this->form_validation->run() === FALSE) {
                $errors = validation_errors();
                echo json_encode(array('status' => 'MSG', 'type' => 'warning', "message" => $errors));
            } else {
                $this->load->model('baucher_model');
                $baucher = $this->baucher_model->get($baucher_id);
                $this->load->helper('date');
                if (is_array($baucher)) {
                    $data = array(
                        'folio_caja' => $this->input->post('numero_caja'),
                        'fecha_caja' => exchange_date($this->input->post('fecha_caja')),
                        'extra' => ($this->input->post('baportacion') == 1)?$this->input->post('aportacion'):0,
                        'beca' => ($this->input->post('bbeca') == 1) ? $this->input->post('beca'):0
                    );
                    if ($this->baucher_model->update($baucher_id, $data)) {
                        echo json_encode(array('status' => 'MSG', 'type' => 'success', 'message' => 'Los datos se editaron con &eacute;xito.'));
                    } else {
                        echo json_encode(array('status' => 'MSG', 'type' => 'error', "message" => 'Ocurrio un error al actualizar la inscripci&oacute;n'));
                    }
                } else {
                    echo json_encode(array('status' => 'MSG', 'type' => 'warning', "message" => 'Ya no tiene permisos para validar este baucher, actualiza la pagina por favor.'));
                }
            }
        } else {
            echo json_encode(array('status' => 'MSG', 'type' => 'warning', "message" => 'No tienes permisos para poder realizar esta operaci&oacute;n.'));
        }
    }
    
    public function ingresa_folio_caja($baucher_id = '') {
        $this->load->helper('sesion');
        if (get_type_user() == 1) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules("numero_caja", "Numero de caja", "xss|required");
            $this->form_validation->set_message("required", "Ingresa %s");
            if ($this->form_validation->run() === FALSE) {
                $errors = validation_errors();
                echo json_encode(array('status' => 'MSG', 'type' => 'warning', "message" => $errors));
            } else {
                $this->load->model('baucher_model');
                $baucher = $this->baucher_model->get($baucher_id);
                if (is_array($baucher) && $baucher['status'] == 1) {
                    $data = array(
                        'folio_caja' => $this->input->post('numero_caja')
                    );
                    if ($this->baucher_model->update($baucher_id, $data)) {
                        echo json_encode(array('status' => 'MSG', 'type' => 'success', 'message' => 'La inscripci&oacute;n se finaliz&oacute; con &eacute;xito.' , 'numero_caja' => $data['folio_caja']));
                    } else {
                        echo json_encode(array('status' => 'MSG', 'type' => 'error', "message" => 'Ocurrio un error al actualizar la inscripci&oacute;n'));
                    }
                } else {
                    echo json_encode(array('status' => 'MSG', 'type' => 'warning', "message" => 'Ya no tiene permisos para validar este baucher, actualiza la pagina por favor.'));
                }
            }
        } else {
            echo json_encode(array('status' => 'MSG', 'type' => 'warning', "message" => 'No tienes permisos para poder realizar esta operaci&oacute;n.'));
        }
    }
    public function ingresa_fecha_caja($baucher_id = '') {
        $this->load->helper('sesion');
        if (get_type_user() == 1) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules("fecha_caja", "Fecha de caja", "xss|required|callback_date_form");
            $this->form_validation->set_message("required", "Ingresa %s");
            if ($this->form_validation->run() === FALSE) {
                $errors = validation_errors();
                echo json_encode(array('status' => 'MSG', 'type' => 'warning', "message" => $errors));
            } else {
                $this->load->model('baucher_model');
                $baucher = $this->baucher_model->get($baucher_id);
                if (is_array($baucher) && $baucher['status'] == 1) {
                    $this->load->helper('date');
                    $data = array(
                        'fecha_caja' => exchange_date($this->input->post('fecha_caja'))
                    );
                    if ($this->baucher_model->update($baucher_id, $data)) {
                        echo json_encode(array('status' => 'MSG', 'type' => 'success', 'message' => 'La fecha se agregó con &eacute;xito.' , 'fecha_caja' => $this->input->post('fecha_caja')));
                    } else {
                        echo json_encode(array('status' => 'MSG', 'type' => 'error', "message" => 'Ocurrio un error al actualizar la inscripci&oacute;n'));
                    }
                } else {
                    echo json_encode(array('status' => 'MSG', 'type' => 'warning', "message" => 'Ya no tiene permisos para validar este baucher, actualiza la pagina por favor.'));
                }
            }
        } else {
            echo json_encode(array('status' => 'MSG', 'type' => 'warning', "message" => 'No tienes permisos para poder realizar esta operaci&oacute;n.'));
        }
    }

    public function baja() {
        $this->load->helper('sesion');
        if (get_type_user() == 1) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules("baucher", "Baucher", "xss|required");
            $this->form_validation->set_message("required", "Ocurrio un error con %s");
            if ($this->form_validation->run() === FALSE) {
                $errors = validation_errors();
                echo json_encode(array('status' => 'MSG', 'type' => 'warning', "message" => $errors));
            } else {
                $this->load->model('baucher_model');
                if ($this->baucher_model->update_status($this->input->post('baucher'), 3)) {
                    echo json_encode(array('status' => 'MSG', 'type' => 'success', 'message' => 'La inscripci&oacute;n se dio de baja con &eacute;xito.'));
                } else {
                    echo json_encode(array('status' => 'MSG', 'type' => 'error', "message" => 'Ocurrio un error al actualizar la inscripci&oacute;n'));
                }
            }
        } else {
            echo json_encode(array('status' => 'MSG', 'type' => 'warning', "message" => 'No tienes permisos para poder realizar esta operaci&oacute;n.'));
        }
    }
    function date_form($fecha) {
        if($fecha != ''){
            $datos = explode('-', $fecha);
            if (count($datos) === 3 &&
                    is_numeric($datos[1]) &&
                    is_numeric($datos[0]) &&
                    is_numeric($datos[2]) &&
                    checkdate($datos[1], $datos[0], $datos[2])) {
                return true;
            } else {
                $this->form_validation->set_message('date_form', 'Ingresa %s en formato v&aacute;lido (dd-mm-aaaa)');
                return FALSE;
            }
        }else{
            return true;
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
                if ($result >= 0) {
                    if($result >= 60*60*24){
                        $this->baucher_model->update_status($baucher['id'], 3);
                    }else{
                        $this->baucher_model->update_status($baucher['id'], 2);
                    }
                }
            }
        }
    }
}

?>
