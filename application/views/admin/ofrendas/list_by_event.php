<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?>
<div class="row">
    <div class="col-md-12">
        <a href="#add_offering_modal" id="btn_add_offering_modal" data-toggle="modal" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-plus-sign">&nbsp;</span> Agregar</a>
    </div>
</div>
<table class="table">
    <thead>
        <tr>
            <th>Imagen</th>
            <th>Ofrenda</th>
            <th>Votos</th>
            <th>Descripción</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($ofrendas as $ofrenda){?>
        <tr data-id="<?php echo $ofrenda['id'];?>">
            <td><a href="<?php echo base_url() . "uploads/ofrendas/" .$ofrenda["img"]?>" target="_blank"><img width="50px" src="<?php echo base_url() . "uploads/ofrendas/" .$ofrenda["img"]?>" /></a></td>
            <td><?php echo $ofrenda["nombre"]?></td>
            <td><?php echo $ofrenda["votos"]?></td>
            <td><?php echo $ofrenda["descripcion"]?></td>
            <td>
                <button class="btn btn-default btn-edit">Editar</button>
                <a href="<?php echo base_url()?>admin/ofrendas/votos/<?php echo $ofrenda["id"];?>" class="btn btn-default btn-votos">Votos</button>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>
<div class="modal fade" id="add_offering_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-signin form-horizontal" method="POST" id="offering_form" action="admin/ofrendas/insert">
                <input type="hidden" name="evento_id" value="<?php echo $evento_id?>" />
                <div class="modal-header">
                    <button class="close" data-dismiss="modal" type="button">&times;</button>
                    <h3>Agregar Ofrenda</h3>
                </div>
                <input name="id" type="hidden" id="id_input">
                <div class="modal-body">
                    <div class="control-group">
                        <label class="control-label" for="titulo_input">Título</label>
                        <div class="controls">
                            <input name="nombre" class="form-control" id="titulo_input" type="text" placeholder="Título" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="descripcion_input">Descripción</label>
                        <div class="controls">
                            <textarea name="descripcion" class="form-control" id="descripcion_input" placeholder="Descripción" ></textarea>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label for="img_offering">Imagen</label>
                        <input type="file" id="img_offering" name="file">
                        <p class="help-block">Formatos soportados: .jpg .png</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>