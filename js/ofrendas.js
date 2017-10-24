$(document).on("ready" , function(){
    $("#btn_add_sliders_modal").on("click" , function(){
        $("#offering_form").attr("action" , "admin/ofrendas/insert");
        $("#offering_form #titulo_input").val("");
        $("#offering_form #numero_input").val("");
        $("#offering_form #descripcion_input").val("");
    });
    $(".table .btn-edit").on("click" , function(){
        var id = $(this).closest("tr").data("id");
        $.ajax({
            url: base_url + "admin/ofrendas/getone/" + id,
            type: "GET",
            dataType: "json",
            success: function (data){
                if(data.status == "OK"){
                    $("#offering_form").attr("action" , "admin/ofrendas/update/" + data.ofrenda.id);
                    $("#offering_form #titulo_input").val(data.ofrenda.nombre);
                    $("#offering_form #numero_input").val(data.ofrenda.numero);
                    $("#offering_form #descripcion_input").val(data.ofrenda.descripcion);
                    $("#add_offering_modal").modal("show");

                }else{
                    alerts(data.type , data.message);
                }
            }
        });
    });
    $("#offering_form").on("submit" , function(event){
        event.preventDefault();
        $.ajax({
            url: base_url + $(this).attr("action"),
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            dataType: "json",
            success: function (data){
                if(data.status == "OK"){
                    setTimeout(function(){
                        location.reload();
                    },500);
                }else{
                    alerts(data.type , data.message);
                }
            }
        });
    });
});