<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
if ($tiempo !== false) {
    ?>
    <div class="row pull-right" id="content_count">
        <div><p>Inscripci&oacute;n inicia en:</p></div>
        <div id="counter" data-time="<?php echo $tiempo ?>"></div>
    </div>
<?php } ?>
<div class="row">
<!--    <div class="col-md-12">
        <h3>Candidatos a inscribirse al Taller de Piano:</h3>
        <p>Inmediatamente después de haber obtenido el voucher que genera el sistema, favor de presentarlo en el Departamento de Actividades Culturales, como parte indispensable de su procedimiento de inscripción. Las inscripciones que no atiendan a este requerimiento serán canceladas.</p>
    </div>-->
    <div class="col-md-12">
        <?php
        if (is_array($talleres)) {
            $count = 0;
            foreach ($talleres as $taller) {
                if ($count == 0) {
                    ?>
                    <div class="row">
                        <?php
                    }
                    ?>
                    <div class="col-md-3">
                        <div class="panel panel-info panel-talleres">
                            <div class="panel-heading" style="background-image: url(images/talleres/<?php echo $taller['id'] . '_image' ?>.jpg)"><h3 style="background-image: url(images/titulo_trasnparencia.png)"><?php echo $taller['taller'] ?></h3></div>
                            <div class="panel-body">
                                <a href="admin/talleres/get_info/<?php echo $taller['id'] ?>" class="btn btn-link">M&aacute;s informaci&oacute;n..</a>
                            </div>
                        </div>
                    </div>
                    <?php
                    $count++;
                    if ($count == 4) {
                        $count = 0;
                        ?>
                    </div>
                    <?php
                }
            }
            if ($count > 0 && $count < 4) {
                echo '</div>';
            }
        }else{
            ?>
            <p style="font-size:20px;padding: 30px 0 30px 0;text-align:center;">Por el momento no se encuentran talleres para inscribir. <br />Sigue al pendiente de las inscripciones.<br />¡Gracias por tu atención!</p>
            <?php
        }
        ?>
    </div>
</div>
<?php
if (get_type_user() != 1 && $talleres !== false) {
    ?>
    <div class="row">
        <div class="col-md-12">
            <strong>Requisitos para terminar inscripci&oacute;n:</strong>
        </div>
    </div>
    <div class="row" id="requisitos_inscripcion">
        <?php
        if (get_type_user() == 2 || get_type_user() === false) {
            ?>
            <div class="bs-callout bs-callout-primary">
                <h4>Alumnos</h4>
                <ul>
                    <!--<li>Original y Copia de credencial de alumno</li>
                    <li>Presentar Original y copia del voucher generado para validar la inscripci&oacute;n en el Departamento de Actividades Culturales</li>
                    <li>Ticket de caja en original y 2 copia</li>
                    <li>Comprobante de inscripción al semestre 2016-2</li>-->
                    <li>Original y Copia de credencial de alumno</li>
                    <li>Presentar Original y copia del voucher generado para validar la inscripción en el Departamento de Actividades Culturales</li>
                </ul>
            </div>
            <?php
        }
        if (get_type_user() == 4 || get_type_user() === false) {
            ?>
            <div class="bs-callout bs-callout-primary">
                <h4>Trabajadores</h4>
                <ul>
                    <!--<li>Original y Copia de credencial de trabajador</li>
                    <li>Presentar Original y copia del voucher generado para validar la inscripci&oacute;n en el Departamento de Actividades Culturales</li>
                    <li>Ticket de caja en original y 2 copia</li>-->
                    <li>Original y Copia de credencial de trabajador</li>
                    <li>Presentar Original y copia del voucher generado para validar la inscripción en el Departamento de Actividades Culturales.</li>
                </ul>
            </div>
            <?php
        }
        if (get_type_user() == 3 || get_type_user() === false) {
            ?>
            <div class="bs-callout bs-callout-primary">
                <h4>Exalumnos</h4>
                <ul>
                    <!--<li>Original y Copia de credencial de ex-alumno o Identificaci&oacute;n oficial + Historial academico</li>
                        <li>Presentar Original y copia del voucher generado para validar la inscripci&oacute;n en el Departamento de Actividades Culturales</li>
                        <li>Ticket de caja en original y 2 copia</li>-->
                        <li>Original y Copia de credencial de ex-alumno o Identificación oficial + Historial academico</li>
                        <li>Presentar Original y copia del voucher generado para validar la inscripción en el Departamento de Actividades Culturales</li>
                        <li>Ticket de caja en original y 2 copias.</li>
                </ul>
            </div>
            <?php
        }
        if (get_type_user() == 5 || get_type_user() === false) {
            ?>
            <div class="bs-callout bs-callout-primary">
                <h4>Externos</h4>
                <ul>
                    <!--<li>Original y copia de identificaci&oacute;n oficial.</li>
                    <li>Presentar Original y copia del voucher generado para validar la inscripci&oacute;n en el Departamento de Actividades Culturales</li>
                    <li>Ticket de caja en original y 2 copia</li>-->
                    <li>Original y copia de identificación oficial.</li>
                    <li>Presentar Original y copia del voucher generado para validar la inscripción en el Departamento de Actividades Culturales</li>
                    <li>Ticket de caja en original y 2 copias</li>
                </ul>
            </div>
            <?php
        }
        ?>
    </div>
    <?php
}
?>
<div class="row">
    <div class="modal fade active" id="informacion_modal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
</div>
