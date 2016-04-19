<?php
/**
 *
 * Los datos del bloque se encuentran en el arreglo $esteBloque.
 */
// URL base
$url = $this->miConfigurador->getVariableConfiguracion("host");
$url .= $this->miConfigurador->getVariableConfiguracion("site");
$url .= "/index.php?";

// Variables
$cadenaACodificar = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificar .= "&procesarAjax=true";
$cadenaACodificar .= "&action=index.php";
$cadenaACodificar .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificar .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificar .= "&funcion=NumeroSolicitud";
$cadenaACodificar .= "&usuario=" . $_REQUEST['usuario'];
$cadenaACodificar .="&tiempo=" . $_REQUEST['tiempo'];


// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar, $enlace);

// URL definitiva
$urlVigencia = $url . $cadena;




$cadenaACodificar2 = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificar2 .= "&procesarAjax=true";
$cadenaACodificar2 .= "&action=index.php";
$cadenaACodificar2 .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificar2 .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificar2 .= "&funcion=AlmacenarDatos";
$cadenaACodificar2 .= "&usuario=" . $_REQUEST['usuario'];
$cadenaACodificar2 .="&tiempo=" . $_REQUEST['tiempo'];
$cadena2 = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar2, $enlace);
$urlDatosPaso = $url . $cadena2;
?>
<script type='text/javascript'>



    function NumeroSolicitud(elem, request, response) {
        $.ajax({
            url: "<?php echo $urlVigencia ?>",
            dataType: "json",
            data: {valor: $("#<?php echo $this->campoSeguro('vigencia') ?>").val()},
            success: function (data) {




                if (data[0] != " ") {

                    $("#<?php echo $this->campoSeguro('num_solicitud') ?>").html('');
                    $("<option value=''>Seleccione  ....</option>").appendTo("#<?php echo $this->campoSeguro('num_solicitud') ?>");
                    $.each(data, function (indice, valor) {

                        $("<option value='" + data[ indice ].id + "'>" + data[ indice ].descripcion + "</option>").appendTo("#<?php echo $this->campoSeguro('num_solicitud') ?>");
                    });
                    $('#<?php echo $this->campoSeguro('num_solicitud') ?>').width(150);
                    $("#<?php echo $this->campoSeguro('num_solicitud') ?>").select2();
                    $("#<?php echo $this->campoSeguro('num_solicitud') ?>").removeAttr('disabled');
                }


            }

        });
    }
    ;</script>

<script>

    function almacenarInfoTemporal(pasoActual, pasoNuevo) {
        if (pasoActual == 0) {
            var InfoPaso0 = [];
            InfoPaso0[0] = document.getElementById("<?php echo $this->campoSeguro('numero_contrato') ?>").value;
            InfoPaso0[1] = document.getElementById("<?php echo $this->campoSeguro('tipo_identificacion') ?>").value;
            InfoPaso0[2] = document.getElementById("<?php echo $this->campoSeguro('numero_identificacion') ?>").value;
            InfoPaso0[3] = document.getElementById("<?php echo $this->campoSeguro('digito_verificacion') ?>").value;
            InfoPaso0[4] = document.getElementById("<?php echo $this->campoSeguro('tipo_persona') ?>").value;
            InfoPaso0[5] = document.getElementById("<?php echo $this->campoSeguro('primer_nombre') ?>").value;
            InfoPaso0[6] = document.getElementById("<?php echo $this->campoSeguro('segundo_nombre') ?>").value;
            InfoPaso0[7] = document.getElementById("<?php echo $this->campoSeguro('primer_apellido') ?>").value;
            InfoPaso0[8] = document.getElementById("<?php echo $this->campoSeguro('segundo_apellido') ?>").value;
            InfoPaso0[9] = document.getElementById("<?php echo $this->campoSeguro('genero') ?>").value;
            InfoPaso0[10] = document.getElementById("<?php echo $this->campoSeguro('nacionalidad') ?>").value;
            InfoPaso0[11] = document.getElementById("<?php echo $this->campoSeguro('direccion') ?>").value;
            InfoPaso0[12] = document.getElementById("<?php echo $this->campoSeguro('correo') ?>").value;
            InfoPaso0[13] = document.getElementById("<?php echo $this->campoSeguro('perfil') ?>").value;
            InfoPaso0[14] = document.getElementById("<?php echo $this->campoSeguro('profesion') ?>").value;
            InfoPaso0[15] = document.getElementById("<?php echo $this->campoSeguro('especialidad') ?>").value;
            InfoPaso0[16] = document.getElementById("<?php echo $this->campoSeguro('tipo_cuenta') ?>").value;
            InfoPaso0[17] = document.getElementById("<?php echo $this->campoSeguro('numero_cuenta') ?>").value;
            InfoPaso0[18] = document.getElementById("<?php echo $this->campoSeguro('entidad_bancaria') ?>").value;
            InfoPaso0[19] = document.getElementById("<?php echo $this->campoSeguro('tipo_configuracion') ?>").value;
            InfoPaso0[20] = document.getElementById("<?php echo $this->campoSeguro('clase_contratista') ?>").value;
            InfoPaso0[21] = document.getElementById("<?php echo $this->campoSeguro('identificacion_clase_contratista') ?>").value;
            InfoPaso0[22] = document.getElementById("<?php echo $this->campoSeguro('digito_verificacion_clase_contratista') ?>").value;
            InfoPaso0[23] = document.getElementById("<?php echo $this->campoSeguro('porcentaje_clase_contratista') ?>").value;
            InfoPaso0[24] = document.getElementById("<?php echo $this->campoSeguro('telefono') ?>").value;
            var arregloDatos=[];
            arregloDatos = JSON.stringify(InfoPaso0);
            AlmacenarPaso(arregloDatos);
        }
        if (pasoActual == 1) {
            var InfoPaso1 = [];
        }
        if (pasoActual == 2) {
            var InfoPaso2 = [];
        }
        if (pasoActual == 3) {
            var InfoPaso3 = [];
        }
    }

    function AlmacenarPaso(arreglo) {
    $.ajax({
            url: "<?php echo $urlDatosPaso ?>",
            dataType: "json",
            data: {valor: arreglo},
            success: function (data) {

                if (data[0] != " ") {

                    $.each(data, function (indice, valor) {
                        alert("bien");

                    });
                }


            }

        });
    }
    ;


</script>