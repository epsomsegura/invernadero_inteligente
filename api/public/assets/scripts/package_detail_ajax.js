var id = '';

function create(){
    var data = {
        "pad_fk_package" : $('#pad_fk_package').text(),
        "pad_fk_product" : $('#pad_fk_product').val(),
        "pad_impacts" : $('#pad_impacts').val(),
        "pad_validity" : $('#pad_validity').val(),
        "pad_discount" : $('#pad_discount').val(),
        "pad_final_price" : $('#pad_discount_number').val()
    };

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url:   createRoute,
        data: data,
        type:  'post',
        success:  function (data) {
            if (data.success) {
                alert(data.data);
                loadTable();
                $('#add').modal('hide');
                $(':input', '#agregar')
                .not(':button, :submit, :reset, :hidden')
                .val('');
                $('#pad_fk_product').val('null');
            }else{
                failure(data.data);
            };
            
        }
    });
}

function read(id){
    var data = {
        "id" : id,
    };

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url:   readRoute,
        data: data,
        type:  'post',
        success:  function (data) { 
            if (data.success) {
                $('#u_pad_fk_product').val(data.data.pro_id);
                $('#u_pro_outlay').val(data.data.pro_outlay);
                $('#u_pad_impacts').val(data.data.pad_impacts);
                $('#u_pad_validity').val(data.data.pad_validity);
                $('#u_pad_discount').val(data.data.pad_discount);
                $('#u_pad_discount_number').val(data.data.pad_final_price);
                if(data.data.type == 'transmisión'){
                    $('#u_forType').show();                        
                }else{
                    $('#u_forType').hide();
                }
                $('#updateModal').modal('show'); 
            }else{
                failure(data.data);
            };      
            
        }
    });
}

function update(){
    var data = {
        "id" : this.id,        
        'pad_impacts': $('#u_pad_impacts').val(),
        'pad_validity': $('#u_pad_validity').val(),
        'pad_discount': $('#u_pad_discount').val(),
        "pad_final_price" : $('#u_pad_discount_number').val()
    };

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url:   updateRoute,
        data: data,
        type:  'post',
        success:  function (data) {
            if (data.success) {
                alert(data.data);
                loadTable();
                $('#updateModal').modal('hide'); 
                $(':input', '#actualizar')
                .not(':button, :submit, :reset, :hidden')
                .val('')
                .removeAttr('checked')
                .removeAttr('selected')
            }else{
                failure(data.data);
            };
            
        }
    });
}

function delet(id){
    var data = {
        "id" : id,
    };

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url:   deleteRoute,
        data: data,
        type:  'post',
        success:  function (data) {
            if (data.success) {
                alert(data.data);
                loadTable();
            }else{
                failure(data.data);
            };
            
        }
    });
}

function loadTable(){
    var data = {
        "pad_fk_package" : $('#pad_fk_package').text()
    };

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url:   readAllRoute,
        data: data,
        type:  'post',
        success:  function (data) {
            if (data.success) {
                $("#detalles").html('');
                if (data.data !== null && $.isArray(data.data) && data.data.length>0){
                    $.each(data.data, function(index, value){
                        $("#detalles").append('<tr class="gradeX"><td>'+value.pad_id+'</td><td>'+value.pro_name+'</td><td>'+value.pro_outlay+'</td><td>'+value.pad_impacts+'</td><td>'+value.pad_validity+'</td><td>'+value.pad_discount+'</td><td>'+value.pad_finalPrice+'</td><td>'+value.pad_subtotal+'</td><td><div class="btn-group" role="group" aria-label="..."><button class="btn btn-warning btn-sm" type="button" onclick="modalUpdate('+value.pad_id+')">Modificar</button><button class="btn btn-danger btn-sm" type="button" onclick="delet('+value.pad_id+')">Eliminar</button></div></td></tr>');
                    });
                }else{
                    $("#detalles").append('<tr class="gradeX"><td colspan="9">no existen detalles para este Paquete</td>');
                }
                $("#total_outlay").html(data.total_outlay);
            }else{
                failure(data.data);
            };
            
        }
    });
}

function modalUpdate(id){  
    this.id = id;
    read(id);                   
}


function loadProducts(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url:   loadProductsRoute,
        type:  'post',
        success:  function (data) { 
            if (data.success) {
                $.each(data.data, function(index, value) {   
                    $('#pad_fk_product')
                    .append($("<option></option>")
                       .attr("value",value.pro_id)
                       .text(value.pro_name));
                    $('#u_pad_fk_product')
                    .append($("<option></option>")
                       .attr("value",value.pro_id)
                       .text(value.pro_name));
                });        
            }else{
                failure(data.data);
            }; 
            
        }
    });
}

function toDiscount_number(){
    var price = parseFloat($('#pro_outlay').val());
    var discount = parseFloat($('#pad_discount').val());
    if(discount<=100){
        $('#pad_discount_number').val((price-(price*(discount/100))).toFixed(2));
    }else{
        $('#pad_discount_number').val((price+(price*((discount-100)/100))).toFixed(2));
    }
}

function toDiscount(){
    var price = parseFloat($('#pro_outlay').val());
    var discount = parseFloat($('#pad_discount_number').val());
    if(price>=discount){
        $('#pad_discount').val((100-((discount*100)/price)).toFixed(2));
    }else{
        $('#pad_discount').val(((((discount)*100)/price)).toFixed(2));
    }
}

function u_toDiscount_number(){
    var price = parseFloat($('#u_pro_outlay').val());
    var discount = parseFloat($('#u_pad_discount').val());
    if(discount<=100){
        $('#u_pad_discount_number').val((price-(price*(discount/100))).toFixed(2));
    }else{
        $('#u_pad_discount_number').val((price+(price*((discount-100)/100))).toFixed(2));
    }
}

function u_toDiscount(){
    var price = parseFloat($('#u_pro_outlay').val());
    var discount = parseFloat($('#u_pad_discount_number').val());
    if(price>=discount){
        $('#u_pad_discount').val((100-((discount*100)/price)).toFixed(2));
    }else{
        $('#u_pad_discount').val(((((discount)*100)/price)).toFixed(2));
    }
}

function loadListeners(){
    $( '#pad_fk_product' ).change(function() {
        var data = {
            "pro_id" : $('#pad_fk_product').val(),
        };

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url:   loadPriceProductRoute,
            data: data,
            type:  'post',
            success:  function (data) {  
                if (data.success) {
                    $('#pro_outlay').val(data.data);
                    if(data.type == 'transmisión'){
                        $('#forType').show();                        
                    }else{
                        $('#forType').hide();
                    }
                    toDiscount_number();
                }else{
                    failure(data.data);
                };
                
            }
        });
    });

    $( '#u_pad_fk_product' ).change(function() {
        var data = {
            "pro_id" : $('#u_pad_fk_product').val(),
        };

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url:   loadPriceProductRoute,
            data: data,
            type:  'post',
            success:  function (data) {  
                if (data.success) {
                    $('#u_pro_outlay').val(data.data);
                    u_toDiscount_number();
                }else{
                    failure(data.data);
                };
                
            }
        });
    });
}

$(document).ready(function(){
    loadProducts();
    loadListeners();
});
