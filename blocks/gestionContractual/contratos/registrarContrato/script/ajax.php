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
// Variables

$cadenaACodificarProveedorSociedad = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificarProveedorSociedad .= "&procesarAjax=true";
$cadenaACodificarProveedorSociedad .= "&action=index.php";
$cadenaACodificarProveedorSociedad .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificarProveedorSociedad .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificarProveedorSociedad .= "&funcion=consultaProveedorSociedad";
$cadenaACodificarProveedorSociedad .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificarProveedorSociedad, $enlace);

// URL definitiva
$urlFinalProveedorSociedad = $url . $cadena;
// Variables
$cadenaAInformacionProveedor = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaAInformacionProveedor .= "&procesarAjax=true";
$cadenaAInformacionProveedor .= "&action=index.php";
$cadenaAInformacionProveedor .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaAInformacionProveedor .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaAInformacionProveedor .= "&funcion=consultaInformacionProveedor";
$cadenaAInformacionProveedor .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaAInformacionProveedor, $enlace);

// URL definitiva
$urlInformacionProveedor = $url . $cadena;

$cadenaAInformacionProveedorSociedad = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaAInformacionProveedorSociedad .= "&procesarAjax=true";
$cadenaAInformacionProveedorSociedad .= "&action=index.php";
$cadenaAInformacionProveedorSociedad .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaAInformacionProveedorSociedad .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaAInformacionProveedorSociedad .= "&funcion=consultaInformacionProveedorSociedad";
$cadenaAInformacionProveedorSociedad .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaAInformacionProveedorSociedad, $enlace);

// URL definitiva
$urlFinalInformacionSociedad = $url . $cadena;


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


$cadenaACodificar3 = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificar3 .= "&procesarAjax=true";
$cadenaACodificar3 .= "&action=index.php";
$cadenaACodificar3 .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificar3 .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificar3 .= "&funcion=obtenerGeneros";
$cadenaACodificar3 .= "&usuario=" . $_REQUEST['usuario'];
$cadenaACodificar3 .="&tiempo=" . $_REQUEST['tiempo'];
$cadena3 = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar3, $enlace);
$urlPersonaGenero = $url . $cadena3;


$cadenaACodificarSolCdp = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificarSolCdp .= "&procesarAjax=true";
$cadenaACodificarSolCdp .= "&action=index.php";
$cadenaACodificarSolCdp .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificarSolCdp .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificarSolCdp .= $cadenaACodificarSolCdp . "&funcion=ObtenersCdps";
$cadenaACodificarSolCdp .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadenaACodificarSolCdp = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificarSolCdp, $enlace);

// URL definitiva
$urlFinalSolCdp = $url . $cadenaACodificarSolCdp;


$cadenaACodificarInfoCDP = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificarInfoCDP .= "&procesarAjax=true";
$cadenaACodificarInfoCDP .= "&action=index.php";
$cadenaACodificarInfoCDP .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificarInfoCDP .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificarInfoCDP .= $cadenaACodificarInfoCDP . "&funcion=ObtenerInfoCdps";
$cadenaACodificarInfoCDP .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadenaACodificarInfoCDP = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificarInfoCDP, $enlace);

// URL definitiva
$urlInfoCDP = $url . $cadenaACodificarInfoCDP;



$cadenaParticipante = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaParticipante .= "&procesarAjax=true";
$cadenaParticipante .= "&action=index.php";
$cadenaParticipante .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaParticipante .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaParticipante .= $cadenaParticipante . "&funcion=ObtenerParticipante";
$cadenaParticipante .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadenaParticipante = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaParticipante, $enlace);

// URL definitiva
$urlParticipante = $url . $cadenaParticipante;

$cadenaRepresentanteSuplente = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaRepresentanteSuplente .= "&procesarAjax=true";
$cadenaRepresentanteSuplente .= "&action=index.php";
$cadenaRepresentanteSuplente .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaRepresentanteSuplente .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaRepresentanteSuplente .= $cadenaRepresentanteSuplente . "&funcion=ObtenerRepresentanteSuplente";
$cadenaRepresentanteSuplente .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadenaRepresentanteSuplente = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaRepresentanteSuplente, $enlace);

// URL definitiva
$urlRepresentanteSuplente = $url . $cadenaRepresentanteSuplente;

$cadenaInfoParticipante = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaInfoParticipante .= "&procesarAjax=true";
$cadenaInfoParticipante .= "&action=index.php";
$cadenaInfoParticipante .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaInfoParticipante .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaInfoParticipante .= $cadenaInfoParticipante . "&funcion=ObtenerInfoParticipante";
$cadenaInfoParticipante .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadenaInfoParticipante = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaInfoParticipante, $enlace);

// URL definitiva
$urlInfoParticipante = $url . $cadenaInfoParticipante;


$cadenaACodificarConvenioxVigencia = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificarConvenioxVigencia .= "&procesarAjax=true";
$cadenaACodificarConvenioxVigencia .= "&action=index.php";
$cadenaACodificarConvenioxVigencia .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificarConvenioxVigencia .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificarConvenioxVigencia .= $cadenaACodificarConvenioxVigencia . "&funcion=consultarConveniosxvigencia";
$cadenaACodificarConvenioxVigencia .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadenaACodificarConvenioxVigencia = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificarConvenioxVigencia, $enlace);

// URL definitiva
$urlFinalConveniosxvigencia = $url . $cadenaACodificarConvenioxVigencia;


// Variables
$cadenaACodificarConvenio = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificarConvenio .= "&procesarAjax=true";
$cadenaACodificarConvenio .= "&action=index.php";
$cadenaACodificarConvenio .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificarConvenio .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificarConvenio .= $cadenaACodificarConvenio . "&funcion=consultarConvenio";
$cadenaACodificarConvenio .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadenaACodificarConvenio = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificarConvenio, $enlace);

// URL definitiva
$urlFinalConvenio = $url . $cadenaACodificarConvenio;



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


// Variables
$cadenaACodificarDireccionSede = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificarDireccionSede .= "&procesarAjax=true";
$cadenaACodificarDireccionSede .= "&action=index.php";
$cadenaACodificarDireccionSede .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificarDireccionSede .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificarDireccionSede .= $cadenaACodificarDireccionSede . "&funcion=consultarDireccionSede";
$cadenaACodificarDireccionSede .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadenaACodificarDireccionSede = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificarDireccionSede, $enlace);

// URL definitiva
$urlFinalDireccionSede = $url . $cadenaACodificarDireccionSede;





// Variables
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

