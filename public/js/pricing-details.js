"use strict";
$(document).ready(function () {
    // Select the first card element with the class '.myDiv'
    var firstCard = $('.myDiv').first();
    // Get the data attributes from the first card
    var name = firstCard.data('name');
    var credit = firstCard.data('credit');
    var price = firstCard.data('price');

    firstCard.css('background-color', "var(--color)");
    firstCard.find('.bi-envelope-check').css('color', '#fff');
    firstCard.find('.creditPoint').css('color', '#fff');
    firstCard.find('.text-price').css('color', '#fff');
    // $('#infoOverCredit').text(`Over ${credit} credits or custom requirements`);
    setDataView(credit, price);

});

$('.myDiv').on('click', function () {
    $('.creditPoint').css('color', '#222222');
    $('.text-price').css('color', ' #555555');
    $('.bi-envelope-check').css('color', "var(--color)");
    $('.myDiv').css('background-color', '');

    if ($('html').attr('data-bs-theme') === 'dark') {
        $('.creditPoint').css('color', 'white');
        $('.text-price').css('color', ' white');
    }

    $(this).css('background-color', "var(--color)");
    $(this).find('.bi-envelope-check').css('color', '#fff');
    $(this).find('.creditPoint').css('color', '#fff');
    $(this).find('.text-price').css('color', '#fff');



    // change price
    var name = $(this).data('name');
    var credit = $(this).data('credit');
    var price = $(this).data('price');

    setDataView(credit, price);
});


function setDataView(credit, price) {
    $('.priceInput').val(credit);
    $('.priceShow').text(price);
}

$('.priceInput').on('keyup', function () {
    var inputValue = $(this).val();
    if (inputValue == 0 || inputValue == NaN || inputValue == null) {
        var inputValue = 0;
    }
    priceCalculation(inputValue);
});

function priceCalculation(val) {
    var creditVal = parseInt(val); // Convert the input value to an integer
    var nearestPrice = null; // Initialize nearest price to null
    let credit = [], price = [];
    let singlePrice = 0; //
    // Loop through each myDiv element\

    if ($(`.myDiv[data-credit="${val}"]`).length) {
        $(`.myDiv[data-credit="${val}"]`).click();
        singlePrice = parseFloat($(`.myDiv[data-credit="${val}"]`).data('price'));
        setDataView(val, singlePrice);
    }
    else {
        $('.creditPoint').css('color', '#222222');
        $('.text-price').css('color', ' #555555');
        $('.bi-envelope-check').css('color', "var(--color)");
        $('.myDiv').css('background-color', '');
        singlePrice = $(`[data-default_credit_rate]`).data('default_credit_rate');
        let amount = creditVal * singlePrice;
        var num = parseFloat(amount); // Convert the string to a floating-point number
        num = num.toFixed(2); // Round the number to 2 decimal places
        num = parseFloat(num);
        setDataView(val, num);
    }

    // return false;



    // $('.myDiv').each(function () {
    //     credit.push(parseInt($(this).data('credit')));
    //     price[parseInt($(this).data('credit'))] = parseInt($(this).data('price'));
    // });

    // credit.sort(function (a, b) { return a - b });
    // $.each(credit, function (key, val) {
    //     if (creditVal == val) {
    //         nearestPrice = price[val];
    //         singlePrice = nearestPrice / val;
    //         return false;
    //     }
    //     if (creditVal < val) {
    //         nearestPrice = price[val];
    //         singlePrice = nearestPrice / val;
    //         return false;
    //     }
    //     if (creditVal > val && credit.length == key + 1) {
    //         nearestPrice = price[val];
    //         return false;
    //     }
    // });

    // let amount = creditVal * singlePrice;
    // var num = parseFloat(amount); // Convert the string to a floating-point number
    // num = num.toFixed(2); // Round the number to 2 decimal places
    // num = parseFloat(num);
    // setDataView(val, num);
}

// pay
$('#PayMethod').on('click', function () {
    var price = $('.priceShow').text();
    var priceInput = $('.priceInput').val();

    $('#popPrice').text('');
    $('#popPrice').text(price);


    $('#popCredit').text('');
    $('#popCredit').text(priceInput);
});