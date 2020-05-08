var id = '';

function create() {
    var data = {
        "bus_name": $('#bus_name').val(),
        "bus_address": $('#bus_address').val()
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
                $(':input', '#agregar').not(':button, :submit, :reset, :hidden').val('').removeAttr('checked').removeAttr('selected');
            } else {
                failure(data.data);
            };
        }
    });
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
                $('#u_bus_name').val(data.data['bus_name']);
                $('#u_bus_address').val(data.data['bus_address']);
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
        "bus_name": $('#u_bus_name').val(),
        "bus_address": $('#u_bus_address').val()
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
                $("#unidades_negocio").html('');
                if (data.data !== null && $.isArray(data.data) && data.data.length > 0) {
                    $.each(data.data, function(index, value) {
                        $("#unidades_negocio").append('<tr class="gradeX"><td>' + value.bus_id + '</td><td>' + value.bus_name + '</td><td>' + value.bus_address + '</td><td><div class="btn-group" role="group" aria-label="..."><button class="btn btn-info btn-sm" type="button" onclick="showEmployees(' + value.bus_id + ')">Ver Empleados</button><button class="btn btn-warning btn-sm" type="button" onclick="modalUpdate(' + value.bus_id + ')">Modificar</button><button class="btn btn-danger btn-sm" type="button" onclick="delet(' + value.bus_id + ')">Eliminar</button></div></td></tr>');
                    });
                } else {
                    $("#unidades_negocio").append('<tr class="gradeX"><td colspan="4">No existen Unidades de Negocio registradas en la base de datos</td>');
                }
            } else {
                failure(data.data);
            };
        }
    });
}

function showEmployees(id) {
    window.location.href = businessUnitsRoute + '/' + id + '/empleados';
}

function modalUpdate(id) {
    this.id = id;
    read(id);
}

$(document).ready(function() {
    loadTable();
});