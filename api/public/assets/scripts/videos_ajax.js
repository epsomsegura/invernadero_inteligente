function disableDetail() {
    if ($('#vid_service_order').val() == 'null') {
        $('#vid_detail_product').prop('disabled', true);
        //$('#vid_type').prop('disabled', true);
        $('#unique').hide();
        $('#dates').show();
        setToShow();
    } else {
        $('#vid_detail_product').prop('disabled', false);
        //$('#vid_type').prop('disabled', false);
        $('#dates').hide();
        $('#unique').show();
        setToShow();
        loadDetails();
    }
}

function setToShow(){
    if ($('#vid_service_order').val() == 'null') {
        $('#vid_type').val('programación');
        $('#vid_type').prop('disabled',true); 
        $('#show').show();        
    }else{
        $('#vid_type').prop('disabled',false); 
        $('#show').hide();
    }
}

function loadSelects() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: loadSelectsRoute,
        type: 'post',
        success: function (data) {
            if (data.success) {                
                $.each(data.data, function (index, value) {
                    $('#vid_show').append($("<option></option>").attr("value", value.sho_id).html(value.sho_name));
                });
            } else {
                failure(data.data);
            }
        }
    });
}
function sendFile() {
    /*var data = {
        'vid_name': $('#vid_name').val(),
        'det_id': $('#vid_detail_product').val(),
        'vid_type': $('#vid_type').val(),
        'file': ($('#file').prop('files'))[0]
    };*/
    var data = new FormData();
    data.append('service_order', $('#vid_service_order').val())
    data.append('vid_name', $('#vid_name').val());
    data.append('det_id', $('#vid_detail_product').val());
    data.append('vid_type', $('#vid_type').val());
    data.append('vid_start_date',$('#vid_start_date').val());
    data.append('vid_end_date',$('#vid_end_date').val());
    data.append('vid_show',$('#vid_show').val());
    data.append('file', ($('#file').prop('files'))[0]);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: sendFileRoute,
        data: data,
        type: 'post',
        cache: false,
        dataType: 'json',
        processData: false,
        contentType: false,
        success: function (data) {
            if (data.success) {
                alert(data.data);
                $('#vid_name').val('');
                $('#vid_service_order').val('null');
                $('#vid_type').val('program');
                $('#file').val('');
                $('#vid_detail_product').html('');
                $('#add').modal('hide');
                disableDetail();
                loadTable();
            } else {
                failure(data.data);
            }
        }
    });

}

function loadServiceOrders() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: serviceOrdersRoute,
        type: 'post',
        success: function (data) {
            if (data.success) {
                $.each(data.data, function (index, value) {
                    $('#vid_service_order').append('<option value=\'' + value.ser_id + '\'>' + value.ser_id + '</option>');
                });
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
        success: function (data) {
            if (data.success) {
                $("#filesoncloud").html('');
                if (data.data !== null && $.isArray(data.data) && data.data.length > 0) {
                    $.each(data.data, function (index, value) {
                        $("#filesoncloud").append('<tr class="gradeX"><td>' + value.id + '</td><td>' + value.name + '</td><td>' + value.type + '</td><td>' + value.service_order + '</td><td>' + value.detail + '</td><td><div class="btn-group" role="group" aria-label="..."><button class="btn btn-danger btn-sm" type="button" onclick="delet(' + value.id + ')">Eliminar</button></div></td></tr>');
                    });
                } else {
                    $("#filesoncloud").append('<tr class="gradeX"><td colspan="6">No existen videos registrados en la base de datos</td>');
                }
            } else {
                failure(data.data);
            }

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
        success: function (data) {
            if (data.success) {
                alert(data.data);
                loadTable();
            } else {
                failure(data.data);
            }
        }
    });
}

function loadDetails() {
    if ($('#vid_service_order').val() != 'null') {
        var data = {
            'ser_id': $('#vid_service_order').val(),
            'vid_type': $('#vid_type').val()
        };

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: detailsRoute,
            data: data,
            type: 'post',
            success: function (data) {
                if (data.success) {
                    $('#vid_detail_product').html('');
                    $.each(data.data, function (index, value) {
                        $('#vid_detail_product').append('<option value=\'' + value.det_id + '\'>' + value.product.pro_name + '</option>');
                    });
                } else {
                    failure(data.data);
                }
            }
        });
    }
}

$(document).ready(function () {
    loadServiceOrders();
    loadTable();
    loadSelects();
});