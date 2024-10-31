"use strict";
$(document).ready(function () {
    $('.showResponderDiv').hide();
    $('.status-spinner').hide();
    var urlView = $('#table1').data('urlview');
    var table = $('#table1').DataTable({
        processing: true,
        serverSide: true,
        searching: true,
        ajax: urlView,
        columns: [
            { data: 'DT_RowIndex', DT_RowIndex: 'DT_RowIndex' },
            { data: 'name', name: 'name' },
            { data: 'processed', name: 'processed' },
            { data: 'fdate', name: 'fdate' },
            { data: 'total_clean_status', name: 'total_clean_status' },
            { data: 'clean', name: 'clean' },
            { data: 'invalid', name: 'invalid' },
            { data: 'total', name: 'total' },
            { data: 'action', name: 'action', className: ' text-end' }
        ]
    });
    table.draw();

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
                    url: BaseUrl + "/admin/finished-list-delete",
                    data: { id: id, UserID: 1, _token: _token },
                    success: function () {
                        table.draw();
                        sAlert('success', 'Successfully deleted.');
                    }
                });
            }
        });
    });
});

$('#table1').on('click', '.data-retry', function () {
    var id = $(this).attr("id");
            $.ajax({
                type: "get",
                url: BaseUrl + "/admin/restart-queue/"+id,
                success: function (response) {
                    //table.draw();
                    //$('.ResponderData').html(response);
                    $("#"+id).html(response.msg);
                }
            });
});

$('#table1').on('click', '.GetAutoRespondersOnclick', function () {
    var rowId = $(this).data('id');
    var Url = $(this).data('urlresponders');
    $.ajax({
        type: "post",
        url: Url,
        data: {
            rowID: rowId,
            _token: $('meta[name="csrf-token"]').attr('content'),
        },
        success: function (response) {
            $('.ResponderData').html(response);
        }
    });
});

// ResponderData
$(document).ready(function () {
    $('.ResponderData').on('change', function () {
        // loading show and hide
        $('.status-spinner').show();
        $('.showResponderDiv').hide();
        var selectElement = document.querySelector('.ResponderData');
        var selectedValue = selectElement.value;
        var selectedRowID = selectElement.options[selectElement.selectedIndex].getAttribute('data-rowid');
        var selectedURL = selectElement.options[selectElement.selectedIndex].getAttribute('data-url');
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
                $('.email_cleaner_id').val(response.email_cleaner_id);
            }
        });

    });
});


$(document).ready(function () {
    $("#ResponderEmailSave").on("click", function () {
        let btn = document.querySelector('#ResponderEmailSave').textContent;
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
                $("#ResponderEmailSave").html('Please Wait...');
            },
            success: function (response) {
                document.getElementById("FromID").reset();
                if (response.status == 200) {
                    sAlert('success', response.msg);
                } else if (response.status == 201) {
                    sAlert('error', response.msg);
                }
                $("#AutoResponders").modal("hide");
            }, error: function (error) {
                sAlert('error', 'Api not configured');
            },
            complete: function () {
                document.querySelector('#ResponderEmailSave').textContent = btn;
            },
        });
    });
});


$(document).ready(function () {
    // Close button click event
    $('.modalHide').on('click', function () {
        $("#AutoResponders").modal("hide");
    });
});



// function fetchQueueProgress() {
//     $.ajax({
//         url: BaseUrl +'/admin/check-queue-progress',
//         type: 'GET',
//         data:{
//             _token: $('meta[name="csrf-token"]').attr('content'),
//         },
//         dataType: 'json',
//         success: function(response) {
//           console.log(response);
//         },
//         error: function(xhr, status, error) {
//             // Handle error response
//         }
//     });
// }

// // Periodically fetch queue progress every 5 seconds
// setInterval(fetchQueueProgress, 5000);