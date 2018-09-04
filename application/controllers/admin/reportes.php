<?php

class Reportes extends CI_Controller {

    private $vista_pdf = '';
    private $css_pdf = '';
    private $csv_rows = array();

    public function __construct() {
        parent::__construct();
        $this->load->model('talleres_semestre_model');
        $this->load->helper('date');
        $this->load->model('taller_semestre_horario_model');
        //$this->load->library('archivos');
    }

    public function carrera() {
        $this->load->model('semestres_model');
        $this->load->model('carreras_model');
        $this->load->helper(array('url', 'sesion', 'date'));
        $data['active'] = 'reportes';
        $data['semestre_actual'] = $this->semestres_model->get_actual();
        if ($data['semestre_actual']) {
            $data['puede_inscribir'] = $this->semestres_model->puede_insc($data['semestre_actual']['id']);
        } else {
            $data['puede_inscribir'] = false;
        }
        $data['js'] = 'js/reporte1.js';
        $this->load->view('main/header_view', $data);
        $data['carreras'] = $this->carreras_model->get_all();
        $data['semestres'] = $this->semestres_model->get_all_order_by_inicio();
        $this->load->view('admin/reportes/reporte1_view', $data);
        $this->load->view('main/footer_view', '');
    }

    public function presupuesto1() {
        $this->load->model('semestres_model');
        $this->load->model('carreras_model');
        $this->load->helper(array('url', 'sesion', 'date'));
        $data['active'] = 'reportes';
        $data['semestre_actual'] = $this->semestres_model->get_actual();
        if ($data['semestre_actual']) {
            $data['puede_inscribir'] = $this->semestres_model->puede_insc($data['semestre_actual']['id']);
        } else {
            $data['puede_inscribir'] = false;
        }
        $data['js'] = 'js/presupuesto1.js';
        $this->load->view('main/header_view', $data);
        $this->load->helper('date');
        $data['semestres'] = $this->semestres_model->get_all_order_by_inicio();
        $this->load->view('admin/reportes/reporte2_view', $data);
        $this->load->view('main/footer_view', '');
    }

    public function presupuesto2() {
        $this->load->model('semestres_model');
        $this->load->model('carreras_model');
        $this->load->helper(array('url', 'sesion', 'date'));
        $data['active'] = 'reportes';
        $data['semestre_actual'] = $this->semestres_model->get_actual();
        if ($data['semestre_actual']) {
            $data['puede_inscribir'] = $this->semestres_model->puede_insc($data['semestre_actual']['id']);
        } else {
            $data['puede_inscribir'] = false;
        }
        $data['js'] = 'js/presupuesto2.js';
        $this->load->view('main/header_view', $data);
        $this->load->helper('date');
        $data['semestres'] = $this->semestres_model->get_all_order_by_inicio();
        $this->load->view('admin/reportes/reporte3_view', $data);
        $this->load->view('main/footer_view', '');
    }

