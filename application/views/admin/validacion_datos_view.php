<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?>
<div id="datos_baucher" class="row">
    <div class="datos_alumno">
        <div><span class="nombre-span">Folio: </span><span class="content-span"><?php echo str_pad($baucher['folio'], 11, "0", STR_PAD_LEFT); ?></span></div>
        <div><span class="nombre-span">Fecha Expedici&oacute;n: </span><span class="content-span"><?php echo exchange_date_time($baucher['fecha_expedicion']) ?></span></div>
        <div>
            <span class="nombre-span">No. Recibo: </span>
            <span class="content-span no_recibo_span">
                <?php
                if ($baucher['folio_caja'] !== null) {
                    echo $baucher['folio_caja'];
                } else {
                    echo '---';
                }
                ?>
            </span>
        </div>
        <div>
            <span class="nombre-span">Fecha de Recibo: </span>
            <span class="content-span fecha_recibo_span">
                <?php
                if ($baucher['fecha_caja'] !== null) {
                    echo exchange_date($baucher['fecha_caja']);
                } else {
                    echo '---';
                }
                ?>
            </span>
        </div>
        <div><span class="nombre-span">Alumno: </span><span class="content-span"><?php echo $usuario['paterno'] . ' ' . $usuario['materno'] . ' ' . $usuario['nombre'] ?></span></div>
        <div>
            <span class="nombre-span">Estado: </span><span class="content-span validado-span">
                <?php
                if ($baucher['status'] == 0) {
                    echo 'No Validado';
                } else if ($baucher['status'] == 1) {
                    echo 'Validado';
                } else if ($baucher['status'] == 2) {
                    echo 'Penalizado: A&uacute;n no se puede inscribir';
                } else {
                    echo 'No validado, pero ya puede inscribir nuevamente los Talleres';
                }
                ?>
            </span>
        </div>
    </div>
    <div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Grupo</th>
                    <th>Taller</th>
                    <th>Profesor</th>
                    <th>Sal&oacute;n</th>
                    <th>Aportación</th>
                    <th>Voluntario</th>
                    <th>Beca</th>
                    <th>Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $costo_total = 0;
                
                ?>
                <tr>
                    <td><?php echo $baucher['grupo'] ?></td>
                    <td><?php echo $baucher['taller'] ?></td>
                    <td><?php echo $baucher['nombre'] . ' ' . $baucher['paterno'] . ' ' . $baucher['materno'] ?></td>
                    <td><?php echo $baucher['salon'] ?></td>
                    <td>$ <?php echo $baucher['aportacion']?>
                    </td>
                    <td>$ <?php echo $baucher['extra']; ?></td>
                    <td>$ <?php echo $baucher['beca'];?></td>
                    <td>$ <?php echo $baucher['aportacion'] + $baucher['extra'] - $baucher["beca"];?></td>
                    
                    <td>
                        <?php
                        if (get_type_user() == 1) {
                        ?>
                        <a class="btn btn-success pull-right" href="<?php echo base_url(); ?>admin/cambio/index/<?php echo $baucher['id'];?>/<?php echo $baucher['ts_id'];?>" data-toggle="modal">Cambiar</a></td>
                        <?php
                        }
                        ?>
                </tr>
                
            </tbody>
        </table>
    </div>
    <div id="btn_valida_content">
        <?php
        if ($baucher['status'] == 0) {
            ?>
            <button class="btn btn-danger pull-right" id="btn_baja_baucher" data-id="<?php echo $baucher['id'] ?>">Dar de baja</button>
            <button class="btn btn-success pull-right" href="#valida_folio_dialog" data-toggle="modal">Validar</button>
            <?php
        }else if (get_type_user() == 1) {
            ?>
            <button class="btn btn-success pull-right" href="#valida_folio_dialog" data-toggle="modal">Editar</button>
            <?php
        }
        ?>
    </div>
