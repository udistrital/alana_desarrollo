<?php
/**
 *
 * Los datos del bloque se encuentran en el arreglo $esteBloque.
 */
// URL base
$url = $this->miConfigurador->getVariableConfiguracion("host");
$url .= $this->miConfigurador->getVariableConfiguracion("site");
$url .= "/index.php?";


//COnsulta de Contractos ----------------------------
// Variables
$cadenaACodificar = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificar .= "&procesarAjax=true";
$cadenaACodificar .= "&action=index.php";
$cadenaACodificar .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificar .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificar .= "&funcion=consultaContrato";
$cadenaACodificar .= "&usuario=" . $_REQUEST['usuario'];
$cadenaACodificar .="&tiempo=" . $_REQUEST['tiempo'];


// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar, $enlace);

// URL definitiva
$urlVigenciaContrato = $url . $cadena;

// Variables
$cadenaACodificar = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificar .= "&procesarAjax=true";
$cadenaACodificar .= "&action=index.php";
$cadenaACodificar .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificar .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificar .= "&funcion=consultaContratista";
$cadenaACodificar .= "&usuario=" . $_REQUEST['usuario'];
$cadenaACodificar .="&tiempo=" . $_REQUEST['tiempo'];


// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar, $enlace);

// URL definitiva
$urlContratista = $url . $cadena;


//-----------------------------------------------------
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


$cadenaACodificarSolCdp = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificarSolCdp .= "&procesarAjax=true";
$cadenaACodificarSolCdp .= "&action=index.php";
$cadenaACodificarSolCdp .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificarSolCdp .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificarSolCdp .= $cadenaACodificarSolCdp . "&funcion=ObtenerSolicitudesCdp";
$cadenaACodificarSolCdp .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadenaACodificarSolCdp = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificarSolCdp, $enlace);

// URL definitiva
$urlFinalSolCdp = $url . $cadenaACodificarSolCdp;




$cadenaACodificarProveedorFiltro = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificarProveedorFiltro .= "&procesarAjax=true";
$cadenaACodificarProveedorFiltro .= "&action=index.php";
$cadenaACodificarProveedorFiltro .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificarProveedorFiltro .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificarProveedorFiltro .= $cadenaACodificarProveedorFiltro . "&funcion=consultarProveedorFiltro";
$cadenaACodificarProveedorFiltro .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadenaACodificarProveedorFiltro = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificarProveedorFiltro, $enlace);

// URL definitiva
$urlProveedorFiltro = $url . $cadenaACodificarProveedorFiltro;

$cadenaACodificarTerceroCesion = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificarTerceroCesion .= "&procesarAjax=true";
$cadenaACodificarTerceroCesion .= "&action=index.php";
$cadenaACodificarTerceroCesion .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificarTerceroCesion .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificarTerceroCesion .= $cadenaACodificarTerceroCesion . "&funcion=consultarTerceroCesion";
$cadenaACodificarTerceroCesion .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadenaACodificarTerceroCesion = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificarTerceroCesion, $enlace);

// URL definitiva
$urlTerceroCesion = $url . $cadenaACodificarTerceroCesion;


// Variables
$cadenaACodificarConsultaDependencia = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificarConsultaDependencia .= "&procesarAjax=true";
$cadenaACodificarConsultaDependencia .= "&action=index.php";
$cadenaACodificarConsultaDependencia .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificarConsultaDependencia .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificarConsultaDependencia .= $cadenaACodificarConsultaDependencia . "&funcion=consultarDependencia";
$cadenaACodificarConsultaDependencia .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena16 = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificarConsultaDependencia, $enlace);

// URL definitiva
$urlFinalConsultaDependencia = $url . $cadena16;

$cadenaACodificarCdps = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificarCdps .= "&procesarAjax=true";
$cadenaACodificarCdps .= "&action=index.php";
$cadenaACodificarCdps .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificarCdps .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificarCdps .= $cadenaACodificarCdps . "&funcion=ObtenerCdps";
$cadenaACodificarCdps .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadenaACodificarCdps = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificarCdps, $enlace);

// URL definitiva
$urlFinalCdps = $url . $cadenaACodificarCdps;

// Variables
$cadenaACodificarInfoDisponibilidades = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificarInfoDisponibilidades .= "&procesarAjax=true";
$cadenaACodificarInfoDisponibilidades .= "&action=index.php";
$cadenaACodificarInfoDisponibilidades .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificarInfoDisponibilidades .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificarInfoDisponibilidades .= "&funcion=Infodisponibilidades";
$cadenaACodificarInfoDisponibilidades .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadenaACodificarInfoDisponibilidades = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificarInfoDisponibilidades, $enlace);

