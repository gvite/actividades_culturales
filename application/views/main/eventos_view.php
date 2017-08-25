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
                        <?php if(get_id()){?>
                            <?php if(strtotime($evento["init_insc"]) < time()){?>
                                <?php if( $evento["has_event"] === false){ ?>
                                    <?php if( $evento["asistentes"] < $evento["cupo"]){ ?>
                                        <button class="btn btn-success btn-event" role="button" data-id="<?php echo $evento["id"];?>">Asistir al evento</button>
                                    <?php } ?>
                                <?php } else { ?>
                                    <a class="btn btn-success" href="<?php echo base_url()?>eventos/detalle/<?php echo $evento["id"];?>">Detalle</a>
                                <?php } ?>
                            <?php } else { ?>
                                <span class="label label-danger">Boletos disponibles a partir del: <?php echo exchange_date_time($evento["init_insc"]);?></span>
                            <?php } ?>
                        <?php } else { ?>
                            <a href="#form_login_modal" data-toggle="modal" class="btn btn-success">Asistir <span class="glyphicon glyphicon-log-in"></span></a>
                        <?php } ?>
                        <br />
                        <br />
                        <span class="label label-<?php echo $evento["asistentes_label"]?> pull-right">Cupo <?php echo $evento["asistentes"];?>/<?php echo $evento["cupo"];?></span>
                    </div>
                </div>
            </div>
        </div>
    <?php }?>
</div>