"use strict";
// razorpay payments
$('body').on('click', '.razorpay', function (e) {
    var APP_NAME = $('#APP_NAME').val();
    var rzpKEY = $('#rzpKEY').val();
    var email = $('#email').val();
    var logo = $('#logo').val();
    var popPrice = $('#popPrice').text();
    var popCredit = $('#popCredit').text();
    var _token = $('meta[name="csrf-token"]').attr('content');

    var options = {
        "key": rzpKEY,
        "amount": (popPrice * 100), // 2000 paise = INR 20
        "currency": "USD",
        "name": APP_NAME,
        "description": "Payment on Credit point",
        "image": logo,
        "handler": function (response) {
            var razorpay_payment_id = response.razorpay_payment_id
            $.ajax({
                type: "POST",
                url: BaseUrl + "/admin/payment-save",
                data: {
                    _token: _token,
                    type: 'razorpay',
                    popCredit: popCredit,
                    totalAmount: popPrice,
                    payment_id: razorpay_payment_id,
                },

                success: function (res) {
                    Swal.fire({
                        text: res.msg,
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Okay!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    }).then(function (result) {
                        if (result.isConfirmed) {
                            location.href = res.url;
                        }
                    });
                }
            });
        },
        "prefill": {
            "contact": '',
            "email": email,
        },
        "theme": {
            "color": "#006FD6"
        }
    };

    var rzp1 = new Razorpay(options);
    rzp1.open();
    e.preventDefault();
    $("#pay .close").click();
});


// stripepay payments
$('body').on('click', '.stripepay', function (e) {
    var btn = document.querySelector('.stripepay').textContent;
    var data = {
        APP_NAME: $('#APP_NAME').val(),
        email: $('#email').val(),
        popPrice: $('#popPrice').text(),
        popCredit: $('#popCredit').text(),
        _token: $('meta[name="csrf-token"]').attr('content'),
    };

    $.ajax({
        type: "POST",
        url: BaseUrl + "/admin/stripe-payment",
        data: data,
        beforeSend: function () {
            $(".stripepay").html('Please Wait...');
        },
        success: function (response) {
            window.location = response.url;
        },
        complete: function () {
            document.querySelector('.stripepay').textContent = btn;
        },
    });
});

// paypalpay

$('body').on('click', '.paypalpay', function (e) {
    var btn = document.querySelector('.paypalpay').textContent;
    var data = {
        APP_NAME: $('#APP_NAME').val(),
        email: $('#email').val(),
        popPrice: $('#popPrice').text(),
        popCredit: $('#popCredit').text(),
        _token: $('meta[name="csrf-token"]').attr('content'),
    };
    $.ajax({
        type: "POST",
        url: BaseUrl + "/admin/process-paypal",
        data: data,
        beforeSend: function () {
            $(".paypalpay").html('Please Wait...');
        },
        success: function (response) {
            window.location = response.url;
        }
        ,
        complete: function () {
            document.querySelector('.paypalpay').textContent = btn;
        },
    });
});