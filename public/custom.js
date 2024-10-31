"use strict";
$('.form-switch').on('click', function () {
    var currentUrl = window.location.href;
    var pathArray = currentUrl.split('/');
    var lastSegment = pathArray[pathArray.length - 1];
    if (lastSegment == 'pricing-details') {
        location.reload();
    }

    var tm = localStorage.getItem('theme');
    if (tm == 'light') {
        updateColor('#1e1e2d');
    } else {
        // pricing-details this code
        $('html[data-bs-theme=dark] .creditPoint, .text-price, .title-price-card, .title-price-second, .payType, .priceShow, .priceShowType')
            .css('color', 'white');
        //
        updateColor('#fff');
    }
});

const tm = localStorage.getItem('theme');
if (tm == 'light') {
    updateColor('#fff');
} else {
    $('html[data-bs-theme=dark] .creditPoint, .text-price, .title-price-card, .title-price-second, .payType, .priceShow, .priceShowType')
        .css('color', 'white');
    updateColor('#1e1e2d');
}

function updateColor(color) {
    // Get the second element with the class name `.Thing`
    const secondThing = document.querySelector('.Thing:nth-of-type(2)');
    // Get the last element with the class name `.Thing`
    const lastThing = document.querySelector('.Thing:last-of-type');
    // Get all elements with the class name `.Thing-step`
    const thingSteps = document.querySelectorAll('.Thing-step');
    // Create a new style rule for the `::before` pseudo-element of the second `.Thing`
    const secondBeforeStyle = document.createElement('style');
    secondBeforeStyle.innerHTML = `.Thing:nth-of-type(2)::before { background: ${color}; }`;
    // Create a new style rule for the `::before` pseudo-element of the last `.Thing`
    const lastBeforeStyle = document.createElement('style');
    lastBeforeStyle.innerHTML = `.Thing:last-of-type::before { background: ${color}; }`;
    // Create a new style rule for elements with the class name `.Thing-step`
    const stepStyle = document.createElement('style');
    stepStyle.innerHTML = `.Thing-step { color: ${color}; }`;
    // Add the new style rules to the head of the document
    document.head.appendChild(secondBeforeStyle);
    document.head.appendChild(lastBeforeStyle);
    document.head.appendChild(stepStyle);
}

// If you want to use tooltips in your project, we suggest initializing them globally
// instead of a "per-page" level.
document.addEventListener(
    "DOMContentLoaded",
    function () {
        var tooltipTriggerList = [].slice.call(
            document.querySelectorAll('[data-bs-toggle="tooltip"]')
        );
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    },
    false
);


function CustomAjax(url, type, formData, id, successCallback, beforeSendCallback, completeCallback,errorCallback) {
    var ajaxSettings = {
        url: url,
        type: type,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function () {
            if (typeof beforeSendCallback === "function") {
                beforeSendCallback();
            }
        },
        success: function (response) {
            if (successCallback && typeof successCallback === "function") {
                successCallback(response);
            }
        },
        complete: function () {
            if (typeof completeCallback === "function") {
                completeCallback();
            }
        },
        error: function (error) {
            if (typeof completeCallback === "function") {
                errorCallback(error);
            }
        }
    };

    if (type === "GET") {
        if (id) {
            ajaxSettings.url += "/" + id;
        }
    } else if (type === "POST") {
        ajaxSettings.data = formData;
    } else if (type === "DELETE") {
        ajaxSettings.url += "/" + id;
    }

    $.ajax(ajaxSettings);
}

function errorShow(response) {
    $('.error-text').text('');
    $('.form-control').removeClass('is-invalid is-valid');
    $('.invalid-feedback').text('');

    $.each(response, function (key, value) {
        $('.' + key + '_error').text(value[0]);
        $('input[name="' + key + '"]').addClass('is-invalid');
        $('select[name="' + key + '"]').addClass('is-invalid');
        $('radio[name="' + key + '"]').addClass('is-invalid');
        $('textarea[name="' + key + '"]').addClass('is-invalid');
        $('.' + key + '_error').addClass('invalid-feedback');
    });
}


$('.form-control').on('keyup', function () {
    $(this).removeClass('is-invalid');
    $(this).siblings('.error-text').text('');
});

$(function () {
    var themeColor = $('body').attr('data-theme-color');
    $('.colorSet').val(themeColor);
    document.documentElement.style.setProperty('--color', themeColor);
    localStorage.setItem('pageColor', themeColor);
});
// daymiac color change
document.documentElement.style.setProperty('--color', localStorage.getItem('pageColor'));
// colorSet

$('.theme-reset-color').on('click', function () {
    $('.colorSet').val('#FF564E');
});

var suspected = `<i class="bi bi-info-circle" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="1 credit, 1 email cleared">
                                                            </i>`
$("#email_check").on("click", function () {
    $('#email_check_status').text('');
    $('#email_check_status').html('');
    $('#email_check_status').removeClass('text-success');
    $('#email_check_status').removeClass('text-warning');
    $('#email_check_status').removeClass('text-danger');
    let btn = document.querySelector('#email_check').textContent;
    var urlInsert = $(this).data('url');
    $("#email_check").attr("disabled", "disabled");
    $.ajax({
        url: urlInsert,
        type: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            email: $('#emailChecks').val(),
        },
        beforeSend: function () {
            $("#email_check").html('Please Wait...');
        },
        success: function (response) {
            $("#email_check").removeAttr("disabled");

            if (response.status == 200) {
                $('#email_check_status').addClass('text-success');
                $('#email_check_status').text(response.msg);
            } else {
                let elemClass = response.msg=='Suspected Email' ? 'text-warning' : 'text-danger';
                $('#email_check_status').addClass(elemClass);
                if( response.msg == 'Suspected Email' ){
                    $('#email_check_status').html(`${response.msg}<i class="bi bi-info-circle ms-2 res-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="We couldn&#39;t get proper response from ${response.domain}. So this might be a valid or invalid email."></i>`);
                    setTimeout(()=>{
                        response.msg=='Suspected Email'?
                        new bootstrap.Tooltip($('.res-tooltip')): ''
                    }, 500);
                }else{
                    $('#email_check_status').text(response.msg);
                }
            }
        },
        complete: function () {
            document.querySelector('#email_check').textContent = btn;
        },
    });
});
