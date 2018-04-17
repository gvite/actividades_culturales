<table class="table">
    <thead>
        <tr>
            <th>Alumno</th>
            <th>No Cta</th>
            <th>Semestre</th>
            <th>Facultad</th>
            <th>Carrera</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($concurso['participantes'] as $participante) {?>
            <tr>
                <td><?php echo $participante['nombre']?> <?php echo $participante['paterno']?> <?php echo $participante['materno']?></td>
                <td><?php echo $participante['no_cuenta']?></td>
                <td><?php echo $participante['semestre']?></td>
                <td><?php echo $participante['facultad']?></td>
                <td><?php echo $participante['carrera']?></td>
            </tr>
        <?php }?>
    </tbody>
</table>