<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
if ($tiempo !== false) {
    ?>
    <div class="row" id="content_count">
        <div class="col-md-4 col-md-offset-8">
            <div><p>Inscripci&oacute;n inicia en:</p></div>
            <div id="counter" data-time="<?php echo $tiempo ?>"></div>
        </div>
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
            foreach ($talleres as $taller) {
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
            <strong>Documentación adicional que deberán presentar los interesados (alumnos, exalumnos, trabajadores o externos) para concluir su inscripción en el Departamento de Actividades Culturales: </strong>
        </div>
    </div>
    <div class="row" id="requisitos_inscripcion">
        <?php
        if (get_type_user() == 2 || get_type_user() === false) {
            ?>
            <div class="bs-callout bs-callout-primary">
                <h4>Alumnos</h4>
                <!--<?php if (get_type_user() === false) {?>
                <p>Alumnos que ya se han inscrito anteriormente a algún taller sólo presentar los de color <span class="label label-success">verde</span></p>
                <p>Alumnos que se inscriben por primera vez a algún taller presentar los de color <span class="label label-success">verde</span> y <span class="label label-primary">azul</span></p>
                <?php } ?>
                <ul class="list-group">
                    <li class="list-group-item list-group-item-success">Original y Copia de hoja de inscripción al taller</li>
                    <?php if (get_talleres_inscritos() === 0) {?>
                    <li class="list-group-item list-group-item-<?php echo (get_type_user() === false)?"primary": "success";?>">2 fotografías tamaño infantil</li>
                    <li class="list-group-item list-group-item-<?php echo (get_type_user() === false)?"primary": "success";?>">Copia de credencial del alumno</li>
                    <?php } ?>
                    <li class="list-group-item list-group-item-success">Tira de materias o comprobante de inscripción</li>
                    <li class="list-group-item list-group-item-success">Ticket de pago y 2 copias del mismo</li>
                    
                </ul>-->
                <ul class="list-group">
                    <li class="list-group-item list-group-item-success">Hoja de inscripción SELLADA (original y copia).</li>
                    <li class="list-group-item list-group-item-success">Ticket de pago (original y dos fotocopias).</li>
                    <li class="list-group-item list-group-item-success">Fotocopia de identificación con el que compruebe estatus de alumno</li>
                </ul>
            </div>
            <?php
        }
        if (get_type_user() == 4 || get_type_user() === false) {
            ?>
            <div class="bs-callout bs-callout-primary">
                <h4>Empleados Universitarios</h4>
                <!--<?php if (get_type_user() === false) {?>
                <p>Empleados que ya se han inscrito anteriormente a algún taller sólo presentar los de color <span class="label label-success">verde</span></p>
                <p>Empleados que se inscriben por primera vez a algún taller presentar los de color <span class="label label-success">verde</span> y <span class="label label-primary">azul</span></p>
                <?php } ?>
                <ul class="list-group">
                    <li class="list-group-item list-group-item-success">Original y Copia de hoja de inscripción al taller</li>
                    <?php if (get_talleres_inscritos() === 0) {?>
                    <li class="list-group-item list-group-item-<?php echo (get_type_user() === false)?"primary": "success";?>">2 fotografías tamaño infantil</li>
                    <li class="list-group-item list-group-item-<?php echo (get_type_user() === false)?"primary": "success";?>">Copia de credencial de empleado</li>
                    <?php } ?>
                    <li class="list-group-item list-group-item-success">Copia de talón de cheque</li>
                    <li class="list-group-item list-group-item-success">Ticket de pago y 2 copias del mismo</li>
                </ul>-->
                <ul class="list-group">
                    <li class="list-group-item list-group-item-success">Hoja de inscripción SELLADA (original y copia).</li>
                    <li class="list-group-item list-group-item-success">Ticket de pago (original y dos fotocopias).</li>
                    <li class="list-group-item list-group-item-success">Fotocopia de identificación con el que compruebe estatus de trabajador universitario.</li>
                </ul>
            </div>
            <?php
        }
        if (get_type_user() == 3 || get_type_user() === false) {
            ?>
            <div class="bs-callout bs-callout-primary">
                <h4>Egresados</h4>
                <!--<?php if (get_type_user() === false) {?>
                <p>Egresados que ya se han inscrito anteriormente a algún taller sólo presentar los de color <span class="label label-success">verde</span></p>
                <p>Egresados que se inscriben por primera vez a algún taller presentar los de color <span class="label label-success">verde</span> y <span class="label label-primary">azul</span></p>
                <?php } ?>
                <ul class="list-group">
                    <li class="list-group-item list-group-item-success">Original y Copia de hoja de inscripción al taller</li>
                    <?php if (get_talleres_inscritos() === 0) {?>
                    <li class="list-group-item list-group-item-<?php echo (get_type_user() === false)?"primary": "success";?>">2 fotografías tamaño infantil</li>
                    <li class="list-group-item list-group-item-<?php echo (get_type_user() === false)?"primary": "success";?>">Copia de credencial de exalumno</li>
                    <?php } ?>
                    <li class="list-group-item list-group-item-success">Ticket de pago y 2 copias del mismo</li>
                </ul>-->
                <ul class="list-group">
                    <li class="list-group-item list-group-item-success">Hoja de inscripción SELLADA (original y copia).</li>
                    <li class="list-group-item list-group-item-success">Ticket de pago (original y dos fotocopias).</li>
                    <li class="list-group-item list-group-item-success">Fotocopia de identificación con el que compruebe estatus de egresado</li>
                </ul>
            </div>
            <?php
        }
        if (get_type_user() == 5 || get_type_user() === false) {
            ?>
            <div class="bs-callout bs-callout-primary">
                <h4>Externos</h4>
                <!--<?php if (get_type_user() === false) {?>
                <p>Externos que ya se han inscrito anteriormente a algún taller sólo presentar los de color <span class="label label-success">verde</span></p>
                <p>Externos que se inscriben por primera vez a algún taller presentar los de color <span class="label label-success">verde</span> y <span class="label label-primary">azul</span></p>
                <?php } ?>
                <ul class="list-group">
                    <li class="list-group-item list-group-item-success">Original y Copia de hoja de inscripción al taller</li>
                    <?php if (get_talleres_inscritos() === 0) {?>
                    <li class="list-group-item list-group-item-<?php echo (get_type_user() === false)?"primary": "success";?>">2 fotografías tamaño infantil</li>
                    <li class="list-group-item list-group-item-<?php echo (get_type_user() === false)?"primary": "success";?>">Copia de identificación oficial</li>
                    <?php } ?>
                    <li class="list-group-item list-group-item-success">Ticket de pago y 2 copias del mismo</li>
                </ul>-->
                <ul class="list-group">
                    <li class="list-group-item list-group-item-success">Hoja de inscripción SELLADA (original y copia).</li>
                    <li class="list-group-item list-group-item-success">Ticket de pago (original y dos fotocopias).</li>
                    <li class="list-group-item list-group-item-success">Fotocopia de identificación ofical (INE, pasaporte, etc).</li>
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
<div class="modal fade" id="sliders_modal" data-items="<?php echo ($sliders) ? count($sliders):0;?>">
    <button class="close" data-dismiss="modal" type="button"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
    <div class="swiper-container col-md-12">
        <div class="swiper-wrapper">
            <?php if($sliders){
                foreach($sliders as $slider){
                    ?>
                    <div class="swiper-slide">
                        <?php if($slider["link"]){?>
                        <a href="<?php echo base_url() . $slider["link"];?>">
                        <?php } ?>
                        <img alt="<?php echo $slider['titulo'];?>" src="<?php echo base_url();?>/uploads/sliders/<?php echo $slider['img']?>" />
                        <?php if($slider["link"]){?>
                        </a>
                        <?php } ?>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
        <!-- Add Arrows -->
            <div class="swiper-button-prev">&nbsp</div>
            <div class="swiper-button-next">&nbsp</div>
    </div>
</div>