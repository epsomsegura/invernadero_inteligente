@extends('layouts.dashboard')
@section('page_heading','Sensores')
@section('section')

<div class="container-fluid"> 
<div class="row">
        <div class="col-sm-1">
        </div>
        <div class="col-sm-10">
            <form class="form-inline">                        
                <button class="btn align-middle btn-primary" type="button" id="new">Nuevo Sensor</button>
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
                    <th>Valor máximo</th>
                    <th>Valor mínimo</th>
                    <th>Tipo</th>
                    <th>ID parcela</th>                                                        
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
                <h5 class="modal-title">Registrar Nuevo Sensor</h5>
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

                            <label for="nombre">Valor máximo:</label>
                            <div class="form-group">
                                <input required class="form-control" placeholder="Valor máximo" name="valormax" type="number" id="valormax" autofocus>
                            </div>

                            <label for="nombre">Valor mínimo:</label>
                            <div class="form-group">
                                <input required class="form-control" placeholder="Valor mínimo" name="valormin" type="number" id="valormin" autofocus>
                            </div>

                            <label for="nombre">Tipo:</label>
                            <div class="form-group">
                                <select class="form-control" id="tipo">
                                    <option value="I">Individual (Sensa solo a la parcela)</option>
                                    <option value="G">General (Sensa todo el invernadero)</option>
                                </select>
                            </div>

                            <label for="nombre">ID parcela:</label>
                            <div class="form-group">
                                <select class="form-control" id="parcela">                           
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

<!-- Modal Edit-->
<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Sensor</h5>
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

                            <label for="nombre">Valor máximo:</label>
                            <div class="form-group">
                                <input required class="form-control" placeholder="Valor máximo" name="valormax" type="number" id="avalormax" autofocus>
                            </div>

                            <label for="nombre">Valor mínimo:</label>
                            <div class="form-group">
                                <input required class="form-control" placeholder="Valor mínimo" name="valormin" type="number" id="avalormin" autofocus>
                            </div>

                            <label for="nombre">Tipo:</label>
                            <div class="form-group">
                                <select class="form-control" id="atipo">
                                    <option value="I">Individual (Sensa solo a la parcela)</option>
                                    <option value="G">General (Sensa todo el invernadero)</option>
                                </select>
                            </div>

                            <label for="nombre">ID parcela:</label>
                            <div class="form-group">
                                <select class="form-control" id="aparcela">
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
    function getParcela(){    
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
                    $('#parcela').append('<option value="'+value.id+'">'+value.id+': '+value.plant+'- ID Invernadero: '+value.id_grenhouse+'</option>'); 
                    $('#aparcela').append('<option value="'+value.id+'">'+value.id+': '+value.plant+'- ID Invernadero: '+value.id_grenhouse+'</option>');                                
                });                                                        
            },
            error: function(response) { 
                alertify.notify(response.responseJSON.message);               
            }
        });
    }; 

    //Función que llena la tabla con los datos de la base de datos
    function getAll(){    
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url:   "{{ action('SensorController@readAll') }}",
            type:  'post',
            success:  function (response) {
                $('#table').DataTable().destroy(); //Se destruye el objeto de javascript
                $("#table").find("tbody").empty(); //Se limpia el HTML de la Tabla
                $(response.data).each(function(index,value){                                
                    $('#table').find("tbody").append('<tr><td>'+value.id+'</td><td>'+value.name+'</td><td>'+value.codename+'</td><td>'+value.maxvalue+'</td><td>'+value.minvalue+'</td><td>'+value.type+'</td><td>'+value.id_plot+'</td><td><button type="button" class="btn btn-info editar" value="'+value.id+'"><i class="fa fa-pencil" aria-hidden="true"></i></button> <button type="button" class="btn btn-danger eliminar" value="'+value.id+'"><i class="fa fa-trash-o" aria-hidden="true"></i></button></tr>');                                
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
            url:   "{{ action('SensorController@read') }}",
            data: data,                
            type:  'post',
            success:  function (response) {
                $('#aid').val(response.data.id);
                $('#anombre').val(response.data.name);
                $('#acodigo').val(response.data.codename);
                $('#avalormax').val(response.data.maxvalue);
                $('#avalormin').val(response.data.minvalue);
                $('#atipo').val(response.data.type);
                $('#aparcela').val(response.data.id_plot);
                $('#modalEdit').modal('show');
            },
            error: function(response) { 
                alertify.notify(response.responseJSON.message);               
            }
        });
    }; 

    //Función que envia datos para guardar un nuevo registro
    function fnew(){
        var data = {
            "name" : $('#nombre').val(), 
            "codename" : $('#codigo').val(), 
            "maxvalue" : $('#valormax').val(), 
            "minvalue" : $('#valormin').val(), 
            "type" : $('#tipo').val(), 
            "plot" : $('#parcela').val()
        };

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url:   "{{ action('SensorController@new') }}",
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
            "name" : $('#anombre').val(), 
            "codename" : $('#acodigo').val(), 
            "maxvalue" : $('#avalormax').val(), 
            "minvalue" : $('#avalormin').val(), 
            "type" : $('#atipo').val(), 
            "plot" : $('#aparcela').val()   
        };

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url:   "{{ action('SensorController@update') }}",
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
            url:   "{{ action('SensorController@delete') }}",
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
            $('#direccion').val('');
            $('#modalNew').modal('show');
        });

        /*
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
        */
        getAll();
        getParcela();

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

});

</script>
 @endpush
@stop
