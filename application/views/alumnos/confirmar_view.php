<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <form class="form-signin form-horizontal" id="confirmar_form" action="<?php echo base_url(); ?>alumnos/confirmar/update">
            <?php if($return_url){?>
            <input type="hidden" name="return_url" value="<?php echo $return_url;?>">
            <?php }?>
            <h3>Confirma los siguientes datos</h3>
            <div class="control-group">
                <label class="control-label" for="direccion">*Domicilio</label>
                <div class="controls">
                    <input type="text" name="direccion" class="form-control" value="<?php echo $usuario["direccion"]?>" id="direccion" placeholder="" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="celular">*Celular</label>
                <div class="controls">
                    <input type="text" name="celular" class="form-control" value="<?php echo $usuario["celular"]?>" id="celular" placeholder="" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="telefono_fijo">Teléfono Fijo</label>
                <div class="controls">
                    <input type="text" name="telefono_fijo" class="form-control" value="<?php echo $usuario["telefono_fijo"]?>" id="telefono_fijo" placeholder="" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="clinica">*Clínica de servicio médico</label>
                <div class="controls">
                    <input type="text" name="clinica" class="form-control" value="<?php echo $usuario["clinica"]?>" id="clinica" placeholder="" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="num_clinica">*Número de Clínica</label>
                <div class="controls">
                    <input type="text" name="num_clinica" class="form-control" value="<?php echo $usuario["num_clinica"]?>" id="num_clinica" placeholder="" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="sexo">*Sexo</label>
                <div class="controls">
                    <select name="sexo" id="sexo" class="form-control">
                        <option value="">Selecciona</option>
                        <option value="F" <?php echo ($usuario["sexo"] == "F") ? "selected" : "";?>>Femenino</option>
                        <option value="M" <?php echo ($usuario["sexo"] == "M") ? "selected" : "";?>>Masculino</option>
                    </select>
                </div>
            </div>
            <input type="hidden" name="return_url" class="form-control" value="<?php echo $return_url;?>" />
            <div class="text-center" style="margin-top: 20px;margin-bottom:20px;">
                <button type="submit" class="btn btn-success">Continuar</button>
            </div>
        </form>
    </div>
</div>