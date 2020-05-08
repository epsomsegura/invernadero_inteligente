// Dates of transmision
$(document).ready(function () {
    // Add
//    var max_fields_date = 5; //maximum boxes allowed
    var wrapper_date = $(".input_fields_wrap_date");
    var add_button_date = $(".add_field_button_date");
    var x = 1;
    var a = 2;
    $(add_button_date).click(function (e) {
        e.preventDefault();
        if (x < max_fields_date) {
            x++;
            a++;
            $(wrapper_date).append('<div id="' + a + '" class="form-group form-group-sm input_fields_wrap_date" style="margin-bottom: 10px!important; display: inline-block; width: 80%;"><label class="col-sm-1 control-label" for="formGroupInputSmall">Inicia</label><div class="col-sm-3"><div class=""><div><input class="form-control" id="' + a + '" style="margin-bottom: 10px!important; display: inline-block; width: 80%;" type="date" name="mytext[]"></div></div></div><label class="col-sm-1 control-label" for="formGroupInputSmall">Termina</label><div class="col-sm-3"><div class=""><div><input class="form-control" id="' + ++a + '" style="margin-bottom: 10px!important; display: inline-block; width: 80%;" type="date" name="mytext[]"></div></div></div><a style="margin-left: 10px; color: #c9302c;" href="#" class="remove_field_date"><i class="fa fa-times-circle" style="float: left; cursor: pointer; font-size: 30px;"></i></a></div>'); //add input box
        }
    });
    //Delete
    $(wrapper_date).on("click", ".remove_field_date", function (e) {
        e.preventDefault();
        $(this).parent('div').remove();
        x--;
        a = a - 2;
        var id = parseInt($(this).parent('div').attr('id'));
        id2 = id;
        id3 = id + 1;
        z = 20;
        while (z !== 0) {
            $(document).ready(function () {
                $("input[id^=" + id2 + "]").attr("id", id2 - 2);
                $("input[id^=" + id3 + "]").attr("id", id3 - 2);
                $("div[id^=" + id + "]").attr("id", id - 2);
            });
            id2 = ++id2;
            id3 = ++id3;
            id = ++id;
            z--;
        }
    });
});


// Payments
$(document).ready(function () {
    // Add
//    var max_fields_payment = 5; //maximum boxes allowed
    var wrapper_payment = $(".input_fields_wrap_payment");
    var add_button_payment = $(".add_field_button_payment");
    var q = 1;
    var w = 2;
    $(add_button_payment).click(function (e) {
        e.preventDefault();
        if (q < max_fields_payment) {
            q++;
            w++;
            $(wrapper_payment).append('<div id="' + w + '" class="form-group form-group-sm" style="margin-bottom: 10px!important; display: inline-block; width: 80%;"><label class="col-sm-1 control-label" for="formGroupInputSmall">Monto</label><div class="col-sm-3"><div class=""><div><input class="form-control" id="' + 'payment-' + w + '" style="margin-bottom: 10px!important; display: inline-block; width: 80%;" type="text" name="mytext[]"></div></div></div><label class="col-sm-1 control-label" for="formGroupInputSmall">Termina</label><div class="col-sm-3"><div class=""><div><input class="form-control" id="' + 'payment-' + ++w + '" style="margin-bottom: 10px!important; display: inline-block; width: 80%;" type="date" name="mytext[]"></div></div></div><a style="margin-left: 10px; color: #c9302c;" href="#" class="remove_field_payment"><i class="fa fa-times-circle" style="float: left; cursor: pointer; font-size: 30px;"></i></a></div>');
        }
    });
    // Delete
    $(wrapper_payment).on("click", ".remove_field_payment", function (e) {
        e.preventDefault();
        $(this).parent('div').remove();
        q--;
        w = w - 2;
        var idPayment = parseInt($(this).parent('div').attr('id'));
        id4 = idPayment;
        id5 = idPayment + 1;
        r = 20;
        while (r !== 0) {
            $(document).ready(function () {
                $("input[id^=" + 'payment-' + id4 + "]").attr("id", "payment-" + (id4 - 2) + "");
                $("input[id^=" + 'payment-' + id5 + "]").attr("id", "payment-" + (id5 - 2) + "");
                $("div[id^=" + idPayment + "]").attr("id", idPayment - 2);
            });
            id4 = ++id4;
            id5 = ++id5;
            idPayment = ++idPayment;
            r--;
        }
    });
});