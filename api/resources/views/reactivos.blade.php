@extends('layouts.dashboard')
@section('page_heading','Reactivos Activos')
@section('section')

<div class="container-fluid"> 
    <div class="row">
        <div class="col-sm-3">
        Materia
        </div>
        <div class="col-sm-3">
            Ámbito/Eje/Bloque
        </div>
        <div class="col-sm-3">
            Aprendizaje a Evaluar
        </div>
        <div class="col-sm-3">
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3">
            <div class="dropdown">
                <button class="btn btn-default btn-block dropdown-toggle" type="button" id="dropMateriaBtn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    Matería
                <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" id="dropMateria" aria-labelledby="dropdownMenu1">
                    
                </ul>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="dropdown">
                <button disabled class="btn btn-default btn-block dropdown-toggle" type="button" id="dropAmbitoBtn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    Ámbito/Eje/Bloque
                <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" id="dropAmbito" aria-labelledby="dropdownMenu1">
                    
                </ul>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="dropdown">
                <button disabled class="btn btn-default btn-block dropdown-toggle" type="button" id="dropAEBtn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    Aprendizaje a Evaluar
                <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" id="dropAE" aria-labelledby="dropdownMenu1">
                    
                </ul>
            </div>
        </div>
        <div class="col-sm-3">
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
                    <th>Materia</th>
                    <!--<th>Bloque</th>-->
                    <th>Ámbito/Eje/Bloque</th>
                    <th>Aprendizaje a Evaluar</th>
                    <th data-priority="10007">Tipo</th>
                    <th data-priority="10008">Reactivo Padre</th>
                    <th>Instrucción</th>
                    <th>Pregunta</th>
                    <th data-priority="10001">Respuesta A</th>
                    <th data-priority="10002">Respuesta B</th>
                    <th data-priority="10003">Respuesta C</th>
                    <th data-priority="10004">Respuesta D</th>
                    <th data-priority="10005">Respuesta Correcta</th>                                        
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

@push('scripts')
<script>                    
    


    $(document).ready(function() {  
        alertify.set('notifier','position', 'top-left');
        alertify.set('notifier','delay', 10);
        
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

         

    });
    
</script>   
 @endpush                     
@stop