// Variables
$cadenaACodificar6 = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificar6 .= "&procesarAjax=true";
$cadenaACodificar6 .= "&action=index.php";
$cadenaACodificar6 .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificar6 .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificar6 .= $cadenaACodificar . "&funcion=SeleccionOrdenador";
$cadenaACodificar6 .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace6 = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena6 = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar6, $enlace6);

// URL definitiva
$urlFinal6 = $url . $cadena6;


//Variables
$cadenaACodificar18 = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificar18 .= "&procesarAjax=true";
$cadenaACodificar18 .= "&action=index.php";
$cadenaACodificar18 .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificar18 .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificar18 .= $cadenaACodificar18 . "&funcion=consultarCiudadAjax";
$cadenaACodificar18 .= "&tiempo=" . $_REQUEST ['tiempo'];
// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena18 = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar18, $enlace);
// URL definitiva
$urlFinal18 = $url . $cadena18;

//Variables
$cadenaACodificarDeptoxPais = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificarDeptoxPais .= "&procesarAjax=true";
$cadenaACodificarDeptoxPais .= "&action=index.php";
$cadenaACodificarDeptoxPais .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificarDeptoxPais .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificarDeptoxPais .= $cadenaACodificarDeptoxPais . "&funcion=consultarDepartamentoAjax";
$cadenaACodificarDeptoxPais .= "&tiempo=" . $_REQUEST ['tiempo'];
// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadenaACodificarDeptoxPais = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificarDeptoxPais, $enlace);
// URL definitiva
$urlFinalDeptoEjecucion = $url . $cadenaACodificarDeptoxPais;

