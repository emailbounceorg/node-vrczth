$("#CreateUpdate").on("click", function () {
    "use strict";
    let btn = document.querySelector('#CreateUpdate').textContent;
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
            $("#CreateUpdate").html('Please Wait...');
        },
        success: function (response) {
            if(response.status == 200){
                sAlert('success', response.msg, response.url);
            }else{
                sAlert('error', response.msg);
            }
        },
        error : function(response){

            $.each(response.responseJSON.errors, function (key, value) {

                sAlert('error', value[0]);
            });
        },
        complete: function () {
            document.querySelector('#CreateUpdate').textContent = btn;
        }


    });
});