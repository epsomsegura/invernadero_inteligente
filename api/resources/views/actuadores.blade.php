@extends('layouts.dashboard')
@section('page_heading','Actuadores')
@section('section')

<div class="container-fluid"> 
    
    <div class="row">
        <div class="col-sm-1">
        </div>
        <div class="col-sm-10">
            <form class="form-inline">                        
                <button class="btn align-middle btn-primary" type="button" id="new">Nuevo Actuador</button>
            </form>
        </div>
        <div class="col-sm-1">
        </div>                        
    </div>
    <br>  
    <div class="row">
        <div class="col-sm-1">
        </div>
        <div class="col-sm-10">
            <table id="table" class="display" cellspacing="0" width="100%">
                <thead>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Código</th>
                    <th>Tipo</th>
                    <th>ID parcela</th>
                    <th>ID sensor</th>                                                        
                    <th>Acciones</th>                           
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <div class="col-sm-1">
        </div>
    </div>
</div>  


<!-- Modal -->
<div class="modal fade" id="modalNew" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Registrar Nuevo Actuador</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="m-t" role="form" id="newForm">
                <div class="modal-body">    
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="nombre">Nombre:</label>
                            <div class="form-group">
                                <input required class="form-control" placeholder="Nombre" name="nombre" type="text" id="nombre" autofocus>
                            </div>
                            
                            <label for="nombre">Código:</label>
                            <div class="form-group">
                                <input required class="form-control" placeholder="Código" name="codigo" type="text" id="codigo" autofocus>
                            </div>
                           
                            <label for="nombre">Tipo:</label>
                            <div class="form-group">
                                <input required class="form-control" placeholder="Tipo" name="tipo" type="text" id="tipo" autofocus>
                            </div>

                            <label for="id_parcela">ID Parcela:</label>
                            <div class="form-group">
                                <select class="form-control" id="parcela">   
                                    <option disabled value=''>---Seleccionar parcela---</option>                          
                        
                                </select>
                            </div>

                            <label for="id_sensor">ID Sensor:</label>
                            <div class="form-group">
                                <select disabled class="form-control" id="sensor">       
                                    <option value="">Sin Sensor Asociado</option>');                    
                                </select>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <input class="btn btn-primary" type="submit" value="Guardar">                                                                
                </div>
            </form>
        </div>
    </div>
</div>  


<!-- Modal Edit -->
<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Actuador</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="m-t" role="form" id="editForm">
            <input required class="form-control" type="hidden" id="aid">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="nombre">Nombre:</label>
                            <div class="form-group">
                                <input required class="form-control" placeholder="Nombre" name="nombre" type="text" id="anombre" autofocus>
                            </div>
                            <label for="nombre">Código:</label>
                            <div class="form-group">
                                <input required class="form-control" placeholder="Código" name="codigo" type="text" id="acodigo" autofocus>
                            </div>
                            <label for="nombre">Tipo:</label>
                            <div class="form-group">
                                <input required class="form-control" placeholder="Tipo" name="tipo" type="text" id="atipo" autofocus>
                            </div>
                            <label for="invernadero">ID Parcela:</label>
                            <div class="form-group">
                                <select class="form-control" id="aparcela">
                                    <option disabled value=''>---Seleccionar parcela---</option>                          
                                </select>
                            </div>
                            <label for="invernadero">ID Sensor:</label>
                            <div class="form-group">
                                <select disabled class="form-control" id="asensor">
                                    <option value="">Sin Sensor Asociado</option>');                           
                                </select>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <input class="btn btn-primary" type="submit" value="Guardar">
                </div>
            </form>
        </div>
    </div>
</div>


