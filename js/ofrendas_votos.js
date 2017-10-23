$(document).on("ready" , function(){
    $(".ofrendas-content .thumbnail img").on("click" , function(){
        var img = $('<img>'); //Equivalent: $(document.createElement('img'))
        img.attr('src', $(this).attr("src"));
        img.appendTo('#ofrendas_img_modal .modal-body');
        
        $thum = $(this).closest(".thumbnail");
        $("#ofrendas_img_modal .modal-title").text($thum.data("nombre"));
        $("#ofrendas_img_modal .modal-footer .badge").text($thum.data("votos") + " Votos");
        $("#ofrendas_img_modal .modal-footer .btn-votar").data("id",$thum.data("id"));
        $("#ofrendas_img_modal").modal("show");
    });
    var height = 0;
    $(".ofrendas-content .thumbnail h3").each(function(){
        //console.log($(this));
        if(height < $(this).height()){
            height = $(this).height();
        }
    });
    $(".ofrendas-content .thumbnail h3").height(height);
    $(".btn-votar").on("click" , function(){
        var id = $(this).data("id");
        $.ajax({
            url: base_url + "ofrendas/vota/",
            data: "ofrenda_id="+id,
            type: 'POST',
            dataType: 'json',
            success: function (data) {
                if (data.status === "MSG") {
                    if (data.type === 'success') {
                        $('#ofrendas_img_modal').modal('hide');
                        setTimeout(function(){
                            window.location.reload();
                        },2000);
                    }
                    alerts(data.type, data.message, '');
                }
            }
        });
    });
});