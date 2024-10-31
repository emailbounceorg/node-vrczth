"use strict";

$(document).ready(function(){

    setTimeout(()=>{
        if( $('select[name=Responder_name]').val() ){
            $('select[name=Responder_name]').trigger('change');
        }
    }, 200);

    $('body').on('change', 'select[name=user_id]', function(){
        let user_id = $(this).val();
        let url = $(this).attr('data-source');
        let _token = $("meta[name=csrf-token]").attr('content');
        $.post(url, {user_id, _token}, function(res){
            $('select[name=Responder_name]').html(res);
        });
    });

    $('select[name=Responder_name]').on('change', function () {
        // loading show and hide
        $('.status-spinner').show();
        $('.showResponderDiv').hide();
        var selectedValue = $(this).val();
        var selectedRowID = $('select[name=Responder_name] :selected').attr('data-rowid');
        var selectedURL = $('select[name=Responder_name] :selected').attr('data-url');
        if (selectedURL == null) {
            return false;
        }
        $.ajax({
            type: "post",
            url: selectedURL,
            data: {
                responder_key: selectedValue,
                email_cleaner_id: selectedRowID,
                _token: $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (response) {
                $('.status-spinner').hide();
                $('.showResponderDiv').show();
                $('.showResponder').html(response.options);
            }
        });

    });


    $("#responder-setting-form").on("submit", function (e) {
        e.preventDefault();
        let _form = $(this);
        let _button = _form.find('button[type=submit]');
        let _btnText = _button.text();
        var formData = _form.serializeArray();
        var urlInsert = _form.attr('action');

        $.ajax({
            url: urlInsert,
            type: "POST",
            data: formData,
            beforeSend: function () {
                _button.text('Please Wait...');
            },
            success: function (response) {
                if (response.status == 200) {
                    sAlert('success', response.msg, response.url);
                } else {
                    sAlert('error', response.msg);
                }
            },
            complete: function () {
                _button.text(_btnText);
            },
        });

        return false;
    });
});