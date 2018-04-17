<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?>
<div class="row">
<?php foreach($concursos as $concurso){ ?>
    <div class="col-md-4">
        <div class="thumbnail thumbnail-events">
            <img src="<?php echo base_url();?>images/concursos/<?php echo $concurso["thumbnail"];?>" />
            <div class="caption">
                <h3><?php echo $concurso['nombre'];?></h3>
                <strong><?php echo $concurso["fecha"];?></strong>
                <div>
                    <a href="<?php echo base_url();?>concursos/<?php echo $concurso["slug"];?>" class="btn btn-success">Información <span class="glyphicon glyphicon-log-in"></span></a>
                    <a href="<?php echo base_url();?>admin/concursos/get/<?php echo $concurso["slug"];?>" class="btn btn-success">Participantes <span class="badge"><?php echo $concurso["participantes"];?></span></a>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
</div>