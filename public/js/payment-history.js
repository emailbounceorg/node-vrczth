$(document).ready(function () {
    "use strict";
    var urlView = $('#table1').data('urlview');
    var table = $('#table1').DataTable({
        processing: true,
        serverSide: true,
        searching: true,
        ajax: urlView,
        columns: [
            { data: 'DT_RowIndex', DT_RowIndex: 'DT_RowIndex' },
            { data: 'userID', name: 'userID' },
            { data: 'type', name: 'type' },
            { data: 'pay_id', name: 'pay_id' },
            { data: 'credit', name: 'credit' },
            { data: 'amt', name: 'amt' },
            { data: 'created_at', name: 'created_at' },
            { data: 'action', name: 'action', className: ' text-center' },
        ]
    });
    table.draw();


});