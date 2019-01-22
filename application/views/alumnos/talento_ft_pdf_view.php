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
    <h5>PROGRAMA DE TALENTO ARAGON&Eacute;S</h5>
    <h3>(FICHA T&Eacute;CNICA)</h3>
</div>
<div>
    <div class="col-margin">
        <strong for="">Nombre del grupo/solista: </strong><span><?php echo $nombre_grupo;?></span>
    </div>
    <div class="col-margin">
        <strong for="">Actividad artística: </strong><span><?php echo $actividad_artistica;?></span>
    </div>
    <div class="col-margin">
        <strong for="">Género: </strong><span><?php echo $genero;?></span>
    </div>
    <h4>Área Técnica</h4>
    <div class="col-margin">
        <strong for="">Duración de la presentación: </strong><span><?php echo $duracion;?> mins.</span>
    </div>
    <div class="col-margin"><strong>Listado de equipo (propiedad del participante): </strong></div>
    <ol>
        <?php if(isset($equipo_lista) && count($equipo_lista) > 0){?>
            <?php foreach($equipo_lista as $equipo){?>
                <li><?php echo $equipo;?></li>
            <?php }?>
        <?php }?>
        <li></li>
    </ol>
    <div class="col-margin">
        <strong for="">Escenografía: </strong><span><?php echo $escenografia;?></span>
    </div>
    <div class="col-margin">
        <span>
            <strong for="">Iluminación: </strong><span><?php echo $iluminacion;?></span>
        </span>
        <span>
            <strong for="">Audio y video: </strong><span><?php echo $audio_video;?></span>
        </span>
    </div>
    <div class="col-margin">
        <span>
            <strong for="">Montaje: </strong><span><?php echo $duracion_montaje;?> mins.</span>
        </span>
        <span>
            <strong for="">Desmontaje: </strong><span><?php echo $duracion_desmontaje;?> mins.</span>
        </span>
    </div>
    <p><strong>* El Departamento de Actividades Culturales no proporciona ningún tipo de escenografía</strong></p>
    <p><strong>* El Departamento de Actividades Culturales unicamente prestará microfonos para la presentación de las actividades artisticas a realizar en el teatro</strong></p>
    <p><strong>* Presentarse 2 horas antes de la hora indicada de su presentación</strong></p>
    <p><strong>* No habrá ensayos previos a la presentación</strong></p>
</div>