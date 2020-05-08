var id = '';
var businessUnitCount = 0;
var addToNewSelect = null;

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
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: readAllRoute,
        type: 'post',
        success: function(data) {
            if (data.success) {
                $("#empleados").html('');
                $("#employee_old").html('');
                $("#employee_new").html('');
                $('#employee_old').append($("<option></option>").attr("value", "null").text("---Seleccionar empleado---"));
                $('#employee_new').append($("<option></option>").attr("value", "null").text("---Seleccionar empleado---"));
                if (data.data !== null && $.isArray(data.data) && data.data.length > 0) {
                    $.each(data.data, function(index, value) {
                        var businessUnitPrint = '';
                        if (value.business_unit != null) {
                            businessUnitPrint = value.business_unit.bus_name;
                        } else {
                            businessUnitPrint = '';
                        }
                        $("#empleados").append('<tr class="gradeX"><td>' + value.emp_id + '</td><td>Nombre: ' + value.emp_first_name + ' ' + value.emp_last_name + '<br>Puesto: ' + value.emp_job + '</td><td><b>Diracción:</b> ' + value.emp_address + '<br><b>Unidad de Negocio: </b>' + businessUnitPrint + '</td><td>' + 'Telefono Fijo: ' + value.emp_phone_number + '<br>Celular: ' + value.emp_cellphone_number + '</td><td>' + value.emp_email + '</td><td><div class="btn-group" role="group" aria-label="..."><button class="btn btn-warning btn-sm" type="button" onclick="modalUpdate(' + value.emp_id + ')">Modificar</button><button class="btn btn-danger btn-sm" type="button" onclick="delet(' + value.emp_id + ')">Eliminar</button></div></td></tr>');
                        $('#employee_old').append($("<option></option>").attr("value", value.emp_id).text(value.emp_first_name + ' ' + value.emp_last_name));
                        $('#employee_new').append($("<option></option>").attr("value", value.emp_id).text(value.emp_first_name + ' ' + value.emp_last_name));
                    });
                } else {
                    $("#empleados").append('<tr class="gradeX"><td colspan="6">No existen Empleados registrados en la base de datos</td>');
                }
                setifnull();
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

function checkEmployee() {
    id = $("#employee_old").val();
    html = $("#employee_old option[value=" + id + "]").text();
    if (id === null || id == 'null') {
        loadTable();
        addToNewSelect = null;
    } else {
        addtoNew(id, html);
        $("#changecustomers").prop("disabled", false);
        $("#employee_new option[value=" + id + "]").remove();
        getCustomers(id);
    }
}

function addtoNew(id, html) {
    if (addToNewSelect !== null) {
        $('#employee_new').append(addToNewSelect);
    }
    addToNewSelect = $("<option></option>").attr("value", id).text(html);
}

function setifnull() {
    $("#clientes").html('');
    $("#clientes").append('<tr class="gradeX"><td colspan="4">Seleccionar empleado</td>/tr>');
    $("#changecustomers").prop("disabled", true);
}

function getCustomers(id) {
    var data = {
        'id': id
    };
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: readCustomersRoute,
        data: data,
        type: 'post',
        success: function(data) {
            if (data.success) {
                $("#clientes").html('');
                if (data.data !== null && $.isArray(data.data) && data.data.length > 0) {
                    $.each(data.data, function(index, value) {
                        $("#clientes").append('<tr class="gradeX"><td><input class="tochange" onclick="setDisabledAll()" type="checkbox" value="' + value.cus_id + '"></td><td>' + value.cus_name + '</td><td>' + value.cus_enterprise + '</td><td>' + value.cus_contact + '</td></tr>');
                    });
                } else {
                    $("#clientes").append('<tr class="gradeX"><td colspan="6">No existen Empleados registrados en la base de datos</td>');
                }
            } else {
                failure(data.data);
            };
        }
    });
}

function setallselect() {
    if ($('#employee_change_all').is(':checked')) {
        $(".tochange").prop('checked', true);
    } else {
        $(".tochange").prop('checked', false);
    }
}

function setDisabledAll() {
    var values = $(".tochange");
    result = true;
    $.each(values, function(index, value) {
        if (!value.checked) {
            result = false;
        }
    });
    $('#employee_change_all').prop('checked', result);
}

function changeCustomers() {
    var allValues = $(".tochange");
    var valuesToSend = [];
    $.each(allValues, function(index, value) {
        if (value.checked) {
            valuesToSend[valuesToSend.length] = value.value;
        }
    });
    if (valuesToSend.length === 0) {
        alert('no hay empleados seleccionados');
    } else {
        sendCustomersToChange(valuesToSend);
    }
}

function sendCustomersToChange(customers) {
    if ($('#employee_new').val() == 'null') {
        alert('Seleccione un empleado a recibir los clientes');
    } else {
        var data = {
            'customers': customers,
            'id': $('#employee_new').val()
        };
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: updateCustomersRoute,
            data: data,
            type: 'post',
            success: function(data) {
                if (data.success) {
                    alert(data.data);
                    $('#customerschange').modal('hide');
                    loadTable();
                } else {
                    failure(data.data);
                };
            }
        });
    }
}
$(document).ready(function() {
    loadTable();
    loadBusinessUnit();
});