@push('scripts')
<script>                    
    
 //Función que llena la tabla con los datos de la base de datos              
    function getAll(){    
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url:   "{{ action('ActuatorController@readAll') }}",
            type:  'post',
            success:  function (response) {
                $('#table').DataTable().destroy(); //Se destruye el objeto de javascript
                $("#table").find("tbody").empty(); //Se limpia el HTML de la Tabla
                $(response.data).each(function(index,value){                                
                    //Dudas
                    $('#table').find("tbody").append('<tr><td>'+value.id+'</td><td>'+value.name+'</td><td>'+value.codename+'</td><td>'+value.type+'</td><td>'+value.id_plot+'</td><td>'+value.id_sensor+'</td><td><button type="button" class="btn btn-info editar" value="'+value.id+'"><i class="fa fa-pencil" aria-hidden="true"></i></button> <button type="button" class="btn btn-danger eliminar" value="'+value.id+'"><i class="fa fa-trash-o" aria-hidden="true"></i></button></tr>');                                
                });                            
                $('#table').DataTable({
                    responsive: true,
                    "order": [[ 0, "desc" ]],
                    "language" : {
                        "sProcessing":     "Procesando...",
                        "sLengthMenu":     "Mostrar _MENU_ registros",
                        "sZeroRecords":    "No se encontraron resultados",
                        "sEmptyTable":     "Ningún dato disponible en esta tabla",
                        "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                        "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                        "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                        "sInfoPostFix":    "",
                        "sSearch":         "Buscar:",
                        "sUrl":            "",
                        "sInfoThousands":  ",",
                        "sLoadingRecords": "Cargando...",
                        "oPaginate": {
                            "sFirst":    "Primero",
                            "sLast":     "Último",
                            "sNext":     "Siguiente",
                            "sPrevious": "Anterior"
                        },
                        "oAria": {
                            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                        }
                    }
                });                            
            },
            error: function(response) { 
                alertify.notify(response.responseJSON.message);               
            }
        });
    };

    //llena los select de nuevo y de editar 
    function getParcelas(){    
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url:   "{{ action('PlotController@readAll') }}",
            type:  'post',
            success:  function (response) {
                $(response.data).each(function(index,value){                                
                   //Dudas
                    $('#parcela').append('<option value="'+value.id+'">ID '+value.id+': '+value.plant+'</option>'); 
                    $('#aparcela').append('<option value="'+value.id+'">ID '+value.id+': '+value.plant+'</option>'); 
                });                                                        
            },
            error: function(response) { 
                alertify.notify(response.responseJSON.message);               
            }
        });
    }; 

    //llena los select de nuevo y de editar 
    function getSensors(id,selected = false,idSelected = ''){    
        $('#sensor').prop('disabled',true);
        $('#asensor').prop('disabled',true);

        var data = {
            'id_plot': id
        };

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url:   "{{ action('SensorController@readBySensores') }}",
            data: data,
            type:  'post',
            success:  function (response) {
                $('#sensor').html('');
                $('#asensor').html('');
                $('#sensor').append('<option value="">Sin Sensor Asociado</option>');
                $('#asensor').append('<option value="">Sin Sensor Asociado</option>');
                $(response.data).each(function(index,value){                                
                   //Dudas
                    $('#sensor').append('<option value="'+value.id+'">ID '+value.id+': '+value.codename+' - '+value.name+'</option>'); 
                    $('#asensor').append('<option value="'+value.id+'">ID '+value.id+': '+value.codename+' - '+value.name+'</option>'); 
                });
                $('#sensor').prop('disabled',false);
                $('#asensor').prop('disabled',false);   
                if (selected) {
                    $('#asensor').val(idSelected);
                }                                                     
            },
            error: function(response) { 
                alertify.notify(response.responseJSON.message);               
            }
        });
    }; 
 
    //función que obtiene un solo registro.
    function get(id){ 
        var data = {
            "id" : id                    
        };

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url:   "{{ action('ActuatorController@read') }}",
            data: data,                
            type:  'post',
            success:  function (response) {
                $('#aid').val(response.data.id);
                $('#anombre').val(response.data.name);
                $('#acodigo').val(response.data.codename);
                $('#atipo').val(response.data.type);
                $('#aparcela').val(response.data.id_plot);
                getSensors(response.data.id_plot,true,response.data.id_sensor);
                $('#modalEdit').modal('show');
            },
            error: function(response) { 
                alertify.notify(response.responseJSON.message);               
            }
        });
    }; 

//Función que envia datos para guardar un nuevo registro 
function fnew(){
    //dudas
        var data = {
            "name" : $('#nombre').val(),  //(nombre de la base de datos : y coma)
            "codename" : $('#codigo').val(),
            "type" : $('#tipo').val(),
            "plot" : $('#aparcela').val(),       
            "sensor" : $('#sensor').val() 
        };

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url:   "{{ action('ActuatorController@new') }}",
            data: data,                
            type:  'post',
            success:  function (response) {
                alertify.success(response.message);
                $('#modalNew').modal('hide'); 
                getAll();                                                 
            },
            error: function(response) { 
                alertify.notify(response.responseJSON.message);               
            }
        });
    };

    //Función que actualiza los datos.
    function update(){
        var data = {
            "id" : $('#aid').val(),
            "name" : $('#anombre').val(), //Yo
            "codename" : $('#acodigo').val(),
            "type" : $('#atipo').val(),
            "plot" : $('#aparcela').val(),
            "sensor" : $('#asensor').val()
        };

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url:   "{{ action('ActuatorController@update') }}",
            data: data,                
            type:  'post',
            success:  function (response) {
                alertify.success(response.message);
                $('#modalEdit').modal('hide'); 
                getAll();                                                 
            },
            error: function(response) { 
                alertify.notify(response.responseJSON.message);               
            }
        });
    };  

    //Función que elimina un registro.
    function fdelete(id){
        var data = {
            "id" : id, 
           
        };

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url:   "{{ action('ActuatorController@delete') }}",
            data: data,                
            type:  'post',
            success:  function (response) {
                alertify.success(response.message);
                getAll();                                                 
            },
            error: function(response) { 
                alertify.notify(response.responseJSON.message);               
            }
        });
    };



    $(document).ready(function() {  
        alertify.set('notifier','position', 'top-left');
        alertify.set('notifier','delay', 10);
        
        $("#new").on('click',function(){ 
            $('#nombre').val('');
            $('#codigo').val('');
            $('#tipo').val('');
            $('#parcela').val('');
            $('#sensor').val('');
            $('#modalNew').modal('show');
        }); 

        getAll();

        $('#newForm').submit(function () {
            fnew();
            return false;
        }); 

        $('#table').on('click','.editar',function(){
            get($(this).val()); 
        });

        $('#editForm').submit(function () {
            update();
            return false;
        });   

        $('#table').on('click','.eliminar',function(){
            fdelete($(this).val()); 
        });   

        getParcelas();

        $('#parcela').on('change',function(){
            getSensors($(this).val()); 
        });

         $('#aparcela').on('change',function(){
            getSensors($(this).val()); 
        });   
    });
    
</script>   
 @endpush                     
@stop