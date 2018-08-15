$(document).on('ready', function () {
    $('#reporte1_form').on('submit', function (event) {
        event.preventDefault();
        $("#content_btn_download").hide();
        $.ajax({
            url: $(this).attr('action'),
            data: $(this).serialize(),
            type: 'POST',
            dataType: 'json',
            success: function (data) {
                if (data.status === "OK") {
                    $("#content_btn_download a").attr("href" , data.file);
                    $("#content_btn_download").show();
                }else{
                    alerts(data.type, data.message);
                }
            }
        });
    });
});