<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?>
<div>
    <h4>UNIDAD DE EXTENSI&Oacute;N UNIVERSITARIA</h4>
    <h4>DEPARTAMENTO DE ACTIVIDADES CULTURALES</h4>
    <h4><?php echo strtoupper(($semestre) ? $semestre['semestre'] : "Todo");?></h4>
</div>
<div>
    Carrera: <?php echo $carrera['carrera']?>
</div>
<?php if (is_array($talleres)) { 
$total = 0;
foreach ($talleres as $taller) {
    ?>
    Taller: <?php echo $taller['taller']; ?>
    Número de alumnos: <?php echo $taller['num_alumnos']; ?>
    <table class="table">
    <thead>
        <tr>
            <th>No.</th>
            <th>Alumno</th>
            <th>No Cta</th>
            <th>Carrera</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($taller['alumnos'] as $key => $alumno) {
            ?>
            <tr>
                <td><?php echo $key + 1 ?></td>
                <td><?php echo $alumno['nombre'] . " " . $alumno['paterno'] . ' ' . $alumno['materno'] ?></td>
                <td><?php echo $alumno['no_cuenta'] ?></td>
                <td><?php echo $alumno['carrera'] ?></td>
            </tr>
            <?php
        }
        ?>
    </tbody>
    </table>
<?php 
    }
}else{
?>
    No hay registros.
<?php
}
?>
