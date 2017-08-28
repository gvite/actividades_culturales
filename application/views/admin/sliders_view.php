<div class="row">
    <div class="col-md-12">
        <a href="#add_sliders_modal" id="btn_add_sliders_modal" data-toggle="modal" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-plus-sign">&nbsp;</span> Agregar</a>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <table class="table">
            <thead>
                <tr>
                    <th class="text-center">Imagen</th>
                    <th class="text-center">Titulo</th>
                    <th class="text-center">Orden</th>
                    <th class="text-center">Link</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if($sliders){
                        foreach($sliders as $slider){
                            ?>
                            <tr data-id="<?php echo $slider['id'];?>">
                                <td class="text-center"><img width="50px" src="<?php echo base_url()."uploads/sliders/".$slider["img"]?>"></td>
                                <td class="text-center"><?php echo $slider["titulo"]?></td>
                                <td class="text-center"><?php echo $slider["orden"]?></td>
                                <td class="text-center"><?php echo $slider["link"]?></td>
                                <td class="text-center"><button class="btn btn-default btn-edit">Editar</button><!--<button class="btn btn-danger btn-delete">Eliminar</button>--></td>
                            </tr>
                            <?php
                        }
                    }else{
                        ?>
                        <tr>
                            <td colspan="5" class="text-center">No hay registros.</td>
                        </tr>
                        <?php
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>
<div class="modal fade" id="add_sliders_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-signin form-horizontal" method="POST" id="slider_form" action="admin/sliders/insert">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal" type="button">&times;</button>
                    <h3>Agregar Slider</h3>
                </div>
                <input name="id" type="hidden" id="id_input">
                <div class="modal-body">
                    <div class="control-group">
                        <label class="control-label" for="titulo_input">Título</label>
                        <div class="controls">
                            <input name="titulo" class="form-control" id="titulo_input" type="text" placeholder="Título" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="link_input">Link</label>
                        <div class="controls">
                            <input name="link" class="form-control" id="link_input" type="text" placeholder="Link" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="orden_input">Orden</label>
                        <div class="controls">
                            <input name="orden" class="form-control" id="orden_input" type="number" placeholder="Orden" />
                        </div>
                    </div>
                    <div class="checkbox">
                        <label class="control-label" for="visible_input">
                            <input name="visible" id="visible_input" type="checkbox" value="1"/> Visible
                        </label>
                    </div>
                    <div class="control-group">
                        <label for="img_slider">Imagen</label>
                        <input type="file" id="img_slider" name="file">
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