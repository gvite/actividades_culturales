$(document).on("ready" , function(){
    $(".thumbnail-events").on("click" , ".btn-event" , function(){
        $.ajax({
            url: base_url + "eventos/inscripcion",
            data: "evento=" + $(this).data("id"),
            type: 'POST',
            dataType: 'json',
            success: function (data) {
                if (data.status === "MSG") {
                    alerts(data.type, data.message, '');
                }else if(data.status === "OK"){
                    window.location.href = base_url + "eventos/detalle/" + data.evento_id;
                }
            }
        });
    });
});