//Variables
$cadenaACodificarUE1 = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificarUE1 .= "&procesarAjax=true";
$cadenaACodificarUE1 .= "&action=index.php";
$cadenaACodificarUE1 .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificarUE1 .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificarUE1 .= $cadenaACodificarUE1 . "&funcion=consultarContratistaUE1";
$cadenaACodificarUE1 .= "&tiempo=" . $_REQUEST ['tiempo'];
// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadenaACodificarUE1 = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificarUE1, $enlace);
// URL definitiva
$urlFinalUE1 = $url . $cadenaACodificarUE1;
?>
<script type='text/javascript'>
//----------------------------Configuracion Paso a Paso--------------------------------------

    $("#ventanaA").steps({
        headerTag: "h3",
        bodyTag: "section",
        enableAllSteps: true,
        enablePagination: true,
        transitionEffect: "slideLeft",
        onStepChanging: function (event, currentIndex, newIndex) {
            resultado = $("#registrarContrato").validationEngine("validate");
	
	     	 $("#amparo0").width(300);
             $("#amparo0").select2();

            if (currentIndex === 0 && ($("#<?php echo $this->campoSeguro('tipo_contrato') ?>").val()) === '5' && $("#ventanaA").find('section').length === 9)
            {


                $("#ventanaA").steps("insert", 1, {
                    title: "Información Detallada Arrendamiento",
                    content: '<fieldset class="ui-widget ui-widget-content">' +
                            '<legend class="ui-state-default ui-corner-all"> Destinación Arrendamiento:</legend>' +
                            '<textarea id="destinacionArrendamiento" class="areaTexto validate[required, minSize[5]]" name="destinacionArrendamiento" cols="145" rows="6" tabindex="57"></textarea>' +
                            '</fieldset>' +
                            '<div class="campoCuadroLista anchoColumna2">' +
                            '<div style="float:left; width:213px">' +
                            '<label for="diasHabilesCanon">Días Hábiles Pago Mensual: </label>' +
                            '<span class="texto_rojo texto_pie">* </span>' +
                            '</div>' +
                            '<input type=text class="validate[required, custom[onlyNumberSp]] " id=diasHabiles size="40"  maxlength="2" value=""  onblur="CalcularFormaPago()"/>' +
                            '</div>' +
                            '<div class="campoCuadroLista anchoColumna2">' +
                            '<div style="float:left; width:213px">' +
                            '<label for="valorCanon">Valor Mensual Arrendamiento: </label>' +
                            '<span class="texto_rojo texto_pie">* </span>' +
                            '</div>' +
                            '<input type=text class="validate[required], custom[onlyNumberSp]] " id=valorMensualArrendamiento size="40"  maxlength="10" value="" onblur="CalcularFormaPago()" />' +
                            '</div>' +
                            '<fieldset class="ui-widget ui-widget-content">' +
                            '<legend class="ui-state-default ui-corner-all"> Reajuste Si Aplica:</legend>' +
                            '<textarea id="reajusteArrendamiento" class="areaTexto validate[minSize[5]]" name="reajusteArrendamiento" cols="145" rows="6" tabindex="57" onblur="CalcularFormaPago()"></textarea>' +
                            '</fieldset>' +
                            '<div class="campoCuadroLista anchoColumna3">' +
                            '<div style="float:left; width:213px">' +
                            '<label for="diasHabilesAdmin">Días Hábiles Administración: </label>' +
                            '</div>' +
                            '<input type=text class="validate[custom[onlyNumberSp]] " id=diasHabilesAdmin size="40"  maxlength="2" value="" onblur="CalcularFormaPago()"/>' +
                            '</div>' +
                            '<div class="campoCuadroLista anchoColumna3">' +
                            '<div style="float:left; width:213px">' +
                            '<label for="valorAdmin">Valor Administración: </label>' +
                            '</div>' +
                            '<input type=text class="validate[custom[onlyNumberSp]] " id=valorAdmin size="40"  maxlength="10" value="" onblur="CalcularFormaPago()"/>' +
                            '</div>' +
                            '<div class="campoCuadroLista anchoColumna3">' +
                            '<div style="float:left; width:400px">' +
                            '<label for="diasHabilesEntrega">Días Hábiles Entrega Inmueble por Parte del Arrendador: </label>' +
                            '<span class="texto_rojo texto_pie">* </span>' +
                            '</div>' +
                            '<input type=text class="validate[required], custom[onlyNumberSp]] " id=diasHabilesEntrega size="40"  maxlength="3" value="" />' +
                            '</div>'
                });
                
            }


            if (currentIndex === 0 && ($("#<?php echo $this->campoSeguro('tipo_contrato') ?>").val()) !== '5' && $("#ventanaA").find('section').length !== 9)
            {


                $("#ventanaA").steps("remove", 1, {
                    title: "Step Title",
                    content: "<p>Step Body</p>"
                });
            }



            if (resultado) {
                return true;
            } else {
                return false;
            }

        },
        onFinished: function (event, currentIndex) {
            $("#<?php echo $this->campoSeguro('destinacionArrendamiento_hidden') ?>").val($("#destinacionArrendamiento").val());
            $("#<?php echo $this->campoSeguro('diasHabiles_hidden') ?>").val($("#diasHabiles").val());
            $("#<?php echo $this->campoSeguro('valorMensualArrendamiento_hidden') ?>").val($("#valorMensualArrendamiento").val());
            $("#<?php echo $this->campoSeguro('reajusteArrendamiento_hidden') ?>").val($("#reajusteArrendamiento").val());
            $("#<?php echo $this->campoSeguro('diasHabilesAdmin_hidden') ?>").val($("#diasHabilesAdmin").val());
            $("#<?php echo $this->campoSeguro('valorAdmin_hidden') ?>").val($("#valorAdmin").val());
            $("#<?php echo $this->campoSeguro('diasHabilesEntrega_hidden') ?>").val($("#diasHabilesEntrega").val());

            var camposA = '';
            var camposS = '';
            var camposV = '';


            $('#tab_amparos tr').each(function (index, element) {



                camposA = camposA + $('#amparo' + index).val() + '~',
                        camposS = camposS + $('#porcentajeamparo' + index).val() + '~',
                        camposV = camposV + $('#valoramparo' + index).val() + '~';


            });

            $("#<?php echo $this->campoSeguro('tablAmparos_hidden') ?>").val(camposA);
            $("#<?php echo $this->campoSeguro('tablaSuficiencia_hidden') ?>").val(camposS);
            $("#<?php echo $this->campoSeguro('tablaVigencia_hidden') ?>").val(camposV);
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



//---------------Consulta Proveedor UNICO de Contrato---------------------------------------------------


    $("#<?php echo $this->campoSeguro('selec_proveedor') ?>").autocomplete({
        minChars: 3,
        serviceUrl: '<?php echo $urlFinalProveedor; ?>',
        onSelect: function (suggestion) {

            $("#<?php echo $this->campoSeguro('id_proveedor') ?>").val(suggestion.data);
            consultarInformacionProveedor($("#<?php echo $this->campoSeguro('id_proveedor') ?>").val());
        }


    });

    var i = 0;
    var numeracion = 1;
    var texto_forma_pago='';


    function CalcularFormaPago() {
        
        
        
        if($("#diasHabiles").val()!=='' && $("#valorMensualArrendamiento").val()!=='' && $("#diasHabilesAdmin").val()!=='' && $("#valorAdmin").val()!==''){
            if($("#reajusteArrendamiento").val()!==''){
               texto_forma_pago='i) A título de canon de arrendamiento, un pago anticipado dentro de los primeros [DIAS HABILES PAGO MENSUAL] días hábiles de cada mes, por valor de [VALOR MENSUAL ARRENDAMIENTO]' +
                              ' IVA incluido.  [REAJUSTE] ' + 
                              ' ii) A título de cuotas ordinarias de administración, un pago anticipado a EL ARRENDADOR, quien deberá a su vez cancelar a la administración correspondiente, dentro de los primeros ' +
                              ' [DIAS HABILES ADMINISTRACION] días hábiles de cada mes, por valor de [VALOR ADMINISTRACION]. LA UNIVERSIDAD  en ningún caso pagará o reconocerá valor ' +
                              ' alguno por las cuotas extraordinarias de administración, las cuales están a cargo de EL ARRENDADOR. Los pagos se realizarán dentro de los días previstos ' +
                              ' por LA UNIVERSIDAD siguientes a fecha de presentación del certificado de cumplimiento firmado por el supervisor del Contrato. Los pagos a los cuales hace referencia ' +
                              ' la presente cláusula se efectuarán previo recibo a satisfacción suscrito por el supervisor del contrato, así como del comprobante de pago de los ' +
                              'aportes al Sistema de Seguridad Social Integral o la certificación del representante legal o revisor fiscal, según corresponda.';
                    $("#<?php echo $this->campoSeguro('descripcion_forma_pago') ?>").val(texto_forma_pago);  
            }
            else{
                texto_forma_pago='i) A título de canon de arrendamiento, un pago anticipado dentro de los primeros [DIAS HABILES PAGO MENSUAL] días hábiles de cada mes, por valor de [VALOR MENSUAL ARRENDAMIENTO]' +
                              ' IVA incluido. ' + 
                              ' ii) A título de cuotas ordinarias de administración, un pago anticipado a EL ARRENDADOR, quien deberá a su vez cancelar a la administración correspondiente, dentro de los primeros ' +
                              ' [DIAS HABILES ADMINISTRACION] días hábiles de cada mes, por valor de [VALOR ADMINISTRACION]. LA UNIVERSIDAD  en ningún caso pagará o reconocerá valor ' +
                              ' alguno por las cuotas extraordinarias de administración, las cuales están a cargo de EL ARRENDADOR. Los pagos se realizarán dentro de los días previstos ' +
                              ' por LA UNIVERSIDAD siguientes a fecha de presentación del certificado de cumplimiento firmado por el supervisor del Contrato. Los pagos a los cuales hace referencia ' +
                              ' la presente cláusula se efectuarán previo recibo a satisfacción suscrito por el supervisor del contrato, así como del comprobante de pago de los ' +
                              'aportes al Sistema de Seguridad Social Integral o la certificación del representante legal o revisor fiscal, según corresponda.';
                    $("#<?php echo $this->campoSeguro('descripcion_forma_pago') ?>").val(texto_forma_pago);  
                
            }
            
                      
                      
        }
        else{
             if($("#diasHabiles").val()!=='' && $("#valorMensualArrendamiento").val()!==''){
                 if($("#reajusteArrendamiento").val()!==''){
                   texto_forma_pago='i) A título de canon de arrendamiento, un pago anticipado dentro de los primeros [DIAS HABILES PAGO MENSUAL] días hábiles de cada mes, por valor de [VALOR MENSUAL ARRENDAMIENTO]' +
                              ' IVA incluido.  [REAJUSTE] ' + 
                              ' Los pagos se realizarán dentro de los días previstos ' +
                              ' por LA UNIVERSIDAD siguientes a fecha de presentación del certificado de cumplimiento firmado por el supervisor del Contrato. Los pagos a los cuales hace referencia ' +
                              ' la presente cláusula se efectuarán previo recibo a satisfacción suscrito por el supervisor del contrato, así como del comprobante de pago de los ' +
                              'aportes al Sistema de Seguridad Social Integral o la certificación del representante legal o revisor fiscal, según corresponda.';
                    $("#<?php echo $this->campoSeguro('descripcion_forma_pago') ?>").val(texto_forma_pago);  
                 }
                 else{
                    texto_forma_pago='i) A título de canon de arrendamiento, un pago anticipado dentro de los primeros [DIAS HABILES PAGO MENSUAL] días hábiles de cada mes, por valor de [VALOR MENSUAL ARRENDAMIENTO]' +
                              ' IVA incluido. ' + 
                              ' Los pagos se realizarán dentro de los días previstos ' +
                              ' por LA UNIVERSIDAD siguientes a fecha de presentación del certificado de cumplimiento firmado por el supervisor del Contrato. Los pagos a los cuales hace referencia ' +
                              ' la presente cláusula se efectuarán previo recibo a satisfacción suscrito por el supervisor del contrato, así como del comprobante de pago de los ' +
                              'aportes al Sistema de Seguridad Social Integral o la certificación del representante legal o revisor fiscal, según corresponda.';
                    $("#<?php echo $this->campoSeguro('descripcion_forma_pago') ?>").val(texto_forma_pago);  
                 }
             }
        
        }
        
            
     }
    
    
    function agregarAmparo() {
    
    
         

        $resultado = $("#registrarContrato").validationEngine("validate");


        if ($resultado) {

            var lista = "<td>" + (numeracion + 1) + "</td><td><select id='amparo" + (i + 1) + "' name='amparo" + (i + 1) + "' class='form-control input-md'/></td>";

            $('#tab_amparos tr:last').after('<tr id="addr' + (i + 1) + '">' +
                    lista +
                    '<td>' + "<input id='porcentajeamparo" + (i + 1) + "' name='porcentajeamparo" + (i + 1) + "' type='text' placeholder='Porcentaje(%)-> 10%' maxlength='3' class='form-control   custom[number]'>" + '</td>' +
                    '<td>' + "<input id='valoramparo" + (i + 1) + "'  name='valoramparo" + (i + 1) + "' type='text' placeholder='Descripción'  maxlength='500' class='form-control input-md '>" + '</td>' +
                    '</tr>');

            var data = jQuery.parseJSON($("#amparosOculto").val());

            if (data[0][0] != " ") {
                $("<option value=''>Seleccione  ....</option>").appendTo("#amparo" + (i + 1));
                $.each(data, function (indice, valor) {

                	 var camposA = '';
                                var validacion=1;

                               $('#tab_amparos tr').each(function (index, element) {
                                   
                                     if(validacion === 1){

                                           camposA = $('#amparo' + index).val();
                                           
                                          
                                              if(camposA === data[ indice ].id){
                                                  validacion=0;
                                                 
                                                   return false;
                                              }
                                              else{
                                                  validacion=1;
                                              }
                                     
                                     }
                                          
                                });
                                
                               
                                
                                
                                if(validacion !== 0){
                                    
                                    $("<option value='" + data[ indice ].id + "'>" + data[ indice ].nombre + "</option>").appendTo("#amparo" + (i + 1));
                                }
                    

                });

            }
            $("#amparo" + (i + 1)).width(300);
            $("#amparo" + (i + 1)).select2();

//           

            if (i == 0) {
                $('#amparo0').attr('disabled', true);
                $('#porcentajeamparo0').attr('readonly', true);
                $('#valoramparo0').attr('readonly', true);

            } else {
                var temp = i;
                $('#amparo' + temp).attr('disabled', true);
                $('#porcentajeamparo' + temp).attr('readonly', true);
                $('#valoramparo' + temp).attr('readonly', true);

            }

            i++;
            numeracion++;
            $("#<?php echo $this->campoSeguro('cantidadAmparos_hidden') ?>").val(i);
            $("#numR").val(i);


            return true;



        } else {
            return false;
        }

    }
    function validarAmparo() {
        var aux;
        var contador = 0;
        for (aux = 0; aux <= i; aux++) {
            contador = contador + parseInt($("#porcentajeamparo" + aux).val());

        }

        if (contador > 100 || contador < 1) {
            alert('Valor inválido para Suficiencia, sobrepasa el 100% o es igual a 0');
            return false;
        } else {
            return true;
        }


    }

    function eliminarAmparo() {

        if (i > 0) {
            $("#addr" + (i)).html('');
            i--;
            numeracion--;
            $("#amparo" + (i)).attr('disabled', false);
            $("#porcentajeamparo" + (i)).attr('readonly', false);
            $("#valoramparo" + (i)).attr('readonly', false);
        }
        if (i == 0) {
            $('#amparo0').attr('disabled', false);
            $('#porcentajeamparo0').attr('readonly', false);
            $('#valoramparo0').attr('readonly', false);
        }
        $("#<?php echo $this->campoSeguro('cantidadAmparos_hidden') ?>").val(i);
        $("#numR").val(i);


    }


    function CalcularPorcentajeAmparo(i) {
        var i = i - 1;
        var valorPorcentaje = $("#porcentajeamparo" + i).val();
        if (valorPorcentaje > 0) {
//            var valor_contrato = $('#<?php echo $this->campoSeguro('valor_contrato') ?>').val();
//            var valor_amparo = (valorPorcentaje * valor_contrato) / 100;
//            $("#valoramparo" + i).val(valor_amparo);
        } else {
            $("#valoramparo" + i).val("");
            alert("El porcentaje no es un valor Valido.")
        }
    }

    function consultarInformacionProveedor(id) {
        $.ajax({
            url: "<?php echo $urlInformacionProveedor ?>",
            dataType: "json",
            data: {valor: id},
            success: function (data) {
                if (data[0] != " ") {
                    var sizeJson = Object.keys(data[0]).length;
                    for (i = 0; i < sizeJson / 2; i++) {
                        if (data[0][i] == null || data[0][i] == '') {
                            data[0][i] = "SIN INFORMACIÓN";
                        }
                    }
                    var infoProveedor = '<b>TIPO PERSONA:</b> ' + data[0].tipopersona + '<br>' +
                            '<b>NOMBRE:</b> ' + data[0].nom_proveedor + '<br>' +
                            '<b>DOCUMENTO:</b> ' + data[0].num_documento + '<br>' +
                            '<b>CIUDAD DE CONTACTO:</b> ' + data[0].nombreciudad + '<br>' +
                            '<b>DIRECCIÓN:</b> ' + data[0].direccion + '<br>' +
                            '<b>CORREO:</b> ' + data[0].correo + '<br>' +
                            '<b>SITIO WEB:</b> ' + data[0].web + '<br>' +
                            '<b>ASESOR:</b> ' + data[0].nom_asesor + '<br>' +
                            '<b>TELEFONO ASESOR:</b> ' + data[0].tel_asesor + '<br>' +
                            '<b>DESCRIPCIÓN:</b> ' + data[0].descripcion + '<br>' +
                            '<b>PUNTAJE DE EVALUACIÓN:</b> ' + data[0].puntaje_evaluacion + '<br>' +
                            '<b>TIPO CUENTA BANCARIA:</b> ' + data[0].tipo_cuenta_bancaria + '<br>' +
                            '<b>NUMERO CUENTA :</b> ' + data[0].num_cuenta_bancaria + '<br>' +
                            '<b>ENTIDAD BANCARIA:</b> ' + data[0].nombrebanco;

                    infoProveedor = String(infoProveedor);
                    $('.infoproveedorspan').html(infoProveedor);
                    $("#infoProveedor").css('display', 'block');

                }
            }

        });
    }
    ;
//---------------Consulta Proveedor SOCIEDADTEMPORAL de Contrato---------------------------------------------------


    $("#<?php echo $this->campoSeguro('selec_sociedad') ?>").autocomplete({
        minChars: 3,
        serviceUrl: '<?php echo $urlFinalProveedorSociedad; ?>',
        onSelect: function (suggestion) {

            $("#<?php echo $this->campoSeguro('id_proveedor') ?>").val(suggestion.data);
            consultarInformacionProveedorSociedad($("#<?php echo $this->campoSeguro('id_proveedor') ?>").val());


        }
    });
    function consultarInformacionProveedorSociedad(id) {
        $.ajax({
            url: "<?php echo $urlFinalInformacionSociedad ?>",
            dataType: "json",
            data: {valor: id},
            success: function (data) {
                if (data[0] != " ") {

                    var infoProveedor = '<b>TIPO SOCIEDAD:</b> ' + data[0].tipopersona + '<br>' +
                            '<b>NOMBRE:</b> ' + data[0].nom_proveedor + '<br>' +
                            '<b>DOCUMENTO:</b> ' + data[0].num_documento + '<br>' +
                            '<b>DIGITO DE VERIFICACIÓN:</b> ' + data[0].digito_verificacion + '<br>' +
                            '<b>CIUDAD DE CONTACTO:</b> ' + data[0].nombreciudad + '<br>' +
                            '<b>DIRECCIÓN:</b> ' + data[0].direccion + '<br>' +
                            '<b>CORREO:</b> ' + data[0].correo + '<br>' +
                            '<b>SITIO WEB:</b> ' + data[0].web + '<br>' +
                            '<b>REPRESENTANTE:</b> ' + data[0].inforepresentante + '<br>' +
                            '<b>REPRESENTANTE SUPLENTE:</b> ' + data[0].inforepresentantesuplente + '<br>' +
                            '<b>PUNTAJE DE EVALUACIÓN:</b> ' + data[0].puntaje_evaluacion + '<br>' +
                            '<b>TIPO CUENTA BANCARIA:</b> ' + data[0].tipo_cuenta_bancaria + '<br>' +
                            '<b>NUMERO CUENTA :</b> ' + data[0].num_cuenta_bancaria + '<br>' +
                            '<b>ENTIDAD BANCARIA:</b> ' + data[0].nombrebanco;

                    var infoProveedor = infoProveedor.replace("null", "SIN INFORMACIÓN");

                    var sizeJsonParticipantes = Object.keys(data[1]).length;
                    var participantes = "<table class='table table-bordered table-hover'><thead><tr>";
                    participantes = participantes + " <th class='text-center'>PARTICIPANTE</th><th class='text-center'>PORCENTAJE DE PARTICIPACIÓN</th></tr></thead><tbody>";
                    for (i = 0; i < sizeJsonParticipantes; i++) {
                        participantes = participantes + "<tr><td class='text-center'>" + data[1][i][0] + "</td><td class='text-center'>" + data[1][i][1] + "%</td><tr>"
                    }
                    participantes = participantes + "</tbody></table>";

                    $('.infosociedadspan').html(infoProveedor);
                    $('.infosociedadparticipantesspan').html(participantes);
                    $("#infoSociedad").css('display', 'block');

                }
            }

        });
    }
    ;



//----------------------------Fin Configuracion Paso a Paso--------------------------------------
//--------------Inicio JavaScript y Ajax Sede y Dependencia Solicitante ---------------------------------------------------------------------------------------------    

    $("#<?php echo $this->campoSeguro('sede') ?>").change(function () {

        if ($("#<?php echo $this->campoSeguro('sede') ?>").val() != '') {
            consultarDependencia();
        } else {
            $("#<?php echo $this->campoSeguro('dependencia_solicitante') ?>").attr('disabled', '');
        }

    });

    function consultarDependencia(elem, request, response) {
        $.ajax({
            url: "<?php echo $urlFinalDependencia ?>",
            dataType: "json",
            data: {valor: $("#<?php echo $this->campoSeguro('sede') ?>").val()},
            success: function (data) {



                if (data[0] != " ") {

                    $("#<?php echo $this->campoSeguro('dependencia_solicitante') ?>").html('');
                    $("<option value=''>Seleccione  ....</option>").appendTo("#<?php echo $this->campoSeguro('dependencia_solicitante') ?>");
                    $.each(data, function (indice, valor) {

                        $("<option value='" + data[ indice ].ESF_CODIGO_DEP + "'>" + data[ indice ].ESF_DEP_ENCARGADA + "</option>").appendTo("#<?php echo $this->campoSeguro('dependencia_solicitante') ?>");

                    });

                    $("#<?php echo $this->campoSeguro('dependencia_solicitante') ?>").removeAttr('disabled');

                    $('#<?php echo $this->campoSeguro('dependencia_solicitante') ?>').width(350);
                    $("#<?php echo $this->campoSeguro('dependencia_solicitante') ?>").select2();



                }


            }

        });
    }
    ;

    //--------------Fin JavaScript y Ajax Sede y Dependencia Suepervisor --------------------------------------------------------------------------------------------------   
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

                    $('#<?php echo $this->campoSeguro('dependencia_supervisor') ?>').width(200);
                    $("#<?php echo $this->campoSeguro('dependencia_supervisor') ?>").select2();

                }


            }

        });
    }
    ;
