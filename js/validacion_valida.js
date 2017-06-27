$(document).on('ready', function () {
    $('.fecha_input').datetimepicker({
        useCurrent:true,
        locale:'es',
        format: 'DD-MM-YYYY'
    });
    $("#valida_folio_form").on('submit', function (event) {
        event.preventDefault();
        $("#numero_caja").prop("disabled" , false);
        $.ajax({
            url: $(this).attr('action'),
            data: $(this).serialize(),
            type: 'POST',
            dataType: 'json',
            success: function (data) {
                if (data.status === "MSG") {
                    if (data.type === 'success') {
                        alerts(data.type, data.message , 2500 , function(){
                            location.reload();
                        });
                    }else{
                        alerts(data.type, data.message);
                    }
                }
            }
        });
    });
    
    $("#ingresa_folio_form").on('submit', function (event) {
        event.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            data: $(this).serialize(),
            type: 'POST',
            dataType: 'json',
            success: function (data) {
                if (data.status === "MSG") {
                    if (data.type === 'success') {
                        $('#datos_baucher .datos_alumno .no_recibo_span').text(data.numero_caja);
                        $("#ingresa_folio_dialog").modal('hide');
                    }
                    alerts(data.type, data.message);
                }
            }
        });
    });
    $("#ingresa_fecha_form").on('submit', function (event) {
        event.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            data: $(this).serialize(),
            type: 'POST',
            dataType: 'json',
            success: function (data) {
                if (data.status === "MSG") {
                    if (data.type === 'success') {
                        $('#datos_baucher .datos_alumno .fecha_recibo_span').text(data.fecha_caja);
                        $("#ingresa_fecha_dialog").modal('hide');
                    }
                    alerts(data.type, data.message);
                }
            }
        });
    });
    $("#btn_baja_baucher").on('click', function () {
        var $this = $(this);
        $.ajax({
            url: base_url + 'admin/validacion/baja/',
            data: 'baucher=' + $this.data('id'),
            type: 'POST',
            dataType: 'json',
            success: function (data) {
                if (data.status === "MSG") {
                    if (data.type === 'success') {
                        $('#datos_baucher .datos_alumno .validado-span').html('No validado, pero ya puede inscribir nuevamente los Talleres ');
                        $this.parent().remove();
                    }
                    alerts(data.type, data.message);
                }
            }
        });
    });
    $('.beca').on('click' , function(){
        if($(this).is(':checked')){
            $('#porcentaje_content').show();
            $("#numero_caja").val("BECA");
        }else{
            $('#porcentaje_content').hide();
            $("#numero_caja").val("");
        }
    });
    $('#ingresa_aportacion').on('click' , function(){
        if($(this).is(':checked')){
            $('#aportacion_voluntaria_content').removeClass('hidden');
        }else{
            $('#aportacion_voluntaria_content').addClass('hidden');
        }
    });
    $('#ingresa_beca').on('click' , function(){
        if($(this).is(':checked')){
            $('#aportacion_beca_content').removeClass('hidden');
            $("#numero_caja").val("BECA");
            $("#numero_caja").prop("disabled" , true);
        }else{
            $('#aportacion_beca_content').addClass('hidden');
            $("#numero_caja").val("");
            $("#numero_caja").prop("disabled" , false);
        }
    });
});