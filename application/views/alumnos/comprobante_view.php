<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?>
<div id="encabezado">
    <h3>UNIVERSIDAD NACIONAL AUT&Oacute;NOMA DE M&Eacute;XICO</h3>
    <h4>FES - ARAG&Oacute;N</h4>
    <h5>UNIDAD DE EXTENSI&Oacute;N UNIVERSITARIA</h5>
    <h5>DEPARTAMENTO DE ACTIVIDADES CULTURALES</h5>
    <div>
        <div>Folio: <?php echo str_pad($baucher['folio'], 11, "0", STR_PAD_LEFT); ?></div>
        <div>Fecha Expedici&oacute;n: <?php echo exchange_date_time($baucher['fecha_expedicion']) ?></div>
        <div>Alumno: <?php echo $usuario['paterno'] . ' ' . $usuario['materno'] . ' ' . $usuario['nombre'] ?></div>
    </div>
</div>
<div class="footer">
    <p>El presente pago se debe realizar a m&aacute;s tardar el <strong><?php echo $date_fin['mday'] . '/' . $date_fin['mon'] . '/' . $date_fin['year'] ?></strong>. Y debe ser presentado en <strong>Extensi&oacute;n Universitaria</strong> antes de las <?php echo $termina_hora ?>:00 hrs. <strong>para que se concluya su inscripci&oacute;n.</strong><br />
    En caso de no presentar los requisitos en el departamento de actividades culturales en la fecha indicada el sistema cancelará automaticamente la inscripción y se tendrá que realizar nuevamente el proceso de inscripción. 
    </p>
    <ul>
        <?php
        switch ($usuario['tipo_usuario_id']) {
            case 2:
                ?>
                <!--<li>Original y Copia de credencial de alumno</li>
                <li>Presentar Original y copia del voucher generado para validar la inscripci&oacute;n en el Departamento de Actividades Culturales</li>
                <li>Ticket de caja en original y 2 copia</li>
                <li>Comprobante de inscripción al semestre 2016-2</li>-->
                <li>Original y Copia de credencial de alumno</li>
                <li>Presentar Original y copia del voucher generado para validar la inscripción en el Departamento de Actividades Culturales</li>
                <?php
                break;
            case 3:
                ?>
                <!--<li>Original y Copia de credencial de ex-alumno o Identificaci&oacute;n oficial + Historial academico</li>
                <li>Presentar Original y copia del voucher generado para validar la inscripci&oacute;n en el Departamento de Actividades Culturales</li>
                <li>Ticket de caja en original y 2 copia</li>-->
                <li>Original y Copia de credencial de ex-alumno o Identificación oficial + Historial academico</li>
                <li>Presentar Original y copia del voucher generado para validar la inscripción en el Departamento de Actividades Culturales</li>
                <li>Ticket de caja en original y 2 copias.</li>
                <?php
                break;
            case 4:
                ?>
                <!--<li>Original y Copia de credencial de trabajador</li>
                <li>Presentar Original y copia del voucher generado para validar la inscripci&oacute;n en el Departamento de Actividades Culturales</li>
                <li>Ticket de caja en original y 2 copia</li>-->
                <li>Original y Copia de credencial de trabajador</li>
                <li>Presentar Original y copia del voucher generado para validar la inscripción en el Departamento de Actividades Culturales.</li>
                <?php
                break;
            case 5:
                ?>
                <!--<li>Original y copia de identificaci&oacute;n oficial.</li>
                <li>Presentar Original y copia del voucher generado para validar la inscripci&oacute;n en el Departamento de Actividades Culturales</li>
                <li>Ticket de caja en original y 2 copia</li>-->
                <li>Original y copia de identificación oficial.</li>
                <li>Presentar Original y copia del voucher generado para validar la inscripción en el Departamento de Actividades Culturales</li>
                <li>Ticket de caja en original y 2 copias</li>
                <?php
                break;
        }
        ?>
    </ul>
</div>
<div>
    <table class="table">
        <thead>
            <tr>
                <th>Grupo</th>
                <th>Taller</th>
                <th>Profesor</th>
                <th>Sal&oacute;n</th>
                <th>Horario</th>
                <th>Aportaci&oacute;n<br /> voluntaria</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $costo_total = 0;
            $has_piano = false;
            ?>
            <tr>
                <td><?php echo $baucher['grupo'] ?></td>
                <td><?php echo $baucher['taller'] ?></td>
                <td><?php echo $baucher['nombre'] . ' ' . $baucher['paterno'] . ' ' . $baucher['materno'] ?></td>
                <td><?php echo $baucher['salon'] ?></td>
                <td>
                    <?php
                    if($baucher['id'] == 11){
                        $has_piano = true;
                    }
                    if (is_array($baucher['horarios'])) {
                        for ($i = 1; $i <= 5; $i++) {
                            for ($j = 0; $j < count($baucher['horarios']); $j++) {
                                if ($baucher['horarios'][$j]['dia'] == $i) {
                                    $dia = '';
                                    switch ($i) {
                                        case 1:
                                            $dia = 'Lun';
                                            break;
                                        case 2:
                                            $dia = 'Mar';
                                            break;
                                        case 3:
                                            $dia = 'Mie';
                                            break;
                                        case 4:
                                            $dia = 'Jue';
                                            break;
                                        case 5:
                                            $dia = 'Vie';
                                            break;
                                    }
                                    echo '<div>' . $dia . ' ' . substr($baucher['horarios'][$j]['inicio'], 0, -3) . ' - ' . substr($baucher['horarios'][$j]['termino'], 0, -3) . '</div>';
                                }
                            }
                        }
                    } else {
                        ?>
                        -
                        <?php
                    }
                    ?>
                </td>
                <td><?php
                    echo '$ ' . $baucher['aportacion'];
                    $costo_total += $baucher['aportacion'];
                    ?>
                </td>
            </tr>
            <tr class="tr_total">
                <td colspan="5" class="td_total">Total</td>
                <td><?php echo '$ ' . $costo_total ?></td>
            </tr>
        </tbody>

    </table>
    <?php 
    if($has_piano){
        ?>
        <h3>Candidatos a inscribirse al Taller de Piano:</h3>
        <p>
            Inmediatamente después de haber obtenido el voucher que genera el sistema, favor de presentarlo en el Departamento de Actividades Culturales, como parte indispensable de su procedimiento de inscripción. Las inscripciones que no atiendan a este requerimiento serán canceladas.
        </p>
        <?php
    }
    ?>
</div>