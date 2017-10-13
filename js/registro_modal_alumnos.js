$(document).on('ready' , function(){
    $('#registro_form').on('submit' , function(event){
        event.preventDefault();
        $('#pass_input').val($.md5($('#pass_input_aux').val()));
        $('#repass_input').val($.md5($('#repass_input_aux').val()));
        $.ajax({
            url:$(this).attr('action'),
            data:$(this).serialize(),
            type: 'POST',
            dataType:'json',
            success:function(data){
                if(data.status === "MSG"){
                    if(data.type === 'success'){
                        $('#registro_exito').modal('show');
                        setTimeout('actualiza_pagina()' , 1000);
                    }else{
                        alerts(data.type , data.message);
                    }
                }
            }
        });
    });
    $('#user_input_ar').on('blur' , function(event){
        var $this = $(this);
        $.ajax({
            url: base_url + "acceso/registro/check_user",
            data:"user=" + $(this).val(),
            type: 'POST',
            dataType:'json',
            success:function(data){
                console.log(data);
                if(data.status === "OK"){
                    $this.closest(".control-group").addClass("has-success");
                    $this.closest(".control-group").removeClass("has-error");
                }else{
                    $this.closest(".control-group").addClass("has-error");
                    $this.closest(".control-group").removeClass("has-success");
                }
            }
        });
    });
    $("#nacimiento_user").datetimepicker({
        useCurrent:false,
        locale:'es',
        format: 'DD-MM-YYYY'
    });
});
function actualiza_pagina(){
    window.location.href = window.location.href;
}