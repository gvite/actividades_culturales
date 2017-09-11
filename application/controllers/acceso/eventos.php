<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Eventos extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index($token) {
        header('Access-Control-Allow-Origin: http://localhost:8100');
        //$data = json_decode(file_get_contents('php://input'));
        $this->load->library("Cjwt");
        $this->load->model('asistentes_model');
        try{
            $cJWT = new Cjwt();
            $asistencia = $cJWT->decode($token, JWT_KEY, array('HS256'));
            if(isset($asistencia->data->id)){
                $data = $this->asistentes_model->get_with_user($asistencia->data->id);
                if($data){
                    $this->load->model('datos_alumnos_ex_model');
                    switch($data['tipo_usuario_id']){
                        case 2:case '2':
                            $datos = $this->datos_alumnos_ex_model->get_all_by_user($data['user_id']);
                            if($datos){
                                $data['no_cuenta'] = $datos['no_cuenta'];
                                $data['carrera'] = $datos['carrera'];
                            }else{
                                $data['no_cuenta'] = 'Datos Incompletos';
                                $data['carrera'] = 'Datos Incompletos';
                            }
                            break;
                    }
                    if($data['asistencia'] == 0){
                        if($this->asistentes_model->update($asistencia->data->id , array('asistencia' => 1,'fecha_ingreso'=>date('Y-m-d H:i:s')))){
                            
                            echo json_encode(array("status"=>'OK','alumno' => $data));
                        }else{
                            echo json_encode(array("status" => "ERROR" , 'code' => 1,'message' =>'Error al actualizar el registro'));
                        }
                    }else{
                        echo json_encode(array("status" => "ERROR" , 'code' => 0 , 'alumno' => $data,'message' =>'El alumno ya se registro anteriormente: ' . $data['fecha_ingreso']));
                    }   
                }else{
                    echo json_encode(array("status" => "ERROR" , 'code' => 2,'message' =>'El registro no existe'));
                }
            }else{
                echo json_encode(array("status" => "ERROR","code" => 3,'message' =>'El código Qr no pertence a la aplicación'));
            }
        }catch(Exception $e){
            echo json_encode(array("status" => "ERROR" , 'code' => 4,'message' =>'El código Qr no pertence a la aplicación'));
        }
    }

}

?>
