<h2>Alumnos inscritos</h2>
<table class="table">
    <thead>
        <tr>
            <th>Folio</th>
            <th>Alumno</th>
            <th>Número de Cuenta</th>
            <th>Carrera</td>
            <th>Banda</th>
            <th>Integrantes</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php if(isset($alumnos) && is_array($alumnos)){ ?>
            <?php foreach($alumnos as $alumno){?>
                <tr>
                    <td><?php echo $alumno["id"];?></td>
                    <td><?php echo $alumno["nombre"];?></td>
                    <td><?php echo $alumno["no_cta"];?></td>
                    <td><?php echo $alumno["carrera"];?></td>
                    <td><?php echo $alumno["banda"];?></td>
                    <td><?php echo $alumno["no_integrantes"];?></td>
                    <th><a href="<?php echo base_url();?>talento/pdf/<?php echo $alumno["id"];?>" target="_blank">PDF</a></th>
                </tr>
            <?php } ?>
        <?php }else{ ?>
            <tr><td colspan="5">No hay Registros</td></tr>
        <?php } ?>
    </tbody>
</table>