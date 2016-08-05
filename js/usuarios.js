$(document).on('ready' , function(){
    $('#btn_add_user').on('click' , function(){
        $('input').val('');
        $('#add_user_modal').modal('show');
    });
    $('#table_usuarios').on('click','.event-button' , function(){
        var action = $(this).data('action');
        var id = $(this).closest('tr').data('id');
        var $this = $(this);
        $.ajax({
            url: base_url + 'admin/usuarios/' + action,
            type: 'POST',
            data: {id: id},
            dataType: 'json',
            success: function(data){
                switch(action){
                    case 'delete':
                        $this.addClass('hide');
                        $this.siblings('.return-btn').removeClass('hide');
                        $this.closest('tr').removeClass('success');
                        $this.closest('tr').addClass('danger');
                        break;
                    case 'return_user':
                        $this.addClass('hide');
                        $this.siblings('.delete-btn').removeClass('hide');
                        $this.closest('tr').removeClass('danger');
                        $this.closest('tr').addClass('success');
                        break;
                }
                alerts(data.type , data.message);
            }
        });
    });
    $(".date").datetimepicker({
        useCurrent:false,
        locale:'es',
        format: 'DD-MM-YYYY'
    });
    $("#add_user_form").on('submit' , function(event){
        event.preventDefault();
        $('#pass_input').val($.md5($('#password_usuario_input').val()));
        $('#repass_input').val($.md5($('#repass_input_aux').val()));
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function (data) {
                if (data.type === "success") {
                    var html = '<tr data-id="' + data.user.id + '" class="success"';
                    html += ' data-nombre="' + data.user.nombre + '"';
                    html += ' data-paterno="' + data.user.paterno + '"';
                    html += ' data-materno="' + data.user.materno + '"';
                    html += ' data-nickname="' + data.user.nickname + '"';
                    html += ' data-email="' + data.user.email + '"';
                    html += ' data-nacimiento="' + data.user.nacimiento + '"';
                    html += ' data-tipo="' + data.user.tipo_usuario_id + '"';
                    html += '>';
                    html += '<td>' + data.user.nombre + '</td>';
                    html += '<td>' + data.user.paterno + '</td>';
                    html += '<td>' + data.user.materno + '</td>';
                    html += '<td>' + data.user.nickname + '</td>';
                    html += '<td>' + ((data.user.tipo_usuario_id == 1) ? 'Administrador' : 'Pasante') + '</td>';
                    html += '<td>' + data.user.email + '</td>';
                    html += '<button data-action="edit" class="btn btn-default edit-button" title="Editar">';
                    html += '<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>';
                    html += '</button>';
                    html += '<button data-action="delete" class="btn btn-default event-button" title="Dar de baja">';
                    html += '<span class="glyphicon glyphicon glyphicon-trash" aria-hidden="true"></span>'
                    html += '</button>';
                    html += '<button data-action="return_user" class="btn btn-default event-button hide" title="Dar de alta">';
                    html += '<span class="glyphicon glyphicon glyphicon-cloud" aria-hidden="true"></span>';
                    html += '</button>';
                    html += '</tr>';
                    
                    $('#table_usuarios tbody').append(html);
                    $('#add_user_modal').modal('hide');
                };
                alerts(data.type , data.message);
            }
        });
    });
    $('#table_usuarios').on('click','.edit-button' , function(){
        var $tr = $(this).closest('tr'); 
        $('input').val('');
        $('#edit_user_form #id_input_edit').val($tr.data('id'));
        $('#edit_user_form #usuario_input').val($tr.data('nickname'));
        $('#edit_user_form #name_user').val($tr.data('nombre'));
        $('#edit_user_form #paterno_user').val($tr.data('paterno'));
        $('#edit_user_form #materno_user').val($tr.data('materno'));
        $('#edit_user_form #correo_user').val($tr.data('email'));
        $('#edit_user_form #nacimiento_user_input').val($tr.data('nacimiento'));
        $('#edit_user_form #type_user').val($tr.data('tipo'));
        $('#edit_user_modal').modal('show');
    });
    $("#edit_user_form").on('submit' , function(event){
        event.preventDefault();
        $('#pass_input_edit').val($.md5($('#password_usuario_input_edit').val()));
        $('#repass_input_edit').val($.md5($('#repass_input_aux_edit').val()));
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function (data) {
                if (data.type === "success") {
                    $('#table_usuarios tbody tr').each(function(){
                        console.log($(this).data('id') +':'+ data.user.id);
                        if($(this).data('id') == data.user.id){
                            console.log('entro aqui');
                            $(this).data('nickname' , data.user.nickname);
                            $(this).data('nombre', data.user.nombre);
                            $(this).data('paterno', data.user.paterno);
                            $(this).data('materno', data.user.materno);
                            $(this).data('email', data.user.email);
                            $(this).data('nacimiento', data.user.nacimiento);
                            $(this).data('tipo', data.user.tipo_usuario_id);
                            var $tds = $(this).find('td');
                            $tds.eq(0).text(data.user.nombre);
                            $tds.eq(1).text(data.user.paterno);
                            $tds.eq(2).text(data.user.materno);
                            $tds.eq(3).text(data.user.nickname);
                            $tds.eq(4).text(((data.user.tipo_usuario_id == 1) ? 'Administrador' : 'Pasante'));
                            $tds.eq(5).text(data.user.email);
                        }
                    });
                    $('#edit_user_modal').modal('hide');
                };
                alerts(data.type , data.message);
            }
        });
    });
});