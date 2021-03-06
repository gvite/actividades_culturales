<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?>
<div id="encabezado">
    <div class="content-img">
        <img src="images/logo_pdf.jpg">
    </div>
    <h3>UNIVERSIDAD NACIONAL AUT&Oacute;NOMA DE M&Eacute;XICO</h3>
    <h4>FES - ARAG&Oacute;N</h4>
    <h5>UNIDAD DE EXTENSI&Oacute;N UNIVERSITARIA</h5>
    <h5>DEPARTAMENTO DE ACTIVIDADES CULTURALES</h5>
    <h5>HOJA DE INSCRIPCI&Oacute;N</h5>
    <div>
        <div>Folio: <?php echo str_pad($baucher['folio'], 11, "0", STR_PAD_LEFT); ?></div>
        <div>Fecha Expedici&oacute;n: <?php echo exchange_date_time($baucher['fecha_expedicion']) ?></div>
        <div>Alumno: <?php echo $usuario['paterno'] . ' ' . $usuario['materno'] . ' ' . $usuario['nombre'] ?></div>
    </div>
</div>
<div class="footer">
    <p>PARA CONCLUIR TU INSCRIPCIÓN FAVOR DE: </p>
    <ol>
        <li>EFECTUAR EL PAGO INDICADO EN LA PRESENTE HOJA DE INSCRIPCIÓN A MÁS TARDAR EL <strong><?php echo $date_fin['mday'] . '/' . $date_fin['mon'] . '/' . $date_fin['year'] ?></strong></li>
        <li>DESPUÉS DE EFECTUAR EL PAGO ACUDIR AL DEPARTAMENTO DE ACTIVIDADES CULTURALES ANTES DE LAS <?php echo $termina_hora ?>:00 HRS. PRESENTANDO:</li>
        <li>
            <ul>
                <?php
                switch ($usuario['tipo_usuario_id']) {
                    case 1: case 2:
                        ?>
                        <li class="list-group-item list-group-item-success">Hoja de inscripción SELLADA (original y copia).</li>
                        <li class="list-group-item list-group-item-success">Ticket de pago (original y dos fotocopias).</li>
                        <li class="list-group-item list-group-item-success">Fotocopia de identificación con el que compruebe estatus de alumno</li>
                        <?php
                        break;
                    case 3:
                        ?>
                        <li class="list-group-item list-group-item-success">Hoja de inscripción SELLADA (original y copia).</li>
                        <li class="list-group-item list-group-item-success">Ticket de pago (original y dos fotocopias).</li>
                        <li class="list-group-item list-group-item-success">Fotocopia de identificación con el que compruebe estatus de egresado</li>
                        <?php
                        break;
                    case 4:
                        ?>
                        <li class="list-group-item list-group-item-success">Hoja de inscripción SELLADA (original y copia).</li>
                        <li class="list-group-item list-group-item-success">Ticket de pago (original y dos fotocopias).</li>
                        <li class="list-group-item list-group-item-success">Fotocopia de identificación con el que compruebe estatus de trabajador universitario.</li>
                        <?php
                        break;
                    case 5:
                        ?>
                        <li class="list-group-item list-group-item-success">Hoja de inscripción SELLADA (original y copia).</li>
                        <li class="list-group-item list-group-item-success">Ticket de pago (original y dos fotocopias).</li>
                        <li class="list-group-item list-group-item-success">Fotocopia de identificación ofical (INE, pasaporte, etc).</li>
                        <?php
                        break;
                }
                ?>
            </ul>
        </li>
    </ol>
    <p>IMPORTANTE: SE CANCELARÁ TU INSCRIPCIÓN EN CASO DE NO CONCLUIR EL PROCEDIMIENTO EN TIEMPO Y FORMA</p>
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
                <th></th>
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