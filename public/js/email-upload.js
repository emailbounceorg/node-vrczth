"use strict";
$(document).ready(function () {
    $("#UploadFile").on("click", function () {
        let btn = document.querySelector('#UploadFile').textContent;
        var formData = new FormData(document.forms.namedItem("FromID"));
        var urlInsert = $('#FromID').data('urlinsert');
        var fileInput = document.getElementById('file');
        var filePath = fileInput.value;
        var allowedExtensions = /(\.csv|\.xlsx|\.txt)$/i;

        if (!allowedExtensions.exec(filePath)) {
            sAlert('info', 'Invalid file type. Please upload .txt, .csv or .xlsx file only.');
            fileInput.value = '';
            return false;
        }
        $.ajax({
            url: urlInsert,
            type: "POST",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $("#UploadFile").html('Please Wait...');
            },
            success: function (response) {
                if (response.status == 200) {
                    sAlert('success', response.msg, response.url);
                    document.getElementById("FromID").reset();
                } else {
                    sAlert('error', response.msg);
                }
            },
            complete: function () {
                document.querySelector('#UploadFile').textContent = btn;
            },
        });
    });



    $("#SubmitEmailcleaner").on("click", function () {
        let btn = document.querySelector('#SubmitEmailcleaner').textContent;
        var formData = new FormData(document.forms.namedItem("FromID2"));
        var urlInsert = $('#FromID2').data('urlinsert');
        $("#SubmitEmailcleaner").attr("disabled", "disabled");

        $.ajax({
            url: urlInsert,
            type: "POST",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $("#SubmitEmailcleaner").html('Please Wait...');
            },
            success: function (response) {
                $("#SubmitEmailcleaner").removeAttr("disabled");
                if (response.status == 200) {
                    $('.ValidEmailsRow').removeClass('d-none');
                    $('#Valid').val(response.data);
                    $('#invalid').val(response.InvalidEmail);
                }
            },
            complete: function () {
                document.querySelector('#SubmitEmailcleaner').textContent = btn;
            },
        });
    });


    $(".copy-mail").on('click', function () {
        // Get the text content from the textarea
        var textToCopy = $("#Valid").val();
        // Create a temporary input element to hold the text and copy it to the clipboard
        var tempInput = $("<input>");
        $("body").append(tempInput);
        tempInput.val(textToCopy).select();
        document.execCommand("copy");
        tempInput.remove();

        sAlert('success', 'Valid emails copied to clipboard!');
    });

    $(".copy-mail-Invalid").on('click', function () {
        // Get the text content from the textarea
        var textToCopy = $("#invalid").val();
        // Create a temporary input element to hold the text and copy it to the clipboard
        var tempInput = $("<input>");
        $("body").append(tempInput);
        tempInput.val(textToCopy).select();
        document.execCommand("copy");
        tempInput.remove();

        sAlert('success', 'invalid emails copied to clipboard!');
    });

    // file
    $('body').on('change', '#file', function () {
        var formData = new FormData(document.forms.namedItem("FromID"));
        var urlInsert = $('#FromID').attr('data-urlMapping');
        var fileInput = document.getElementById('file');
        var filePath = fileInput.value;
        var allowedExtensions = /(\.csv|\.xlsx|\.txt)$/i;

        if (!allowedExtensions.exec(filePath)) {
            sAlert('info', 'Invalid file type. Please upload .txt, .csv or .xlsx file only.');
            fileInput.value = '';
            return false;
        }
    });

});
