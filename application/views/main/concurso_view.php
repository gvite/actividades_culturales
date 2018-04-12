<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?>
<div class="row">
    <div class="col-md-3">
        <img width="100%" src="<?php echo base_url();?>images/concursos/<?php echo $concurso["image"];?>" />
    </div>
    <div class="col-md-9">
        <div class="row">
            <div class="col-md-12">
                <h3><?php echo $concurso['nombre'];?></h3>
                <strong>Fecha del evento: <?php echo $concurso["fecha"];?></strong>
                <div class="row">
                    <h4>Generar Ficha de Inscripción</h4>
                <?php if(strtotime($concurso["fecha_inscripcion"]) < time() /*|| in_array(get_id(),array(87,3384,3588,2798,3479))*/){?>
                    <?php if(get_id()){?>
                        <?php if( $concurso["participantes"] < $concurso["cupo"] || $concurso["cupo"] == -1){ ?>
                            <a href="<?php echo base_url();?>alumnos/confirmar/?return-url=<?php echo base_url()?>concursos/registro/<?php echo $concurso["id"];?>" class="btn btn-success">Inscribir <span class="glyphicon glyphicon-edit"></span></a>
                        <?php }else{ ?>
                            <div class="alert alert-danger">
                                <strong>Registro agotado</strong>
                            </div>
                        <?php } ?>
                    <?php } else { ?>
                        <?php if( $concurso["participantes"] < $concurso["cupo"] || $concurso["cupo"] == -1){ ?>
                            <a href="#form_login_modal" data-toggle="modal" class="btn btn-success">Iniciar Sesión <span class="glyphicon glyphicon-log-in"></span></a>
                            <a href="<?php echo base_url();?>acceso/registro/?return-url=<?php echo base_url();?>concursos/registro/<?php echo $concurso["id"];?>" data-toggle="modal" class="btn btn-warning">Registrarse <span class="glyphicon glyphicon-log-in"></span></a>
                        <?php }else{ ?>
                            <div class="alert alert-danger">
                                <strong>Registro agotado</strong>
                            </div>
                        <?php } ?>
                    <?php } ?>
                <?php } else { ?>
                    <span class="label label-warning">Disponible a partir de: <?php echo exchange_date_time($concurso["fecha_inscripcion"]);?></span>
                <?php } ?>
                <?php if($concurso["cupo"] != -1){ ?>
                <span class="label label-<?php echo $concurso["asistentes_label"]?>">Cupo <?php echo $concurso["participantes"];?>/<?php echo $concurso["cupo"];?></span>
                <?php } ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 bases-content">
                    <h3>Bases</h3>
                <?php echo $concurso["format_bases"];?>
            </div>
        </div>
    </div>
</div>