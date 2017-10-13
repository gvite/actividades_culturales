<div class="modal fade active" id="form_register_alumno_modal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form class="form-signin form-horizontal" id="registro_form" action="<?php echo base_url(); ?>acceso/registro/insert">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Registro de Alumnos</h4>
                </div>
                <div class="modal-body">
                    <h3>Datos de acceso</h3>
                    <div class="control-group">
                        <label class="control-label" for="user_input_ar">*Nickname</label>
                        <div class="controls">
                            <input name="user" id="user_input_ar" class="form-control" type="text" placeholder="usuario" />
                            <span class="help-block">El usuario ya existe, ingresa otro por favor.</span>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="pass_input_aux">*Contrase&ntilde;a</label>
                        <div class="controls">
                            <input type="password" name="" class="form-control" id="pass_input_aux" placeholder="Password">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="repass_input_aux">*Repite Contrase&ntilde;a</label>
                        <div class="controls">
                            <input type="password" name="" class="form-control" id="repass_input_aux" placeholder="Password">
                        </div>
                    </div>
                    <h3>Datos personales</h3>
                    <div class="control-group">
                        <label class="control-label" for="name_user">*Nombre</label>
                        <div class="controls">
                            <input type="text" name="name_user" class="form-control" id="name_user" placeholder="Nombre(s)" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="paterno_user">*Apellido Paterno</label>
                        <div class="controls">
                            <input type="text" name="paterno_user" class="form-control" id="paterno_user" placeholder="Apellido Paterno" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="materno_user">Apellido Materno</label>
                        <div class="controls">
                            <input type="text" name="materno_user" class="form-control" id="materno_user" placeholder="Apellido Materno" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="correo_user">*E-Mail</label>
                        <div class="controls">
                            <input type="text" name="correo_user" id="correo_user" placeholder="user@example.com" class="input-xlarge form-control" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="telefono_fijo">Teléfono fijo</label>
                        <div class="controls">
                            <input type="text" name="telefono_fijo" id="telefono_fijo" placeholder="" class="input-xlarge form-control" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="celular">Celular</label>
                        <div class="controls">
                            <input type="text" name="celular" id="celular" placeholder="" class="input-xlarge form-control" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="nacimiento_user_input">*Fecha de Nacimiento</label>
                        <div class="controls">
                            <div class="input-group date" id="nacimiento_user" data-date-format="DD-MM-YYYY">
                                <input name="nacimiento_user" class="fecha_input form-control" id="nacimiento_user_input" type="text" placeholder="dd-mm-yyyy" />
                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="num_cuenta">*No. Cuenta</label>
                        <div class="controls">
                            <input type="text" id="num_cuenta" class="form-control" name="num_cuenta" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="carrera_select">*Carrera</label>
                        <div class="control">
                            <select name="carrera" id="carrera_select" class="form-control">
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
                        <label id="label_ingreso" class="control-label" for="ingreso_egreso">*A&ntilde;o de ingreso</label>
                        <div class="controls">
                            <input type="text" id="ingreso_egreso" name="ingreso_egreso" class="input-small form-control" />
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
                    <input type="hidden" name="pass" id="pass_input" />
                    <input type="hidden" name="repass" id="repass_input">
                    <input type="hidden" name="type_user" value="2" />
                    <input type="hidden" name="facultad" value="1" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary ">Registrar</button>
                </div>
                
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>