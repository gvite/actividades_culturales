<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?>
<div id="encabezado">
    <h4>CARTA RESPONSIVA</h4>
    <p>Nezahualcóyotl, Estado de México a <?php echo date("d")?> de <?php echo $meses[date('n')];?> de <?php echo date('Y');?>.</p>
</div>
<div id="body">
    <h5>DEPARTAMENTO DE ACTIVIDADES CULTURALES</h5>
    <h5>PRESENTE</h5>
    <p> Por medio de la misma, me presento como estudiante de la Universidad Nacional Autónoma de México, como: <strong><?php echo  $usuario['nombre'] . ' ' . $usuario['paterno'] . ' ' . $usuario['materno']; ?></strong> De la Facultad: <strong><?php echo $usuario['facultad']; ?></strong> de la carrera de: <strong><?php echo $usuario['carrera']; ?></strong> Número de cuenta:  <strong><?php echo $usuario['no_cuenta']; ?></strong> De:  <strong><?php echo $usuario['semestre']; ?>º</strong> semestre.</p>
    <p>Declaro, me encuentro en condiciones saludables para realizar cualquier tipo de actividad física y deportiva, así mismo, expreso que tengo experiencia mínima de un año practicando Pole Dance. Manifiesto por convicción, mi interés por participar en el 1° Concurso de Pole Dance Artístico que se realizará en la Facultad de Estudios Superiores Aragón, el próximo viernes 20 de abril, dentro del Programa "Vive la FES Aragón".</p>
    <p>Señalo que, en caso de que sufra durante la realización de mi presentación alguna lesión física, cualquier tipo de accidente o siniestro de cualquier naturaleza, los gastos generados serán cubiertos por los suscritos, deslindando a la Facultad de Estudios Superiores Aragón, a la UNAM y a todos aquellos que pertenezcan en dicha Institución eximir de cualquier reclamación que llegare a surgir, reservando cualquier acción legal alguna en su contra.</p>
    <p>Con relación a los requisitos de ingreso al Concurso, exigidos por el Departamento de Actividades Culturales, manifiesto que toda la documentación pertinente como ficha de inscripción, Copia de Seguro Facultativo ISSSTE/IMSS, así como la presente carta, los entrego en forma personal ante el Departamento de Actividades Culturales bajo mi propia responsabilidad.</p>
</div>
<div id="firma">
    <div class="conformidad">FIRMA DE CONFORMIDAD:</div>
    <div class="nombre">(Nombre completo y firma)</div>
</div>