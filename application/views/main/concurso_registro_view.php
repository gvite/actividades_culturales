<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?>
<div class="row">
<?php if($status === "OK"){?>
    <h3>Registro Exitoso</h3>
    <p>Imprime tu ficha de inscripción y la carta responsiva, necesarios para terminar tu registro en el departamento de Actividades Culturales</p>
    <div class="text-center">
        <a class="btn btn-success" href="<?php echo base_url();?>concursos/get-pdf/<?php echo $concurso["id"];?>" target="_blank">Ficha de Inscripción</a>
        <a class="btn btn-success" href="<?php echo base_url();?>concursos/get-pdf-responsiva/<?php echo $concurso["id"];?>" target="_blank">Carta Responsiva</a>
    </div>
<?php }else{ ?>
    <h3><?php echo $message;?></h3>
<?php } ?>
</div>