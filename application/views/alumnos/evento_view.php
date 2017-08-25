<h3>BOLETO ELECTRÓNICO (ESTUDIANTE)</h3>
<div class="ticket">
    <div class="header">
        <h3>UNIVERSIDAD NACIONAL AUT&Oacute;NOMA DE M&Eacute;XICO</h3>
        <h4>FES - ARAG&Oacute;N</h4>
        <h5>UNIDAD DE EXTENSI&Oacute;N UNIVERSITARIA</h5>
        <h5>DEPARTAMENTO DE ACTIVIDADES CULTURALES</h5>
    </div>
    <div class="body">
        <table>
            <tbody>
                <tr>
                    <td>Alumno:</td>
                    <td class="td-col-6"><?php echo $evento["usuario_nombre"];?> <?php echo $evento["usuario_paterno"];?> <?php echo $evento["usuario_materno"];?></td>
                </tr>
                <tr>
                    <td>Evento:</td>
                    <td class="td-col-6"><?php echo $evento["nombre"];?></td>
                </tr>
                <tr>
                    <td>Lugar:</td>
                    <td class="td-col-6"><?php echo $evento["lugar"];?> - <?php echo $evento["sala"];?></td>
                </tr>
                <tr>
                    <td>Fecha y hora:</td>
                    <td class="td-col-6"><?php echo exchange_date_time($evento["fecha"]);?></td>
                </tr>
                <tr>
                    <td>Folio:</td>
                    <td class="td-col-6"><?php echo $evento["folio"];?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="line">&nbsp;</div>
<h3>BOLETO ELECTRÓNICO (PERSONAL DEL EVENTO)</h3>
<div class="ticket">
    <div class="header">
        <h3>UNIVERSIDAD NACIONAL AUT&Oacute;NOMA DE M&Eacute;XICO</h3>
        <h4>FES - ARAG&Oacute;N</h4>
        <h5>UNIDAD DE EXTENSI&Oacute;N UNIVERSITARIA</h5>
        <h5>DEPARTAMENTO DE ACTIVIDADES CULTURALES</h5>
    </div>
    <div class="body">
        <table>
            <tbody>
                <tr>
                    <td>Alumno:</td>
                    <td class="td-col-6"><?php echo $evento["usuario_nombre"];?> <?php echo $evento["usuario_paterno"];?> <?php echo $evento["usuario_materno"];?></td>
                </tr>
                <tr>
                    <td>Evento:</td>
                    <td class="td-col-6"><?php echo $evento["nombre"];?></td>
                </tr>
                <tr>
                    <td>Lugar:</td>
                    <td class="td-col-6"><?php echo $evento["lugar"];?> - <?php echo $evento["sala"];?></td>
                </tr>
                <tr>
                    <td>Fecha y hora:</td>
                    <td class="td-col-6"><?php echo exchange_date_time($evento["fecha"]);?></td>
                </tr>
                <tr>
                    <td>Folio:</td>
                    <td class="td-col-6"><?php echo $evento["folio"];?></td>
                </tr>   
            </tbody>
        </table>
    </div>
</div>