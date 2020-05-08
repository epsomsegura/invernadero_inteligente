// spots
$(document).ready(function () {
    $('#u_pro_type').change(function () {
        $('.u_product').hide();
        $('#u_' + $(this).val()).show();
    });
    $('#pro_type').change(function () {
        $('.product').hide();
        $('#' + $(this).val()).show();
    });
});

$(document).ready(function () {
    $('#u_spy_has_duration').change(function () {
        if (this.checked)
            //  ^
            $('.u_duration').show();
        else
            $('.u_duration').hide();
    });
    $('#spy_has_duration').change(function () {
        if (this.checked)
            //  ^
            $('.duration').show();
        else
            $('.duration').hide();
    });
});




// cintillos

$(document).ready(function () {
    $('#hour').keyup(function () {
        $('#day').text($(this).val() * 12);
        $('#month').text($(this).val() * 12 * 30);
    });
});

$(document).ready(function () {
    $('#hour2').keyup(function () {
        $('#day2').text($(this).val() * 12);
        $('#month2').text($(this).val() * 12 * 30);
    });
});


$(document).ready(function () {
    $('#hour3').keyup(function () {
        $('#day3').text($(this).val() * 12);
        $('#month3').text($(this).val() * 12 * 30);
    });
});