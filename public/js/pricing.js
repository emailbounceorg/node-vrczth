"use strict";
$(document).ready(function () {
    var urlView = $('#table1').data('urlview');
    var table = $('#table1').DataTable({
        processing: true,
        serverSide: true,
        searching: true,
        "bPaginate": false,
        ajax: urlView,
        columns: [
            { data: 'DT_RowIndex', DT_RowIndex: 'DT_RowIndex' },
            { data: 'name', name: 'name' },
            { data: 'credit', name: 'credit' },
            { data: 'price', name: 'price' },
            { data: 'action', name: 'action', className: ' text-center' },
        ]
    });
    table.draw();


    $("#CreateUpdate").on("click", function () {
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
                if (response.status == 200) {
                    sAlert('success', response.msg, response.url);
                    document.getElementById("FromID").reset();
                    $('#createEdit').modal('hide');
                    table.draw();
                } else if (response.status == 201) {
                    sAlert('error', response.msg);
                    errorShow(response.errors);
                }else if (response.status == 302) {
                    sAlert('error', response.msg);

                }
            },
            complete: function () {
                document.querySelector('#CreateUpdate').textContent = btn;
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
                    url: BaseUrl + "/admin/pricing-list-delete",
                    data: { id: id, UserID: 1, _token: _token },
                    success: function (response) {
                         if (response.status == 302) {
                            sAlert('error', response.msg);

                        }else{
                            table.draw();
                        sAlert('success', 'Successfully deleted.');
                        }
                    }
                });
            }
        });
    });


});

$('#table1').on('click', '.edit-button', function () {
    var id = $(this).data('id');
    var name = $(this).data('name');
    var credit = $(this).data('credit');
    var price = $(this).data('price');

    // Set the values in the modal form
    $('input[name="id"]').val(id);
    $('input[name="name"]').val(name);
    $('input[name="credit"]').val(credit);
    $('input[name="price"]').val(price);

    $('.modal-title').text("Edit");
    $('#CreateUpdate').text("Update");
});


$('body').on('click', '#create', function () {
     $('input[name="id"]').val('');
     create();
});

function create() {
    document.getElementById("FromID").reset();
    document.querySelector('.modal-title').textContent = "Create";
    document.querySelector('#CreateUpdate').textContent = "Submit";
}