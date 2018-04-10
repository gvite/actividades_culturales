<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?>
<div class="row">
<?php foreach($concursos as $concurso){ ?>
    <div class="col-md-4">
        <div class="thumbnail thumbnail-events">
            <img src="images/concursos/<?php echo $concurso["thumbnail"];?>" />
            <div class="caption">
                <h3><?php echo $concurso['nombre'];?></h3>
                <strong><?php echo $concurso["fecha"];?></strong>
                <div>
                    <?php if(strtotime($concurso["fecha_inscripcion"]) < time() /*|| in_array(get_id(),array(87,3384,3588,2798,3479))*/){?>
                        <?php if(get_id()){?>
                            <?php if( $concurso["participantes"] < $concurso["cupo"] || $concurso["cupo"] == -1){ ?>
                                <a href="<?php echo base_url();?>concursos/<?php echo $concurso["slug"];?>" class="btn btn-success">Ver <span class="glyphicon glyphicon-log-in"></span></a>
                            <?php }else{ ?>
                                <div class="alert alert-danger">
                                    <strong>Pre registro agotado</strong>
                                </div>
                            <?php } ?>
                        <?php } else { ?>
                            <?php if( $concurso["participantes"] < $concurso["cupo"] || $concurso["cupo"] == -1){ ?>
                                <a href="<?php echo base_url();?>concursos/<?php echo $concurso["slug"];?>" class="btn btn-success">Ver <span class="glyphicon glyphicon-log-in"></span></a>
                            <?php }else{ ?>
                                <div class="alert alert-danger">
                                    <strong>Pre registro agotado</strong>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    <?php } else { ?>
                        <span class="label label-warning">Disponible a partir de: <?php echo exchange_date_time($concurso["fecha_inscripcion"]);?></span>
                    <?php } ?>
                    <br />
                    <br />
                    <?php if($concurso["cupo"] != -1){ ?>
                    <span class="label label-<?php echo $concurso["asistentes_label"]?> pull-right">Cupo <?php echo $concurso["participantes"];?>/<?php echo $concurso["cupo"];?></span>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
</div>