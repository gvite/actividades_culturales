$(document).on('ready' , function(){
    /*$('#btn_add_user').on('click' , function(){
        $('input').val('');
        $('#add_user_modal').modal('show');
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
    });*/
    // $("#table_usuarios").DataTable();
    $("#migration").on("click" , function(){
        var $trs = $('#table_usuarios tbody tr');
        saveUser($trs, 0);
    });
    function saveUser($trss, index){
        $("#count_users").text(index);
        if(index < $trss.length ){
            var $trs = $($trss[index]);
            var user = {
                "name": $trs.data("name"),
                "lastname": $trs.data("lastname"),
                "surname": $trs.data("surname"),
                "email": $trs.data("email"),
                "number_id": $trs.data("number_id"),
                "phone": $trs.data("phone"),
                "celphone": $trs.data("celphone") ? $trs.data("celphone") : "1234567890",
                "gender": $trs.data("gender"),
                "year": $trs.data("year"),
                "career_id": $trs.data("career_id"),
                "campus_id": $trs.data("campus_id"),
                "semester": $trs.data("semester") ? $trs.data("semester") : 1,
                // "semester": $trs.data("semester"),
                "workshift": $trs.data("workshift"),
                "area": $trs.data("area"),
                "address": $trs.data("address"),
                "occupation_id": $trs.data("occupation_id"),
                "student_type": $trs.data("student_type"),
            }
            if(user.student_type == 'student' || user.student_type == 'exstudent' || user.student_type == 'employee'){
                user.password = user.number_id;
                user.password_confirmation = user.number_id;
            }
            if(user.student_type == 'external'){
                user.password = user.email;
                user.password_confirmation = user.email;
            }
            // console.log(user);
            if($trs.data("hasdata")){
                $.ajax({
                    url: 'http://18.223.185.128/api/register',
                    type: 'POST',
                    data: JSON.stringify(user),
                    dataType: 'json',
                    headers: {
                        'Content-Type':'application/json'
                    },
                    success: function(data){
                        if(data.success == false) {
                            $trs.removeClass('success');
                            $trs.addClass('danger');
                            $trs.find("td").eq(0).text(JSON.stringify(data));
                            saveUser($trss , index + 1);
                        } else {
                            $.ajax({
                                url: base_url + 'admin/usuarios/delete',
                                type: 'POST',
                                data: {id: $trs.data("id")},
                                dataType: 'json',
                                success: function(){
                                    saveUser($trss , index + 1);         
                                }
                            });
                        }
                    },
                    error: function(){
                        $trs.removeClass('success');
                        $trs.addClass('danger');
                        $trs.find("td").eq(0).text("CORS");
                        saveUser($trss , index + 1);
                    }
                });
            } else {
                $trs.removeClass('success');
                $trs.addClass('danger');
                $trs.find("td").eq(0).text("No data");
                $.ajax({
                    url: base_url + 'admin/usuarios/delete',
                    type: 'POST',
                    data: {id: $trs.data("id")},
                    dataType: 'json',
                    success: function(){
                        saveUser($trss , index + 1);     
                    }
                });
            }
        } else {
            console.log("process finished");
        }
    }
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
    $('#table_usuarios').on('click','.edit-button' , function(){
        var id = $(this).closest('tr').data('id');
        var $this = $(this);
        $.ajax({
            url: base_url + 'admin/usuarios/get',
            type: 'POST',
            data: {id: id},
            dataType: 'json',
            success: function(data){
                $("#user_modal #usuario_input").val(data.user.nickname);
                $("#user_modal #name_user").val(data.user.nombre);
                $("#user_modal #paterno_user").val(data.user.paterno);
                $("#user_modal #materno_user").val(data.user.materno);
                $("#user_modal #correo_user").val(data.user.email);
                $("#user_modal #tipo_usuario").text(data.user.tipo_usuario);
                $('#user_modal').modal('show');
            }
        });
    });
});