//--------------Fin JavaScript y Ajax Sede y Dependencia Suepervisor --------------------------------------------------------------------------------------------------   

    $("#<?php echo $this->campoSeguro('nombre_supervisor') ?>").change(function () {

        if ($("#<?php echo $this->campoSeguro('nombre_supervisor') ?>").val() != '') {
            cargoSuper();
        }

    });

    function cargoSuper(elem, request, response) {
        $.ajax({
            url: "<?php echo $urlFinal17 ?>",
            dataType: "json",
            data: {valor: $("#<?php echo $this->campoSeguro('nombre_supervisor') ?>").val()},
            success: function (data) {


                $("#<?php echo $this->campoSeguro('cargo_supervisor') ?>").val(data[0]);
                $("#<?php echo $this->campoSeguro('cargo_inicial') ?>").val(data[0]);

            }

        });
    }
    ;

  


//--------------Fin JavaScript y Ajax Cargo Suepervisor ---------------------------------------------------------------------------------------------    
//--------------Inicio JavaScript y Ajax Nombre Ordenador ---------------------------------------------------------------------------------------------    

    $("#<?php echo $this->campoSeguro('ordenador_gasto') ?>").change(function () {

        if ($("#<?php echo $this->campoSeguro('ordenador_gasto') ?>").val() != '') {

            datosOrdenador();
        } else {
            $("#<?php echo $this->campoSeguro('nombreOrdenador') ?>").val('');
        }



    });
    function datosOrdenador(elem, request, response) {
        $.ajax({
            url: "<?php echo $urlFinal6 ?>",
            dataType: "json",
            data: {ordenador: $("#<?php echo $this->campoSeguro('ordenador_gasto') ?>").val()},
            success: function (data) {

                if (data[0] != 'null') {

                    $("#<?php echo $this->campoSeguro('nombreOrdenador') ?>").val(data[0]);
                    $("#<?php echo $this->campoSeguro('id_ordenador') ?>").val(data[1]);
                }

            }

        });
    }
    ;
