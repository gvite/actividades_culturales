<div id="encabezado">
    <h3>UNIVERSIDAD NACIONAL AUT&Oacute;NOMA DE M&Eacute;XICO</h3>
    <h4>FES - ARAG&Oacute;N</h4>
    <h5>UNIDAD DE EXTENSI&Oacute;N UNIVERSITARIA</h5>
    <h5>DEPARTAMENTO DE ACTIVIDADES CULTURALES</h5>
    <h6>Programa Talento Aragonés</h6>
    <h6>Concurso de Bandas</h6>
    <h6>(Primera fase)</h6>
    <h5><strong>FICHA DE INSCRIPCIÓN</strong></h5>
</div>

<div>

    <table class="table">
        <thead>     
        </thead>
        <tbody>
            <tr>
                <td>NOMBRE GRUPO</td>
                <td colspan="2"><?php echo $banda["nombre"]; ?></td>
            </tr>
            <tr>
                <td colspan="3">REPRESENTANTE DEL GRUPO</td>
            </tr>
            <tr>
                <td>NOMBRE DE LA PERSONA QUE REPRESENTA AL GRUPO</td>
                <td colspan="2"><?php echo $alumno["nombre"]; ?> <?php echo $alumno["paterno"]; ?> <?php echo $alumno["materno"]; ?></td>
            </tr>
            <tr>
                <td>TELÉFONO FIJO</td>
                <td colspan="2"><?php echo $alumno["telefono_fijo"]; ?></td>
            </tr>
            <tr>
                <td>CELULAR</td>
                <td colspan="2"><?php echo $alumno["celular"]; ?></td>
            </tr>
            <tr>
                <td>CORREO ELECTRÓNICO</td>
                <td colspan="2"><?php echo $alumno["email"]; ?></td>
            </tr>
            <tr>
                <td>CARRERA</td>
                <td colspan="2"><?php echo $alumno["datos"]["carrera"]; ?></td>
            </tr>
            <tr>
                <td>SEMESTRE</td>
                <td colspan="2"><?php echo $alumno["datos"]["semestre"]; ?></td>
            </tr>
            <tr>
                <td>NÚMERO DE CUENTA</td>
                <td colspan="2"><?php echo $alumno["datos"]["no_cuenta"]; ?></td>
            </tr>
            <tr>
                <td colspan="3">DESCRIPCIÓN O SEMBLANZA DEL GRUPO: <br />
                <?php echo $banda["descripcion"]; ?></td>
            </tr>
            <tr>
                <td>NÚMERO DE INTEGRANTES</td>
                <td colspan="2"><?php echo count($banda["integrantes"]); ?></td>
            </tr>
            <tr>
                <td colspan="3">DATOS DE LAS PERSONAS QUE INTEGRAN AL GRUPO</td>
            </tr>
            <tr>
                <td>NOMBRE</td>
                <td>EDAD</td>
                <td>INSTRUMENTO</td>
            </tr>
            <?php foreach($banda["integrantes"] as $integrante){ ?>
                <tr>
                    <td><?php echo $integrante["nombre"];?></td>
                    <td><?php echo $integrante["edad"];?></td>
                    <td><?php echo $integrante["instrumento"];?></td>
                </tr>
            <?php } ?>
            <tr>
                <td colspan="3">Canciones</td>
            </tr>
            <tr>
                <td>NOMBRE</td>
                <td colspan="2">AUTOR</td>
            </tr>
            <?php foreach($banda["canciones"] as $cancion){ ?>
                <tr>
                    <td><?php echo $cancion["nombre"];?></td>
                    <td colspan="2"><?php echo $cancion["autor"];?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>