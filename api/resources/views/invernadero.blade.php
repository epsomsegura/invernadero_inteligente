@extends('layouts.dashboard')
@section('page_heading','Invernadero')
@section('section')

<div class="container-fluid">
<div class="row">
        <div class="col-sm-1">
        </div>
        @if (Session::get('writegreenhouse') == 1)
        <div class="col-sm-10">
            <form class="form-inline">
                <button class="btn align-middle btn-primary" type="button" id="new">Nuevo Invernadero</button>
            </form>
        </div>
        @endif
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
                    <th>Dirección</th>
                    @if (Session::get('writegreenhouse') == 1)
                    <th>Acciones</th>
                    @endif
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
                <h5 class="modal-title">Registrar Nuevo Invernadero</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="m-t" role="form" id="newForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="nombre">Dirección:</label>
                            <div class="form-group">
                                <input required class="form-control" placeholder="Dirección" name="direccion" type="text" id="direccion" autofocus>
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
                <h5 class="modal-title">Editar Invernadero</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="m-t" role="form" id="editForm">
            <input required class="form-control" type="hidden" id="aid">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="nombre">Dirección:</label>
                            <div class="form-group">
                                <input required class="form-control" placeholder="Dirección" name="direccion" type="text" id="adireccion" autofocus>
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
            url:   "{{ action('GreenhouseController@readAll') }}",
            type:  'post',
            success:  function (response) {
                $('#table').DataTable().destroy(); //Se destruye el objeto de javascript
                $("#table").find("tbody").empty(); //Se limpia el HTML de la Tabla
                $(response.data).each(function(index,value){       
                    @if (Session::get('writegreenhouse') == 1)                         
                        $('#table').find("tbody").append('<tr><td>'+value.id+'</td><td>'+value.address+'</td><td><button type="button" class="btn btn-info editar" value="'+value.id+'"><i class="fa fa-pencil" aria-hidden="true"></i></button> <button type="button" class="btn btn-danger eliminar" value="'+value.id+'"><i class="fa fa-trash-o" aria-hidden="true"></i></button></tr>');                                
                    @else
                        $('#table').find("tbody").append('<tr><td>'+value.id+'</td><td>'+value.address+'</td></tr>');                                
                    @endif
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
            url:   "{{ action('GreenhouseController@read') }}",
            data: data,                
            type:  'post',
            success:  function (response) {
                $('#aid').val(response.data.id);
                $('#adireccion').val(response.data.address);
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
            "address" : $('#direccion').val()       
        };

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url:   "{{ action('GreenhouseController@new') }}",
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
            "address" : $('#adireccion').val(),     
        };

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url:   "{{ action('GreenhouseController@update') }}",
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
            url:   "{{ action('GreenhouseController@delete') }}",
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