//--------------Fin JavaScript y Ajax Nombre Ordenador ---------------------------------------------------------------------------------------------    


//--------------Inicio JavaScript y Ajax Vigencia y Numero Disponibilidad ---------------------------------------------------------------------------------------------    

    $("#<?php echo $this->campoSeguro('vigencia_solicitud_consulta') ?>").change(function () {

        if ($("#<?php echo $this->campoSeguro('vigencia_solicitud_consulta') ?>").val() != '') {
            $("#<?php echo $this->campoSeguro('numero_disponibilidad') ?>").attr('disabled', '');
            consultarCdps();
        } else {
            $("#<?php echo $this->campoSeguro('vigencia_solicitud_consulta') ?>").attr('disabled', '');
        }

    });

    function consultarCdps(elem, request, response) {

        $.ajax({
            url: "<?php echo $urlFinalSolCdp ?>",
            dataType: "json",
            data: {vigencia: $("#<?php echo $this->campoSeguro('vigencia_solicitud_consulta') ?>").val(),
                unidad: $("#<?php echo $this->campoSeguro('unidad_ejecutora_hidden') ?>").val(),
                cdpseleccion: $("#<?php echo $this->campoSeguro('indices_cdps_vigencias') ?>").val()},
            success: function (data) {

                if (data[0] != " ") {

                    $("#<?php echo $this->campoSeguro('numero_disponibilidad') ?>").html('');
                    $("<option value=''>Seleccione  ....</option>").appendTo("#<?php echo $this->campoSeguro('numero_disponibilidad') ?>");
                    $.each(data, function (indice, valor) {

                        $("<option value='" + data[ indice ].VALOR + "'>" + data[ indice ].INFORMACION + "</option>").appendTo("#<?php echo $this->campoSeguro('numero_disponibilidad') ?>");

                    });

                    $("#<?php echo $this->campoSeguro('numero_disponibilidad') ?>").removeAttr('disabled');

                    $('#<?php echo $this->campoSeguro('numero_disponibilidad') ?>').width(200);
                    $("#<?php echo $this->campoSeguro('numero_disponibilidad') ?>").select2();

                }


            }

        });
    }
    ;

    //--------------Fin JavaScript y Ajax SVigencia y Numero solicitud --------------------------------------------------------------------------------------------------   


