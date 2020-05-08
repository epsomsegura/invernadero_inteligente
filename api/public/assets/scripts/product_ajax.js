var id = '';

function create() {
    var data = {
        'pro_name': $('#pro_name').val(),
        'pro_description': $('#pro_description').val(),
        'pro_type': $('#pro_type').val(),
        'spr_has_production_registry': $('#spr_has_production_registry').is(':checked'),
        'spr_outlay': $('#spr_outlay').val(),
        'spy_proyection_media': $('#spy_proyection_media').val(),
        'spy_has_show': $('#spy_has_show').is(':checked'),
        'spy_has_transmission_scheme': $('#spy_has_transmission_scheme').is(':checked'),
        'spy_has_duration': $('#spy_has_duration').is(':checked'),
        'spy_duration': $('#spy_duration').val(),
        'spy_outlay': $('#spy_outlay').val()
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
                $(':input', '#agregar').not(':button, :submit, :reset, :hidden').val('').removeAttr('checked');
                $('#pro_type').val('null');
                $('#spy_proyection_media').val('null');
                $('.duration').hide();
                $('.product').hide();
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
                $('#u_pro_name').val(data.data['pro_name']);
                $('#u_pro_description').val(data.data['pro_description']);
                $('#u_pro_type').val(data.data['pro_type']);
                $('.u_product').hide();
                $('.u_duration').hide();
                if (data.data['pro_type'] == 'transmisión') {
                    $('#u_transmisión').show();
                    $('#u_spy_proyection_media').val(data.data['service_proyection']['spy_proyection_media']);
                    $('#u_spy_has_show').prop('checked', Boolean(data.data['service_proyection']['spy_has_show']));
                    $('#u_spy_has_transmission_scheme').prop('checked', Boolean(data.data['service_proyection']['spy_has_transmission_scheme']));
                    $('#u_spy_has_duration').prop('checked', Boolean(data.data['service_proyection']['spy_duration']));
                    if (Boolean(data.data['service_proyection']['spy_duration'])) {
                        $('.u_duration').show();
                        $('#u_spy_duration').val(data.data['service_proyection']['spy_duration']);
                    }
                    $('#u_spy_outlay').val(data.data['service_proyection']['spy_outlay']);
                } else {
                    $('#u_producción').show();
                    $('#u_spr_has_production_registry').prop('checked', Boolean(data.data['service_production']['spr_has_production_registry']));
                    $('#u_spr_outlay').val(data.data['service_production']['spr_outlay']);
                }
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
        'pro_name': $('#u_pro_name').val(),
        'pro_description': $('#u_pro_description').val(),
        'pro_type': $('#u_pro_type').val(),
        'spr_has_production_registry': $('#u_spr_has_production_registry').is(':checked'),
        'spr_outlay': $('#u_spr_outlay').val(),
        'spy_proyection_media': $('#u_spy_proyection_media').val(),
        'spy_has_show': $('#u_spy_has_show').is(':checked'),
        'spy_has_transmission_scheme': $('#u_spy_has_transmission_scheme').is(':checked'),
        'spy_has_duration': $('#u_spy_has_duration').is(':checked'),
        'spy_duration': $('#u_spy_duration').val(),
        'spy_outlay': $('#u_spy_outlay').val()
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
                $(':input', '#actualizar').not(':button, :submit, :reset, :hidden').val('').removeAttr('checked');
                $('#u_pro_type').val('null');
                $('#u_spy_proyection_media').val('null');
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
                $("#productos").html('');
                if (data.data !== null && $.isArray(data.data) && data.data.length > 0) {
                    $.each(data.data, function(index, value) {
                        var textToBtn = 'Eliminar';
                        if (value.pro_status == 'eliminado') {
                             textToBtn = 'Restaurar';
                        }
                        $("#productos").append('<tr class="gradeX"><td>' + value.pro_id + '</td><td>' + value.pro_name + '</td><td>' + value.pro_description + '</td><td>' + value.pro_type + '</td><td>' + value.pro_details + '</td><td>' + value.pro_outlay + '</td><td><div class="btn-group" role="group" aria-label="..."><button class="btn btn-warning btn-sm" type="button" onclick="modalUpdate(' + value.pro_id + ')">Modificar</button><button class="btn btn-danger btn-sm" type="button" onclick="delet(' + value.pro_id + ')">'+textToBtn+'</button></div></td></tr>');
                    });
                } else {
                    $("#productos").append('<tr class="gradeX"><td colspan="7">No existen Productos registrados en la base de datos</td>');
                };
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

function toDelete() {
    window.location.href = toDeleteRoute;
}
$(document).ready(function() {
    loadTable();
});