// URL definitiva
$urlFinalInfoDisponibilidades = $url . $cadenaACodificarInfoDisponibilidades;


// Variables
$cadenaACodificarProveedor = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificarProveedor .= "&procesarAjax=true";
$cadenaACodificarProveedor .= "&action=index.php";
$cadenaACodificarProveedor .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificarProveedor .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificarProveedor .= "&funcion=consultaProveedor";
$cadenaACodificarProveedor .= "&tiempo=" . $_REQUEST ['tiempo'];



// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificarProveedor, $enlace);

// URL definitiva
$urlFinalProveedor = $url . $cadena;






$cadenaACodificarInformacionConvenio = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificarInformacionConvenio .= "&procesarAjax=true";
$cadenaACodificarInformacionConvenio .= "&action=index.php";
$cadenaACodificarInformacionConvenio .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificarInformacionConvenio .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificarInformacionConvenio .= $cadenaACodificarInformacionConvenio . "&funcion=consultarInfoConvenio";
$cadenaACodificarInformacionConvenio .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadenaACodificarInformacionConvenio = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificarInformacionConvenio, $enlace);

// URL definitiva
$urlInformacionConvenio = $url . $cadenaACodificarInformacionConvenio;

$cadenaACodificarInformacionContratistaUnico = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificarInformacionContratistaUnico .= "&procesarAjax=true";
$cadenaACodificarInformacionContratistaUnico .= "&action=index.php";
$cadenaACodificarInformacionContratistaUnico .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificarInformacionContratistaUnico .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificarInformacionContratistaUnico .= $cadenaACodificarInformacionContratistaUnico . "&funcion=consultarInfoContratistaUnico";
$cadenaACodificarInformacionContratistaUnico .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadenaACodificarInformacionContratistaUnico = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificarInformacionContratistaUnico, $enlace);

// URL definitiva
$urlInformacionContratistaUnico = $url . $cadenaACodificarInformacionContratistaUnico;

$cadenaACodificarInformacionSociedadTemporal = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificarInformacionSociedadTemporal .= "&procesarAjax=true";
$cadenaACodificarInformacionSociedadTemporal .= "&action=index.php";
$cadenaACodificarInformacionSociedadTemporal .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificarInformacionSociedadTemporal .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificarInformacionSociedadTemporal .= $cadenaACodificarInformacionSociedadTemporal . "&funcion=consultarInfoSociedadTemporal";
$cadenaACodificarInformacionSociedadTemporal .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadenaACodificarInformacionSociedadTemporal = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificarInformacionSociedadTemporal, $enlace);

// URL definitiva
$urlInformacionSociedadTemporal = $url . $cadenaACodificarInformacionSociedadTemporal;

$cadenaValidarSupervisor = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaValidarSupervisor .= "&procesarAjax=true";
$cadenaValidarSupervisor .= "&action=index.php";
$cadenaValidarSupervisor .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaValidarSupervisor .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaValidarSupervisor .= $cadenaValidarSupervisor . "&funcion=validarSupervisor";
$cadenaValidarSupervisor .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadenaValidarSupervisor = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaValidarSupervisor, $enlace);

// URL definitiva
$urlValidarSupervisor = $url . $cadenaValidarSupervisor;


// Variables
$cadenaACodificarDependencia = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificarDependencia .= "&procesarAjax=true";
$cadenaACodificarDependencia .= "&action=index.php";
$cadenaACodificarDependencia .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificarDependencia .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificarDependencia .= $cadenaACodificarDependencia . "&funcion=consultarDependencia";
$cadenaACodificarDependencia .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadenaDependencia = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificarDependencia, $enlace);

// URL definitiva
$urlFinalDependencia = $url . $cadenaDependencia;

$cadenaACodificar17 = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificar17 .= "&procesarAjax=true";
$cadenaACodificar17 .= "&action=index.php";
$cadenaACodificar17 .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificar17 .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificar17 .= $cadenaACodificar17 . "&funcion=consultarCargoSuper";
$cadenaACodificar17 .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena17 = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar17, $enlace);

// URL definitiva
$urlFinal17 = $url . $cadena17;


$urlInformacionRP = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$urlInformacionRP .= "&procesarAjax=true";
$urlInformacionRP .= "&action=index.php";
$urlInformacionRP .= "&bloqueNombre=" . $esteBloque ["nombre"];
$urlInformacionRP .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$urlInformacionRP .= $urlInformacionRP . "&funcion=consultarInfoRP";
$urlInformacionRP .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$urlInformacionRP = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($urlInformacionRP, $enlace);

