<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Migracion extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function profesores() {
        $this->load->library('apiactcul');
        $this->load->model('profesores_model');
        $profesores = $this->profesores_model->get_all();
        foreach($profesores as $profe){
            $data = array(
                'name' => $profe['nombre'],
                'lastname' => $profe['paterno'],
                'surname' => $profe['materno'],
                'email' => $profe['id'] . "abc@gmail.com",
                'gender' => "Maculino",
                'password' => "P12345",
                'password_confirmation' => "P12345"
            );
            $this->apiactcul->addTeacher($data);
        }
        echo "Exito";
    }

}
