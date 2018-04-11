<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?>
<div id="encabezado">
    <h3>UNIVERSIDAD NACIONAL AUT&Oacute;NOMA DE M&Eacute;XICO</h3>
    <h4>FES - ARAG&Oacute;N</h4>
    <h5>UNIDAD DE EXTENSI&Oacute;N UNIVERSITARIA</h5>
    <h5>DEPARTAMENTO DE ACTIVIDADES CULTURALES</h5>
    <h5>FICHA DE INSCRIPCI&Oacute;N</h5>
</div>
<div>
<table class="table">
    <thead>
        <tr>
            <th>Concurso</th>
            <th><?php echo $concurso["nombre"];?></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Actividad</td>
            <td><?php echo $concurso["actividad"];?></td>
        </tr>
        <tr>
            <td>Alumno</td>
            <td><?php echo $usuario['paterno'] . ' ' . $usuario['materno'] . ' ' . $usuario['nombre'] ?></td>
        </tr>
        <tr>
            <td>Sexo</td>
            <td><?php echo $usuario['sexo']?></td>
        </tr>
        <tr>
            <td>Carrera</td>
            <td><?php echo $usuario['carrera']?></td>
        </tr>
        <tr>
            <td>Semestre</td>
            <td><?php echo $usuario['semestre']?>º</td>
        </tr>
        <tr>
            <td>Número de cuenta</td>
            <td><?php echo $usuario['no_cuenta']?></td>
        </tr>
        <tr>
            <td>E-mail</td>
            <td><?php echo $usuario['email']?></td>
        </tr>
        <tr>
            <td>Número celular</td>
            <td><?php echo $usuario['celular']?></td>
        </tr>
        <tr>
            <td>Número de casa</td>
            <td><?php echo $usuario['telefono_fijo']?></td>
        </tr>
        <tr>
            <td>Dirección</td>
            <td><?php echo $usuario['direccion']?></td>
        </tr>
        <tr>
            <td>Clínica</td>
            <td><?php echo $usuario['clinica']?></td>
        </tr>
        <tr>
            <td>Número de clínica</td>
            <td><?php echo $usuario['num_clinica']?></td>
        </tr>
    </tbody>
</table>
<p>
    * Recuerda que antes de haber llenado esta Ficha de inscripción, debes acudir al Departamento de Actividades Culturales para realizar tu pre-registro.
</p>
<div>
<div class="footer">
    
</div>