// URL definitiva
$urlInformacionRPFinal = $url . $urlInformacionRP;

$cadenaRpxCdp = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaRpxCdp .= "&procesarAjax=true";
$cadenaRpxCdp .= "&action=index.php";
$cadenaRpxCdp .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaRpxCdp .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaRpxCdp .= $cadenaRpxCdp . "&funcion=consultarInfoRPxCdp";
$cadenaRpxCdp .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadenaRpxCdp = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaRpxCdp, $enlace);

// URL definitiva
$urlFinalRpsxCdp = $url . $cadenaRpxCdp;


$cadenainformacionRp = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenainformacionRp .= "&procesarAjax=true";
$cadenainformacionRp .= "&action=index.php";
$cadenainformacionRp .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenainformacionRp .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenainformacionRp .= $cadenainformacionRp . "&funcion=consultarinformacionRpadicion";
$cadenainformacionRp .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadenainformacionRp = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenainformacionRp, $enlace);

// URL definitiva
$urlFinalinformacionRp = $url . $cadenainformacionRp;
?>
<script type='text/javascript'>


    $("#ventanaA").steps({
        headerTag: "h3",
        bodyTag: "section",
        enableAllSteps: true,
        enablePagination: true,
        transitionEffect: "slideLeft",
        onStepChanging: function (event, currentIndex, newIndex) {
            $resultado = $("#registrarContrato").validationEngine("validate");
            if ($resultado) {

                return true;
            }
            return false;

        },
        onFinished: function (event, currentIndex) {

            $("#registrarContrato").submit();

        },
        labels: {
            cancel: "Cancelar",
            current: "Paso Siguiente :",
            pagination: "Paginación",
            finish: "Guardar Información",
            next: "Siquiente",
            previous: "Atras",
            loading: "Cargando ..."
        }

    });



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
    ;

    $(function () {

        $("#<?php echo $this->campoSeguro('vigencia_contrato') ?>").keyup(function () {
            $('#<?php echo $this->campoSeguro('vigencia_contrato') ?>').val($('#<?php echo $this->campoSeguro('vigencia_contrato') ?>').val());

        });

        $("#<?php echo $this->campoSeguro('vigencia_contrato') ?>").autocomplete({
            minChars: 2,
            serviceUrl: '<?php echo $urlVigenciaContrato; ?>',
            onSelect: function (suggestion) {

                $("#<?php echo $this->campoSeguro('id_contrato') ?>").val(suggestion.data);
            }


        });



        $("#<?php echo $this->campoSeguro('contratista') ?>").autocomplete({
            minChars: 3,
            serviceUrl: '<?php echo $urlContratista; ?>',
            onSelect: function (suggestion) {

                $("#<?php echo $this->campoSeguro('id_contratista') ?>").val(suggestion.data);
            }

        });



    });





    //-------------------Inicio JavaScript y Ajax Sede Dependencia ------------------------------------------------------------------

    $("#<?php echo $this->campoSeguro('sedeConsulta') ?>").change(function () {
        if ($("#<?php echo $this->campoSeguro('sedeConsulta') ?>").val() != '') {
            consultarDependenciaConsultada();
        } else {
            $("#<?php echo $this->campoSeguro('dependenciaConsulta') ?>").attr('disabled', '');
        }

    });

    function consultarDependenciaConsultada(elem, request, response) {
        $.ajax({
            url: "<?php echo $urlFinalConsultaDependencia ?>",
            dataType: "json",
            data: {valor: $("#<?php echo $this->campoSeguro('sedeConsulta') ?>").val()},
            success: function (data) {

                if (data[0] != " ") {

                    $("#<?php echo $this->campoSeguro('dependenciaConsulta') ?>").html('');
                    $("<option value=''>Seleccione  ....</option>").appendTo("#<?php echo $this->campoSeguro('dependenciaConsulta') ?>");
                    $.each(data, function (indice, valor) {
                        $("<option value='" + data[ indice ].ESF_CODIGO_DEP + "'>" + data[ indice ].ESF_DEP_ENCARGADA + "</option>").appendTo("#<?php echo $this->campoSeguro('dependenciaConsulta') ?>");

                    });

                    $("#<?php echo $this->campoSeguro('dependenciaConsulta') ?>").removeAttr('disabled');

                    $('#<?php echo $this->campoSeguro('dependenciaConsulta') ?>').width(300);
                    $("#<?php echo $this->campoSeguro('dependenciaConsulta') ?>").select2();



                }


            }

        });
    }
    ;

