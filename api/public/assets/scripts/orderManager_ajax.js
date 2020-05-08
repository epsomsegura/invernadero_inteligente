var rejectedID = '';

function loadTables(){
 $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

 $.ajax({
    url:   ReadServiceOrderAuthRoute,
    type:  'post',
    success:  function (data) {
        if (data.success) {
            $("#autorizadas").html('');
            $("#pendientes").html('');
            $("#rechazadas").html('');
            $("#canceladas").html('');
            $("#historial").html('');
            if (data.accepted !== null && $.isArray(data.accepted) && data.accepted.length>0){
                $.each(data.accepted, function(index, value){
                    $("#autorizadas").append('<tr class="gradeX"><td>' + value.ser_id + '</td><td>' + value.ser_fk_customer + '</td><td>' + value.created_at + '</td><td><div class="btn-group" role="group" aria-label="..."><button class="btn btn-info btn-sm" type="button" onclick="viewServiceOrder(\''+ value.ser_id +'\')">Ver Orden</button><button class="btn btn-danger btn-sm" type="button" onclick="cancel(\''+ value.ser_id +'\')">Cancelar</button></div></td></tr>');
                });
            }else{
                $("#autorizadas").append('<tr class="gradeX"><td colspan="4">No existen Ordenes de Servicio registradas en la base de datos</td>');
            }
            if (data.pending !== null && $.isArray(data.pending) && data.pending.length>0){
                $.each(data.pending, function(index, value){
                    $("#pendientes").append('<tr class="gradeX"><td>' + value.ser_id + '</td><td>' + value.ser_fk_customer + '</td><td>' + value.created_at + '</td><td><div class="btn-group" role="group" aria-label="..."><button class="btn btn-info btn-sm" type="button" onclick="viewServiceOrder(\''+ value.ser_id +'\')">Ver Orden</button><button class="btn btn-success btn-sm" type="button" onclick="auth(\''+ value.ser_id +'\')">Autorizar</button><button class="btn btn-warning btn-sm" type="button" onclick="reject(\''+ value.ser_id +'\')">Rechazar</button><button class="btn btn-danger btn-sm" type="button" onclick="cancel(\''+ value.ser_id +'\')">Cancelar</button></div></td></tr>');
                });
            }else{
                $("#pendientes").append('<tr class="gradeX"><td colspan="4">No existen Ordenes de Servicio registradas en la base de datos</td>');
            }
            if (data.rejected !== null && $.isArray(data.rejected) && data.rejected.length>0){
                $.each(data.rejected, function(index, value){
                    $("#rechazadas").append('<tr class="gradeX"><td>' + value.ser_id + '</td><td>' + value.ser_fk_customer + '</td><td>' + value.created_at + '</td><td><div class="btn-group" role="group" aria-label="..."><button class="btn btn-info btn-sm" type="button" onclick="viewServiceOrder(\''+ value.ser_id +'\')">Ver Orden</button><button class="btn btn-success btn-sm" type="button" onclick="auth(\''+ value.ser_id +'\')">Autorizar</button><button class="btn btn-danger btn-sm" type="button" onclick="cancel(\''+ value.ser_id +'\')">Cancelar</button></div></td></tr>');
                });
            }else{
                $("#rechazadas").append('<tr class="gradeX"><td colspan="4">No existen Ordenes de Servicio registradas en la base de datos</td>');
            }
            if (data.canceled !== null && $.isArray(data.canceled) && data.canceled.length>0){
                $.each(data.canceled, function(index, value){
                    $("#canceladas").append('<tr class="gradeX"><td>' + value.ser_id + '</td><td>' + value.ser_fk_customer + '</td><td>' + value.created_at + '</td><td><div class="btn-group" role="group" aria-label="..."><button class="btn btn-info btn-sm" type="button" onclick="viewServiceOrder(\''+ value.ser_id +'\')">Ver Orden</button></div></td></tr>');
                });
            }else{
                $("#canceladas").append('<tr class="gradeX"><td colspan="4">No existen Ordenes de Servicio registradas en la base de datos</td>');
            }
            if (data.history !== null && $.isArray(data.history) && data.history.length>0){
                $.each(data.history, function(index, value){
                    $("#historial").append('<tr class="gradeX"><td>' + value.ser_id + '</td><td>' + value.ser_fk_customer + '</td><td>' + value.created_at + '</td><td><div class="btn-group" role="group" aria-label="..."><button class="btn btn-info btn-sm" type="button" onclick="viewServiceOrder(\''+ value.ser_id +'\')">Ver Orden</button></div></td></tr>');
                });
            }else{
                $("#historial").append('<tr class="gradeX"><td colspan="4">No existen Ordenes de Servicio registradas en la base de datos</td>');
            }
        }else{
            failure(data.data);
        };        
    }
});
}

function auth(id){
    var data = {
        'id' : id
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url:   AuthOrderRoute,
        data: data,
        type:  'post',
        success:  function (data) {
            if (data.success) {
                alert("Orden de Servicio Autorizada");
                loadTables();
            }else{
                failure(data.data);
            };
            
        }
    });
}

function reject(id){
 rejectedID = id;
 $('#setComment').modal('show');
}

function sendReject(){
 var data = {
    'id' : rejectedID,
    'comment' : $('#comment').val()
}

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$.ajax({
    url:   RejectOrderRoute,
    data: data,
    type:  'post',
    success:  function (data) {
        if (data.success) {
            alert("Orden de Servicio recahzada");
            $('#setComment').modal('hide');
            loadTables();
        }else{
            failure(data.data);
        };
        
    }
}); 
}

function cancel(id){
    var data = {
        'id' : id
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url:   CancelOrderRoute,
        data: data,
        type:  'post',
        success:  function (data) {
            if (data.success) {
                alert(data.data);
                loadTables();
            }else{
                failure(data.data);
            };

        }
    });
}

function viewServiceOrder(id){
    window.location.href = serviceOrderViewRoute+'/'+id;
}

$(document).ready(function(){
    loadTables();
});