var id = '';

function create() {
    var data = {
        "sho_name": $('#sho_name').val(),
        "sho_description": $('#sho_description').val(),
        "sho_media": $('#sho_media').val(),
        "sho_impacts": $('#sho_impacts').val(),
        "sho_duration": getDuration()
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
                $('#sho_media').val('null');
            } else {
                failure(data.data);
            }
        }
    });
}

function getDuration(){
    var hours = $('#sho_hours').val();
    var minutes = $('#sho_min').val();
    var seconds = $('#sho_sec').val();
    if (hours == '') {
        hours = '00';
    }
    if (minutes == '') {
        minutes = '00';
    }
    if (seconds == '') {
        seconds = '00';
    }
    hours = parseInt(hours);
    minutes = parseInt(minutes);
    seconds = parseInt(seconds);
    if (seconds >= '60') {
        seconds = seconds-60;
        minutes = minutes+1;
    } 
    if (minutes >= '60') {
        minutes = minutes-60;
        hours = hours+1;        
    }
    hours = hours.toString();
    minutes = minutes.toString();
    seconds = seconds.toString();       
    if (hours.length == 1) {
        hours = '0'+hours;
    }
    if (minutes.length == 1) {
        minutes = '0'+minutes;
    }
    if (seconds.length == 1) {
        seconds = '0'+seconds;
    }    
    return hours+':'+minutes+':'+seconds;
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
                $('#u_sho_name').val(data.data['sho_name']);
                $('#u_sho_description').val(data.data['sho_description']);
                $('#u_sho_media').val(data.data['sho_media']);
                $('#u_sho_impacts').val(data.data['sho_impacts']);
                var time = data.data['sho_duration'].split(":");
                $('#u_sho_hours').val(time[0]);
                $('#u_sho_min').val(time[1]);
                $('#u_sho_sec').val(time[2]);
                $('#updateModal').modal('show');
            } else {
                failure(data.data);
            }
        }
    });
}

function update() {
    var data = {
        "id": this.id,
        "sho_name": $('#u_sho_name').val(),
        "sho_description": $('#u_sho_description').val(),
        "sho_media": $('#u_sho_media').val(),
        "sho_impacts": $('#u_sho_impacts').val(),
        "sho_duration": uGetDuration()
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
                $(':input', '#actualizar').not(':button, :submit, :reset, :hidden').val('');
                $('#u_sho_media').val('null');
            } else {
                failure(data.data);
            }
        }
    });
}

function uGetDuration(){
    var hours = $('#u_sho_hours').val();
    var minutes = $('#u_sho_min').val();
    var seconds = $('#u_sho_sec').val();
    if (hours == '') {
        hours = '00';
    }
    if (minutes == '') {
        minutes = '00';
    }
    if (seconds == '') {
        seconds = '00';
    }
    hours = parseInt(hours);
    minutes = parseInt(minutes);
    seconds = parseInt(seconds);
    if (seconds >= '60') {
        seconds = seconds-60;
        minutes = minutes+1;
    } 
    if (minutes >= '60') {
        minutes = minutes-60;
        hours = hours+1;        
    }
    hours = hours.toString();
    minutes = minutes.toString();
    seconds = seconds.toString();       
    if (hours.length == 1) {
        hours = '0'+hours;
    }
    if (minutes.length == 1) {
        minutes = '0'+minutes;
    }
    if (seconds.length == 1) {
        seconds = '0'+seconds;
    }    
    return hours+':'+minutes+':'+seconds;
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
            }
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
                        var textToBtn = 'Eliminar';
                        if (value.sho_status == 'eliminado') {
                             textToBtn = 'Restaurar';
                        }
                        $("#unidades_negocio").append('<tr class="gradeX"><td>' + value.sho_id + '</td><td>' + value.sho_name + '</td><td>' + value.sho_description + '</td><td>' + value.sho_impacts + '</td><td>' + value.sho_duration + '</td><td>' + value.sho_media + '</td><td><div class="btn-group" role="group" aria-label="..."><button class="btn btn-warning btn-sm" type="button" onclick="modalUpdate(' + value.sho_id + ')">Modificar</button><button class="btn btn-danger btn-sm" type="button" onclick="delet(' + value.sho_id + ')">'+ textToBtn +'</button></div></td></tr>');
                    });
                } else {
                    $("#unidades_negocio").append('<tr class="gradeX"><td colspan="5">No existen Programas registradas en la base de datos</td>');
                }
            } else {
                failure(data.data);
            }
        }
    });
}

function modalUpdate(id) {
    this.id = id;
    read(id);
}

function toDelete(){
    window.location.href = toDeleteRoute;
}
$(document).ready(function() {
    loadTable();
});