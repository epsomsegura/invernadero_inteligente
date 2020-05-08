@extends('layouts.dashboard')
@section('page_heading','Usuarios')
@section('section')

<div class="container-fluid">
<div class="row">
        <div class="col-sm-1">
        </div>
        <div class="col-sm-3">
            <form class="form-inline">
                <button class="btn align-middle btn-primary" type="button" id="new">Nuevo Usuario</button>
            </form>
        </div>
        <div class="col-sm-7">
            <form class="form-inline">
                <button class="btn align-middle btn-primary" type="button" id="grant">Dar Permisos a Invernadero</button>
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
                    <th>Nombre de Usuario</th>
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
                <h5 class="modal-title">Registrar Nuevo Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="m-t" role="form" id="newForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="nombre">Nombre Usuario:</label>
                            <div class="form-group">
                                <input required class="form-control" placeholder="Usuario" name="usuario" type="text" id="usuario" autofocus>
                            </div>
                            <label for="nombre">Contraseña:</label>
                            <div class="form-group">
                                <input required class="form-control" placeholder="Contraseña" name="contraseña" type="password" id="password" autofocus>
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
                <h5 class="modal-title">Editar Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="m-t" role="form" id="editForm">
            <input required class="form-control" type="hidden" id="aid">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="nombre">Nombre Usuario:</label>
                            <div class="form-group">
                                <input required class="form-control" placeholder="Usuario" name="usuario" type="text" id="ausuario" autofocus>
                            </div>
                            <label for="nombre">Contraseña:</label>
                            <div class="form-group">
                                <input class="form-control" placeholder="Dejar en blanco para no modificar" name="contraseña" type="password" id="apassword" autofocus>
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

<!-- Modal Permissions -->
<div class="modal fade" id="modalPermissions" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Permisos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="m-t" role="form" id="PermissionsForm">
            <input required class="form-control" type="hidden" id="sid">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="grado">Ver/Editar Sensores:</label>
                            <div class="form-group">
                                <select class="form-control" id="sensors">                           
                                    <option value="1">Si</option>
                                    <option value="0">No</option>                        
                                </select>
                            </div>
                            <label for="grado">Ver/Editar Actuadores:</label>
                            <div class="form-group">
                                <select class="form-control" id="actuators">   
                                    <option value="1">Si</option>
                                    <option value="0">No</option>                        
                                </select>
                            </div>
                            <label for="grado">Ver Invernadero:</label>
                            <div class="form-group">
                                <select class="form-control" id="readgreenhouse">     
                                    <option value="1">Si</option>
                                    <option value="0">No</option>                  
                                </select>
                            </div>
                            <label for="grado">Editar Invernadero:</label>
                            <div class="form-group">
                                <select class="form-control" id="writegreenhouse">    
                                    <option value="1">Si</option>
                                    <option value="0">No</option>                       
                                </select>
                            </div>
                            <label for="grado">Ver Parcela:</label>
                            <div class="form-group">
                                <select class="form-control" id="readplot"> 
                                    <option value="1">Si</option>
                                    <option value="0">No</option>                          
                                </select>
                            </div>
                            <label for="grado">Editar Parcela:</label>
                            <div class="form-group">
                                <select class="form-control" id="writeplot">
                                    <option value="1">Si</option>
                                    <option value="0">No</option>                           
                                </select>
                            </div>
                            <label for="grado">Ver Usuarios:</label>
                            <div class="form-group">
                                <select class="form-control" id="readusers">                           
                                    <option value="1">Si</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                            <label for="grado">Editar Usuario:</label>
                            <div class="form-group">
                                <select class="form-control" id="writeusers">                           
                                    <option value="1">Si</option>
                                    <option value="0">No</option>
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

