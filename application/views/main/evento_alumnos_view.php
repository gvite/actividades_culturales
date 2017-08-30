<h2>Alumnos</h2>
<table class="table" id="alumnos_evento">
    <thead>
        <tr>
            <th>Alumno</th>
            <th>Folio</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($asistentes as $asistente){?>
            <tr>
                <td><?php echo $asistente["usuario_nombre"];?></td>
                <td><?php echo $asistente["folio"];?></td>
                <td>
                    <?php if($asistente["asistencia"] == 0){?>
                        <button class="btn btn-success btn-asistencia" data-id="<?php echo $asistente["asistente_id"];?>">Asistencia</button>
                    <?php }else{ ?>
                        <button class="btn btn-danger btn-noasistencia" data-id="<?php echo $asistente["asistente_id"];?>">Quitar Asistencia</button>
                    <?php } ?>
                    
                </td>
            </tr>
        <?php }?>
    </tbody>
</table>