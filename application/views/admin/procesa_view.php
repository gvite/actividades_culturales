<ul>
<?php
foreach($bauchers as $baucher){
    if($baucher['count_talleres']>1){
?>
<li><?php echo $baucher['folio'];?> : <?php echo $baucher['count_talleres'];?> : <?php echo $baucher['status']?></li>
<?php
    }
}
?>
</ul>