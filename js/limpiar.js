$(document).on('ready', function() {
    $("#table_bauchers a.delete").on("click" , function(event){
        event.preventDefault();
        var $this = $(this);
        $.ajax({
            url: $this.attr("href"),
            type: 'POST',
            data: "id=" + $this.data("id"),
            dataType: 'json',
            success: function(data) {
                alerts(data.type , data.message);
                $this.closest("tr").remove();
            }
        });
    });
});