    public function genera_carrera() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules("tipo_alumno", "Tipo de Alumno", "xss|required");
        $this->form_validation->set_rules("carrera", "Carrera", "xss|required");
        $this->form_validation->set_rules("semestre", "Semestre", "xss|required");
        $this->form_validation->set_message("required", "Introduce %s");
        if ($this->form_validation->run() == FALSE) {
            $errors = validation_errors();
            echo json_encode(array('status' => 'MSG', 'type' => 'warning', "message" => $errors));
        } else {
            $tipo_alumno = $this->input->post('tipo_alumno');
            $carrera = $this->input->post('carrera');
            $semestre = $this->input->post('semestre');
            $alumno_completo = $this->input->post('alumno_completo');
            $tipo_archivo = $this->input->post('tipo_archivo');
            $this->load->model('reportes_model');
            $data['talleres'] = $this->reportes_model->get_alumnos_talleres($tipo_alumno, $carrera, $semestre);
            if($alumno_completo == 1 && is_array($data['talleres'])){
                foreach($data['talleres'] as $key => $taller){
                    $data['talleres'][$key]['alumnos'] = $this->reportes_model->get_alumnos_names_talleres($tipo_alumno, $taller['id'], $carrera, $semestre);
                }
            }
            if ($carrera == 0) {
                $data['carrera']['carrera'] = 'Todas las carreras';
            } else {
                $this->load->model('carreras_model');
                $data['carrera'] = $this->carreras_model->get($carrera);
            }
            if($semestre != 0){
                $this->load->model('semestres_model');
                $data["semestre"] = $this->semestres_model->get($semestre);
            }else{
                $data["semestre"] = false;
            }
            if($tipo_archivo == 2){
                if($alumno_completo == 1){
                    $this->vista_pdf = $this->load->view('admin/reportes/reporte1a_pdf', $data, true);
                }else{
                    $this->vista_pdf = $this->load->view('admin/reportes/reporte1_pdf', $data, true);
                }
                $this->css_pdf = $this->load->view('admin/reportes/reporte1_css', '', true);
                $file = $this->genera_pdf('reporte1');
            }else{
                $this->csv_rows = array();
                $this->csv_rows[] =  array("Semestre: " . strtoupper(($data["semestre"]) ? $data["semestre"]['semestre'] : "Todo"));
                $this->csv_rows[] =  array("Carrera: " . $data["carrera"]['carrera']);
                $this->csv_rows[] =  array("Taller","No. Alumnos");

                if($alumno_completo == 1){
                    if (is_array($data["talleres"])) {
                        foreach ($data["talleres"] as $taller) {
                            $this->csv_rows[] = array();
                            $this->csv_rows[] = array("","Taller: " . utf8_decode($taller['taller']));
                            $this->csv_rows[] = array("",utf8_decode("Número de alumnos: ") . $taller['num_alumnos']);
                            $this->csv_rows[] = array("No", "Alumno", "No. Cta" , "Carrera");
                            foreach ($taller['alumnos'] as $key => $alumno) {
                                $this->csv_rows[] = array(
                                    $key + 1,
                                    utf8_decode($alumno['nombre'] . " " . $alumno['paterno'] . ' ' . $alumno['materno']),
                                    $alumno['no_cuenta'],
                                    utf8_decode($alumno['carrera'])
                                );
                            }
                        }
                    }else{
                        $this->csv_rows[] = array();
                        $this->csv_rows[] =  array("No hay registros");
                    }
                }else{
                    if (is_array($data["talleres"])) {
                        $total = 0;
                        foreach ($data["talleres"] as $taller) {
                            $this->csv_rows[] = array(utf8_decode($taller['taller']), $taller['num_alumnos']);
                            $total += $taller['num_alumnos'];
                        }
                        $this->csv_rows[] = array("Total", $total);
                    }
                    $this->csv_rows[] = array();
                    $this->csv_rows[] =  array("No hay registros");
                }

                $file = $this->genera_csv('reporte1');
            }
            if ($file !== false) {
                echo json_encode(array('status' => 'OK', "file" => $file));
            } else {
                echo json_encode(array('status' => 'MSG', 'type' => 'error', "message" => 'No se pudo crear el archivo.'));
            }
        }
    }

    public function genera_presupuesto1() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules("fecha_inicio", "Fecha de Inicio", "xss|required");
        $this->form_validation->set_rules("fecha_termino", "Fecha de Termino", "xss|required");
        $this->form_validation->set_rules("semestre", "Semestre", "xss|required");
        $this->form_validation->set_rules("tamanio_fuente", "Tama&ntilde;o de fuente", "xss|integer");
        $this->form_validation->set_rules("no_reg", "No. de registros", "xss|integer");
        $this->form_validation->set_message("required", "Introduce %s");
        $this->form_validation->set_message("integer", "%s debe de ser numerico.");
        if ($this->form_validation->run() == FALSE) {
            $errors = validation_errors();
            echo json_encode(array('status' => 'MSG', 'type' => 'warning', "message" => $errors));
        } else {
            $inicio = $this->input->post('fecha_inicio');
            $termino = $this->input->post('fecha_termino');
            $this->load->model('reportes_model');
            $this->load->model('semestres_model');
            $data['semestre'] = $this->semestres_model->get($this->input->post('semestre'));
            $alumnos = $this->reportes_model->getPresupuesto1(exchange_date($inicio), exchange_date($termino));
            $tamanio = $this->input->post('tamanio_fuente');
            $no_reg = $this->input->post('no_reg');
            $tipo_archivo = $this->input->post('tipo_archivo');
            $this->csv_rows = array();
            if ($no_reg != '') {
                $limite = $no_reg;
            } else {
                $limite = 50;
            }
            $fuentes = array(
                'helvetica',
                'courier',
                'times',
                'franklin'
            );
            $data['font'] = ($this->input->post('fuente') != '' && isset($fuentes[(int) $this->input->post('fuente')])) ? $fuentes[(int) $this->input->post('fuente')] : false;
            if($tipo_archivo == 2){
                if (is_array($alumnos) && count($alumnos) > $limite) {
                    $this->vista_pdf = array();
                    $new_alumnos = array_chunk($alumnos, $limite);
                    $total = 0;
                    foreach ($alumnos as $alumno) {
                        $total += $alumno['aportacion'] - $alumno["beca"];
                    }
                    foreach ($new_alumnos as $key => $alumno_aux) {
                        $data['alumnos'] = $alumno_aux;
                        if ($key == (count($new_alumnos) - 1)) {
                            $data['total'] = $total;
                        }
                        $data['pagina'] = $key + 1;

                        $this->vista_pdf[] = $this->load->view('admin/reportes/reporte2_pdf', $data, true);
                    }
                } else {
                    $data['alumnos'] = $alumnos;
                    $data['pagina'] = 1;
                    $this->vista_pdf = $this->load->view('admin/reportes/reporte2_pdf', $data, true);
                }
            }else{
                $this->csv_rows[] = array(
                    "Semestre: ",
                    utf8_decode($data["semestre"]['semestre'])
                );
                $this->csv_rows[] = array();
                $this->csv_rows[] = array(
                    "No. Recibo",
                    "Fecha",
                    "Importe",
                    "Nombre",
                    "Taller",
                    "Carrera"
                );
                if (is_array($alumnos)) {
                    setlocale(LC_MONETARY, 'en_US');
                    $total_taller = 0;
                    $taller_ant = null;
                    $total = 0;
                    foreach ($alumnos as $alumno) {
                        $total += $alumno['aportacion'] - $alumno["beca"];
                        if($taller_ant == null){
                            $taller_ant = $alumno['taller'];
                        }
                        $beca = $alumno["beca"];
                        if($alumno['taller'] !== $taller_ant){
                            $this->csv_rows[] = array(
                                "",
                                "",
                                "",
                                "",
                                "",
                                "Subtotal",
                                money_format('%n', $total_taller)
                            );    
                            $total_taller = $alumno['aportacion'] - $beca;
                            $taller_ant = null;
                        }else{
                            $total_taller += $alumno['aportacion'] - $beca;
                        }
                        $carrera = "";
                        switch ($alumno['tipo_usuario_id']) {
                            case '2':
                                $carrera = $alumno['carrera'];
                                break;
                            case '3':
                                $carrera = 'Exalumno';
                                break;
                            case '4':
                                $carrera = 'Trabajador';
                                break;
                            case '5':
                                $carrera = 'Externo';
                                break;
                        }
                        $this->csv_rows[] = array(
                            ($alumno['folio_caja'] !== null) ? $alumno['folio_caja'] : 'N/A',
                            exchange_date($alumno['fecha_caja']),
                            money_format('%n', $alumno['aportacion'] - $beca),
                            utf8_decode(ucfirst(strtolower($alumno['paterno'])) . ' ' . ucfirst(strtolower($alumno['materno'])) . ' ' . ucwords(strtolower($alumno['nombre']))),
                            utf8_decode($alumno['taller']),
                            utf8_decode($carrera)
                        );
                        
                    }
                    $this->csv_rows[] = array(
                        "",
                        "",
                        "",
                        "",
                        "",
                        "Subtotal",
                        money_format('%n', $total_taller)
                    );
                    $this->csv_rows[] = array(
                        "",
                        "",
                        "",
                        "",
                        "",
                        "Total",
                        money_format('%n', $total)
                    );
                }else{
                    $this->csv_rows[] = array("No hay registros");
                }
            }
            if($tipo_archivo == 2){
                $data = array(
                    'font_size' => ($tamanio != '') ? $tamanio : 8
                );
                $this->css_pdf = $this->load->view('admin/reportes/reporte2_css', $data, true);
                //echo json_encode(array('status' => 'OK' , 'd' => $this->vista_pdf));
                $file = $this->genera_pdf('reporte2');
            }else{
                $file = $this->genera_csv('reporte2');
            }
            if ($file !== false) {
                echo json_encode(array('status' => 'OK', "file" => $file));
            } else {
                echo json_encode(array('status' => 'MSG', 'type' => 'error', "message" => 'No se pudo crear el archivo.'));
            }
        }
    }

    public function genera_presupuesto2() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules("semestre", "Semestre", "xss|required");
        $this->form_validation->set_rules("fecha_inicio", "Fecha de Inicio", "xss|required");
        $this->form_validation->set_rules("fecha_termino", "Fecha de Termino", "xss|required");
        $this->form_validation->set_message("required", "Introduce %s");
        if ($this->form_validation->run() == FALSE) {
            $errors = validation_errors();
            echo json_encode(array('status' => 'MSG', 'type' => 'warning', "message" => $errors));
        } else {
            $this->load->model('talleres_model');
            $this->load->model('semestres_model');
            $this->load->model('reportes_model');
            $semestre = $this->input->post('semestre');
            $inicio = exchange_date($this->input->post('fecha_inicio'));
            $termino = exchange_date($this->input->post('fecha_termino'));
            $data['semestre'] = $this->semestres_model->get($semestre);
            $data['talleres'] = $this->talleres_model->get_all_by_semestre_order($semestre);
            $tipo_archivo = $this->input->post('tipo_archivo');
            //$data['talleres'] = false;
            if (is_array($data['talleres'])) {
                foreach ($data['talleres'] as $key => $taller) {
                    $data['talleres'][$key]['uni'] = $this->reportes_model->getUsuarioByTaller($taller['id'], 2, $semestre, $inicio,$termino);
                    $data['talleres'][$key]['exuni'] = $this->reportes_model->getUsuarioByTaller($taller['id'], 3, $semestre, $inicio,$termino);
                    $data['talleres'][$key]['traba'] = $this->reportes_model->getUsuarioByTaller($taller['id'], 4, $semestre, $inicio,$termino);
                    $data['talleres'][$key]['exter'] = $this->reportes_model->getUsuarioByTaller($taller['id'], 5, $semestre, $inicio,$termino);
                }
                $data['meses'] = $this->reportes_model->getSumBySemestreMonth($semestre ,$inicio,$termino );
            }
            $this->load->helper('date');
            if($tipo_archivo == 2){
                $this->vista_pdf = $this->load->view('admin/reportes/reporte3_pdf', $data, true);
                $this->css_pdf = $this->load->view('admin/reportes/reporte3_css', '', true);
                $header = '<img src="images/logo_pdf.jpg" style="top:-15px;" />';
                $file = $this->genera_pdf('reporte3', '', $header);
            }else{
                $mes_name = array(
                    1 => "Enero",
                    2 => "Febrero",
                    3 => "Marzo",
                    4 => "Abril",
                    5 => "Mayo",
                    6 => "Junio",
                    7 => "Julio",
                    8 => "Agosto",
                    9 => "Septiembre",
                    10 => "Octubre",
                    11 => "Noviembre",
                    12 => "Diciembre"
                );
                $this->csv_rows[] = array(
                    "Semestre: ",
                    utf8_decode($data["semestre"]['semestre'])
                );
                $this->csv_rows[] = array();
                $this->csv_rows[] = array(
                    "Taller",
                    "Universitarios",
                    "Egresados",
                    "Trabajadores",
                    "Externos",
                    "Total",
                    "Ingreso"
                );
                setlocale(LC_MONETARY, 'en_US');
                if (is_array($data["talleres"])) {
                    $total = array(
                        'uni' => 0,
                        'exuni' => 0,
                        'traba' => 0,
                        'exter' => 0,
                        'suma' => 0
                    );
                    foreach ($data["talleres"] as $taller) {
                        $this->csv_rows[] = array(
                            utf8_decode($taller['taller']),
                            $taller['uni']['count_user'],
                            $taller['exuni']['count_user'],
                            $taller['traba']['count_user'],
                            $taller['exter']['count_user'],
                            $taller['uni']['count_user'] + $taller['exuni']['count_user'] + $taller['exter']['count_user'] + $taller['traba']['count_user'],
                            money_format( '%n' , $taller['uni']['suma'] + $taller['exuni']['suma'] + $taller['exter']['suma'] + $taller['traba']['suma'] - $taller['uni']['beca_sum'] - $taller['exuni']['beca_sum'] - $taller['exter']['beca_sum'] - $taller['traba']['beca_sum'])
                        );
                        $total['uni'] += $taller['uni']['count_user'];
                        $total['exuni'] += $taller['exuni']['count_user'];
                        $total['traba'] += $taller['traba']['count_user'];
                        $total['exter'] += $taller['exter']['count_user'];
                        $total['suma'] += $taller['uni']['suma'] + $taller['exuni']['suma'] + $taller['exter']['suma'] + $taller['traba']['suma'] - $taller['uni']['beca_sum'] - $taller['exuni']['beca_sum'] - $taller['exter']['beca_sum'] - $taller['traba']['beca_sum'];
                    }
                    $this->csv_rows[] = array();
                    $this->csv_rows[] = array(
                        "Total",
                        $total['uni'],
                        $total['exuni'],
                        $total['traba'],
                        $total['exter'],
                        $total['uni'] + $total['exuni'] + $total['traba'] + $total['exter'],
                        money_format('%n', $total['suma'])
                    );
                    if(is_array($data['meses'])){
                        $total = 0;
                        foreach($data['meses'] as $mes){
                            $this->csv_rows[] = array(
                                $mes_name[$mes['mes']],
                                money_format('%n', $mes['suma'] - $mes['beca_sum'])
                            );
                            $total += $mes['suma'] - $mes["beca_sum"];
                        }
                        $this->csv_rows[] = array(
                            "Total",
                            money_format('%n', $total)
                        );
                    }
                }else{
                    $this->csv_rows[] = array("No hay registros");
                }
                $file = $this->genera_csv('reporte3');
            }
            if ($file !== false) {
                echo json_encode(array('status' => 'OK', "file" => $file,'lq' => $data['meses']));
            } else {
                echo json_encode(array('status' => 'MSG', 'type' => 'error', "message" => 'No se pudo crear el archivo.'));
            }
        }
    }

    private function genera_pdf($folder = '', $name = '', $header = '', $position = 'P') {
        $this->load->helper(array('url', 'sesion', 'date'));
        $this->load->library(array('mpdf', 'archivos'));
        ini_set("memory_limit", "1024M");
        $mpdf = new mPDF();
        $mpdf->SetProtection(array('copy', 'print'));
        if ($header !== '') {
            $mpdf->SetHTMLHeader($header);
        }
        $mpdf->WriteHTML($this->css_pdf, 1);
        if (is_array($this->vista_pdf)) {
            foreach ($this->vista_pdf as $vista) {
                $mpdf->AddPage($position); // L - landscape, P - portrait
                $mpdf->WriteHTML($vista, 2);
            }
        } else {
            $mpdf->AddPage($position); // L - landscape, P - portrait
            $mpdf->WriteHTML($this->vista_pdf, 2);
        }
        //$footer = $this->load->view('alumnos/comprobante_footer_view' , $data1 , true);
        //$mpdf->SetHTMLFooter($footer);
        $route = str_replace("\\", "/", FCPATH) . "uploads/reportes/" . $folder . '/';
        if ($this->archivos->create_folder($route)) {
            $file = $name . date('d_m_y') . '.pdf';
            $mpdf->Output($route . $file, 'F');
            return base_url() . 'uploads/reportes/' . $folder . '/' . $file;
        } else {
            ///echo json_encode(array('status' => 'MSG', 'type' => 'error', "message" => 'No se pudo crear la carpeta de usuario'));
            return false;
        }
    }
    public function genera_csv($folder = '', $name = ''){
        $route = str_replace("\\", "/", FCPATH) . "uploads/reportes/" . $folder . '/';
        $file = $name . date('d_m_y') . '.csv';
        $FH = fopen($route . $file, 'w');
        // fprintf($FH, chr(0xEF).chr(0xBB).chr(0xBF));
        foreach ($this->csv_rows as $row) {
            fputcsv($FH, $row);
        }
        fclose($FH);
        return base_url() . 'uploads/reportes/' . $folder . '/' . $file;
    }

    public function insert_aportacion() {
        $this->load->model("baucher_model");
        $inscripciones = $this->baucher_model->get_by_semestre(3);
        if (is_array($inscripciones)) {
            foreach ($inscripciones as $ins) {
                $costo = false;
                if ($ins['tipo_usuario_id'] == 2) {
                    $costo = $ins['costo_alumno'];
                } else if ($ins['tipo_usuario_id'] == 3) {
                    $costo = $ins['costo_exalumno'];
                } else if ($ins['tipo_usuario_id'] == 4) {
                    $costo = $ins['costo_trabajador'];
                } else {
                    $costo = $ins['costo_externo'];
                }
                $data = array('aportacion' => $costo);
                $this->baucher_model->update($ins['id'], $data);
            }
        }
    }

    public function get_registros_reportes() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules("fecha_inicio", "Fecha de Inicio", "xss|required");
        $this->form_validation->set_rules("fecha_termino", "Fecha de Termino", "xss|required");
        $this->form_validation->set_rules("semestre", "Semestre", "xss|required");
        $this->form_validation->set_message("required", "Introduce %s");
        if ($this->form_validation->run() == FALSE) {
            $errors = validation_errors();
            echo json_encode(array('status' => 'MSG', 'type' => 'warning', "message" => $errors));
        } else {
            $inicio = $this->input->post('fecha_inicio');
            $termino = $this->input->post('fecha_termino');
            $this->load->model('reportes_model');
            $this->load->model('semestres_model');
            $data['semestre'] = $this->semestres_model->get($this->input->post('semestre'));
            $alumnos = $this->reportes_model->getPresupuesto1(exchange_date($inicio), exchange_date($termino));
            $data['alumnos'] = $alumnos;
            $this->load->helper('url');
            $container = $this->load->view('admin/reportes/reporte2_preview_pdf', $data, true);
            echo json_encode(array('status' => 'OK', "container" => $container));
        }
    }

}
