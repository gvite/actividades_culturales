<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Usuarios extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }
    
    public function index(){
        $this->load->model('semestres_model');
        $this->load->model('usuarios_model');
        $this->load->helper(array('url', 'sesion', 'date'));
        $data['active'] = 'usuarios';
        $data['semestres'] = $this->semestres_model->get_all();
        $data['semestre_actual'] = $this->semestres_model->get_actual();
        if ($data['semestre_actual']) {
            $data['puede_inscribir'] = $this->semestres_model->puede_insc($data['semestre_actual']['id']);
        } else {
            $data['puede_inscribir'] = false;
        }
        $data['js'][] = 'js/plugins/jquery.dataTables.min.js';
        $data['js'][] = 'js/usuarios.js';
        $this->load->view('main/header_view', $data);
        $data['usuarios'] = $this->usuarios_model->get_usuarios();
        $this->load->view("admin/usuarios_view", $data);
        $this->load->view('main/footer_view', '');
    }
    public function insert(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules("usuario", "Usuario", "xss|required|callback_valida_user");
        $this->form_validation->set_rules("pass", "Contrase&ntilde;a", "xss|required|callback_valida_pass_blank|callback_valida_pass[" . $this->input->post('repass') . "]");
        $this->form_validation->set_rules("repass", "Repite contrase&ntilde;a", "xss|required");
        $this->form_validation->set_rules("name_user", "Nombre", "xss|required");
        $this->form_validation->set_rules("paterno_user", "Apellido Paterno", "xss|required");
        $this->form_validation->set_rules("materno_user", "Apellido Materno", "xss");
        $this->form_validation->set_rules("correo_user", "E-Mail", "xss|required|valid_email|callback_valida_email");
        $this->form_validation->set_rules("nacimiento_user", "Fecha de Nacimiento", "xss|required|callback_valida_fecha");
        $this->form_validation->set_rules("type_user", "Tipo de usuario", "xss|required|is_natural_no_zero");
        $this->form_validation->set_message("required", "Introduce %s");
        $this->form_validation->set_message("valid_email", "Introduce un correo v&aacute;lido");
        $this->form_validation->set_message("is_natural_no_zero", "Introduce un tipo de usuario v&aacute;lido");
        if ($this->form_validation->run() === FALSE) {
            $errors = validation_errors();
            echo json_encode(array('status' => 'MSG', 'type' => 'warning', "message" => $errors));
        } else {
            $this->load->helper('date_helper');
            $data = array(
                'nombre' => $this->input->post('name_user'),
                'paterno' => $this->input->post('paterno_user'),
                'materno' => $this->input->post('materno_user'),
                'nickname' => $this->input->post('usuario'),
                'pass' => $this->input->post('pass'),
                'email' => $this->input->post('correo_user'),
                'nacimiento' => exchange_date($this->input->post('nacimiento_user')),
                'status' => 1,
                'tipo_usuario_id' => $this->input->post('type_user')
            );
            $this->load->model('usuarios_model');
            $id = $this->usuarios_model->insert($data);
            if($id){
                $data['nacimiento'] = exchange_date($data['nacimiento']);
                $data['id'] = $id;
                echo json_encode(array('status' => 'MSG', 'type' => 'success', 'message' => 'El Registro se realiz&oacute; con &eacute;xito' , 'user' => $data));
            }else{
                echo json_encode(array('status' => 'MSG', 'type' => 'error', 'message' => 'El Registro no se pudo realizar, intentelo mas tarde.'));
            }
        }
    }
    public function update(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules("id", "Ocurrio un error, recarga la pagina", "xss|required");
        $this->form_validation->set_rules("usuario", "Usuario", "xss|required|callback_valida_user_update[" . $this->input->post('id') . "]");
        $this->form_validation->set_rules("pass", "Contrase&ntilde;a", "xss|required|callback_valida_pass[" . $this->input->post('repass') . "]");
        $this->form_validation->set_rules("repass", "Repite contrase&ntilde;a", "xss|required");
        $this->form_validation->set_rules("name_user", "Nombre", "xss|required");
        $this->form_validation->set_rules("paterno_user", "Apellido Paterno", "xss|required");
        $this->form_validation->set_rules("materno_user", "Apellido Materno", "xss");
        $this->form_validation->set_rules("correo_user", "E-Mail", "xss|required|valid_email|callback_valida_email_update[" . $this->input->post('id') . "]");
        $this->form_validation->set_rules("nacimiento_user", "Fecha de Nacimiento", "xss|required|callback_valida_fecha");
        $this->form_validation->set_rules("type_user", "Tipo de usuario", "xss|required|is_natural_no_zero");
        $this->form_validation->set_message("required", "Introduce %s");
        $this->form_validation->set_message("valid_email", "Introduce un correo v&aacute;lido");
        $this->form_validation->set_message("is_natural_no_zero", "Introduce un tipo de usuario v&aacute;lido");
        if ($this->form_validation->run() === FALSE) {
            $errors = validation_errors();
            echo json_encode(array('status' => 'MSG', 'type' => 'warning', "message" => $errors));
        } else {
            $this->load->helper('date_helper');
            $data = array(
                'nombre' => $this->input->post('name_user'),
                'paterno' => $this->input->post('paterno_user'),
                'materno' => $this->input->post('materno_user'),
                'nickname' => $this->input->post('usuario'),
                'email' => $this->input->post('correo_user'),
                'nacimiento' => exchange_date($this->input->post('nacimiento_user')),
                'status' => 1,
                'tipo_usuario_id' => $this->input->post('type_user')
            );
            if($this->input->post('pass') !== 'd41d8cd98f00b204e9800998ecf8427e'){
                $data['pass'] = $this->input->post('pass');
            }
            $this->load->model('usuarios_model');
            if($this->usuarios_model->update($this->input->post('id') , $data)){
                $data['nacimiento'] = exchange_date($data['nacimiento']);
                $data['id'] = $this->input->post('id');
                echo json_encode(array('status' => 'MSG', 'type' => 'success', 'message' => 'El Registro se realiz&oacute; con &eacute;xito' , 'user' => $data));
            }else{
                echo json_encode(array('status' => 'MSG', 'type' => 'error', 'message' => 'El Registro no se pudo realizar, intentelo mas tarde.'));
            }
        }
    }
    public function valida_user($user){
        $this->load->model('usuarios_model');
        if($this->usuarios_model->check_user($user)){
            return true;
        }else{
            $this->form_validation->set_message('valida_user', 'El usuario que proporcionaste ya existe, intenta poner uno nuevo.');
            return false;
        }
    }
    public function valida_user_update($user , $id){
        $this->load->model('usuarios_model');
        if($this->usuarios_model->check_user($user , $id)){
            return true;
        }else{
            $this->form_validation->set_message('valida_user_update', 'El usuario que proporcionaste ya existe, intenta poner uno nuevo.');
            return false;
        }
    }
    public function valida_email($email){
        $this->load->model('usuarios_model');
        if($this->usuarios_model->check_email($email)){
            return true;
        }else{
            $this->form_validation->set_message('valida_email', 'El correo que proporcionaste ya existe, intenta poner uno nuevo.');
            return false;
        }
    }
    public function valida_email_update($email , $id){
        $this->load->model('usuarios_model');
        if($this->usuarios_model->check_email($email , $id)){
            return true;
        }else{
            $this->form_validation->set_message('valida_email_update', 'El correo que proporcionaste ya existe, intenta poner uno nuevo.');
            return false;
        }
    }
    public function valida_pass($pass1, $pass2) {
        if ($pass1 !== $pass2) {
            $this->form_validation->set_message('valida_pass', 'Las contrase&ntilde;as no coinsiden');
            return false;
        } else {
            return true;
        }
    }
    public function valida_pass_blank($pass1) {
        if ($pass1 === 'd41d8cd98f00b204e9800998ecf8427e') {
            $this->form_validation->set_message('valida_pass_blank', 'Ingrese contrase&ntilde;a');
            return false;
        } else {
            return true;
        }
    }
    public function valida_fecha($fecha) {
        $fecha_array = explode('-', $fecha);
        if (count($fecha_array) === 3 && checkdate($fecha_array[1], $fecha_array[0], $fecha_array[2])) {
            $date1 = new DateTime($fecha);
            $date2 = new DateTime(date('d-m-Y'));
            if ($date1 < $date2) {
                return true;
            } else {
                $this->form_validation->set_message('valida_fecha', 'WOW vienes del futuro, mmm :| ya enserio pon una fecha de nacimiento correcta.');
                return false;
            }
        } else {
            $this->form_validation->set_message('valida_fecha', 'La fecha de nacimiento no es v&aacute;lida. Debe estar en este formato "dd-mm-yyyy"');
            return false;
        }
    }
    public function delete(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules("id", "usuario", "xss|required");
        $this->form_validation->set_message("required", "Ocurrio un error. Recarga la página.");
        if ($this->form_validation->run() === FALSE) {
            $errors = validation_errors();
            echo json_encode(array('status' => 'MSG', 'type' => 'warning', "message" => $errors));
        } else {
            $this->load->helper('date_helper');
            $data = array(
                'status' => 0
            );
            $this->load->model('usuarios_model');
            if($this->usuarios_model->update($this->input->post('id') , $data)){
                echo json_encode(array('status' => 'MSG', 'type' => 'success', 'message' => 'El usuario se di&oacute; de baja con &eacute;xito'));
            }else{
                echo json_encode(array('status' => 'MSG', 'type' => 'error', 'message' => 'El Registro no se pudo realizar, intentelo mas tarde.'));
            }
        }
    }
    public function return_user(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules("id", "usuario", "xss|required");
        $this->form_validation->set_message("required", "Ocurrio un error. Recarga la página.");
        if ($this->form_validation->run() === FALSE) {
            $errors = validation_errors();
            echo json_encode(array('status' => 'MSG', 'type' => 'warning', "message" => $errors));
        } else {
            $this->load->helper('date_helper');
            $data = array(
                'status' => 1
            );
            $this->load->model('usuarios_model');
            if($this->usuarios_model->update($this->input->post('id') , $data)){
                echo json_encode(array('status' => 'MSG', 'type' => 'success', 'message' => 'El usuario se di&oacute; de alta con &eacute;xito' , 'user' => $data));
            }else{
                echo json_encode(array('status' => 'MSG', 'type' => 'error', 'message' => 'El Registro no se pudo realizar, intentelo mas tarde.'));
            }
        }
    }
}