<!-- Modal GrantGreenhouse -->
<div class="modal fade" id="modalGrant" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Permitir Invernadero</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="m-t" role="form" id="grantForm">
            <input required class="form-control" type="hidden" id="sid">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="grado">Usuario:</label>
                            <div class="form-group">
                                <select class="form-control" id="guser">                           
                                    <option selected disabled>Selecciona un usuario</option>         
                                </select>
                            </div>
                            <label for="grado">Invernadero:</label>
                            <div class="form-group">
                                <select disabled class="form-control" id="ggreenhouse">                           
                                                            
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
    function getUserGrant(){    
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url:   "{{ action('UserController@getUserToGrant') }}",
            type:  'post',
            success:  function (response) {
                $(response.data).each(function(index,value){                                
                    $('#guser').append('<option value="'+value.id+'">'+value.id+': '+value.username+'</option>'); 
                });                                                        
            },
            error: function(response) { 
                alertify.notify(response.responseJSON.message);               
            }
        });
    };

    function getInvernaderosGrant(id){  
        var data = {
            "id" : id,       
        };

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url:   "{{ action('GreenhouseController@getGreenhouseToGrant') }}",
            type:  'post',
            data: data,
            success:  function (response) {
                $(response.data).each(function(index,value){                                
                    $('#ggreenhouse').append('<option value="'+value.id+'">'+value.id+': '+value.address+'</option>'); 
                });   
                $('#ggreenhouse').prop('disabled',false);                                                     
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
            url:   "{{ action('UserController@readAll') }}",
            type:  'post',
            success:  function (response) {
                $('#table').DataTable().destroy(); //Se destruye el objeto de javascript
                $("#table").find("tbody").empty(); //Se limpia el HTML de la Tabla
                $(response.data).each(function(index,value){                                
                    $('#table').find("tbody").append('<tr><td>'+value.id+'</td><td>'+value.username+'</td><td><button type="button" class="btn btn-success permisos" value="'+value.id+'"><i class="fa fa-check" aria-hidden="true"></i></button> <button type="button" class="btn btn-info editar" value="'+value.id+'"><i class="fa fa-pencil" aria-hidden="true"></i></button> <button type="button" class="btn btn-danger eliminar" value="'+value.id+'"><i class="fa fa-trash-o" aria-hidden="true"></i></button></tr>');                                
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
            url:   "{{ action('UserController@read') }}",
            data: data,                
            type:  'post',
            success:  function (response) {
                $('#aid').val(response.data.id);
                $('#ausuario').val(response.data.username);
                $('#apassword').val('');
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
            "username" : $('#usuario').val(),       
            "password" : $('#password').val()       
        };

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url:   "{{ action('UserController@new') }}",
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
            "username" : $('#ausuario').val(),       
            "password" : $('#apassword').val()   
        };

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url:   "{{ action('UserController@update') }}",
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
            url:   "{{ action('UserController@delete') }}",
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

    function fgetPermissions(id){ 
        var data = {
            "id" : id                    
        };

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url:   "{{ action('UserController@getPermissions') }}",
            data: data,                
            type:  'post',
            success:  function (response) {
                $('#sid').val(response.data.id);
                $('#sensors').val(response.data.sensors);
                $('#actuators').val(response.data.actuators);
                $('#readgreenhouse').val(response.data.readgreenhouse);
                $('#writegreenhouse').val(response.data.writegreenhouse);
                $('#readplot').val(response.data.readplot);
                $('#writeplot').val(response.data.writeplot);
                $('#readusers').val(response.data.readusers);
                $('#writeusers').val(response.data.writeusers);
                $('#modalPermissions').modal('show');
            },
            error: function(response) { 
                alertify.notify(response.responseJSON.message);               
            }
        });
    }; 


    function fSavePermissions(){ 
        var data = {
            "id" : $('#sid').val(),        
            "sensors" : $('#sensors').val(),
            "actuators" : $('#actuators').val(),
            "readgreenhouse" : $('#readgreenhouse').val(),
            "writegreenhouse" : $('#writegreenhouse').val(),
            "readplot" : $('#readplot').val(),
            "writeplot" : $('#writeplot').val(),
            "readusers" : $('#readusers').val(),
            "writeusers" : $('#writeusers').val()
        };

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url:   "{{ action('UserController@savePermissions') }}",
            data: data,                
            type:  'post',
            success:  function (response) {
                alertify.success(response.message);
                $('#modalPermissions').modal('hide');
            },
            error: function(response) { 
                alertify.notify(response.responseJSON.message);               
            }
        });
    };

    function saveGrant(){
        var data = {
            "idUser" : $('#guser').val(),       
            "idGreenhouse" : $('#ggreenhouse').val()       
        };

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url:   "{{ action('GreenhouseController@saveGrant') }}",
            data: data,                
            type:  'post',
            success:  function (response) {
                alertify.success(response.message);
                $('#modalGrant').modal('hide');                                             
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
        getUserGrant();

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

        $('#PermissionsForm').submit(function () {
            fSavePermissions();
            return false;
        });   

        $('#grantForm').submit(function (){
            saveGrant();
            return false;
        })

        $('#table').on('click','.eliminar',function(){
            fdelete($(this).val()); 
        });   

        $('#table').on('click','.permisos',function(){
            fgetPermissions($(this).val()); 
        }); 

        $("#grant").on('click',function(){
            $('#modalGrant').modal('show');
        });

        $("#guser").on('change',function(){
            getInvernaderosGrant($(this).val());
        });
});

</script>
 @endpush
@stop
