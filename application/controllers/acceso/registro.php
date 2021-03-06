<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Registro extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->load->helper(array('url', 'sesion'));
        $this->load->model('carreras_model');
        $this->load->model('facultades_model');
        $this->load->model('ocupaciones_model');
        $data['js'][] = 'js/registro.js';
        $data['js'][] = 'js/acceso.js';
        $data['no_menu'] = true;
        $data['active'] = "";
        $data['hide_menu'] = true;
        $data["return_url"] = $this->input->get("return-url");
        $this->load->view('main/header_view', $data);
        $data['carreras'] = $this->carreras_model->get_all();
        $data['facultades'] = $this->facultades_model->get_all();
        $data['ocupaciones'] = $this->ocupaciones_model->get_all();
        $this->load->view('acceso/registro_view', $data);
        $this->load->view('acceso/login_view', $data);
        $this->load->view('main/footer_view', '');
    }

    public function insert() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules("user", "Usuario", "xss|required|alpha_dash|callback_valida_user");
        $this->form_validation->set_rules("pass", "Contrase&ntilde;a", "xss|required|callback_valida_pass[" . $this->input->post('repass') . "]");
        $this->form_validation->set_rules("repass", "Repite contrase&ntilde;a", "xss|required");
        $this->form_validation->set_rules("name_user", "Nombre", "xss|required");
        $this->form_validation->set_rules("paterno_user", "Apellido Paterno", "xss|required");
        $this->form_validation->set_rules("materno_user", "Apellido Materno", "xss");
        $this->form_validation->set_rules("correo_user", "E-Mail", "xss|required|valid_email|callback_valida_email");
        $this->form_validation->set_rules("telefono_fijo", "Teléfono Fijo", "xss");
        $this->form_validation->set_rules("celular", "Teléfono Fijo", "xss|required");
        $this->form_validation->set_rules("correo_user", "E-Mail", "xss|required|valid_email|callback_valida_email");
        $this->form_validation->set_rules("nacimiento_user", "Fecha de Nacimiento", "xss|required|callback_valida_fecha");
        $this->form_validation->set_rules("type_user", "Tipo de usuario", "xss|required|is_natural_no_zero");
        $this->form_validation->set_rules("direccion", "Dirección", "xss");
        $this->form_validation->set_rules("clinica", "Dirección", "xss");
        $this->form_validation->set_rules("num_clinica", "Número de clínica", "xss");
        $this->form_validation->set_rules("sexo", "Sexo", "xss|required");
        $this->form_validation->set_message("required", "Introduce %s");
        $this->form_validation->set_message("valid_email", "Introduce un correo v&aacute;lido");
        $this->form_validation->set_message("alpha_dash", "%s: sólo se permite caracteres alfanuemericos.");
        $this->form_validation->set_message("is_natural_no_zero", "Introduce un %s v&aacute;lido");
        $tipo = $this->input->post('type_user');
        if ($tipo == 2 || $tipo == 3) {
            $this->form_validation->set_rules("num_cuenta", "N&uacute;mero de cuenta", "xss|required|exact_length[9]|callback_valida_nocta");
            $this->form_validation->set_rules("facultad", "Facultad", "xss|required");
            $this->form_validation->set_rules("carrera", "Carrera", "xss|required");
            $this->form_validation->set_rules("ingreso_egreso", "Tipo de usuario", "xss|required");
            $this->form_validation->set_rules("semestre", "Semestre", "xss|required|is_natural_no_zero");
            $this->form_validation->set_message("exact_length", "El n&uacute;mero de cuenta debe tener una longitud de 9");
        } else if ($tipo == 4) {
            $this->form_validation->set_rules("facultad_t", "Facultad", "xss|required");
            $this->form_validation->set_rules("num_trabajador", "N&uacute;mero de Trabajador", "xss|required");
            $this->form_validation->set_rules("turno_prof", "Turno", "xss|required");
            $this->form_validation->set_rules("area", "Area", "xss|required");
        } else if ($tipo == 5) {
            $this->form_validation->set_rules("direccion", "Direcci&oacute;n", "xss|required");
            $this->form_validation->set_rules("ocupacion", "Ocupaci&oacute;n", "xss|required");
        }
        if ($this->form_validation->run() === FALSE) {
            $errors = validation_errors();
            echo json_encode(array('status' => 'MSG', 'type' => 'warning', "message" => $errors));
        } else {
            $this->load->helper('date_helper');
            $data = array(
                'nombre' => $this->input->post('name_user'),
                'paterno' => $this->input->post('paterno_user'),
                'materno' => $this->input->post('materno_user'),
                'nickname' => $this->input->post('user'),
                'pass' => $this->input->post('pass'),
                'email' => $this->input->post('correo_user'),
                'nacimiento' => exchange_date($this->input->post('nacimiento_user')),
                'status' => 1,
                'tipo_usuario_id' => $tipo,
                'telefono_fijo' => $this->input->post('telefono_fijo'),
                'celular' => $this->input->post('celular'),
                'fecha_reg' => date("Y-m-d H:i:s"),
                'clinica' => $this->input->post("clinica"),
                'num_clinica' => $this->input->post("num_clinica"),
                'direccion' => $this->input->post("direccion"),
                'sexo' => $this->input->post("sexo")
            );
            $this->load->model('usuarios_model');
            $id = $this->usuarios_model->insert($data);
            if($id){
                $data2 = array(
                    'usuario_id' => $id
                );
                $id_datos = false;
                if ($tipo == 2 || $tipo == 3) {
                    $data2['no_cuenta'] = $this->input->post('num_cuenta');
                    $data2['ingreso_egreso'] = $this->input->post('ingreso_egreso');
                    $data2['carrera_id'] = $this->input->post('carrera');
                    $data2['facultad_id'] = $this->input->post('facultad');
                    $data2['semestre'] = $this->input->post('semestre');
                    $this->load->model('datos_alumnos_ex_model');
                    $id_datos = $this->datos_alumnos_ex_model->insert($data2);
                } else if ($tipo == 4) {
                    $data2['no_trabajador'] = $this->input->post('num_trabajador');
                    $data2['facultad_id'] = $this->input->post('facultad_t');
                    $data2['turno'] = $this->input->post('turno_prof');
                    $data2['area'] = $this->input->post('area');
                    $this->load->model('datos_trabajador_model');
                    $id_datos = $this->datos_trabajador_model->insert($data2);
                } else if ($tipo == 5) {
                    $data2['direccion'] = $this->input->post('direccion');
                    $data2['ocupacion_id'] = $this->input->post('ocupacion');
                    $this->load->model('datos_externo_model');
                    $id_datos = $this->datos_externo_model->insert($data2);
                }
                if($id_datos){
                    $this->load->helper('sesion');
                    $this->load->model('tipo_usuario_model');
                    $type = $this->tipo_usuario_model->get($data['tipo_usuario_id']);
                    set_user($data['nickname']);
                    if($type !== false){
                        set_type($type['tipo']);
                        set_type_user($type['id']);
                    }
                    set_name($data['nombre']);
                    set_id($id);
                    echo json_encode(array('status' => 'MSG', 'type' => 'success', 'message' => 'El Registro se realiz&oacute; con &eacute;xito' , "return_url" => $this->input->post("return_url")));
                }else{
                    echo json_encode(array('status' => 'MSG', 'type' => 'error', 'message' => 'El Registro no se pudo realizar, intentelo mas tarde.'));
                }
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
    public function valida_email($email){
        $this->load->model('usuarios_model');
        if($this->usuarios_model->check_email($email)){
            return true;
        }else{
            $this->form_validation->set_message('valida_email', 'El correo que proporcionaste ya existe, intenta poner uno nuevo.');
            return false;
        }
    }
    public function valida_nocta($no_cuenta){
        $this->load->model('datos_alumnos_ex_model');
        if($this->datos_alumnos_ex_model->check_cta($no_cuenta)){
            return true;
        }else{
            $this->form_validation->set_message('valida_nocta', 'El número de cuenta que proporcionaste ya existe, intenta poner uno nuevo.');
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

    public function check_user(){
        $user = $this->input->post('user');
        $this->load->model('usuarios_model');
        if($this->usuarios_model->check_user($user)){
            echo json_encode(array('status' => 'OK'));
        }else{
            echo json_encode(array('status' => 'EXIST'));
        }
    }

}

?>
