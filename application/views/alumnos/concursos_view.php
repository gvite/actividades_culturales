<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?>
<?php foreach($concursos as $concurso){ ?>
    <h3><?php echo $concurso['nombre'];?></h3>
<?php } ?>