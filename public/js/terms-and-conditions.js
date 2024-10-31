$("#TermsAndConditionsUpdate").on("click", function () {
    "use strict";
    let btn = document.querySelector('#TermsAndConditionsUpdate').textContent;
    var formData = new FormData(document.forms.namedItem("FromID"));
    var urlInsert = $('#FromID').attr('data-url');

    $.ajax({
        url: urlInsert,
        type: "POST",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function () {
            $("#TermsAndConditionsUpdate").html('Please Wait...');
        },
        success: function (response) {
            if(response.status == 200){
                sAlert('success', response.msg, response.url);
            }else{
                sAlert('error', response.msg);
            }
        },
        complete: function () {
            document.querySelector('#TermsAndConditionsUpdate').textContent = btn;
        },
    });
});