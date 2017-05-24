<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?>
<div class="footer">
        <strong>Requisitos para terminar inscripci&oacute;n:</strong>
        <ul>
            <li>Original y Copia de hoja de inscripción al taller.</li>
            <?php
            switch (get_type_user()) {
                case 2:
                    ?>
                    
                    <li>Copia de credencial que compruebe su status de alumno.</li>
                    <?php
                    break;
                case 3:
                    ?>
                    
                    <li>Copia de credencial que compruebe su status de exalumno.</li>
                    <?php
                    break;
                case 4:
                    ?>
                    <li>Copia de credencial que compruebe su status de empleado.</li>
                    <?php
                    break;
                case 5:
                    ?>
                    <li>Identificación oficial.</li>
                    <li>Ticket de pago y 2 copias del mismo.</li>
                    <?php
                    break;
            }
            ?>
        </ul>
    <p>El presente pago se debe realizar antes de esta fecha: <strong><?php echo $date_fin['mday'] . '/' . $date_fin['mon'] . '/' . $date_fin['year'] ?></strong>. Y debe ser presentado en <strong>Extensi&oacute;n Universitaria</strong> antes de las <?php echo $termina_hora ?>:00 hrs. para que se concluya su inscripci&oacute;n.</p>
</div>