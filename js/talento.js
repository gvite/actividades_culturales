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
                var html = "<tr>"
                html += "<td><input type='hidden' name='integrantes[][nombre]' value='" + nombre + "'>" + nombre + "</td>";
                html += "<td><input type='hidden' name='integrantes[][edad]' value='" + edad + "'>" + edad + "</td>";
                html += "<td><input type='hidden' name='integrantes[][instrumento]' value='" + instrumento + "'>" + instrumento + "</td>";
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
        var nombre = $("#nombrecancion").val();
        var autor = $("#autorcancion").val();
        var ytcancion = $("#ytcancion").val();
        var sccancion = $("#sccancion").val();
        var fbcancion = $("#fbcancion").val();
        var twcancion = $("#twcancion").val();
        if(nombre !== "" && autor !== ""){
            var html = "<tr>"
            html += "<td><input type='hidden' name='canciones[][nombre]' value='" + nombre + "'>" + nombre + "</td>";
            html += "<td><input type='hidden' name='canciones[][autor]' value='" + autor + "'>" + autor + "</td>";
            html += "<td>";
            html += "<input type='hidden' name='canciones[][ytcancion]' value='" + ytcancion + "'>";
            html += "<input type='hidden' name='canciones[][sccancion]' value='" + sccancion + "'>";
            html += "<input type='hidden' name='canciones[][fbcancion]' value='" + fbcancion + "'>";
            html += "<input type='hidden' name='canciones[][twcancion]' value='" + twcancion + "'>";
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
        }else{
            alerts("warning", "Ingresa todos los campos del integrante");
        }
    });
    $(".table-integrantes,.table-canciones").on("click" , ".btn-danger", function(){
        $(this).closest("tr").remove();
    });
});