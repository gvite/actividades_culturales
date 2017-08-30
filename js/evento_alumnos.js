$(document).on("ready" , function(){
    $('#alumnos_evento').DataTable();
    $("#alumnos_evento").on("click",".btn-asistencia" , function(){
        var id = $(this).data("id");
        var $td = $(this).parent();
        $.ajax({
            url: base_url + "eventos/asistencia",
            data: "asistencia=" + id + "&status=true",
            type: 'POST',
            dataType: 'json',
            success: function (data) {
                if (data.status === "MSG") {
                    alerts(data.type, data.message, '');
                }else if(data.status === "OK"){
                    $td.html('<button class="btn btn-danger btn-noasistencia" data-id="' + id + '">Quitar Asistencia</button>');
                }
            }
        });
    });
    $("#alumnos_evento").on("click",".btn-noasistencia" , function(){
        var id = $(this).data("id");
        var $td = $(this).parent();
        $.ajax({
            url: base_url + "eventos/asistencia",
            data: "asistencia=" + id + "&status=false",
            type: 'POST',
            dataType: 'json',
            success: function (data) {
                if (data.status === "MSG") {
                    alerts(data.type, data.message, '');
                }else if(data.status === "OK"){
                    $td.html('<button class="btn btn-success btn-asistencia" data-id="' + id + '">Asistencia</button>');
                }
            }
        });
    });
});