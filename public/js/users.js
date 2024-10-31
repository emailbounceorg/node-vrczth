"use strict";
$(document).ready(function () {
    var urlView = $('#table1').data('urlview');
    var table = $('#table1').DataTable({
        processing: true,
        serverSide: true,
        searching: true,
        ajax: urlView,
        columns: [
            { data: 'DT_RowIndex', DT_RowIndex: 'DT_RowIndex' },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'role', name: 'role' },
            { data: 'credit', name: 'credit' },
            { data: 'action', name: 'action', className: ' text-center' },
        ]
    });
    table.draw();

    $("#Update").on("click", function () {
        let btn = document.querySelector('#Update').textContent;
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
                $("#Update").html('Please Wait...');
            },
            success: function (response) {
                if (response.status == 200) {
                    sAlert('success', response.msg);
                    document.getElementById("FromID").reset();
                    $('#edit').modal('hide');
                    table.draw();
                    let _token = $(`[name="csrf-token"]`).attr('content');
                    if(response.arPushEmailUrl && response.email){
                        $.ajax({
                            url:response.arPushEmailUrl,
                            type:'POST',
                            data:{email:response.email,_token:_token}
                        })
                    }
                } else {
                    sAlert('error', response.msg);
                    errorShow(response.errors);
                }
            },
            complete: function () {
                document.querySelector('#Update').textContent = btn;
            },
        });
    });


    // Delete record
    $('#table1').on('click', '.data-delete', function () {
        var id = $(this).attr("id");
        var _token = $('meta[name="csrf-token"]').attr('content');
        Swal.fire({
            text: "Are you sure delete ?",
            icon: "warning",
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonText: "Yes",
            cancelButtonText: "No, return",
            customClass: {
                confirmButton: "btn btn-primary",
                cancelButton: "btn btn-active-light"
            }
        }).then(function (result) {
            if (result.value) {
                $.ajax({
                    type: "post",
                    url: BaseUrl + "/admin/user-list-delete",
                    data: { id: id, UserID: 1, _token: _token },
                    success: function (response) {
                        table.draw();
                        sAlert('success', 'Successfully deleted.');
                    }
                });
            }
        });
    });
});



$('.users-section').on('click', '.edit-button', function () {
    var id = $(this).data('id');
    var name = $(this).data('name');
    var email = $(this).data('email');
    var credit = $(this).data('credit');
    var modal_title = $(this).data('title');
    var modal_btn_text = $(this).data('btn-text');
    var role = $(this).data('role');

    $('#edit').find('.modal-title').text(modal_title);
    $('#edit').find('#Update').text(modal_btn_text);
    $('input[name="id"]').val(id);
    $('input[name="name"]').val(name);
    $('input[name="email"]').val(email);
    $('input[name="credit"]').val(credit);

    $('input[name="inlineRadioOptions"]').removeAttr('checked');
    $('input[name="inlineRadioOptions"][value="' + role + '"]').click();

});

