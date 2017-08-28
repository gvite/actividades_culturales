$(document).on("ready", function () {
    /*$("#img_slider").on("change", function(){
        console.log($(this));
    });*/
    $("#btn_add_sliders_modal").on("click" , function(){
        $("#slider_form").attr("action" , "admin/sliders/insert");
        $("#slider_form #titulo_input").val("");
        $("#slider_form #orden_input").val("");
        $("#slider_form #visible_input").prop(false);
        $("#slider_form #id_input").val("");
        $("#slider_form #link_input").val("");
    });
    $(".table .btn-edit").on("click" , function(){
        var id = $(this).closest("tr").data("id");
        $.ajax({
            url: base_url + "admin/sliders/getone/" + id,
            type: "GET",
            dataType: "json",
            success: function (data){
                if(data.status == "OK"){
                    $("#slider_form").attr("action" , "admin/sliders/update");
                    $("#slider_form #titulo_input").val(data.slider.titulo);
                    $("#slider_form #orden_input").val(data.slider.orden);
                    $("#slider_form #visible_input").prop("checked",((data.slider.status == 1)?true:false));
                    $("#slider_form #id_input").val(data.slider.id);
                    $("#slider_form #link_input").val(data.slider.link);
                    $("#add_sliders_modal").modal("show");

                }else{
                    alerts(data.type , data.message);
                }
            }
        });
    });
    $("#slider_form").on("submit" , function(event){
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