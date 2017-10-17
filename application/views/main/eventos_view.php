<div class="row">
    <?php foreach($eventos as $evento){?>
        <div class="col-md-4">
            <div class="thumbnail thumbnail-events">
                <img src="images/eventos/<?php echo $evento["thumbnail"];?>" />
                <div class="caption">
                    <h3><?php echo $evento["nombre"];?></h3>
                    <strong><?php echo $evento["fecha"];?></strong>
                    <div><p><?php echo $evento["descripcion"];?></p></div>
                    <div>
                        <?php if(get_type_user() == 1){?>
                            <a class="btn btn-success" href="<?php echo base_url()?>eventos/alumnos/<?php echo $evento["id"];?>">Alumnos</a>
                        <?php } ?>
                        <?php if(strtotime($evento["init_insc"]) < time() /*|| in_array(get_id(),array(87,3384,3588,2798,3479))*/){?>
                                <?php if(get_id()){?>
                                    <?php if( $evento["has_event"] === false){ ?>
                                        <?php if( $evento["asistentes"] < $evento["cupo"] || $evento["cupo"] == -1){ ?>
                                            <?php if($evento["url"]){?>
                                                <a class="btn btn-success pull-right" href="<?php echo base_url() . $evento["url"];?>" role="button">Inscribir</a>
                                            <?php }else{?>
                                            <button class="btn btn-success btn-event pull-right" role="button" data-id="<?php echo $evento["id"];?>">OBTENER BOLETOS PARA EL EVENTO</button>
                                            <?php }?>
                                        <?php }else{ ?>
                                            <div class="alert alert-danger">
                                                <strong>Boletos Agotados</strong>
                                            </div>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <a class="btn btn-success" href="<?php echo base_url()?>eventos/detalle/<?php echo $evento["id"];?>">Detalle</a>
                                    <?php } ?>
                                <?php } else { ?>
                                    <?php if( $evento["asistentes"] < $evento["cupo"] || $evento["cupo"] == -1){ ?>
                                        <a href="#form_login_modal" data-toggle="modal" class="btn btn-success">Iniciar Sesión <span class="glyphicon glyphicon-log-in"></span></a>
                                        <a href="<?php echo base_url();?>acceso/registro/?return-url=<?php echo base_url();?>eventos" data-toggle="modal" class="btn btn-warning">Registrarse <span class="glyphicon glyphicon-log-in"></span></a>
                                    <?php }else{ ?>
                                        <div class="alert alert-danger">
                                            <strong>Boletos Agotados</strong>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                        <?php } else { ?>
                            <span class="label label-danger">Boletos disponibles a partir de: <?php echo exchange_date_time($evento["init_insc"]);?></span>
                        <?php } ?>
                        <br />
                        <br />
                        <?php if($evento["cupo"] != -1){ ?>
                        <span class="label label-<?php echo $evento["asistentes_label"]?> pull-right">Cupo <?php echo $evento["asistentes"];?>/<?php echo $evento["cupo"];?></span>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    <?php }?>
</div>