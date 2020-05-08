var calendar = null;
var selectedTr = null;
var idForRegistry = null;

function loadServiceOrders() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: getServiceOrdersRoute,
        type: 'post',
        success: function(data) {
            if (data.success) {
                $("#pendientes").html('');
                $("#enProceso").html('');
                $("#completas").html('');
                $("#historial").html('');
                if (data.pending !== null && $.isArray(data.pending) && data.pending.length > 0) {
                    $.each(data.pending, function(index, value) {
                        $("#pendientes").append('<tr class="gradeX"><td>' + value.id + '</td><td>' + value.customer + '</td><td>' + value.start_date + '</td><td><div class="btn-group" role="group" aria-label="..."><button class="btn btn-success btn-sm" type="button" onclick="detail(\'' + value.id + '\')">En Proceso</button></div></td></tr>');
                    });
                    tableSelect('pendientes');
                } else {
                    $("#pendientes").append('<tr class="gradeX"><td colspan="7">No existen ordenes de servicio vigentes</td>');
                }
                if (data.process !== null && $.isArray(data.process) && data.process.length > 0) {
                    $.each(data.process, function(index, value) {
                        $("#enProceso").append('<tr class="gradeX"><td>' + value.id + '</td><td>' + value.customer + '</td><td>' + value.start_date + '</td><td><div class="btn-group" role="group" aria-label="..."><button class="btn btn-success btn-sm" type="button" onclick="updateModal(\'' + value.id + '\')">Siguiente Registro</button></div></td></tr>');
                    });
                    tableSelect('enProceso');
                } else {
                    $("#enProceso").append('<tr class="gradeX"><td colspan="7">No existen ordenes de servicio en proceso</td>');
                }
                if (data.full !== null && $.isArray(data.full) && data.full.length > 0) {
                    $.each(data.full, function(index, value) {
                        $("#completas").append('<tr class="gradeX"><td>' + value.id + '</td><td>' + value.customer + '</td><td>' + value.start_date + '</td></tr>');
                    });
                    tableSelect('completas');
                } else {
                    $("#completas").append('<tr class="gradeX"><td colspan="7">No existen ordenes de servicio completas</td>');
                }
                if (data.historial !== null && $.isArray(data.historial) && data.historial.length > 0) {
                    $.each(data.historial, function(index, value) {
                        $("#historial").append('<tr class="gradeX"><td>' + value.id + '</td><td>' + value.customer + '</td><td>' + value.start_date + '</td></tr>');
                    });
                    tableSelect('historial');
                } else {
                    $("#historial").append('<tr class="gradeX"><td colspan="7">No existen ordenes de servicio anteriores</td>');
                }
            } else {
                failure(data.data);
            }
        }
    });
}

function tableSelect(id) {
    var table = document.getElementById(id);
    var tr = table.getElementsByTagName('tr');
    for (var i = 0; i < tr.length; i++) {
        tr[i].addEventListener('click', function() {
            if (selectedTr !== null) {
                selectedTr.removeAttr('style');
                if (selectedTr[0].innerHTML != $(this)[0].innerHTML) {
                    selectedTr = $(this);
                    selectedTr.css('background-color', 'orange');
                    getDatesByServiceOrder();
                } else {
                    selectedTr = null;
                    loadCalendar(getDatesRoute);
                }
            } else {
                selectedTr = $(this);
                selectedTr.css('background-color', 'orange');
                getDatesByServiceOrder();
            }
        });
    }
}

function getDatesByServiceOrder() {
    var data = {
        'id': selectedTr.children().eq(0).html(),
    };
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: getDatesByServiceOrderRoute,
        data: data,
        type: 'post',
        success: function(data) {
            if (data.success) {
                loadCalendar(data.result);
            } else {
                failure(data.data);
            }
        }
    });
}

