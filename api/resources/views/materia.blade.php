@extends('layouts.dashboard')
@section('page_heading','Asignaturas')
@section('section')

<div class="container-fluid"> 
    <div class="row">
        <div class="col-sm-1">
        </div>
        <div class="col-sm-10">
            <form class="form-inline">                        
                <button class="btn align-middle btn-primary" type="button" id="new">Nueva Asignatura</button>
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
                    <th>Grado</th>  
                    <th>Nombre</th>
                    <th>Reactivos</th>  
                    <th>Abreviatura</th> 
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
                <h5 class="modal-title">Registrar Nueva Asignatura</h5>
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
                            <label for="grado">Grado:</label>
                            <div class="form-group">
                                <select class="form-control" id="grado">
                                    <option value="1">1</option>
                                    <option value="2">2</option>  
                                    <option value="3">3</option> 
                                    <option value="4">4</option> 
                                    <option value="5">5</option> 
                                    <option value="6">6</option>                             
                                </select>
                            </div>
                            <label for="abreviatura">Abreviatura:</label>                
                            <div class="form-group">
                                <input required class="form-control" placeholder="Abreviatura" name="abreviatura" type="text" id="abreviatura">
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

<!-- Modal -->
<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Asignatura</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="m-t" role="form" id="editForm">
                <input type="hidden" id="aid">
                <div class="modal-body">   
                <div class="col-sm-12">
                    <label for="permissions">Nombre:</label>
                    <div class="form-group">
                        <input required class="form-control" placeholder="Nombre" name="nombre" type="text" id="anombre" autofocus>
                    </div>
                    <label for="permissions">Grado:</label>
                    <div class="form-group">
                        <select class="form-control" id="agrado">
                            <option value="1">1</option>
                            <option value="2">2</option>  
                            <option value="3">3</option> 
                            <option value="4">4</option> 
                            <option value="5">5</option> 
                            <option value="6">6</option>                             
                        </select>
                    </div>
                    <label for="permissions">Abreviatura:</label>                
                    <div class="form-group">
                        <input required class="form-control" placeholder="Abreviatura" name="abreviatura" type="text" id="aabreviatura">
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
    function getAll(){    
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url:   "{{ action('SubjectController@getAll') }}",
            type:  'post',
            success:  function (response) {
                $('#table').DataTable().destroy(); //Se destruye el objeto de javascript
                $("#table").find("tbody").empty(); //Se limpia el HTML de la Tabla
                $(response.data).each(function(index,value){                                
                    $('#table').find("tbody").append('<tr><td>'+value.id+'</td><td>'+value.grade+'</td><td>'+value.name+'</td><td>'+value.count_question+'</td><td>'+value.alias+'</td><td><button type="button" class="btn btn-info editar" value="'+value.id+'"><i class="fa fa-pencil" aria-hidden="true"></i></button> <button type="button" class="btn btn-danger eliminar" value="'+value.id+'"><i class="fa fa-trash-o" aria-hidden="true"></i></button></tr>');                                
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
            url:   "{{ action('SubjectController@get') }}",
            data: data,                
            type:  'post',
            success:  function (response) {
                $('#aid').val(response.data.id);
                $('#anombre').val(response.data.name);
                $('#agrado').val(response.data.grade);
                $('#aabreviatura').val(response.data.alias);
                $('#modalEdit').modal('show');
            },
            error: function(response) { 
                alertify.notify(response.responseJSON.message);               
            }
        });
    }; 

    function fnew(){
        var data = {
            "name" : $('#nombre').val(),
            "grade" : $('#grado').val(),
            "alias" : $('#abreviatura').val(),        
        };

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url:   "{{ action('SubjectController@new') }}",
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

    function update(){
        var data = {
            "id" : $('#aid').val(),
            "name" : $('#anombre').val(),
            "grade" : $('#agrado').val(),
            "alias" : $('#aabreviatura').val(),        
        };

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url:   "{{ action('SubjectController@update') }}",
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
            url:   "{{ action('SubjectController@delete') }}",
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
        
        getAll(); 

        $("#new").on('click',function(){ 
            $('#nombre').val('');
            $('#grado').val(1);
            $('#abreviatura').val('');
            $('#modalNew').modal('show');
        }); 

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