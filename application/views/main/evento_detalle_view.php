
<h1><?php echo $evento["nombre"];?></h1>
<table class="table">
    <thead>
        <tr>
            <th>Evento</th>
            <th>Descripción</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Alumno</td>
            <td><?php echo $evento["usuario_nombre"]?> <?php echo $evento["usuario_paterno"]?> <?php echo $evento["usuario_materno"]?></td>
        </tr>
        <tr>
            <td>Folio</td>
            <td><?php echo $evento["folio"]?></td>
        </tr>
        <tr>
            <td>Lugar</td>
            <td><?php echo $evento["lugar"]?> <?php echo $evento["sala"]?></td>
        </tr>
        <tr>
            <td>Fecha</td>
            <td><?php echo exchange_date_time($evento["fecha"])?></td>
        </tr>
        <tr>
            <td>Nota</td>
            <td><?php echo $evento["descripcion"]?></td>
        </tr>
    </tbody>
</table>
<div style="text-align:center">
    <a href="<?php echo base_url()?>eventos/pdf/<?php echo $evento["id"];?>" class="btn btn-success">Imprimir</a>
</div>
