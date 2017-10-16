$(document).on("ready",  function(){
    $("#agregar_integrante").on("submit" , function(ev){
        ev.preventDefault();
        var nombre = $("#nombreintegrante").val();
        var edad = $("#edadintegrante").val();
        var instrumento = $("#instrumentointegrante").val();
        if(nombre !== "" && edad !== "" && instrumento !== ""){
            edad = parseInt(edad);
            if(isNaN(edad)){
                alerts("warning", "La edad debe ser número");
            }else{
                var index = $(".table-integrantes tbody tr").length;
                var html = "<tr>"
                html += "<td><input type='hidden' name='integrantes[" + index + "][nombre]' value='" + nombre + "'>" + nombre + "</td>";
                html += "<td><input type='hidden' name='integrantes[" + index + "][edad]' value='" + edad + "'>" + edad + "</td>";
                html += "<td><input type='hidden' name='integrantes[" + index + "][instrumento]' value='" + instrumento + "'>" + instrumento + "</td>";
                html += "<td><button class='btn btn-danger'>-</button></td>";
                html += "</tr>";
                $(".table-integrantes tbody").append(html);
                $("#nombreintegrante").val("");
                $("#edadintegrante").val("");
                $("#instrumentointegrante").val("");
                $("#agregar_integrante_modal").modal("hide");
            }
        }else{
            alerts("warning", "Ingresa todos los campos del integrante");
        }
    });
    $("#agregar_cancion").on("submit" , function(ev){
        ev.preventDefault();
        var index = $(".table-canciones tbody tr").length;
        if(index < 2){
            var nombre = $("#nombrecancion").val();
            var autor = $("#autorcancion").val();
            var ytcancion = $("#ytcancion").val();
            var sccancion = $("#sccancion").val();
            var fbcancion = $("#fbcancion").val();
            var twcancion = $("#twcancion").val();
            if(nombre !== "" && autor !== ""){
                
                var html = "<tr>";
                html += "<td><input type='hidden' name='canciones[" + index + "][nombre]' value='" + nombre + "'>" + nombre + "</td>";
                html += "<td><input type='hidden' name='canciones[" + index + "][autor]' value='" + autor + "'>" + autor + "</td>";
                html += "<td>";
                html += "<input type='hidden' name='canciones[" + index + "][youtube]' value='" + ytcancion + "'>";
                html += "<input type='hidden' name='canciones[" + index + "][soundcloud]' value='" + sccancion + "'>";
                html += "<input type='hidden' name='canciones[" + index + "][facebook]' value='" + fbcancion + "'>";
                html += "<input type='hidden' name='canciones[" + index + "][twitter]' value='" + twcancion + "'>";
                if(ytcancion !== "")
                html += '<a href="' + ytcancion + '" target="_blank"><i class="fa fa-youtube" aria-hidden="true"></i></a>';
                if(sccancion !== "")
                html += '<a href="' + sccancion + '" target="_blank"><i class="fa fa-soundcloud" aria-hidden="true"></i></a>';
                if(fbcancion !== "")
                html += '<a href="' + fbcancion + '" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>';
                if(twcancion !== "")
                html += '<a href="' + twcancion + '" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>';
                html += "</td>";
                html += "<td><button class='btn btn-danger'>-</button></td>";
                html += "</tr>";
                $(".table-canciones tbody").append(html);
                $("#nombrecancion").val("");
                $("#autorcancion").val("");
                $("#ytcancion").val("");
                $("#sccancion").val("");
                $("#fbcancion").val("");
                $("#twcancion").val("");
                $("#agregar_canciones_modal").modal("hide");
                if(index == 1){
                    $("#canciones_modal_a").addClass("hide");
                }
            }else{
                alerts("warning", "Ingresa todos los campos del integrante");
            }
        }else{
            alerts("warning", "Solo puedes agregar dos canciones");
        }
    });
    $(".table-integrantes,.table-canciones").on("click" , ".btn-danger", function(){
        $(this).closest("tr").remove();
        var index = $(".table-canciones tbody tr").length;
        if(index == 1){
            $("#canciones_modal_a").removeClass("hide");
        }
    });
    $("#registro_form").on("submit" , function(ev){
        ev.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            data: $(this).serialize(),
            type: 'POST',
            dataType: 'json',
            success: function (data) {
                if (data.status === "MSG") {
                    alerts(data.type, data.message, '');
                }else{
                    window.location.href = base_url + "talento/pdf/" + data.evento_id + "/" + data.banda_id;
                }
            }
        });
    });
});