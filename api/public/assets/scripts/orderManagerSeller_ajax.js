var rejectedID = '';

function loadTables(){
 $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

 $.ajax({
    url:   ReadServiceOrderSellerRoute,
    type:  'post',
    success:  function (data) {
        if (data.success) {
            var countAccepted = 0;
            var countPending = 0;
            var countRejected = 0;
            var countCanceled = 0;
            var countHistory = 0;
            if (data.data !== null && $.isArray(data.data) && data.data.length>0){
                $.each(data.data, function(index, value){
                    type = '';
                    switch(value.status){
                        case 'accepted':
                        type = 'autorizadas';
                        countAccepted++;
                        break;
                        case 'pending':
                        type = 'pendientes';
                        countPending++;
                        break;
                        case 'rejected':
                        type = 'rechazadas';
                        countRejected++;
                        break;
                        case 'canceled':
                        type = 'canceladas';
                        countCanceled++;
                        break;
                        case 'history':
                        type = 'historial';
                        countHistory++;
                        break;
                    }
                    text = '<tr class="gradeX"><td>' + value.ser_id + '</td><td>' + value.ser_fk_customer + '</td><td>' + value.created_at + '</td>';
                    if (value.hasOwnProperty('detail_status')) {
                        text = text + '<td> administración: ' + value.detail_status.admin + '<br>Producción: ' + value.detail_status.production + '<br>Ventas: ' + value.detail_status.sales + '</td><td><div class="btn-group" role="group" aria-label="..."><button class="btn btn-info btn-sm" type="button" onclick="viewServiceOrder(\''+ value.ser_id +'\')">Ver Orden</button>';
                        if (type=='rechazadas') {
                            text = text + '<button class="btn btn-warning btn-sm" type="button" onclick="viewComments(\''+ value.ser_id +'\')">Ver Comentarios</button></div></td></tr>';
                        }else{
                            text = text + '</div></td></tr>';
                        };
                    }else{
                        text = text + '<td><div class="btn-group" role="group" aria-label="..."><button class="btn btn-info btn-sm" type="button" onclick="viewServiceOrder(\''+ value.ser_id +'\')">Ver Orden</button></div></td></tr>';
                    };                
                    $("#"+type).append(text);
                });
            };
            if (countAccepted == 0) {
                $("#autorizadas").append('<tr class="gradeX"><td colspan="4">No existen Ordenes de Servicio registradas en la base de datos</td>');
            };
            if (countPending == 0) {
                $("#pendientes").append('<tr class="gradeX"><td colspan="4">No existen Ordenes de Servicio registradas en la base de datos</td>');
            };
            if (countRejected == 0) {
                $("#rechazadas").append('<tr class="gradeX"><td colspan="4">No existen Ordenes de Servicio registradas en la base de datos</td>');
            };
            if (countCanceled == 0) {
                $("#canceladas").append('<tr class="gradeX"><td colspan="4">No existen Ordenes de Servicio registradas en la base de datos</td>');
            };
            if (countHistory == 0) {
                $("#historial").append('<tr class="gradeX"><td colspan="4">No existen Ordenes de Servicio registradas en la base de datos</td>');
            };
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

function viewComments(id){
    var data = {
        "id" : id,
    };

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url:   CommentsRoute,
        data: data,
        type:  'post',
        success:  function (data) {
            if (data.success) {
                $('#comentarios_titulo').html(data.data['title']);  
                $('#comentarios').html(data.data['body']);
                $('#viewComment').modal('show');
            }else{
                failure(data.data);
            };

        }
    });  
}

$(document).ready(function(){
    loadTables();
});