<script type='text/javascript'>

    $(function () {


        $(function () {

            $('#tablaContratosAprobados').ready(function () {

                var table = $('#tablaContratosAprobados').dataTable({
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
                    processing: true,
                    searching: true,
                    info: true,
                    "scrollY": "300px",
                    "scrollCollapse": false,
                    "bLengthChange": false,
                    "bPaginate": false,
                    "aoColumns": [
                         {sWidth: "8%"}, 
                        {sWidth: "8%"}, 
                        {sWidth: "16%"}, 
                        {sWidth: "14%"},
                        {sWidth: "8%"},
                        {sWidth: "8%"},
                        {sWidth: "8%"},
                        {sWidth: "8%"},
                        {sWidth: "8%"},
                       {sWidth: "8%"}, 
                       {sWidth: "7%"}, 
                       {sWidth: "7%"}  
                    ]

                });



            });

        });



    });
    $(function () {

        $('#tablaDisponibilidades').ready(function () {

            var table = $('#tablaDisponibilidades').dataTable({
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
                processing: true,
                searching: true,
                info: true,
                "scrollY": "300px",
                "scrollCollapse": false,
                "bLengthChange": false,
                "bPaginate": false,
                "aoColumns": [
                    {sWidth: "25%"},
                    {sWidth: "25%"},
                    {sWidth: "25%"},
                    {sWidth: "25%"},
                    {sWidth: "25%"}

                ]

            });



        });

    });


    $(function () {

        $('#tablaTercerosCotizantes').ready(function () {

            var table = $('#tablaTercerosCotizantes').dataTable({
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
                processing: true,
                searching: true,
                info: true,
                "scrollY": "80px",
                "scrollCollapse": false,
                "bLengthChange": false,
                "bPaginate": false,
                "aoColumns": [
                    {sWidth: "10%"},
                    {sWidth: "10%"},
                    {sWidth: "10%"},
                    {sWidth: "10%"},
                    {sWidth: "10%"}

                ]

            });



        });

    });




</script>
