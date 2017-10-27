<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?>
<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>Usuario</th>
            <th>Fecha</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($votos as $key => $voto){?>
        <tr>
            <td><?php echo $key + 1;?></td>
            <td><?php echo $voto["nombre"]?> <?php echo $voto["paterno"]?> <?php echo $voto["materno"]?></td>
            <td><?php echo $voto["fecha_voto"]?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>