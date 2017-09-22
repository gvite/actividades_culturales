<h2>Registro Exitoso</h2>
<table class="table">
    <thead>
        
    </thead>
    <tbody>
        <tr>
            <td>Alumno</td>
            <td><?php echo $talento['nombre']; ?></td>
        </tr>
        <tr>
            <td>Número de cuenta</td>
            <td><?php echo $talento['no_cta']; ?></td>
        </tr>
        <tr>
            <td>Banda</td>
            <td><?php echo $talento['banda']; ?></td>
        </tr>
        <tr>
            <td>Integrantes</td>
            <td><?php echo $talento['no_integrantes']; ?></td>
        </tr>
        <tr>
            <td></td>
            <td><a href="<?php echo base_url();?>talento/pdf/<?php echo $talento['id']?>" class="btn btn-success">Imprimir</a></td>
        </tr>
    </tbody>
</table>