function loadCalendar(values) {
    "use strict";
    var options = {
        events_source: values,
        view: 'month',
        tmpl_path: 'assets/scripts/bootstrap-calendar/tmpls/',
        tmpl_cache: false,
        day: 'now',
        language: 'es-MX',
        /*modal: "#events-modal",
        modal_type: "ajax",
        modal_title: function (e) {
            return e.title;
        },*/
        format12: true,
        am_suffix: "AM",
        pm_suffix: "PM",
        time_start: '09:00',
        time_end: '22:00',
        time_split: '30',
        onAfterEventsLoad: function(events) {
            if (!events) {
                return;
            }
            var list = $('#eventlist');
            list.html('');
            $.each(events, function(key, val) {
                $(document.createElement('li')).html('<a href="' + val.url + '">' + val.title + '</a>').appendTo(list);
            });
        },
        onAfterViewLoad: function(view) {
            $('.page-header h3').text(this.getTitle());
            $('.btn-group button').removeClass('active');
            $('button[data-calendar-view="' + view + '"]').addClass('active');
        },
        classes: {
            months: {
                general: 'label'
            }
        }
    };
    calendar = $('#calendar').calendar(options);
    $('.btn-group button[data-calendar-nav]').each(function() {
        var $this = $(this);
        $this.click(function() {
            calendar.navigate($this.data('calendar-nav'));
        });
    });
    $('.btn-group button[data-calendar-view]').each(function() {
        var $this = $(this);
        $this.click(function() {
            calendar.view($this.data('calendar-view'));
        });
    });
    $('#first_day').change(function() {
        var value = $(this).val();
        value = value.length ? parseInt(value) : null;
        calendar.setOptions({
            first_day: value
        });
        calendar.view();
    });
    $('#language').change(function() {
        calendar.setLanguage($(this).val());
        calendar.view();
    });
    $('#events-in-modal').change(function() {
        var val = $(this).is(':checked') ? $(this).val() : null;
        calendar.setOptions({
            modal: val
        });
    });
    $('#format-12-hours').change(function() {
        var val = $(this).is(':checked') ? true : false;
        calendar.setOptions({
            format12: val
        });
        calendar.view();
    });
    $('#show_wbn').change(function() {
        var val = $(this).is(':checked') ? true : false;
        calendar.setOptions({
            display_week_numbers: val
        });
        calendar.view();
    });
    $('#show_wb').change(function() {
        var val = $(this).is(':checked') ? true : false;
        calendar.setOptions({
            weekbox: val
        });
        calendar.view();
    });
    $('#events-modal .modal-footer').click(function(e) {});
}

function detail(id) {
    var data = {
        'id': id,
    };
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: setToInProcessRoute,
        data: data,
        type: 'post',
        success: function(data) {
            if (data.success) {
                alert(data.message);
                loadServiceOrders();
                loadCalendar(getDatesRoute);
            } else {
                failure(data.data);
            }
        }
    });
}

function updateModal(id) {
    idForRegistry = id;
    var data = {
        'id': id,
    };
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: checkRegistryRoute,
        data: data,
        type: 'post',
        success: function(data) {
            if (data.success) {
                checkRegistry(data.data);
            } else {
                failure(data.data);
            }
        }
    });
}

function checkRegistry(data) {
    switch (data) {
        case 'prr_proposal_1':
            alert('Fecha de propuesta 1 registrada');
            loadServiceOrders();
            loadCalendar(getDatesRoute);
            break;
        case 'prr_proposal_2':
            alert('Fecha de propuesta 2 registrada');
            loadServiceOrders();
            loadCalendar(getDatesRoute);
            break;
        case 'prr_proposal_3':
            alert('Fecha de propuesta 3 registrada');
            loadServiceOrders();
            loadCalendar(getDatesRoute);
            break;
        case 'prr_customer_answer_1':
            $('#ModalTitle').text("Respuesta 1 del Cliente");
            $('#registryModal').modal('show');
            break;
        case 'prr_customer_answer_2':
            $('#ModalTitle').text("Respuesta 2 del Cliente");
            $('#registryModal').modal('show');
            break;
        case 'prr_customer_answer_3':
            $('#ModalTitle').text("Respuesta 2 del Cliente");
            $('#registryModal').modal('show');
            break;
    }
}

function save() {
    var data = {
        'id': idForRegistry,
        'comment': $('#comment').val(),
        'aprobate': $('#aprobate').is(':checked')
    };
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: setCustomerResponseRoute,
        data: data,
        type: 'post',
        success: function(data) {
            if (data.success) {
                alert(data);
                loadServiceOrders();
                loadCalendar(getDatesRoute);
                $('#registryModal').modal('hide');
            } else {
                failure(data.data);
            }
        }
    });
}
$(document).ready(function() {
    loadServiceOrders();
    loadCalendar(getDatesRoute);
});