"use strict";
$(document).ready(function () {
    $("#register").on("click", function () {
        let btn = document.querySelector('#register').textContent;
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
                $("#register").html('Please Wait...');
            },
            success: function (response) {
                if (response.status == 200) {
                    sAlert('success', response.msg, response.url);
                    document.getElementById("FromID").reset();
                } else if (response.status == 201) {
                    sAlert('error', response.msg);
                    errorShow(response.errors);

                }
            },
            complete: function () {
                document.querySelector('#register').textContent = btn;
            },
        });
    });


    $("#login").on("click", function () {
        $("#login").attr("disabled", "disabled");
        let btn = document.querySelector('#login').textContent;
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
                $("#login").html('Please Wait...');
            },
            success: function (response) {
                if (response.status == 200) {
                    sAlert('success', response.msg, response.url);
                    document.getElementById("FromID").reset();
                    let _token = $(`[name="csrf-token"]`).attr('content');
                    if(response.arPushEmailUrl && response.email){
                        $.ajax({
                            url:response.arPushEmailUrl,
                            type:'POST',
                            data:{email:response.email,_token:_token}
                        })
                    }
                } else if (response.status == 201) {
                    $("#login").removeAttr("disabled");
                    sAlert('error', response.msg);
                    errorShow(response.errors);
                }
            },
            complete: function () {
                document.querySelector('#login').textContent = btn;
            },
        });
    });



    $("#show-password").on("click", function () {
        if ($(this).is(':checked')) {
            $('#password').attr('type', 'text');
            $('#passmsg').text('Switch to show password');
        } else {
            $('#password').attr('type', 'password');
            $('#passmsg').text('Switch to hide password');
        }
    });

});


$("#ForgotPassword").on("click", function () {
    let btn = document.querySelector('#ForgotPassword').textContent;
    var formData = new FormData(document.forms.namedItem("FromID"));
    var urlInsert = $('#FromID').data('urlinsert');
    // POST data with id and formData
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
            }
        },
        function () {
            $("#ForgotPassword").html('Please Wait...');
        },
        function () {
            document.querySelector('#ForgotPassword').textContent = btn;
        }
    );
});

$("#UpdatePassword").on("click", function () {
    let btn = document.querySelector('#UpdatePassword').textContent;
    var formData = new FormData(document.forms.namedItem("FromID"));
    var urlInsert = $('#FromID').data('urlinsert');
    // POST data with id and formData
    CustomAjax(
        urlInsert,
        "POST",
        formData,
        null,
        function (response) {
            if (response.status === 200) {
                sAlert('success', response.msg, response.url);
                document.getElementById("FromID").reset();
            } else if (response.status === 201) {
                errorShow(response.errors);
            }
        },
        function () {
            $("#UpdatePassword").html('Please Wait...');
        },
        function () {
            document.querySelector('#UpdatePassword').textContent = btn;
        }
    );
});

$(".TermsPrivacy").on("click", function () {
    var name = $(this).attr('data-name');
    if (name == "terms") {
        $('.modal-title').text('Terms & Conditions');
    } else {
        $('.modal-title').text('Privacy Policy');
    }
    var formData = new FormData();
    formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
    formData.append('name', name);
    var urlInsert = $(this).data('urlinsert');
    // POST data with id and formData
    CustomAjax(
        urlInsert,
        "POST",
        formData,
        null,
        function (response) {
            $('.TermsPrivacyShow').html(response);
        },
        function () {

        },
        function () {

        }
    );
});
