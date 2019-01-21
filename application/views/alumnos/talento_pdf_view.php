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
    <h3>(FICHA DE INSCRIPCI&Oacute;N)</h3>
</div>
<div>
    <div class="col-margin">
        <strong for="">Nombre: </strong><span><?php echo $nombre;?></span>
    </div>
    <div class="col-margin">
        <strong for="">Carrera: </strong><span><?php echo $carrera;?></span>
    </div>
    <div class="col-margin">
        <span class="span-6">
            <strong for="">Semestre: </strong><span><?php echo $semestre;?></span>
        </span>
        <span class="span-6">
            <strong for="">No. Cuenta: </strong><span><?php echo $no_cta;?></span>
        </span>
    </div>
    <div class="col-margin">
        <strong for="">Correo electrónico: </strong><span><?php echo $email;?></span>
    </div>
    <div class="col-margin">
        <span class="span-6">
            <strong for="">Teléfono Celular: </strong><span><?php echo $celular;?></span>
        </span>
        <span class="span-6">
            <strong for="">Teléfono Casa: </strong><span><?php echo $telefono;?></span>
        </span>
    </div>
    <div class="col-margin">
        <strong for="">Arte: </strong><span><?php echo $artes;?></span>
    </div>
    <div class="col-margin">
        <strong for="">Actividad artística: </strong><span><?php echo $actividad_artistica;?></span>
    </div>
    <div class="col-margin">
        <strong for="">Género: </strong><span><?php echo $genero;?></span>
    </div>   
    <div class="col-margin">
        <strong for="">Nombre del grupo/solista: </strong><span><?php echo $nombre_grupo;?></span>
    </div>
    <div class="col-margin">
        <strong>Nombre de los integrantes: </strong>
    </div>
    <ol>
        <?php if(isset($integrantes) && count($integrantes) > 0){?>
            <?php foreach($integrantes as $integrante){?>
                <li><?php echo $integrante;?></li>
            <?php }?>
        <?php }?>
        <li></li>
    </ol>
</div>