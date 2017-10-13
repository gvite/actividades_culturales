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
            <h3>Formato de inscripción</h3>
            <div class="control-group">
                <label class="control-label" for="banda">*Grupo</label>
                <div class="controls">
                    <input type="text" value="<?php echo (isset($talento)) ? $talento["banda"] : "";?>" id="banda" class="form-control" name="banda" placeholder="Nombre de la banda músical" />
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="banda">*Descripción o semblanza del grupo</label>
                <div class="controls">
                    <textarea value="<?php echo (isset($talento)) ? $talento["descripcion"] : "";?>" id="descripcion" class="form-control" name="descripcion" placeholder=""></textarea>
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
                </tbody>
            </table>

            <h3>Canciones <a href="#agregar_canciones_modal" data-toggle="modal" class="btn btn-success">Agregar <span class="glyphicon glyphicon-log-in"></span></a></h3>
            
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
                </tbody>
            </table>
            <div class="control-group">
                <button type="submit" class="btn btn-primary">Registrar</button>
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