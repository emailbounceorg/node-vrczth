"use strict";
$(function () {
    $("#VerifyEmail").on("click", function () {
        $('#msgCheckMail').removeClass('text-success');
        $('#msgCheckMail').removeClass('text-warning');
        $('#msgCheckMail').removeClass('text-danger');
        $('#msgCheckMail').text('');
        $('#msgCheckMail').html('');
        $("#VerifyEmail").attr("disabled", "disabled");
        let btn = document.querySelector('#VerifyEmail').textContent;
        var formData = new FormData(document.forms.namedItem("FromIDs"));
        var urlInsert = $('#FromIDs').data('urlinsert');
        $.ajax({
            url: urlInsert,
            type: "POST",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $("#VerifyEmail").html('Please Wait...');
            },
            success: function (response) {
                $("#VerifyEmail").removeAttr("disabled");

                if (response.status == 200) {
                    $('#msgCheckMail').text(response.msg);
                    $('#msgCheckMail').addClass('text-success');
                } else if (response.status == 201) {
                    let elemClass = response.msg=='Suspected Email' ? 'text-warning' : 'text-danger';
                    $('#msgCheckMail').addClass(elemClass);
                    if( response.msg == 'Suspected Email' ){
                        $('#msgCheckMail').html(`${response.msg}<i class="bi bi-info-circle ms-2 res-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="We couldn&#39;t get proper response from ${response.domain}. So this might be a valid or invalid email."></i>`);
                        setTimeout(()=>{
                            response.msg=='Suspected Email'?
                            new bootstrap.Tooltip($('.res-tooltip')): ''
                        }, 500);
                    }else{
                        $('#msgCheckMail').text(response.msg);
                    }
                }
            },
            complete: function () {
                document.querySelector('#VerifyEmail').textContent = btn;
            },
        });
    });

});


