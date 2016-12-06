<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Rebaucher extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->load->model(array('baucher_model' , "baucher_talleres_model"));
        $bauchers = $this->baucher_model->get_all();
        foreach($bauchers as $baucher){
            $talleresB = $this->baucher_talleres_model->get_one_by_baucher_taller($baucher["id"]);
            if(is_array($talleresB)){
                $data = array(
                    "aportacion" => $talleresB[0]["aportacion"],
                    "extra" => $talleresB[0]["extra"],
                    "taller_semestre_id" => $talleresB[0]["taller_semestre_id"],
                    "beca" => $talleresB[0]["beca"]
                );
                $this->baucher_model->update($baucher["id"] , $data);
                if(count($talleresB) > 1){
                    $data['usuario_id'] = $baucher["usuario_id"];
                    $data['fecha_expedicion'] = $baucher["fecha_expedicion"];
                    $data['status'] = $baucher["status"];
                    $data['folio_caja'] = $baucher["folio_caja"];
                    $data['fecha_caja'] = $baucher["fecha_caja"];
                    foreach($talleresB as $key => $bt){
                        if($key > 0){
                            $folio = -1;
                            $exito = true;
                            while ($exito) {
                                $folio = mt_rand(1, 2147483647);
                                if ($this->baucher_model->check_folio_free($folio)) {
                                    $exito = false;
                                }
                            }
                            $data['folio'] = $folio;
                            $data["taller_semestre_id"] = $bt["taller_semestre_id"];
                            $data["aportacion"] = $bt["aportacion"];
                            $data["extra"] = $bt["extra"];
                            $data["beca"] = $bt["beca"];
                            $this->baucher_model->insert($data);
                        }
                    }
                }
            }
        }
        echo "Exito.";
    }

}
?>