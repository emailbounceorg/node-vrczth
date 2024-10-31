"use strict";
$(function (){
    $("#FromID").on("submit", function (e) {
        e.preventDefault();
        let btn = document.querySelector('#invoicesettings').textContent;
        var formData = new FormData(document.forms.namedItem("FromID"));
        var urlInsert = $('#FromID').attr('data-urlInsert');

        $.ajax({
            url: urlInsert,
            type: "POST",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $("#invoicesettings").html('Please Wait...');
            },
            success: function (response) {
                if(response.status == 200){
                    sAlert('success', response.msg, response.url);
                }else{
                    sAlert('error', response.msg);
                    errorShow(response.errors);
                }
            },
            complete: function () {
                document.querySelector('#invoicesettings').textContent = btn;
            },
        });
    });
});