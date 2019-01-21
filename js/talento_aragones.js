$(document).on("ready", function () {
    $("#agregar_btn").on("click", function(){
        var name = $("#integrante").val();
        name = name.replace(/<|>|\)|\(|\"|\/|-/g, "");
        if(name !== ""){
            name = $('<span/>').text(name).text();
            console.log(name);
            var li = $('<li/>')
            .addClass('list-group-item')
            .text(name)
            .append('<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>')
            .append('<input type="hidden" value="' + name + '" name="integrantes[]">')
            .appendTo("#lista_integrantes");
            $("#integrante").val("");
        }
    });
    $("#equipo_btn").on("click", function(){
        var name = $("#equipo").val();
        name = name.replace(/<|>|\)|\(|\"|\/|-/g, "");
        if(name !== ""){
            name = $('<span/>').text(name).text();
            console.log(name);
            var li = $('<li/>')
            .addClass('list-group-item')
            .text(name)
            .append('<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>')
            .append('<input type="hidden" value="' + name + '" name="equipo_lista[]">')
            .appendTo("#lista_equipo");
            $("#equipo").val("");
        }
    });
    $("#registro_form").on("submit", function(ev){
        // ev.preventDefault();
    });
    $("#limpiar").on("click" , function(){
        $("input").val("");
        $("select").val("");
        $("textarea").val("");
        $("#lista_equipo").html("");
        $("#lista_integrantes").html("");
    });
});