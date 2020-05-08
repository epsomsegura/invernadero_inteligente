var hasInvoice = false;
var newInvoice = true;
var paid = 0;
var total = parseFloat(payment.pda_amount);

function setTables() {
    $("#realPayment").html('');
    $("#totals").html('');
    if (payment.real_payments !== null && $.isArray(payment.real_payments) && payment.real_payments.length > 0) {
        $.each(payment.real_payments, function(index, value) {
            $("#realPayment").append('<tr class="gradeX"><td>' + value.rpa_id + '</td><td>' + value.rpa_amount + '</td><td>' + value.rpa_date + '</td><td>' + value.rpa_method + '</td><td>' + value.rpa_account + '</td></tr>');
            paid = paid + parseFloat(value.rpa_amount);
        });
    } else {
        $("#realPayment").append('<tr class="gradeX"><td colspan="5">No existen pagos registrados en la base de datos</td></tr>');
    }
    $("#totals").append('<tr class="gradeX"><td>' + total + '</td><td>' + paid + '</td><td>' + (total - paid) + '</td></tr>');
}

function checkForAccount() {
    $("#rpa_account").val('');
    if ($("#rpa_method").val() != 'contado') {
        $("#account").show();
    } else {
        $("#account").hide();
    }
}

function sendPayment() {
    if (parseFloat($("#rpa_amount").val()) > (total - paid)) {
        alert('Cantidad Superior a la cantidad adeudada, porfavor modifique la cantidad');
    } else {
        var data = {
            'rpa_fk_payment_date': payment.pda_id,
            'rpa_amount': $("#rpa_amount").val(),
            'rpa_method': $("#rpa_method").val(),
            'rpa_account': $("#rpa_account").val()
        };
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: sendPaymentRoute,
            type: 'post',
            data: data,
            success: function(data) {
                if (data.success) {
                    alert(data.data);
                    location.reload();
                } else {
                    failure(data.data);
                }
            }
        });
    }
}
$(document).ready(function() {
    setTables();
    if (payment.pda_status == 'pagado') {
        $('#buttonPay').prop('disabled', true);
    }
});