//---------------------Inicio Ajax Numero de Solicitud de Necesidad------------------


    $("#<?php echo $this->campoSeguro('numero_disponibilidad') ?>").change(function () {
        if ($("#<?php echo $this->campoSeguro('numero_disponibilidad') ?>").val() != '') {
            InfoCDP();
        } else {

        }
    });

    function InfoCDP(elem, request, response) {
        $.ajax({
            url: "<?php echo $urlInfoCDP ?>",
            dataType: "json",
            data: {unidad: $("#<?php echo $this->campoSeguro('unidad_ejecutora_hidden') ?>").val(),
                vigencia: $("#<?php echo $this->campoSeguro('vigencia_solicitud_consulta') ?>").val(),
                numero_disponibilidad: $("#<?php echo $this->campoSeguro('numero_disponibilidad') ?>").val()},
            success: function (data) {
                if (data[0] != "") {

                    $('#' + $("#<?php echo $this->campoSeguro('indice_tabla') ?>").val()).html("<td><center>" + data[0].VIGENCIA + "</center></td>\n\\n\
                                   <td><center>" + data[0].NUM_SOL_ADQ + "</center></td>\n\
                                   <td><center>" + data[0].NUMERO_DISPONIBILIDAD + "</center></td>\n\
                                   <td><center>" + data[0].VALOR_CONTRATACION + "</center></td>\n\
                                   <td><center>" + data[0].NOMBRE_DEPENDENCIA + "</center></td>\n\
                                   <td><center>" + data[0].DESCRIPCION + "</center></td>\n\
                                   <td><center>" + data[0].ESTADO + "</center></td>");

                    if ($("#<?php echo $this->campoSeguro('indice_tabla') ?>").val() == 0) {

                        $("#<?php echo $this->campoSeguro('objeto_contrato') ?>").val(data[0].OBJETO);
                        $("#<?php echo $this->campoSeguro('justificacion') ?>").val(data[0].JUSTIFICACION);
                        $("#<?php echo $this->campoSeguro('actividades') ?>").val(data[0].OBSERVACIONES);
                    }

                    var indice = parseFloat($("#<?php echo $this->campoSeguro('indice_tabla') ?>").val()) + 1;
                    $("#<?php echo $this->campoSeguro('indice_tabla') ?>").val(indice);
                    $('#tablacdpasociados').append('<tr id="' + $("#<?php echo $this->campoSeguro('indice_tabla') ?>").val() + '"></tr>');
                    $("#<?php echo $this->campoSeguro('indices_cdps') ?>").val($("#<?php echo $this->campoSeguro('indices_cdps') ?>").val() + "," + data[0].NUMERO_DISPONIBILIDAD);
                    $("#<?php echo $this->campoSeguro('indices_cdps_vigencias') ?>").val($("#<?php echo $this->campoSeguro('indices_cdps_vigencias') ?>").val() + "," + data[0].NUMERO_DISPONIBILIDAD + "-" + data[0].VIGENCIA);
                    var acumulado = parseFloat($("#<?php echo $this->campoSeguro('valor_real_acumulado') ?>").val()) + parseFloat(data[0].VALOR_CONTRATACION);
                    $("#<?php echo $this->campoSeguro('valor_real_acumulado') ?>").val(acumulado);
                    acumulado = new Intl.NumberFormat(["ban", "id"]).format(acumulado);
                    $("#<?php echo $this->campoSeguro('valor_acumulado') ?>").val(acumulado);
                    $("#<?php echo $this->campoSeguro('numero_disponibilidad') ?>").attr('disabled', '');
                    $("#<?php echo $this->campoSeguro('vigencia_solicitud_consulta') ?>").val(null);
                    $("#<?php echo $this->campoSeguro('numero_disponibilidad') ?>").val(null);
                    $("#<?php echo $this->campoSeguro('numero_disponibilidad') ?>").select2();
                    $("#<?php echo $this->campoSeguro('vigencia_solicitud_consulta') ?>").select2();

                    $("#<?php echo $this->campoSeguro('valor_contrato') ?>").val($("#<?php echo $this->campoSeguro('valor_real_acumulado') ?>").val());


                }


            }

        });
    }
    ;
    $(document).ready(function () {

        $("#eliminarCDP").click(function () {
            var indice = parseFloat($("#<?php echo $this->campoSeguro('indice_tabla') ?>").val());
            var table = document.getElementById('tablacdpasociados');
            for (var r = 0, n = table.rows.length; r < n; r++) {
                for (var c = 0, m = table.rows[r].cells.length; c < m; c++) {
                    var row = table.rows[r].cells[3].innerHTML;

                }
            }
            row = row.replace("<center>", "");
            row = row.replace("</center>", "");
            var valor = parseFloat(row);
            if (indice > 0) {
                $("#" + (indice - 1)).html('');
                var acumulado = parseFloat($("#<?php echo $this->campoSeguro('valor_real_acumulado') ?>").val()) - valor;
                $("#<?php echo $this->campoSeguro('valor_real_acumulado') ?>").val(acumulado);
                acumulado = new Intl.NumberFormat(["ban", "id"]).format(acumulado);
                if (acumulado != 0) {
                    $("#<?php echo $this->campoSeguro('valor_acumulado') ?>").val(acumulado);
                } else {
                    $("#<?php echo $this->campoSeguro('valor_acumulado') ?>").val("");
                }
                indice = indice - 1;
                $("#<?php echo $this->campoSeguro('indice_tabla') ?>").val(indice);
                var indices = $("#<?php echo $this->campoSeguro('indices_cdps') ?>").val();
                var arregloindices = indices.split(",");
                arregloindices.splice(arregloindices.length - 1, 1);
                arregloindices = arregloindices.toString();
                $("#<?php echo $this->campoSeguro('indices_cdps') ?>").val(arregloindices);

                var indicesvigencias = $("#<?php echo $this->campoSeguro('indices_cdps_vigencias') ?>").val();
                var arregloindicesvigencias = indicesvigencias.split(",");
                arregloindicesvigencias.splice(arregloindicesvigencias.length - 1, 1);
                arregloindicesvigencias = arregloindicesvigencias.toString();
                $("#<?php echo $this->campoSeguro('indices_cdps_vigencias') ?>").val(arregloindicesvigencias);
                $("#<?php echo $this->campoSeguro('valor_contrato') ?>").val($("#<?php echo $this->campoSeguro('valor_real_acumulado') ?>").val());
                $("#<?php echo $this->campoSeguro('numero_disponibilidad') ?>").attr('disabled', '');
                $("#<?php echo $this->campoSeguro('vigencia_solicitud_consulta') ?>").val(null);
                $("#<?php echo $this->campoSeguro('numero_disponibilidad') ?>").val(null);
                $("#<?php echo $this->campoSeguro('numero_disponibilidad') ?>").select2();
                $("#<?php echo $this->campoSeguro('vigencia_solicitud_consulta') ?>").select2();

                if (indice == 0) {
                    $("#<?php echo $this->campoSeguro('objeto_contrato') ?>").val("");
                    $("#<?php echo $this->campoSeguro('justificacion') ?>").val("");
                    $("#<?php echo $this->campoSeguro('actividades') ?>").val("");
                }


            }
        });

    });
