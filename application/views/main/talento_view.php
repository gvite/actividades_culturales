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
      <div class="col-md-12">
        <div class="alert alert-info" role="alert">
        NOTA: El registro de datos lo efectuará solamente un integrante (el integrante que es alumno de la FES Aragón)
        </div>
      </div>  
    </div>
<div class="row">
    <div class="col-md-6">
        <form class="form-signin form-horizontal" id="registro_form" action="<?php echo base_url(); ?>talento/insert" method="POST">
            <h3>Formato de inscripción</h3>
            <div class="control-group">
                <label class="control-label" for="name_user">*Nombre completo</label>
                <div class="controls">
                    <input type="text" name="nombre" class="form-control" id="name_user" placeholder="Nombre" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="num_cuenta">*No. Cuenta</label>
                <div class="controls">
                    <input type="text" id="num_cuenta" class="form-control" name="num_cta" placeholder="Número de Cuenta" />
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
                                <option value="<?php echo $carrera['id'] ?>"><?php echo $carrera['carrera'] ?></option>
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
                        <option value="1">1º</option>
                        <option value="2">2º</option>
                        <option value="3">3º</option>
                        <option value="4">4º</option>
                        <option value="5">5º</option>
                        <option value="6">6º</option>
                        <option value="7">7º</option>
                        <option value="8">8º</option>
                        <option value="9">9º</option>
                        <option value="10">10º</option>
                        <option value="11">11º</option>
                        <option value="12">12º</option>
                    </select>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="banda">*Banda</label>
                <div class="controls">
                    <input type="text" id="banda" class="form-control" name="banda" placeholder="Nombre de la banda músical" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="integrantes">*Integrantes</label>
                <div class="controls">
                    <input type="text" id="integrantes" class="form-control" name="integrantes" placeholder="Número de integrantes" />
                </div>
            </div>
            <div class="control-group">
                <button type="submit" class="btn btn-primary ">Registrar</button>
            </div>
        </form>
    </div>
</div>