//-------------------Fin JavaScript y Ajax Sede Dependencia ------------------------------------------------------------------



//--------------Inicio JavaScript y Ajax numero CDP y Registro Prsupuestal ---------------------------------------------------------------------------------------------    

    $("#<?php echo $this->campoSeguro('registro_presupuestal_adicion') ?>").change(function () {

        if ($("#<?php echo $this->campoSeguro('registro_presupuestal_adicion') ?>").val() != '') {

            consultarinformacionRp();
        } else {
            $("#<?php echo $this->campoSeguro('info_rubro') ?>").val('');
        }

    });

    function consultarinformacionRp(elem, request, response) {

        $.ajax({
            url: "<?php echo $urlFinalinformacionRp ?>",
            dataType: "json",
            data: {vigencia: $("#<?php echo $this->campoSeguro('vigencia_novedad') ?>").val(),
                unidad: $("#<?php echo $this->campoSeguro('unidad_ejecutora_hidden') ?>").val(),
                registroPresupuestal: $("#<?php echo $this->campoSeguro('registro_presupuestal_adicion') ?>").val()
            },
            success: function (data) {
                console.log(data);
                if (data[0] != " ") {

                    $("#<?php echo $this->campoSeguro('info_rubro') ?>").val("Numero Registro: " + data[0][0] + "\n" +
                            "Id Rubro Interno: " + data[0][1] + "\n" +
                            "Descripcion: " + data[0][2] + "\n" +
                            "Valor: " + data[0][3]);
                    $("#<?php echo $this->campoSeguro('valor_adicion_presupuesto') ?>").val(data[0][3]);

                }


            }

        });
    }
    ;

    //--------------Fin JavaScript y Ajax CDP y Registro Prsupuestal --------------------------------------------------------------------------------------------------   



    //--------------Inicio JavaScript y Ajax numero CDP y Registro Prsupuestal ---------------------------------------------------------------------------------------------    

    $("#<?php echo $this->campoSeguro('numero_cdp') ?>").change(function () {

        if ($("#<?php echo $this->campoSeguro('numero_cdp') ?>").val() != '') {

            consultarRPsXCdp();
        } else {
            $("#<?php echo $this->campoSeguro('registro_presupuestal_adicion') ?>").attr('disabled', '');
        }

    });

    function consultarRPsXCdp(elem, request, response) {

        $.ajax({
            url: "<?php echo $urlFinalRpsxCdp ?>",
            dataType: "json",
            data: {vigencia: $("#<?php echo $this->campoSeguro('vigencia_novedad') ?>").val(),
                unidad: $("#<?php echo $this->campoSeguro('unidad_ejecutora_hidden') ?>").val(),
                numerocdp: $("#<?php echo $this->campoSeguro('numero_cdp') ?>").val()
            },
            success: function (data) {
                if (data[0] != " ") {

                    console.log(data);
                    $("#<?php echo $this->campoSeguro('registro_presupuestal_adicion') ?>").html('');
                    $("<option value=''>Seleccione  ....</option>").appendTo("#<?php echo $this->campoSeguro('registro_presupuestal_adicion') ?>");
                    $.each(data, function (indice) {

                        $("<option value='" + data[indice].VALOR + "'>" + data[indice].INFORMACION + "</option>").appendTo("#<?php echo $this->campoSeguro('registro_presupuestal_adicion') ?>");

                    });

                    $("#<?php echo $this->campoSeguro('registro_presupuestal_adicion') ?>").removeAttr('disabled');

                    $('#<?php echo $this->campoSeguro('registro_presupuestal_adicion') ?>').width(300);
                    $("#<?php echo $this->campoSeguro('registro_presupuestal_adicion') ?>").select2();



                }


            }

        });
    }
    ;

    //--------------Fin JavaScript y Ajax CDP y Registro Prsupuestal --------------------------------------------------------------------------------------------------   
    //--------------Inicio JavaScript y Ajax Vigencia y Numero solicitud ---------------------------------------------------------------------------------------------    

    $("#<?php echo $this->campoSeguro('vigencia_novedad') ?>").change(function () {

        if ($("#<?php echo $this->campoSeguro('vigencia_novedad') ?>").val() != '') {

            consultarSoliditudyCdp();
        } else {
            $("#<?php echo $this->campoSeguro('vigencia_novedad') ?>").attr('disabled', '');
        }

    });

    function consultarSoliditudyCdp(elem, request, response) {

        $.ajax({
            url: "<?php echo $urlFinalSolCdp ?>",
            dataType: "json",
            data: {vigencia: $("#<?php echo $this->campoSeguro('vigencia_novedad') ?>").val(),
                unidad: $("#<?php echo $this->campoSeguro('unidad_ejecutora_hidden') ?>").val()
            },
            success: function (data) {


                if (data[0] != " ") {

                    $("#<?php echo $this->campoSeguro('numero_solicitud') ?>").html('');
                    $("<option value=''>Seleccione  ....</option>").appendTo("#<?php echo $this->campoSeguro('numero_solicitud') ?>");
                    $.each(data, function (indice, valor) {

                        $("<option value='" + data[ indice ].VALOR + "'>" + data[ indice ].INFORMACION + "</option>").appendTo("#<?php echo $this->campoSeguro('numero_solicitud') ?>");

                    });

                    $("#<?php echo $this->campoSeguro('numero_solicitud') ?>").removeAttr('disabled');

                    $('#<?php echo $this->campoSeguro('numero_solicitud') ?>').width(200);
                    $("#<?php echo $this->campoSeguro('numero_solicitud') ?>").select2();



                }


            }

        });
    }
    ;

    //--------------Fin JavaScript y Ajax SVigencia y Numero solicitud --------------------------------------------------------------------------------------------------   