//---------------------Fin Ajax Numero de Solicitud de Necesidad------------------        
    //--------------Inicio JavaScript y Ajax Convenios x Vigenca ---------------------------------------------------------------------------------------------    
    $("#<?php echo $this->campoSeguro('vigencia_convenio') ?>").change(function () {

        if ($("#<?php echo $this->campoSeguro('vigencia_convenio') ?>").val() != '') {
            consultaConveniosxVigencia();
        } else {
            $("#<?php echo $this->campoSeguro('convenio_solicitante') ?>").attr('disabled', '');
        }

    });


    function consultaConveniosxVigencia(elem, request, response) {
        $.ajax({
            url: "<?php echo $urlFinalConveniosxvigencia ?>",
            dataType: "json",
            data: {valor: $("#<?php echo $this->campoSeguro('vigencia_convenio') ?>").val()},
            success: function (data) {
                if (data[0] != " ") {

                    $("#<?php echo $this->campoSeguro('convenio_solicitante') ?>").html('');
                    $("<option value=''>Seleccione  ....</option>").appendTo("#<?php echo $this->campoSeguro('convenio_solicitante') ?>");
                    $.each(data, function (indice, valor) {

                        $("<option value='" + data[ indice ].value + "'>" + data[ indice ].data + "</option>").appendTo("#<?php echo $this->campoSeguro('convenio_solicitante') ?>");

                    });

                    $("#<?php echo $this->campoSeguro('convenio_solicitante') ?>").removeAttr('disabled');

                    $('#<?php echo $this->campoSeguro('convenio_solicitante') ?>').width(350);
                    $("#<?php echo $this->campoSeguro('convenio_solicitante') ?>").select2();

                }


            }

        });
    }
    ;
//--------------Fin JavaScript y Convenios x Vigenca --------------------------------------------------------------------------------------------------   
//--------------Inicio JavaScript y Ajax Nombre Ordenador ---------------------------------------------------------------------------------------------    

    $("#<?php echo $this->campoSeguro('convenio_solicitante') ?>").change(function () {

        if ($("#<?php echo $this->campoSeguro('convenio_solicitante') ?>").val() != '') {
            datosConvenio();
        } else {
            $("#<?php echo $this->campoSeguro('convenio_solicitante') ?>").val('');
        }



    });
    function datosConvenio(elem, request, response) {

        $.ajax({
            url: "<?php echo $urlFinalConvenio ?>",
            dataType: "json",
            data: {valor: $("#<?php echo $this->campoSeguro('convenio_solicitante') ?>").val()},
            success: function (data) {

                if (data[0] != 'null') {

                    $("#<?php echo $this->campoSeguro('nombre_convenio_solicitante') ?>").val(data[0]);

                } else {





                }

            }

        });
    }
    ;
//--------------Fin JavaScript y Ajax Nombre Ordenador ---------------------------------------------------------------------------------------------    


//--------------Inicio JavaScript y Ajax CDP x Solicitud ---------------------------------------------------------------------------------------------    




</script>

<script>






