"use strict";
$(function () {

    $('body').on('click', '#timezonesUpdate', function () {
        let btn = document.querySelector('#timezonesUpdate').textContent;
        var formData = new FormData(document.forms.namedItem("FromID"));
        var urlInsert = $('#FromID').attr('data-urlInsert');
        CustomAjax(
            urlInsert,
            "POST",
            formData,
            null,
            function (response) {
                if (response.status === 200) {
                    sAlert('success', response.msg, response.url);
                } else if (response.status === 201) {
                    errorShow(response.errors);
                    sAlert('error', response.msg);
                }
            },
            function () {
                $("#timezonesUpdate").html('Please Wait...');
            },
            function () {
                document.querySelector('#timezonesUpdate').textContent = btn;
            }
        );
    });

});