</div>
<?php
if ($baucher['status'] == 0 || get_type() == 1) {
?>
    <div class="row">
        <div class="modal fade active" id="valida_folio_dialog" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                <?php
                    if ($baucher['status'] == 0) {
                        ?>
                    <form class="form-horizontal" action="<?php echo base_url(); ?>admin/validacion/valida_insc/<?php echo $baucher['id'] ?>" role="form" id="valida_folio_form">
                    <?php
                    }else if(get_type() == 1){
                        ?>
                        <form class="form-horizontal" action="<?php echo base_url(); ?>admin/validacion/edit/<?php echo $baucher['id'] ?>" role="form" id="valida_folio_form">
                    <?php } ?>
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3>Informaci&oacute;n de recibo</h3>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="control-label col-lg-4" for="numero_caja">No. Recibo</label>
                                <div class="col-lg-8">
                                    <input class="form-control" name="numero_caja" type="text" value="<?php echo ($baucher['folio_caja'] !== null) ? $baucher["folio_caja"]:""?>" placeholder="Caja" id="numero_caja" <?php echo ($baucher['folio_caja'] == "BECA")? "disabled":""?>>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-lg-4" for="fecha_caja">Fecha de Recibo</label>
                                <div class="controls col-lg-8">
                                    <div class="input-group date fecha_input" id="nacimiento_user" data-date-format="DD-MM-YYYY">
                                        <input name="fecha_caja" class="form-control" id="fecha_caja" value="<?php echo ($baucher['fecha_caja'] !== null) ? exchange_date($baucher['fecha_caja']):"" ?>" type="text" placeholder="dd-mm-yyyy" />
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="baportacion" value="1" id="ingresa_aportacion"> Ingresar Aportación
                                </label>
                            </div>
                            <div class="form-group hidden" id="aportacion_voluntaria_content">
                                <label class="control-label col-lg-4" for="aportacion">Aportación voluntaria</label>
                                <div class="col-lg-8">
                                    <input class="form-control" name="aportacion" type="text" placeholder="Aportacion voluntaria" id="aportacion" value="">
                                </div>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="bbeca" value="1" id="ingresa_beca" <?php echo ($baucher['beca']>0) ? "checked":""?>> Ingresar Beca
                                </label>
                            </div>
                            <div class="form-group <?php echo ($baucher['beca']>0) ? "":"hidden"?>" id="aportacion_beca_content">
                                <label class="control-label col-lg-4" for="beca">Beca</label>
                                <div class="col-lg-8">
                                    <input class="form-control" name="beca" type="text" placeholder="Beca" id="beca" value="<?php echo $baucher['beca']?>">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" data-dismiss="modal" class="btn">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Validar</button>
                        </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
    </div>
    <?php
}
if ($baucher['folio_caja'] === null && $baucher['status'] == 1) {
    ?>
    <div class="row">
        <div class="modal fade active" id="ingresa_folio_dialog" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form class="form-horizontal" action="<?php echo base_url(); ?>admin/validacion/ingresa_folio_caja/<?php echo $baucher['id'] ?>" role="form" id="ingresa_folio_form">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3>N&uacute;mero de recibo</h3>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="control-label col-lg-4" for="user_input">No. de recibo</label>
                                <div class="col-lg-8">
                                    <input class="form-control" name="numero_caja" type="text" placeholder="Caja" id="caja_input">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" data-dismiss="modal" class="btn">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
    </div>
    <?php
}
if ($baucher['fecha_caja'] === null && $baucher['status'] == 1) {
    ?>
    <div class="row">
        <div class="modal fade active" id="ingresa_fecha_dialog" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form class="form-horizontal" action="<?php echo base_url(); ?>admin/validacion/ingresa_fecha_caja/<?php echo $baucher['id'] ?>" role="form" id="ingresa_fecha_form">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3>Fecha del recibo</h3>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="control-label col-lg-4" for="user_input">Fecha de recibo</label>
                                <div class="controls col-lg-8">
                                    <div class="input-group date fecha_input" id="nacimiento_user" data-date-format="DD-MM-YYYY">
                                        <input name="fecha_caja" class="form-control" id="fecha_caja" type="text" placeholder="dd-mm-yyyy" />
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" data-dismiss="modal" class="btn">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
    </div>
    <?php
}
?>