$('#tabla').dataTable({
    "sPaginationType": "full_numbers"
});

$('#tablaDisponibilidades').dataTable({
    paging: false,
    "bLengthChange": false,
});

$("#registrarContrato").validationEngine({
    promptPosition: "bottomRight",
    scroll: false,
    autoHidePrompt: true,
    autoHideDelay: 1000
});
$(function () {
    $("#registrarContrato").submit(function () {
        $resultado = $("#registrarContrato").validationEngine("validate");
        if ($resultado) {

            return true;
        }
        return false;
    });
});


$("#tablaTitulos").dataTable().fnDestroy();

$(document).ready(function () {
    $('#tablaTitulos').DataTable({
        dom: 'T<"clear">lfrtip',
        tableTools: {
            "sRowSelect": "os",
            "aButtons": ["select_all", "select_none"]
        },
        "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sSearch": "Buscar:",
            "sLoadingRecords": "Cargando...",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Ãšltimo",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            }
        },
        "columnDefs": [
            {
                "targets": [0, 1],
                "visible": false,
                "searchable": false
            }
        ],
        processing: true,
        searching: true,
        info: true,
        "scrollY": "400px",
        "scrollCollapse": false,
        "bLengthChange": false,
        "bPaginate": false,
        "aoColumns": [
            {sWidth: "1%", sClass: "center"},
            {sWidth: "1%", sClass: "center"},
            {sWidth: "10%", sClass: "center"},
            {sWidth: "12%", sClass: "center"},
            {sWidth: "21%", sClass: "center"},
            {sWidth: "20%", sClass: "center"},
            {sWidth: "15%", sClass: "center"},
            {sWidth: "10%", sClass: "center"},
            {sWidth: "5%", sClass: "center"},
            {sWidth: "5%", sClass: "center"}

        ]


    });
})


