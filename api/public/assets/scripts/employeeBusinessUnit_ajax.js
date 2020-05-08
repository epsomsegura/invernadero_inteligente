var id = '';
var businessUnitCount = 0;

function create() {
    if (businessUnitCount > 0) {
        var data = {
            'emp_first_name': $('#emp_first_name').val(),
            'emp_last_name': $('#emp_last_name').val(),
            'emp_address': $('#emp_address').val(),
            'emp_phone_number': $('#emp_phone_number').val(),
            'emp_cellphone_number': $('#emp_cellphone_number').val(),
            'emp_job': $('#emp_job').val(),
            'emp_fk_business_unit': $('#emp_fk_business_unit').val(),
            'emp_email': $('#emp_email').val(),
            'emp_password': $('#emp_password').val()
        };
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: createRoute,
            data: data,
            type: 'post',
            success: function(data) {
                if (data.success) {
                    alert(data.data);
                    loadTable();
                    $('#add').modal('hide');
                    $(':input', '#agregar').not(':button, :submit, :reset, :hidden').val('');
                    $('#emp_job').val('vendedor');
                    $('#emp_fk_business_unit').val('null');
                } else {
                    failure(data.data);
                };
            }
        });
    } else {
        alert('No existen Unidades de Negocio donde asignar empleados, Cree una para poder agregar empleados');
    }
}

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
                $('#updateModal').modal('show');
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
        'emp_password': $('#u_emp_password').val()
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
                loadTable();
                $('#updateModal').modal('hide');
                $(':input', '#actualizar').not(':button, :submit, :reset, :hidden').val('').removeAttr('checked').removeAttr('selected')
            } else {
                failure(data.data);
            };
        }
    });
}

function delet(id) {
    var data = {
        "id": id,
    };
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: deleteRoute,
        data: data,
        type: 'post',
        success: function(data) {
            if (data.success) {
                alert(data.data);
                loadTable();
            } else {
                failure(data.data);
            };
        }
    });
}

function loadTable() {
    var data = {
        'id': businessUnitId,
    }
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: readAllRoute,
        data: data,
        type: 'post',
        success: function(data) {
            if (data.success) {
                $("#empleados").html('');
                if (data.data !== null && $.isArray(data.data) && data.data.length > 0) {
                    $.each(data.data, function(index, value) {
                        var businessUnitPrint = '';
                        if (value.business_unit != null) {
                            businessUnitPrint = value.business_unit.bus_name;
                        } else {
                            businessUnitPrint = '';
                        }
                        $("#empleados").append('<tr class="gradeX"><td>' + value.emp_id + '</td><td>Nombre: ' + value.emp_first_name + ' ' + value.emp_last_name + '<br>Puesto: ' + value.emp_job + '</td><td><b>Diracción:</b> ' + value.emp_address + '<br><b>Unidad de Negocio: </b>' + businessUnitPrint +'</td><td>' + 'Telefono Fijo: ' + value.emp_phone_number + '<br>Celular: ' + value.emp_cellphone_number + '</td><td>' + value.emp_email + '</td><td><div class="btn-group" role="group" aria-label="..."><button class="btn btn-warning btn-sm" type="button" onclick="modalUpdate(' + value.emp_id + ')">Modificar</button><button class="btn btn-danger btn-sm" type="button" onclick="delet(' + value.emp_id + ')">Eliminar</button></div></td></tr>');
                    });
                } else {
                    $("#empleados").append('<tr class="gradeX"><td colspan="6">No existen Empleados registrados en la base de datos</td>');
                }
            } else {
                failure(data.data);
            };
        }
    });
}

function modalUpdate(id) {
    this.id = id;
    read(id);
}

function loadBusinessUnit() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: loadBusinessUnitRoute,
        type: 'post',
        success: function(data) {
            if (data.success) {
                $.each(data.data, function(index, value) {
                    $('#emp_fk_business_unit').append($("<option></option>").attr("value", value.bus_id).text(value.bus_name));
                    $('#u_emp_fk_business_unit').append($("<option></option>").attr("value", value.bus_id).text(value.bus_name));
                    businessUnitCount++;
                });
            } else {
                failure(data.data);
            };
        }
    });
}
$(document).ready(function() {
    loadTable();
    loadBusinessUnit();
});