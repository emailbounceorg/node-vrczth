"use strict";

$(document).ready(function () {
    // Close button click event
    $('.modalHide').on('click', function () {
        $("#configuration-modal").modal("hide");
    });
});

$(document).ready(function () {
    $('.responderBtn').on('click', function () {
        GetInputValue(this);
    });
});

function GetInputValue(btn) {
    var title = $(btn).data("whatever");
    var key = $(btn).data("key");
    var GetInputsURL = $(btn).data("getinputsurl");

    // set title modal
    $('#ModalTitle').text(title);

    $.ajax({
        type: "post",
        url: GetInputsURL,
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            key: key,
            title: title,
        },
        success: function (response) {
            $("#FromID")[0].reset();
            $('.spinner-border').hide();
            $('.ShowInputs').html(response);
        }
    });
}



$("#saveConfig").on("click", function () {
    let btn = document.querySelector('#saveConfig').textContent;
    var formData = new FormData(document.forms.namedItem("FromID"));
    var urlInsert = $('#FromID').data('urlinsert');
    $.ajax({
        url: urlInsert,
        type: "POST",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function () {
            $("#saveConfig").html('Please Wait...');
        },
        success: function (response) {
            if (response.status == 200) {
                sAlert('success', response.msg, response.url);
                document.getElementById("FromID").reset();
                $('#configuration-modal').modal('hide');
            } else {
                sAlert('error', response.msg);
            }
        },
        complete: function () {
            document.querySelector('#saveConfig').textContent = btn;
        },
    });
});