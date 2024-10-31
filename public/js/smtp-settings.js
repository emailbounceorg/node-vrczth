"use strict";

$(function () {
    // SMTP Settings
    var selectElement = $('#setSelectedSettings');
    var smtp = $('.hideSMTP');
    var aws = $('.hideAWS');
    var setSelectedSetting = $('.setSelectedSetting');

    selectElement.on('change', function () {
        var selectedValue = selectElement.val();
        chooseSettings(selectedValue);
    });

    function chooseSettings(value) {
        if (value == 'aws') {
            $('#awsdriver').val('ses');
            aws.removeClass('d-none');
            smtp.addClass('d-none');
            localStorage.setItem('settings', 'aws');
        } else {
            $('#driver').val('smtp');
            aws.addClass('d-none');
            smtp.removeClass('d-none');
            localStorage.setItem('settings', 'smtp');
        }
    }

    if (localStorage.getItem('settings') == 'smtp') {
        aws.addClass('d-none');
        smtp.removeClass('d-none');
        setSelectedSetting.val('smtp');
    } else {
        aws.removeClass('d-none');
        smtp.addClass('d-none');
        setSelectedSetting.val('aws');
    }

    $('body').on('click', '.smtpUpdate', function () {
        let btn = document.querySelector('.smtpUpdate').textContent;
        var formData = new FormData(document.forms.namedItem("FromID"));
        var urlInsert = $('#FromID').attr('data-URL');
        CustomAjax(
            urlInsert,
            "POST",
            formData,
            null,
            function (response) {
                if (response.status === 200) {
                    Swal.fire({
                        text: response.msg,
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Okay!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                } else if (response.status === 201) {
                    sAlert('error', response.msg);
                }else if (response.status === 302) {
                    sAlert('error', response.msg);
                }
            },
            function () {
                $(".smtpUpdate").html('Please Wait...');
            },
            function () {
                document.querySelector('.smtpUpdate').textContent = btn;
            },
            function (error) {
                console.log(error);
                $.each(error.responseJSON.errors, function (key, value) {

                    sAlert('error', value[0]);
                });
            }
        );
    });

    $('body').on('click', '.AWSUpdate', function () {
        let btn = document.querySelector('.AWSUpdate').textContent;
        var formData = new FormData(document.forms.namedItem("FromIDAWS"));
        var urlInsert = $('#FromIDAWS').attr('data-URL-AWS');
        CustomAjax(
            urlInsert,
            "POST",
            formData,
            null,
            function (response) {
                if (response.status === 200) {
                    Swal.fire({
                        text: response.msg,
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Okay!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                } else if (response.status === 201) {
                    sAlert('error', response.msg);
                }else if (response.status === 302) {
                    sAlert('error', response.msg);
                }
            },
            function () {
                $(".AWSUpdate").html('Please Wait...');
            },
            function () {
                document.querySelector('.AWSUpdate').textContent = btn;
            },
            function (error) {
                // console.log(error);
                $.each(error.responseJSON.errors, function (key, value) {

                    sAlert('error', value[0]);
                });
            }
        );
    });
    // smtp settings end

    // testEmail
    $('body').on('click', '.testEmail', function () {
        let btn = document.querySelector('.testEmail').textContent;
        var url = $(this).attr('data-URl-EmailSendTest');
        var emailTest = $('#emailTest').val();

        var formData = new FormData();
        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
        formData.append('emailTest', emailTest);

        CustomAjax(
            url,
            "POST",
            formData,
            null,
            function (response) {
                if (response.status === 200) {
                    Swal.fire({
                        text: 'Successfully sent email',
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Okay!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                } else {
                    Swal.fire({
                        text: 'Please enter your email',
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Okay!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                }
            },
            function () {
                $(".testEmail").html('Please Wait...');
            },
            function () {
                document.querySelector('.testEmail').textContent = btn;
            },
            function (error) {
                $.each(error.responseJSON.errors, function (key, value) {

                    sAlert('error', value[0]);
                });
            }
        );

    });
});