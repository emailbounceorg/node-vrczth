"use strict";
$(document).ready(function () {
    $("#CSVdownload").on("click", function () {
        var urlInsert = $('#FromID').data('urlinsert');
        var rowID = $('#FromID').data('id');
        var data = $("input[name='down[]']:checked")
            .map(function () { return $(this).val(); }).get();

        if (data.length === 0) {
            sAlert('info', 'Please check the checkbox.');
            return false;
        }

        var typeDownload = $('input[name="typeDownload[]"]:checked').val();

        $.ajax({
            type: "post",
            url: urlInsert,
            data: {
                data: data,
                typeDownload: typeDownload,
                rowID: rowID,
                _token: $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (response) {
                downloadFile(response.zip)
            }
        });
    });
});

// Call the function when an event occurs (e.g., a button click)
$('#toggleButton').on('click', function () {
    $(this).toggleClass('selected');
    if($(this).hasClass('selected')){
        $('input[name="down[]"]').prop('checked',true);
        $("#toggleButton").html('<button type="button" class="btn btn-sm icon icon-left btn-danger"><i class="bi bi-x-circle-fill"></i> Uncheck all</button>');
    }
    else{
        $('input[name="down[]"]').prop('checked',false);
        $("#toggleButton").html('<button type="button" class="btn btn-sm icon icon-left btn-success"><i class="bi bi-check-circle-fill"></i> Select all</button>');
    }
});

// Function to trigger the file download via AJAX
function downloadFile(url) {
    var fileUrl = url; // Replace with the file URL from the response
    // Create a hidden download link element
    var downloadLink = $('<a>', {
        href: fileUrl,
        download: 'contacts.zip' // Replace with the desired file name
    });
    // Append the download link to the body and trigger the download
    downloadLink.appendTo('body');
    downloadLink[0].click();
    downloadLink.remove();
}

var rowID = $('#FromID').data('id');
$.ajax({
    type: "post",
    url: BaseUrl + "/admin/chart",
    data: {
        rowID: rowID,
        _token: $('meta[name="csrf-token"]').attr('content'),
    },
    success: function (response) {
        $('#domainTR').html(response.tr);
        $('#domainTR1').html(response.tr1);

        // Creating doughnut chart

        var ctx = document.getElementById('myChart').getContext('2d');
        var data = {
            labels: response.labels,
            datasets: [{
                data: response.data,
                backgroundColor: response.colors,
                hoverOffset: 4,
                borderWidth: 0, // Set border width to 0 for a clean design
                borderRadius: 10 // Add border radius for rounded edges
            }]
        };

        var options = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true, // Use point style for legend labels
                        font: {
                            weight: 'bold' // Set legend label font weight to bold
                        }
                    },
                    display: false

                }
            }
        };

        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: data,
            options: options
        });


        // / Creating pi chart

        var data_pi = document.getElementById('pi_domain').getContext('2d');
        var data = {
            labels: response.domainsName,
            datasets: [{
                data: response.domainsValue,
                backgroundColor: response.colors,
                hoverOffset: 4,
                borderWidth: 0, // Set border width to 0 for a clean design
                borderRadius: 10 // Add border radius for rounded edges
            }]
        };

        var options = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true, // Use point style for legend labels
                        font: {
                            weight: 'bold' // Set legend label font weight to bold
                        }
                    },
                    display: false
                }
            }
        };

        var myChart = new Chart(data_pi, {
            type: 'pie',
            data: data,
            options: options
        });

        // End pi chart

    }
});


