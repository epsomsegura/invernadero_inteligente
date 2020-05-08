function read(id) {
    var data = {
        "id": id,
    };
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: readRoute,
        data: data,
        type: 'post',
        success: function(data) {
            if (data.success) {
                $('#u_emp_first_name').val(data.data['emp_first_name']);
                $('#u_emp_last_name').val(data.data['emp_last_name']);
                $('#u_emp_address').val(data.data['emp_address']);
                $('#u_emp_phone_number').val(data.data['emp_phone_number']);
                $('#u_emp_cellphone_number').val(data.data['emp_cellphone_number']);
                $('#u_emp_job').val(data.data['emp_job']);
                $('#u_emp_fk_business_unit').val(data.data['emp_fk_business_unit']);
                $('#u_emp_email').val(data.data['emp_email']);
            } else {
                failure(data.data);
            };
        }
    });
}

function update() {
    var data = {
        "id": this.id,
        'emp_first_name': $('#u_emp_first_name').val(),
        'emp_last_name': $('#u_emp_last_name').val(),
        'emp_address': $('#u_emp_address').val(),
        'emp_phone_number': $('#u_emp_phone_number').val(),
        'emp_cellphone_number': $('#u_emp_cellphone_number').val(),
        'emp_job': $('#u_emp_job').val(),
        'emp_fk_business_unit': $('#u_emp_fk_business_unit').val(),
        'emp_email': $('#u_emp_email').val(),
        'emp_password': $('#emp_password').val(),
        'emp_password_change' : $('#spy_has_duration').is(':checked'),
        'emp_new_password' : $('#emp_new_password').val(),
        'emp_rep_password' : $('#emp_rep_password').val()
    };
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: updateRoute,
        data: data,
        type: 'post',
        success: function(data) {
            if (data.success) {
                alert(data.data);
                window.location.href = history.go(-1);
            } else {
                failure(data.data);
            }
        }
    });
}

$(document).ready(function() {
    read(id);
});