//--------------Inicio JavaScript y Ajax CDP x Solicitud ---------------------------------------------------------------------------------------------    

    $("#<?php echo $this->campoSeguro('numero_solicitud') ?>").change(function () {

        if ($("#<?php echo $this->campoSeguro('numero_solicitud') ?>").val() != '') {
            consultarCDPs();
        } else {
            $("#<?php echo $this->campoSeguro('numero_solicitud') ?>").attr('disabled', '');
        }

    });

    function consultarCDPs(elem, request, response) {

        $.ajax({
            url: "<?php echo $urlFinalCdps ?>",
            dataType: "json",
            data: {numsol: $("#<?php echo $this->campoSeguro('numero_solicitud') ?>").val(),
                vigencia: $("#<?php echo $this->campoSeguro('vigencia_novedad') ?>").val(),
                unidad: $("#<?php echo $this->campoSeguro('unidad_ejecutora_hidden') ?>").val(),
                cdpsNovedades: $("#<?php echo $this->campoSeguro('cdpRegistradasNovedades') ?>").val(),
                cdps: $("#<?php echo $this->campoSeguro('cdpRegistradas') ?>").val()},
            success: function (data) {
                if (typeof data[0] != 'undefined') {
                    $("#<?php echo $this->campoSeguro('numero_cdp') ?>").html('');
                    $("<option value=''>Seleccione  ....</option>").appendTo("#<?php echo $this->campoSeguro('numero_cdp') ?>");
                    $.each(data, function (indice, valor) {

                        $("<option value='" + data[ indice ].VALOR + "'>" + data[ indice ].INFORMACION + "</option>").appendTo("#<?php echo $this->campoSeguro('numero_cdp') ?>");

                    });

                    $("#<?php echo $this->campoSeguro('numero_cdp') ?>").removeAttr('disabled');

                    $('#<?php echo $this->campoSeguro('numero_cdp') ?>').width(200);
                    $("#<?php echo $this->campoSeguro('numero_cdp') ?>").select2();

                } else {

                    alert("No existe Numero de CDP Asociadoa Esta Solicitud, \n o el CDP Referenciado ya fue Registrado; \n (Como contrato o como novedad).");

                }


            }

        });
    }
    ;


    function number_format(number, decimals, dec_point, thousands_sep) {
        // Strip all characters but numerical ones.
        number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
        var n = !isFinite(+number) ? 0 : +number,
                prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                s = '',
                toFixedFix = function (n, prec) {
                    var k = Math.pow(10, prec);
                    return '' + Math.round(n * k) / k;
                };
        // Fix for IE parseFloat(0.55).toFixed(0) = 0;
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || '').length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1).join('0');
        }
        return s.join(dec);
    }



    function consultarContratistas(elem, request, response) {

        if ($("#<?php echo $this->campoSeguro('selec_proveedor') ?>").val() != "") {


            $.ajax({
                url: "<?php echo $urlFinalProveedor ?>",
                dataType: "json",
                data: {proveedor: $("#<?php echo $this->campoSeguro('selec_proveedor') ?>").val()},
                success: function (data) {

                    if (data.datos != 'null') {
                        if (data.status == 200) {

                            $("#<?php echo $this->campoSeguro('tipo_persona') ?>").val(data.datos.tipo_persona);

                            if (data.datos.tipo_persona != 'NATURAL') {
                                $("#<?php echo $this->campoSeguro('nuevoContratista') ?>").val(data.datos.num_nit_empresa + '-' + data.datos.nom_empresa);

                            } else {

                                $("#<?php echo $this->campoSeguro('nuevoContratista') ?>").val(data.datos.num_documento_persona_natural + '-' + data.datos.primer_nombre_persona_natural +
                                        ' ' + data.datos.segundo_nombre_persona_natural + ' ' + data.datos.primer_apellido_persona_natural + ' ' +
                                        data.datos.segundo_nombre_persona_natural);
                            }

                        } else {
                            alert("Sin Cocincidencias en la Busqueda.");
                        }
                    } else {
                        alert("Servidor de Proveedores No Disponible.");

                    }

                }

            });
        } else {
            alert("Ingrese la Identificacion o el nombre del proveedor");
        }
    }
    ;


    function VerInfoConvenio(informacionConvenio) {
        $.ajax({
            url: "<?php echo $urlInformacionConvenio ?>",
            dataType: "json",
            data: {codigo: informacionConvenio},
            success: function (data) {
                if (data[0] != " ") {
                    var objetoSPAN = document.getElementById('spandid');
                    objetoSPAN.innerHTML = "Información del Convenio :<br><br><br>" + "Numero de Convenio: " + data[0] + " <br><br> "
                            + "Vigencia: " + data[3] + " <br><br>"
                            + "Nombre: " + data[5] + " <br><br>"
                            + "Descripcion: " + data[4] + " <br><br>"
                            + "Entidad: " + data[6] + " <br><br>"
                            + "Codigo Tesoral: " + data[7] + " <br><br>"
                            + "Fecha Inicio: " + data[8] + " <br><br>"
                            + "Fecha de Finalizacion: " + data[9] + " <br><br>"
                            + "Situacion: " + data[10] + " <br><br>"
                            + "Unidad: " + data[11] + " <br><br>"
                            + "Estado: " + data[12] + " <br><br>"
                            + "Modalidad: " + data[13] + " <br><br>";
                    $("#ventanaEmergenteContratista").dialog('option', 'title', 'Convenio');
                    $("#ventanaEmergenteContratista").dialog("open");


                }
            }

        });

    }

    function VerInfoContratista(identificacion) {
        $.ajax({
            url: "<?php echo $urlInformacionContratistaUnico ?>",
            dataType: "json",
            data: {id: identificacion},
            success: function (data) {
                if (data[0] != " ") {

                    var objetoSPAN = document.getElementById('spandid');
                    objetoSPAN.innerHTML = "Información del Contratista :<br><br><br>" + "Nombre del Contratista: " + data[13] + " <br><br> "
                            + "Documento: " + data[1] + " <br><br>"
                            + "Tipo Persona: " + data[0] + " <br><br>"
                            + "Ciudad de Contacto: " + data[2] + " <br><br>"
                            + "Direccion: " + data[3] + " <br><br>"
                            + "Correo: " + data[4] + " <br><br>"
                            + "Sitio WEB: " + data[5] + " <br><br>"
                            + "Estado: " + data[8] + " <br><br>"
                            + "Tipo Cuenta: " + data[9] + " <br><br>"
                            + "Numero de Cuenta: " + data[10] + " <br><br>"
                            + "Entidad Bancaria: " + data[11] + " <br><br>"
                            + "Fecha Registro: " + data[12] + " <br><br>"
                            + "Punatje: " + data[6] + " <br><br>";
                    $("#ventanaEmergenteContratista").dialog('option', 'title', 'Unico Contratista');
                    $("#ventanaEmergenteContratista").dialog("open");


                }
            }

        });

    }


   function VerInfoSociedadTemporal(identificacion) {
        $.ajax({
            url: "<?php echo $urlInformacionSociedadTemporal ?>",
            dataType: "json",
            data: {id: identificacion},
            success: function (data) {
                if (data[0] != " ") {
                    
                    var participantes = "Participantes: <br><br>";
                    for (i = 0; i < data[1].length; i++) {
                        participantes = participantes + "Nombre: " + data[1][i][0] + " | Porcentaje de Participacion:  " + data[1][i][1] + "%<br>";
                    }

                    var objetoSPAN = document.getElementById('spandid');
                    objetoSPAN.innerHTML = "Información de la Sociedad Temporal :<br><br><br>" + "Nombre de la Sociedad: " + data[0][13] + " <br><br> "
                            + "Documento: " + data[0][1] + " <br><br>"
                            + "Tipo Sociedad: " + data[0][0] + " <br><br>"
                            + "Ciudad de Contacto: " + data[0][2] + " <br><br>"
                            + "Direccion: " + data[0][3] + " <br><br>"
                            + "Correo: " + data[0][4] + " <br><br>"
                            + "Sitio WEB: " + data[0][5] + " <br><br>"
                            + "Estado: " + data[0][8] + " <br><br>"
                            + "Tipo Cuenta: " + data[0][9] + " <br><br>"
                            + "Numero de Cuenta: " + data[0][10] + " <br><br>"
                            + "Entidad Bancaria: " + data[0][11] + " <br><br>"
                            + "Fecha Registro: " + data[0][12] + " <br><br>"
                            + "Puntaje: " + data[0][6] + " <br><br>"
                            + participantes;



                    $("#ventanaEmergenteContratista").dialog('option', 'title', 'Sociedad Temporal');
                    $("#ventanaEmergenteContratista").dialog("open");


                }
            }

        });

    }

    //------------------------------Validar Existencia Supervisor ---------------------------------------------------


    //--------------Inicio JavaScript y Ajax Sede y Dependencia Suepervisor ---------------------------------------------------------------------------------------------    
    $("#<?php echo $this->campoSeguro('sede_super') ?>").change(function () {

        if ($("#<?php echo $this->campoSeguro('sede_super') ?>").val() != '') {
            consultarDependenciaSuper();
        } else {
            $("#<?php echo $this->campoSeguro('dependencia_supervisor') ?>").attr('disabled', '');
        }

    });


    function consultarDependenciaSuper(elem, request, response) {
        $.ajax({
            url: "<?php echo $urlFinalDependencia ?>",
            dataType: "json",
            data: {valor: $("#<?php echo $this->campoSeguro('sede_super') ?>").val()},
            success: function (data) {
                if (data[0] != " ") {

                    $("#<?php echo $this->campoSeguro('dependencia_supervisor') ?>").html('');
                    $("<option value=''>Seleccione  ....</option>").appendTo("#<?php echo $this->campoSeguro('dependencia_supervisor') ?>");
                    $.each(data, function (indice, valor) {

                        $("<option value='" + data[ indice ].ESF_CODIGO_DEP + "'>" + data[ indice ].ESF_DEP_ENCARGADA + "</option>").appendTo("#<?php echo $this->campoSeguro('dependencia_supervisor') ?>");

                    });

                    $("#<?php echo $this->campoSeguro('dependencia_supervisor') ?>").removeAttr('disabled');

                    $('#<?php echo $this->campoSeguro('dependencia_supervisor') ?>').width(350);
                    $("#<?php echo $this->campoSeguro('dependencia_supervisor') ?>").select2();

                }


            }

        });
    }
    ;
