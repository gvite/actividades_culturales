$(document).on("ready" , function(){
    $("#confirmar_form").on("submit", function(ev){
        ev.preventDefault();
        $.ajax({
            url:$(this).attr('action'),
            data:$(this).serialize(),
            type: 'POST',
            dataType:'json',
            success:function(data){
                if(data.status === "MSG"){
                    alerts(data.type , data.message);
                }
                if(data.status === "OK"){
                    setTimeout(function(){
                        if(data.return_url){
                            window.location.href = data.return_url;
                        }else{
                            window.location.href = base_url + 'inicio';
                        }
                    }, 1000);
                }
            }
        });
    });
});