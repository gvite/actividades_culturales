<div class="col-md-12">
    <button class="btn btn-success" id="btn_add_user">Agregar</button>
    <table class="table" id="table_usuarios">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellido Paterno</th>
                <th>Apellido Materno</th>
                <th>Nickname</th>
                <th>Tipo</th>
                <th>E-mail</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if(is_array($usuarios)){
                foreach($usuarios as $usuario){
                ?>
                <tr class="<?php echo ($usuario['status'] == 1)? 'success': 'danger'; ?>" 
                    data-id="<?php echo $usuario['id']; ?>"
                    data-nombre="<?php echo $usuario['nombre']; ?>"
                    data-paterno="<?php echo $usuario['paterno']; ?>"
                    data-materno="<?php echo $usuario['materno']; ?>"
                    data-nickname="<?php echo $usuario['nickname']; ?>"
                    data-email="<?php echo $usuario['email']; ?>"
                    data-nacimiento="<?php echo exchange_date($usuario['nacimiento']); ?>"
                    data-tipo="<?php echo $usuario['tipo_usuario_id']; ?>"
                    >
                    <td><?php echo $usuario['nombre']; ?></td>
                    <td><?php echo $usuario['paterno']; ?></td>
                    <td><?php echo $usuario['materno']; ?></td>
                    <td><?php echo $usuario['nickname']; ?></td>
                    <td><?php echo ($usuario['tipo_usuario_id'] == 1) ? 'Administrador' : 'Pasante'; ?></td>
                    <td><?php echo $usuario['email']; ?></td>
                    <td>
                        <button data-action="edit" class="btn btn-default edit-button" title="Editar">
                            <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                        </button>
                        <button data-action="delete" class="btn btn-default event-button delete-btn <?php echo ($usuario['status'] == 0) ? 'hide' : '';?>" title="Dar de baja">
                            <span class="glyphicon glyphicon glyphicon-trash" aria-hidden="true"></span>
                        </button>
                        <button data-action="return_user" class="btn btn-default event-button return-btn <?php echo ($usuario['status'] == 1) ? 'hide' : '';?>" title="Dar de alta">
                            <span class="glyphicon glyphicon glyphicon-cloud" aria-hidden="true"></span>
                        </button>
                    </td>
                </tr>
                <?php
                }
            }
            ?>
        </tbody>
    </table>
</div>
<div class="row">
    <div class="modal fade active" id="add_user_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="form-signin form-horizontal" id="add_user_form" action="<?php echo base_url(); ?>admin/usuarios/insert">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal" type="button">&times;</button>
                        <h3>Datos de acceso</h3>
                    </div>
                    <div class="modal-body">
                        <div class="control-group">
                            <label class="control-label" for="usuario_input">*Nickname</label>
                            <div class="controls">
                                <input name="usuario" id="usuario_input" class="form-control" type="text" placeholder="usuario" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="password_usuario_input">Contrase&ntilde;a</label>
                            <div class="controls">
                                <input type="password" class="form-control" id="password_usuario_input" placeholder="Password">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="repass_input_aux">Repite Contrase&ntilde;a</label>
                            <div class="controls">
                                <input type="password" class="form-control" id="repass_input_aux" placeholder="Password">
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
                            <label class="control-label" for="type_user">*Tipo de Usuario</label>
                            <div class="controls">
                                <select name="type_user" id="type_user" class="form-control">
                                    <option value="0" selected>Selecciona</option>
                                    <option value="1">Administrador</option>
                                    <option value="6">Pasante</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="pass" class="form-control" id="pass_input" />
                        <input type="hidden" name="repass" class="form-control" id="repass_input">
                        <button type="button" data-dismiss="modal" class="btn">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
</div>
<div class="row">
    <div class="modal fade active" id="edit_user_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="form-signin form-horizontal" id="edit_user_form" action="<?php echo base_url(); ?>admin/usuarios/update">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal" type="button">&times;</button>
                        <h3>Actualizar usuario</h3>
                    </div>
                    <div class="modal-body">
                        <div class="control-group">
                            <label class="control-label" for="usuario_input">*Nickname</label>
                            <div class="controls">
                                <input name="usuario" id="usuario_input" class="form-control" type="text" placeholder="usuario"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="password_usuario_input">Contrase&ntilde;a</label>
                            <div class="controls">
                                <input type="password" class="form-control" id="password_usuario_input_edit" placeholder="Password">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="repass_input_aux">SRepite Contrase&ntilde;a</label>
                            <div class="controls">
                                <input type="password" class="form-control" id="repass_input_aux_edit" placeholder="Password">
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
                            <label class="control-label" for="type_user">*Tipo de Usuario</label>
                            <div class="controls">
                                <select name="type_user" id="type_user" class="form-control">
                                    <option value="0" selected>Selecciona</option>
                                    <option value="1">Administrador</option>
                                    <option value="6">Pasante</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="pass" class="form-control" id="pass_input_edit" />
                        <input type="hidden" name="repass" class="form-control" id="repass_input_edit">
                        <input type="hidden" name="id" class="form-control" id="id_input_edit">
                        <button type="button" data-dismiss="modal" class="btn">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
</div>