//--------------Fin JavaScript y Ajax Sede y Dependencia Suepervisor --------------------------------------------------------------------------------------------------   

//--------------Inicio JavaScript y Ajax Cargo Suepervisor ---------------------------------------------------------------------------------------------    


    $("#<?php echo $this->campoSeguro('nuevoSupervisor') ?>").change(function () {

        if ($("#<?php echo $this->campoSeguro('nuevoSupervisor') ?>").val() != '') {
            cargoSuper();
        }

    });

    function cargoSuper(elem, request, response) {
        $.ajax({
            url: "<?php echo $urlFinal17 ?>",
            dataType: "json",
            data: {valor: $("#<?php echo $this->campoSeguro('nuevoSupervisor') ?>").val()},
            success: function (data) {


                $("#<?php echo $this->campoSeguro('cargo_supervisor') ?>").val(data[0]);
                $("#<?php echo $this->campoSeguro('cargo_inicial') ?>").val(data[0]);

            }

        });
    }
    ;
    function restCargoSuper(elem, request, response) {
        $("#<?php echo $this->campoSeguro('cargo_supervisor') ?>").val($("#<?php echo $this->campoSeguro('cargo_inicial') ?>").val());
    }
    ;


//--------------Fin JavaScript y Ajax Cargo Suepervisor ---------------------------------------------------------------------------------------------    

    $("#<?php echo $this->campoSeguro('cargosExistentes') ?>").change(function () {

        if ($("#<?php echo $this->campoSeguro('cargosExistentes') ?>").val() != '') {
            $("#<?php echo $this->campoSeguro('cargo_supervisor') ?>").val($("#<?php echo $this->campoSeguro('cargosExistentes') ?>").val());
            $("#<?php echo $this->campoSeguro('cargosExistentes') ?>").val("");

        }


    });

    function registrarNuevoCargo() {
        var cargo = prompt("Por favor digite el nuevo cargo:", "");

        if (cargo != null) {
            var Campo = document.getElementById("<?php echo $this->campoSeguro('cargo_supervisor') ?>");
            Campo.value = cargo;
        }
    }

    function restCargoSuper(elem, request, response) {
        $("#<?php echo $this->campoSeguro('cargo_supervisor') ?>").val($("#<?php echo $this->campoSeguro('cargo_inicial') ?>").val());
    }
    ;


    //---------------------------Consulta Tercero --------------------------------------------

    $("#<?php echo $this->campoSeguro('selec_proveedor') ?>").keyup(function () {


        $('#<?php echo $this->campoSeguro('selec_proveedor') ?>').val($('#<?php echo $this->campoSeguro('selec_proveedor') ?>').val());


    });




    $("#<?php echo $this->campoSeguro('selec_proveedor') ?>").autocomplete({
        minChars: 3,
        serviceUrl: '<?php echo $urlTerceroCesion; ?>',
        onSelect: function (suggestions) {

            $("#<?php echo $this->campoSeguro('id_proveedor') ?>").val(suggestions.data);
        }

    });

    //--------------Inicio JavaScript y Ajax RP Seleccionado ---------------------------------------------------------------------------------------------    
    $("#<?php echo $this->campoSeguro('registro_presupuestal_reduccion') ?>").change(function () {

        if ($("#<?php echo $this->campoSeguro('registro_presupuestal_reduccion') ?>").val() != '') {
            consultaInfoRp();
        }

    });


    function consultaInfoRp(elem, request, response) {
        $.ajax({
            url: "<?php echo $urlInformacionRPFinal ?>",
            dataType: "json",
            data: {valor: $("#<?php echo $this->campoSeguro('registro_presupuestal_reduccion') ?>").val(),
                unidad: $("#<?php echo $this->campoSeguro('unidad_ejecutora_hidden') ?>").val(),
                vigencia: $("#<?php echo $this->campoSeguro('vigencia_hidden') ?>").val()},
            success: function (data) {
                if (data[0] != " ") {

                    $("#<?php echo $this->campoSeguro('informacion_rp') ?>").val(
                            "Numero de Registro Presupuestal: " + data[0][0] + "\n" +
                            "Numero de Rubro Asociado: " + data[0][1] + "\n" +
                            "Descripcion del Rubro Asociado: " + data[0][2] + "\n" +
                            "Valor del Registro Presupuestal: " + data[0][3] + "."

                            );
                    $("#<?php echo $this->campoSeguro('valor_rp_hidden') ?>").val(data[0][3]);


                }


            }

        });
    }
    ;


    $("#<?php echo $this->campoSeguro('nuevoSupervisor') ?>").change(function () {

        if ($("#<?php echo $this->campoSeguro('nuevoSupervisor') ?>").val() != '') {
            var supervisor = $("#<?php echo $this->campoSeguro('nuevoSupervisor') ?>").val();
            var identificacion = supervisor.split("-");
            calcularDigitoCedulaSupervisor(identificacion[0]);
        }
    });


    function calcularDigitoCedulaSupervisor(cadenaCedula) {

        var num_primos, control_mod_1, control_mod_2, tamano_cedula, i, digito_verificacion;

        if (isNaN(cadenaCedula)) {
            alert('El valor digitado no es un numero valido');
        } else {
            num_primos = new Array(16);
            control_mod_1 = 0;
            control_mod_2 = 0;
            tamano_cedula = cadenaCedula.length;

            num_primos[1] = 3;
            num_primos[2] = 7;
            num_primos[3] = 13;
            num_primos[4] = 17;
            num_primos[5] = 19;
            num_primos[6] = 23;
            num_primos[7] = 29;
            num_primos[8] = 37;
            num_primos[9] = 41;
            num_primos[10] = 43;
            num_primos[11] = 47;
            num_primos[12] = 53;
            num_primos[13] = 59;
            num_primos[14] = 67;
            num_primos[15] = 71;

            for (i = 0; i < tamano_cedula; i++)
            {
                control_mod_2 = (cadenaCedula.substr(i, 1));
                control_mod_1 += (control_mod_2 * num_primos[tamano_cedula - i]);
            }
            control_mod_2 = control_mod_1 % 11;

            if (control_mod_2 > 1)
            {
                digito_verificacion = 11 - control_mod_2;
            } else {
                digito_verificacion = control_mod_2;
            }
            $("#<?php echo $this->campoSeguro('digito_supervisor') ?>").val(digito_verificacion);
        }
    }
    ;
//--------------Fin JavaScript y Convenios x Vigenca --------------------------------------------------------------------------------------------------  




</script>
