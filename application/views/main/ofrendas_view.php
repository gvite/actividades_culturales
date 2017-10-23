<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="row ofrendas-content">
<?php foreach($ofrendas as $ofrenda){ ?>
    <div class="col-md-3">
        <div class="thumbnail <?php echo ($voto && $voto["ofrenda_id"]== $ofrenda["id"]) ? "active" : "";?>" data-nombre="<?php echo $ofrenda["nombre"];?>" data-id="<?php echo $ofrenda["id"];?>" data-votos="<?php echo $ofrenda["votos"];?>">
            <img src="<?php echo base_url();?>uploads/ofrendas/<?php echo $ofrenda["img"]?>" alt="">
            <div class="caption">
                <h3><?php echo $ofrenda["nombre"];?></h3>
                <p>
                    <?php if ($voto === false){?>
                    <button class="btn btn-primary btn-votar" data-id="<?php echo $ofrenda["id"];?>" role="button">Votar</button> 
                    <?php } ?>
                    <span class="badge <?php if($voto === false) {?>pull-right<?php } ?>"><?php echo $ofrenda["votos"];?> Votos</span>
                </p>
                
            </div>
        </div>
    </div>
<?php } ?>
</div>