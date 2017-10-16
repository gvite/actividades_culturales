<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?>
<?php if(isset($errors)){ ?>
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-danger" role="alert">
            <?php echo $errors;?>
        </div>
      </div>  
    </div>
<?php } ?>
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <form class="form-signin form-horizontal" id="registro_form" action="<?php echo base_url(); ?>talento/insert" method="POST">
            <input type="hidden" name="evento_id" value="<?php echo $evento_id;?>">
            <?php if($banda){?>
                <input type="hidden" name="banda_id" value="<?php echo $banda["id"];?>">
            <?php }?>
            <h3>Formato de inscripción</h3>
            <div class="control-group">
                <label class="control-label" for="banda">*Grupo</label>
                <div class="controls">
                    <input type="text" value="<?php echo (isset($banda)) ? $banda["nombre"] : "";?>" id="banda" class="form-control" name="banda" placeholder="Nombre de la banda músical" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="genero">*Genero</label>
                <div class="controls">
                    <input type="text" value="<?php echo (isset($banda)) ? $banda["genero"] : "";?>" id="genero" class="form-control" name="genero" placeholder="Genero de la banda músical" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="banda">*Descripción o semblanza del grupo</label>
                <div class="controls">
                    <textarea id="descripcion" class="form-control" name="descripcion" placeholder=""><?php echo (isset($banda)) ? $banda["descripcion"] : "";?></textarea>
                </div>
            </div>
            <h3>Integrantes <a href="#agregar_integrante_modal" data-toggle="modal" class="btn btn-success">Agregar <span class="glyphicon glyphicon-log-in"></span></a></h3>
            <table class="table table-integrantes">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Edad</th>
                        <th>Instrumento</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                <?php if($banda){?>
                <?php foreach($banda["integrantes"] as $key => $integrante){?>
                    <tr>
                        <td><input type='hidden' name='integrantes[<?php echo $key;?>][nombre]' value='<?php echo $integrante["nombre"];?>'><?php echo $integrante["nombre"];?></td>
                        <td><input type='hidden' name='integrantes[<?php echo $key;?>][edad]' value='<?php echo $integrante["edad"];?>'><?php echo $integrante["edad"];?></td>
                        <td><input type='hidden' name='integrantes[<?php echo $key;?>][instrumento]' value='<?php echo $integrante["instrumento"];?>'><?php echo $integrante["instrumento"];?></td>
                        <td><button class='btn btn-danger'>-</button></td>
                    </tr>
                <?php }?>
                <?php }?>
                </tbody>
            </table>
            <h3>Canciones (2)<a id="canciones_modal_a" href="#agregar_canciones_modal" data-toggle="modal" class="btn btn-success <?php echo (isset($banda["canciones"])&& count($banda["canciones"]) === 2) ? "hide":"";?>">Agregar <span class="glyphicon glyphicon-log-in"></span></a></h3>
            <table class="table table-canciones">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Autor</th>
                        <th>Links</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                <?php if($banda){?>
                <?php foreach($banda["canciones"] as $key => $cancion){?>
                    <tr>
                        <td><input type='hidden' name='canciones[<?php echo $key;?>][nombre]' value='<?php echo $cancion["nombre"];?>'><?php echo $cancion["nombre"];?></td>
                        <td><input type='hidden' name='canciones[<?php echo $key;?>][autor]' value='<?php echo $cancion["autor"];?>'><?php echo $cancion["autor"];?></td>
                        <td>
                            <input type='hidden' name='canciones[<?php echo $key;?>][youtube]' value='<?php echo $cancion["youtube"];?>'>
                            <input type='hidden' name='canciones[<?php echo $key;?>][soundcloud]' value='<?php echo $cancion["soundcloud"];?>'>
                            <input type='hidden' name='canciones[<?php echo $key;?>][facebook]' value='<?php echo $cancion["facebook"];?>'>
                            <input type='hidden' name='canciones[<?php echo $key;?>][twitter]' value='<?php echo $cancion["twitter"];?>'>
                            <?php if( $cancion["youtube"]){ ?>
                            <a href="<?php echo $cancion["youtube"];?>" target="_blank"><i class="fa fa-youtube" aria-hidden="true"></i></a>
                            <?php } ?>
                            <?php if( $cancion["soundcloud"]){ ?>
                            <a href="<?php echo $cancion["soundcloud"];?>" target="_blank"><i class="fa fa-soundcloud" aria-hidden="true"></i></a>
                            <?php } ?>
                            <?php if( $cancion["facebook"]){ ?>
                            <a href="<?php echo $cancion["facebook"];?>" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                            <?php } ?>
                            <?php if( $cancion["twitter"]){ ?>
                            <a href="<?php echo $cancion["twitter"];?>" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                            <?php } ?>
                        </td>
                        <td><button class='btn btn-danger'>-</button></td>
                    </tr>
                <?php }?>
                <?php }?>
                </tbody>
            </table>
            <div class="control-group">
                <button type="submit" class="btn btn-primary"><?php echo ($banda) ? "Guardar" : "Registrar"?></button>
            </div>
        </form>
    </div>
</div>
<div class="modal fade active" id="agregar_integrante_modal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form class="form-signin form-horizontal" id="agregar_integrante" action="/">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Integrantes</h4>
                </div>
                <div class="modal-body">
                    <div class="control-group">
                        <label class="control-label" for="nombreintegrante">*Nombre</label>
                        <div class="controls">
                            <input type="text" value="" id="nombreintegrante" class="form-control" name="" placeholder="Nombre del Integrante" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="edadintegrante">*Edad</label>
                        <div class="controls">
                            <input type="text" value="" id="edadintegrante" class="form-control" name="" placeholder="Edad del Integrante" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="instrumentointegrante">*Instrumento</label>
                        <div class="controls">
                            <input type="text" value="" id="instrumentointegrante" class="form-control" name="" placeholder="Instrumento que toca el integrante" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary ">Agregar</button>
                </div>
                
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<div class="modal fade active" id="agregar_canciones_modal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form class="form-signin form-horizontal" id="agregar_cancion" action="/">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Canción</h4>
                </div>
                <div class="modal-body">
                    <div class="control-group">
                        <label class="control-label" for="nombrecancion">*Nombre</label>
                        <div class="controls">
                            <input type="text" value="" id="nombrecancion" class="form-control" name="" placeholder="Nombre del Integrante" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="autorcancion">*Autor</label>
                        <div class="controls">
                            <input type="text" value="" id="autorcancion" class="form-control" name="" placeholder="Edad del Integrante" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="ytcancion">Link YouTube</label>
                        <div class="controls">
                            <input type="text" value="" id="ytcancion" class="form-control" name="" placeholder="YouTube" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="sccancion">Link SoundCloud</label>
                        <div class="controls">
                            <input type="text" value="" id="sccancion" class="form-control" name="" placeholder="SoundCloud" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="fbcancion">Link Facebook</label>
                        <div class="controls">
                            <input type="text" value="" id="fbcancion" class="form-control" name="" placeholder="Facebook" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="twcancion">Link Twitter</label>
                        <div class="controls">
                            <input type="text" value="" id="twcancion" class="form-control" name="" placeholder="Twitter" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary ">Agregar</button>
                </div>
                
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>