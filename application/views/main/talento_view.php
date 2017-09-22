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
    <div class="col-md-6">
        <div class="alert alert-info" role="alert">
        NOTA: El registro de datos lo efectuará solamente un integrante (el integrante que es alumno de la FES Aragón)
        </div>
        
    </div>
    <div class="col-md-6">
        <div class="alert alert-info" role="alert">
        NOTA: Asegurate de que puedes imprimir antes de hacer el registro.<br><br>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <form class="form-signin form-horizontal" id="registro_form" action="<?php echo base_url(); ?>talento/insert" method="POST">
            <h3>Formato de inscripción</h3>
            <div class="control-group">
                <label class="control-label" for="name_user">*Nombre completo</label>
                <div class="controls">
                    <input type="text" name="nombre" class="form-control" id="name_user" placeholder="Nombre" value="<?php echo (isset($talento)) ? $talento["nombre"] : "";?>" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="num_cuenta">*No. Cuenta</label>
                <div class="controls">
                    <input type="text" id="num_cuenta" class="form-control" name="num_cta" value="<?php echo (isset($talento)) ? $talento["no_cta"] : "";?>" placeholder="Número de Cuenta" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="carrera_select">*Carrera</label>
                <div class="control">
                    <select name="carrera" id="carrera_select" class="form-control">
                        <option value="">¿De que carrera eres?</option>        
                        <?php
                        if (is_array($carreras)) {
                            foreach ($carreras as $carrera) {
                                ?>
                                <option value="<?php echo $carrera['id'] ?>" <?php echo (isset($talento) && $talento["carrera_id"] == $carrera["id"]) ? "selected" : "";?>><?php echo $carrera['carrera'] ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="semestre_select">*Semestre</label>
                <div class="control">
                    <select name="semestre" id="semestre_select" class="form-control">
                        <option value="">¿De que semestre eres?</option>
                        <?php for($i = 1 ; $i <= 12; $i++){ ?>
                            <option value="<?php echo $i;?>" <?php echo (isset($talento) && $talento["semestre"] == $i) ? "selected" : "";?>><?php echo $i;?>º</option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="banda">*Banda</label>
                <div class="controls">
                    <input type="text" value="<?php echo (isset($talento)) ? $talento["banda"] : "";?>" id="banda" class="form-control" name="banda" placeholder="Nombre de la banda músical" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="integrantes">*Integrantes</label>
                <div class="controls">
                    <input type="text" value="<?php echo (isset($talento)) ? $talento["no_integrantes"] : "";?>" id="integrantes" class="form-control" name="integrantes" placeholder="Número de integrantes" />
                </div>
            </div>
            <div class="control-group">
                <button type="submit" class="btn btn-primary ">Registrar</button>
            </div>
        </form>
    </div>
</div>