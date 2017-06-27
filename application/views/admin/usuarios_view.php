<div class="row">
    <div class="col-md-12">
        <table class="table" id="table_usuarios">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Apellido Paterno</th>
                    <th>Apellido Materno</th>
                    <th>Tipo de usuario</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if(is_array($usuarios)){
                    foreach($usuarios as $usuario){
                    ?>
                    <tr class="<?php echo ($usuario['status'] == 1)? 'success': 'danger'; ?>" 
                        data-id="<?php echo $usuario['id']; ?>">
                        <td><?php echo $usuario['nombre']; ?></td>
                        <td><?php echo $usuario['paterno']; ?></td>
                        <td><?php echo $usuario['materno']; ?></td>
                        <td><?php echo $usuario['tipo_usuario']; ?></td>
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
</div>
<div class="row">
    <div class="modal fade active" id="user_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="form-signin form-horizontal" id="user_form" action="<?php echo base_url(); ?>admin/usuarios/insert">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal" type="button">&times;</button>
                        <h3>Datos de acceso</h3>
                        <h4>Tipo de usuario: <span id="tipo_usuario"></h4>
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