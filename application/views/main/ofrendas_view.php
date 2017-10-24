<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="row">
    <div class="col-md-6">
        <div class="input-group">
            <input type="text" class="form-control" id="input_find" placeholder="Número de Ofrenda">
            <span class="input-group-btn">
                <button class="btn btn-default" type="button" id="findBtn">Buscar</button>
            </span>
            <span class="input-group-btn">
                <button class="btn btn-default" type="button" id="findBtnAll">Mostar Todas</button>
            </span>
        </div><!-- /input-group -->
    </div><!-- /.col-lg-6 -->
</div>
<div class="row ofrendas-content">
<?php foreach($ofrendas as $ofrenda){ ?>
    <div class="col-md-3 ofrenda-item-<?php echo $ofrenda["numero"];?>">
        <div class="thumbnail <?php echo ($voto && $voto["ofrenda_id"]== $ofrenda["id"]) ? "active" : "";?>" data-nombre="<?php echo $ofrenda["nombre"];?>" data-id="<?php echo $ofrenda["id"];?>" data-votos="<?php echo $ofrenda["votos"];?>">
            <img src="<?php echo base_url();?>uploads/ofrendas/<?php echo $ofrenda["img"]?>" alt="">
            <div class="caption">
                <h3><?php echo $ofrenda["numero"];?> - <?php echo $ofrenda["nombre"];?></h3>
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