//---------------------------- Lugar de Ejecucion Ajax------------------------------------------------
//--------------Inicio JavaScript y Ajax Sede y Dependencia Ejecucion ---------------------------------------------------------------------------------------------    
    $("#<?php echo $this->campoSeguro('sede_ejecucion') ?>").change(function () {

        if ($("#<?php echo $this->campoSeguro('sede_ejecucion') ?>").val() != '') {
            consultarDependenciaEjecucion();
            consultarDireccionSedeEjecucion();
        } else {
            $("#<?php echo $this->campoSeguro('dependencia_ejecucion') ?>").attr('disabled', '');
        }

    });


    function consultarDependenciaEjecucion(elem, request, response) {
        $.ajax({
            url: "<?php echo $urlFinalDependencia ?>",
            dataType: "json",
            data: {valor: $("#<?php echo $this->campoSeguro('sede_ejecucion') ?>").val()},
            success: function (data) {
                if (data[0] != " ") {

                    $("#<?php echo $this->campoSeguro('dependencia_ejecucion') ?>").html('');
                    $("<option value=''>Seleccione  ....</option>").appendTo("#<?php echo $this->campoSeguro('dependencia_ejecucion') ?>");
                    $.each(data, function (indice, valor) {

                        $("<option value='" + data[ indice ].ESF_CODIGO_DEP + "'>" + data[ indice ].ESF_DEP_ENCARGADA + "</option>").appendTo("#<?php echo $this->campoSeguro('dependencia_ejecucion') ?>");

                    });

                    $("#<?php echo $this->campoSeguro('dependencia_ejecucion') ?>").removeAttr('disabled');

                    $('#<?php echo $this->campoSeguro('dependencia_ejecucion') ?>').width(350);
                    $("#<?php echo $this->campoSeguro('dependencia_ejecucion') ?>").select2();

                }


            }

        });
    }
    ;

    function consultarDireccionSedeEjecucion(elem, request, response) {
        $.ajax({
            url: "<?php echo $urlFinalDireccionSede ?>",
            dataType: "json",
            data: {valor: $("#<?php echo $this->campoSeguro('sede_ejecucion') ?>").val()},
            success: function (data) {
                if (data[0] != " ") {
                    $("#<?php echo $this->campoSeguro('direccion_ejecucion') ?>").val(data[0][0]);
                }


            }

        });
    }
    ;
//--------------Fin JavaScript y Ajax Sede y Dependencia Ejecucion --------------------------------------------------------------------------------------------------   


//-------------------------------- Inicio Ajax Ciudades por Depto Ejecucion.---------------------------------

    $("#<?php echo $this->campoSeguro('ejecucionDepartamento') ?>").change(function () {
        if ($("#<?php echo $this->campoSeguro('ejecucionDepartamento') ?>").val() != '') {
            consultarCiudadEjecucion();
        } else {
            $("#<?php echo $this->campoSeguro('ejecucionCiudad') ?>").attr('disabled', '');
        }
    });
    function consultarCiudadEjecucion(elem, request, response) {
        $.ajax({
            url: "<?php echo $urlFinal18 ?>",
            dataType: "json",
            data: {valor: $("#<?php echo $this->campoSeguro('ejecucionDepartamento') ?>").val()},
            success: function (data) {
                if (data[0] != " ") {
                    $("#<?php echo $this->campoSeguro('ejecucionCiudad') ?>").html('');
                    $("<option value=''>Seleccione  ....</option>").appendTo("#<?php echo $this->campoSeguro('ejecucionCiudad') ?>");
                    $.each(data, function (indice, valor) {
                        $("<option value='" + data[ indice ].id_ciudad + "'>" + data[ indice ].nombreciudad + "</option>").appendTo("#<?php echo $this->campoSeguro('ejecucionCiudad') ?>");

                    });


                    $("#<?php echo $this->campoSeguro('ejecucionCiudad') ?>").select2();
                    $("#<?php echo $this->campoSeguro('ejecucionCiudad') ?>").removeAttr('disabled');


                }

            }

        });
    }
    ;
//-------------------------------- Fin Ajax Ciudades por Depto Ejecucion.---------------------------------

//--------------------------------Inicio AJax Deptos por Pais---------------------------------------------

    $("#<?php echo $this->campoSeguro('ejecucionPais') ?>").change(function () {
        if ($("#<?php echo $this->campoSeguro('ejecucionPais') ?>").val() != '') {
            $("#<?php echo $this->campoSeguro('ejecucionCiudad') ?>").val(null);
            $("#<?php echo $this->campoSeguro('ejecucionCiudad') ?>").select2();
            consultarDepartamento();


        } else {
            $("#<?php echo $this->campoSeguro('personaJuridicaDepartamento') ?>").attr('disabled', '');
        }
    });
    function consultarDepartamento(elem, request, response) {
        $.ajax({
            url: "<?php echo $urlFinalDeptoEjecucion ?>",
            dataType: "json",
            data: {valor: $("#<?php echo $this->campoSeguro('ejecucionPais') ?>").val()},
            success: function (data) {
                if (data[0] != " ") {
                    $("#<?php echo $this->campoSeguro('ejecucionDepartamento') ?>").html('');
                    $("<option value=''>Seleccione  ....</option>").appendTo("#<?php echo $this->campoSeguro('ejecucionDepartamento') ?>");
                    $.each(data, function (indice, valor) {
                        $("<option value='" + data[ indice ].id_departamento + "'>" + data[ indice ].nombre + "</option>").appendTo("#<?php echo $this->campoSeguro('ejecucionDepartamento') ?>");

                    });

                    $("#<?php echo $this->campoSeguro('ejecucionDepartamento') ?>").select2();
                    $("#<?php echo $this->campoSeguro('ejecucionDepartamento') ?>").removeAttr('disabled');



                }


            }

        });
    }
    ;
//--------------------------------Fin AJax Deptos por Pais--------------------------------------------

// Calcular Digito Supervisor ------------------------------------------------------------------------






    $("#<?php echo $this->campoSeguro('nombre_supervisor_interventor') ?>").change(function () {

        if ($("#<?php echo $this->campoSeguro('nombre_supervisor_interventor') ?>").val() != '') {
            var supervisor = $("#<?php echo $this->campoSeguro('nombre_supervisor_interventor') ?>").val();
            var identificacion = supervisor.split("-");
            calcularDigitoCedulaSupervisor(identificacion[0]);
        }
    });
    $("#<?php echo $this->campoSeguro('nombre_supervisor') ?>").change(function () {

        if ($("#<?php echo $this->campoSeguro('nombre_supervisor') ?>").val() != '') {
            var supervisor = $("#<?php echo $this->campoSeguro('nombre_supervisor') ?>").val();
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


</script>

