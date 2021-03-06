<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?>
<?php
if(get_type() == 1){
    ?>
    <div class="row">
        <div class="col-md-3">
            <select name="type_user" id="type_user_select" class="form-control">
                <option value="0" <?php echo (get_type_user() == 1)?"selected":"";?>>Selecciona</option>
                <option value="2" <?php echo (get_type_user() == 2)?"selected":"";?>>Alumno</option>
                <option value="3" <?php echo (get_type_user() == 3)?"selected":"";?>>Ex-Alumno</option>
                <option value="4" <?php echo (get_type_user() == 4)?"selected":"";?>>Trabajador</option>
                <option value="5" <?php echo (get_type_user() == 5)?"selected":"";?>>Externo</option>
            </select>
        </div>
    </div>
    <script>
        $(document).on("ready" , function(){
            $("#type_user_select").on("change", function(){
                var $this = $(this);
                $.ajax({
                    url: base_url + 'admin/cambio/user/',
                    data: 'type_user=' + $this.val(),
                    type: 'POST',
                    dataType: 'json',
                    success: function (data) {
                        if (data.status === "OK") {
                            window.location.reload();
                        }
                    }
                });
            });
        });
    </script>
    <?php
}
?>
<div class="row">
    <div class="col-md-5">
        <div class="panel panel-primary" id="materias">
            <div class="panel-heading">
                <h3 class="panel-title">Cursos</h3>
            </div>
            <div class="panel-body">
                <?php
                if (is_array($talleres)) {
                    foreach ($talleres as $taller) {
                        if (($taller['status'] === false || $taller['status']['status'] == 3)) {
                            ?>
                            <div class="panel panel-<?php
                            if ($taller['percent'] < 100 && $taller['num_trabajador'] < 2 && $taller['puede_mas']) {
                                echo 'default dragg-taller-div';
                            } else {
                                echo 'danger alert-agotado';
                            }
                            ?>" data-id="<?php echo $taller['id'] ?>">
                                <div class="panel-heading">
                                    <h4 class="name-taller" data-name="<?php echo $taller['taller'] ?>"><?php echo $taller['taller'] ?></h4>
                                </div>
                                <div class="panel-body">
                                    <div class="profesor-taller">Profesor: <?php echo $taller['paterno'] . ' ' . $taller['materno'] . ' ' . $taller['nombre'] ?></div>
                                    <span class="badge pull-right"><?php echo ($taller['percent'] < 100) ? $taller['insc_count'] . '/' . $taller['cupo'] : 'Agotado'; ?></span>
                                    <div>Grupo: <span class="grupo-taller"><?php echo $taller['grupo'] ?></span></div>
                                    <div>Sal&oacute;n: <span class="salon-taller"><?php echo $taller['salon'] ?></span></div>
                                    <div class="horario-taller">Horario: 
                                        <span>
                                            <?php
                                            if (is_array($taller['horarios'])) {
                                                for ($i = 1; $i <= 5; $i++) {
                                                    for ($j = 0; $j < count($taller['horarios']); $j++) {
                                                        if ($taller['horarios'][$j]['dia'] == $i) {
                                                            $dia = '';
                                                            switch ($i) {
                                                                case 1:
                                                                    $dia = 'Lu';
                                                                    break;
                                                                case 2:
                                                                    $dia = 'Ma';
                                                                    break;
                                                                case 3:
                                                                    $dia = 'Mi';
                                                                    break;
                                                                case 4:
                                                                    $dia = 'Ju';
                                                                    break;
                                                                case 5:
                                                                    $dia = 'Vi';
                                                                    break;
                                                            }
                                                            $inicio = explode(':', $taller['horarios'][$j]['inicio']);
                                                            $fin = explode(':', $taller['horarios'][$j]['termino']);
                                                            echo '<div>' . $dia . ' ' . $inicio[0] . ':' . $inicio[1] . ' - ' . $fin[0] . ':' . $fin[1] . '</div>';
                                                        }
                                                    }
                                                }
                                            } else {
                                                ?>
                                                -
                                                <?php
                                            }
                                            ?>
                                        </span>
                                    </div>
                                    <?php
                                    if ($taller['num_trabajador'] >= 2) {
                                        ?>
                                        <span class="label label-warning">* No puede haber mas de 2 trabajadores</span>
                                        <?php
                                    }
                                    if (!$taller['puede_mas']) {
                                        ?>
                                        <span class="label label-warning">* Ya inscribiste este taller <br /> en caso de que no hayas completado la inscripci&oacute;n <br /> a tiempo se aplica una penalizaci&oacute;n de un dia <br /> a partir de la fecha de expiraci&oacute;n</span>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <div class="panel-footer">
                                    <?php if ($taller['percent'] < 100 && $taller['num_trabajador'] < 2 && $taller['puede_mas']) { ?>
                                        <button type="button" class="btn btn-link pull-right btn-taller-insc"><span class="glyphicon glyphicon-circle-arrow-right"></span></button>
                                    <?php } ?>
                                    <div class="costo-taller">$<span class="costo-span"><?php echo $taller['costo'] ?></span></div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                }
                ?>
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="panel panel-primary" id="inscribir_panel">
            <div class="panel-heading">
                <h3 class="panel-title">Inscritos</h3>
            </div>
            <div class="panel-body">
                <p>Arrastra tus talleres a Inscribir Aqui.</p>
            </div>
            <div class="panel-footer">
                <button class="btn btn-primary pull-right">Inscribir</button>
                <div class="control-group col-xs-5">
                    <div class="controls">
                        <input class="form-control" id="costo_total" type="text" disabled="disabled" placeholder="Aportaci&oacute;n Total"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-10">
        <table class="table" id="table_bauchers">
            <thead>
                <tr>
                    <th>Folio</th>
                    <th>Taller</th>
                    <th>Fecha expedici&oacute;n</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (is_array($bauchers)) {
                    $this->load->helper('date');
                    foreach ($bauchers as $baucher) {
                        if ($baucher['status'] != 3) {
                            ?>
                            <tr>
                                <td><?php echo str_pad($baucher['folio'], 11, "0", STR_PAD_LEFT); ?></td>
                                <td><ul><?php echo $baucher['taller']; ?></ul></td>
                                <td><?php echo exchange_date_time($baucher['fecha_expedicion']) ?></td>
                                <td><?php
                                    if ($baucher['status'] == 0) {
                                        echo 'No pagado';
                                    } else if ($baucher['status'] == 1) {
                                        echo 'Pagado';
                                    } else {
                                        echo 'Penalizado';
                                    }
                                    ?></td>
                                <td>
                                    <?php
                                    if ($baucher['status'] == 0) {
                                        
                                    }
                                    ?>
                                    <a data-events="0" class="btn btn-link" data-id="<?php echo $baucher['id'] ?>" href="<?php echo base_url(); ?>alumnos/inscripcion/get_pdf/<?php echo $baucher['id'] ?>" target="_blank">Imprimir</a>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>