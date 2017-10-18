<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?>
<table class="table">
    <thead>
        <tr>
            <th>Evento</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($eventos as $evento){?>
        <tr>
            <td><?php echo $evento["nombre"]?></td>
            <td><a class="btn btn-success" href="<?php echo base_url()?>admin/ofrendas/lista/<?php echo $evento["id"]?>">+</a></td>
        </tr>
        <?php } ?>
    </tbody>
</table>