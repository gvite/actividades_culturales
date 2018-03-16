<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?>
<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>ID</th>
            <th>Usuario</th>
            <th>Tipo</th>
            <th>No Cta. / No Trabajador</th>
            <th>Carrera/Área</th>
            <th>Fecha</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($votos as $key => $voto){?>
        <tr>
            <td><?php echo $key + 1;?></td>
            <td><?php echo $voto["id"]?></td>
            <td><?php echo $voto["nombre"]?> <?php echo $voto["paterno"]?> <?php echo $voto["materno"]?></td>
            <td><?php echo $voto["tipo_usuario"]?></td>
            <td><?php echo ($voto["no_cuenta"]) ? $voto["no_cuenta"]: $voto["no_trabajador"]?></td>
            <td><?php echo ($voto["carrera"]) ? $voto["carrera"]: $voto["area"]?></td>
            <td><?php echo $voto["fecha_voto"]?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>