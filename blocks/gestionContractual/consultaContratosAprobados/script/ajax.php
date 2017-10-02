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
$cadenaACodificar .= "&funcion=consultarProveedorFiltro";
$cadenaACodificar .= "&usuario=" . $_REQUEST['usuario'];
$cadenaACodificar .="&tiempo=" . $_REQUEST['tiempo'];


// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar, $enlace);

// URL definitiva
$urlContratista = $url . $cadena;


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

$cadenaInfoRegistroPresupuestalporDisponibilidad = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaInfoRegistroPresupuestalporDisponibilidad .= "&procesarAjax=true";
$cadenaInfoRegistroPresupuestalporDisponibilidad .= "&action=index.php";
$cadenaInfoRegistroPresupuestalporDisponibilidad .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaInfoRegistroPresupuestalporDisponibilidad .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaInfoRegistroPresupuestalporDisponibilidad .= $cadenaInfoRegistroPresupuestalporDisponibilidad . "&funcion=consultarInfoRP";
$cadenaInfoRegistroPresupuestalporDisponibilidad .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadenaInfoRegistroPresupuestalporDisponibilidad = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaInfoRegistroPresupuestalporDisponibilidad, $enlace);

// URL definitiva
$urlInfoRegistroPresupuestalporDisponibilidad = $url . $cadenaInfoRegistroPresupuestalporDisponibilidad;



// Variables
$cadenaRegistroPresupuestalporDisponibilidad = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaRegistroPresupuestalporDisponibilidad .= "&procesarAjax=true";
$cadenaRegistroPresupuestalporDisponibilidad .= "&action=index.php";
$cadenaRegistroPresupuestalporDisponibilidad .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaRegistroPresupuestalporDisponibilidad .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaRegistroPresupuestalporDisponibilidad .= $cadenaRegistroPresupuestalporDisponibilidad . "&funcion=consultarRegistroDisponibilidad";
$cadenaRegistroPresupuestalporDisponibilidad .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadenaRegistroPresupuestalporDisponibilidad = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaRegistroPresupuestalporDisponibilidad, $enlace);

// URL definitiva
$urlRegistroPresupuestalporDisponibilidad = $url . $cadenaRegistroPresupuestalporDisponibilidad;


$cadenaconsultaInRP = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaconsultaInRP .= "&procesarAjax=true";
$cadenaconsultaInRP .= "&action=index.php";
$cadenaconsultaInRP .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaconsultaInRP .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaconsultaInRP .= $cadenaconsultaInRP . "&funcion=consultarRp";
$cadenaconsultaInRP .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadenaconsultaInRP = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaconsultaInRP, $enlace);

// URL definitiva
$consultaInRP = $url . $cadenaconsultaInRP;

$cadenainactivarRp = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenainactivarRp .= "&procesarAjax=true";
$cadenainactivarRp .= "&action=index.php";
$cadenainactivarRp .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenainactivarRp .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenainactivarRp .= $cadenainactivarRp . "&funcion=inactivarrp";
$cadenainactivarRp .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadenainactivarRp = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenainactivarRp, $enlace);

// URL definitiva
$inactivarRp = $url . $cadenainactivarRp;

// Variables
$cadenadocumento = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenadocumento .= "&procesarAjax=true";
$cadenadocumento .= "&action=index.php";
$cadenadocumento .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenadocumento .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenadocumento .= $cadenadocumento . "&funcion=generarDocumento";
$cadenadocumento .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadenadocumento = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenadocumento, $enlace);

// URL definitiva
$urlDocumento = $url . $cadenadocumento;
?>
<script type='text/javascript'>
var i;
     var numeracion;
    //----------------------------Configuracion Paso a Paso--------------------------------------
    $("#ventanaA").steps({
        headerTag: "h3",
        bodyTag: "section",
        enableAllSteps: true,
        enablePagination: true,
        transitionEffect: "slideLeft",
        onStepChanging: function (event, currentIndex, newIndex) {
            $resultado = $("#modificarContrato").validationEngine("validate");
            
            
            if (currentIndex === 0 && ($("#<?php echo $this->campoSeguro('tipo_contrato') ?>").val()) === '5' && $("#ventanaA").find('section').length === 9)
            {  
                

                $("#ventanaA").steps("insert", 1, {
                    title: "Información Detallada Arrendamiento",
                    content: '<fieldset class="ui-widget ui-widget-content">' +
                            '<legend class="ui-state-default ui-corner-all"> Destinación Arrendamiento:</legend>' +
                            '<textarea id="destinacionArrendamiento" class="areaTexto" name="destinacionArrendamiento" cols="145" rows="6" tabindex="57" disabled>'+$("#<?php echo $this->campoSeguro('destinacionArrendamiento_hidden') ?>").val()+'</textarea>' +
                            '</fieldset>' +
                            '<div class="campoCuadroLista anchoColumna2">' +
                            '<div style="float:left; width:213px">' +
                            '<label for="diasHabilesCanon">Días Hábiles Pago Mensual: </label>' +
                            '<span class="texto_rojo texto_pie">* </span>' +
                            '</div>' +
                            '<input type=text class="" id=diasHabiles size="40"  maxlength="2" value="'+$("#<?php echo $this->campoSeguro('diasHabiles_hidden') ?>").val() + '" disabled/>' +
                            '</div>' +
                            '<div class="campoCuadroLista anchoColumna2">' +
                            '<div style="float:left; width:213px">' +
                            '<label for="valorCanon">Valor Mensual Arrendamiento: </label>' +
                            '<span class="texto_rojo texto_pie">* </span>' +
                            '</div>' +
                            '<input type=text class="" id=valorMensualArrendamiento size="40"  maxlength="10" value="'+parseInt($("#<?php echo $this->campoSeguro('valorMensualArrendamiento_hidden') ?>").val()) + '" disabled/>' + 
                            '</div>' +
                            '<fieldset class="ui-widget ui-widget-content">' +
                            '<legend class="ui-state-default ui-corner-all"> Reajuste Si Aplica:</legend>' +
                            '<textarea id="reajusteArrendamiento" class="areaTexto" name="reajusteArrendamiento" cols="145" rows="6" tabindex="57" disabled>'+$("#<?php echo $this->campoSeguro('reajusteArrendamiento_hidden') ?>").val()+'</textarea>' +
                            '</fieldset>' +
                            '<div class="campoCuadroLista anchoColumna3">' +
                            '<div style="float:left; width:213px">' +
                            '<label for="diasHabilesAdmin">Días Hábiles Administración: </label>' +
                            '<span class="texto_rojo texto_pie">* </span>' +
                            '</div>' +
                            '<input type=text class="" id=diasHabilesAdmin size="40"  maxlength="2" value="'+$("#<?php echo $this->campoSeguro('diasHabilesAdmin_hidden') ?>").val() + '" disabled/>' +
                            '</div>' +
                            '<div class="campoCuadroLista anchoColumna3">' +
                            '<div style="float:left; width:213px">' +
                            '<label for="valorAdmin">Valor Administración: </label>' +
                            '<span class="texto_rojo texto_pie">* </span>' +
                            '</div>' +
                            '<input type=text class="" id=valorAdmin size="40"  maxlength="10" value="'+parseInt($("#<?php echo $this->campoSeguro('valorAdmin_hidden') ?>").val()) + '" disabled/>' +
                            '</div>' +
                            '<div class="campoCuadroLista anchoColumna3">' +
                            '<div style="float:left; width:213px">' +
                            '<label for="diasHabilesEntrega">Días Hábiles Entrega Inmueble por Parte del Arrendador: </label>' +
                            '<span class="texto_rojo texto_pie">* </span>' +
                            '</div>' +
                            '<input type=text class="" id=diasHabilesEntrega size="40"  maxlength="3" value="'+$("#<?php echo $this->campoSeguro('diasHabilesEntrega_hidden') ?>").val() + '" disabled/>' +
                            '</div>'
                });
              
            }

                
                  var seleccion= Number($("#<?php echo $this->campoSeguro('contadorSelect_hidden') ?>").val());
                 
                 
                    for(var j=0;j<=(seleccion);j++){
                        
                        
                        if(j<seleccion){
                          
                         
                         $("#amparo" + (j)).attr('disabled', true);
                         $("#porcentajeamparo" + (j)).attr('readonly', true);
                         $("#valoramparo" + (j)).attr('readonly', true);
                         
                         
                        }
                            
                        $("#amparo" + (j)).width(300);
                        $("#amparo" + (j)).select2();
                        
                         
                     
                        
                    }
                    i=j-1;
                    numeracion=j;
                
            





            if (currentIndex === 0 && ($("#<?php echo $this->campoSeguro('tipo_contrato') ?>").val()) !== '5' && $("#ventanaA").find('section').length !== 9)
            {


                $("#ventanaA").steps("remove", 1, {
                    title: "Step Title",
                    content: "<p>Step Body</p>"
                });
             
            }

            if ($resultado) {
                return true;
            } else {
                return false;
            }

        },
        
        labels: {
            cancel: "Cancelar",
            current: "Paso Siguiente :",
            pagination: "Paginación",
            finish: "Regresar",
            next: "Siquiente",
            previous: "Atras",
            loading: "Cargando ..."
        }

    });

//----------------------------Fin Configuracion Paso a Paso--------------------------------------


    $(function () {

        $("#<?php echo $this->campoSeguro('vigencia_contrato') ?>").keyup(function () {
            $('#<?php echo $this->campoSeguro('vigencia_contrato') ?>').val($('#<?php echo $this->campoSeguro('vigencia_contrato') ?>').val());

        });

        $("#<?php echo $this->campoSeguro('vigencia_contrato') ?>").autocomplete({
            minChars: 1,
            serviceUrl: '<?php echo $urlVigenciaContrato; ?>',
            onSelect: function (suggestion) {

                $("#<?php echo $this->campoSeguro('id_contrato') ?>").val(suggestion.data);
            }

        });



        $("#<?php echo $this->campoSeguro('contratista') ?>").autocomplete({
            minChars: 2,
            serviceUrl: '<?php echo $urlContratista; ?>',
            onSelect: function (suggestion) {

                $("#<?php echo $this->campoSeguro('id_contratista') ?>").val(suggestion.data);
            }

        });



    });

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
                    objetoSPAN.innerHTML = "Información del Contratista :<br><br><br>" + "Numero del Contratista: " + data[13] + " <br><br> "
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

    function ELiminarRP(id) {
        $.ajax({
            url: "<?php echo $inactivarRp ?>",
            dataType: "json",
            data: {id: id},
            success: function (data) {
                if (data[0] != " ") {

                    if (data == true) {
                        window.location.reload()
                    }

                }


            }

        });
    }
    ;
    function ConsultarRP(id) {
        $.ajax({
            url: "<?php echo $consultaInRP ?>",
            dataType: "json",
            data: {id: id},
            success: function (data) {
                if (data[0] != " ") {

                    var rubros = "";
                    var valorTotal = 0;
                    for (i = 0; i < data.length; i++) {
                        rubros = rubros + "---| Rubro: " + data[i][2] + " - Valor: " + new Intl.NumberFormat(["ban", "id"]).format(data[i][3]) + "\n";
                        valorTotal = valorTotal + parseFloat(data[i][3]);
                    }

                    $("#<?php echo $this->campoSeguro('inforegistroPresupuestal') ?>").val(
                            "Número de Registro Presupuestal: " + data[0][0] + "\n" +
                            "Rubro(s) Asociado(os): \n " + rubros +
                            "Valor del Registro Presupuestal: " + new Intl.NumberFormat(["ban", "id"]).format(valorTotal) + ""
                            );

                }


            }

        });
    }
    ;

    //--------------Inicio JavaScript y Ajax Registro por Disponibilidad ---------------------------------------------------------------------------------------------    

    $("#<?php echo $this->campoSeguro('numero_disponibilidad_contrato') ?>").change(function () {

        if ($("#<?php echo $this->campoSeguro('numero_disponibilidad_contrato') ?>").val() != '') {
            consultarRegistroPorDisponibilidad();
        } else {
            $("#<?php echo $this->campoSeguro('registro_presupuestal') ?>").attr('disabled', '');
        }

    });

    function consultarRegistroPorDisponibilidad(elem, request, response) {
        $.ajax({
            url: "<?php echo $urlRegistroPresupuestalporDisponibilidad ?>",
            dataType: "json",
            data: {cdp: $("#<?php echo $this->campoSeguro('numero_disponibilidad_contrato') ?>").val(),
                unidad: $("#<?php echo $this->campoSeguro('unidad_ejecutora_hidden') ?>").val(),
                rpseleccion: $("#<?php echo $this->campoSeguro('lista_vigencia_rp') ?>").val()
            },
            success: function (data) {

                if (data[0] != " ") {

                    $("#<?php echo $this->campoSeguro('registro_presupuestal') ?>").html('');
                    $("<option value=''>Seleccione  ....</option>").appendTo("#<?php echo $this->campoSeguro('registro_presupuestal') ?>");
                    $.each(data, function (indice, valor) {

                        $("<option value='" + data[ indice ].VALOR + "'>" + data[ indice ].INFORMACION + "</option>").appendTo("#<?php echo $this->campoSeguro('registro_presupuestal') ?>");

                    });

                    $("#<?php echo $this->campoSeguro('registro_presupuestal') ?>").removeAttr('disabled');

                    $('#<?php echo $this->campoSeguro('registro_presupuestal') ?>').width(400);
                    $("#<?php echo $this->campoSeguro('registro_presupuestal') ?>").select2();



                }


            }

        });
    }
    ;


    $("#<?php echo $this->campoSeguro('registro_presupuestal') ?>").change(function () {

        if ($("#<?php echo $this->campoSeguro('registro_presupuestal') ?>").val() != '') {
            consultarInfoRegistroPresupuestal();
        } else {

        }

    });

    function consultarInfoRegistroPresupuestal(elem, request, response) {
        $.ajax({
            url: "<?php echo $urlInfoRegistroPresupuestalporDisponibilidad ?>",
            dataType: "json",
            data: {cdp: $("#<?php echo $this->campoSeguro('numero_disponibilidad_contrato') ?>").val(),
                unidad: $("#<?php echo $this->campoSeguro('unidad_ejecutora_hidden') ?>").val(),
                rp: $("#<?php echo $this->campoSeguro('registro_presupuestal') ?>").val()},
            success: function (data) {
                if (data[0] != " ") {
                    var rubros = "";
                    var valorTotal = 0;
                    for (i = 0; i < data.length; i++) {
                        rubros = rubros + "---| Rubro: " + data[i][2] + " - Valor: " + new Intl.NumberFormat(["ban", "id"]).format(data[i][3]) + "\n";
                        valorTotal = valorTotal + parseFloat(data[i][3]);
                    }

                    $("#<?php echo $this->campoSeguro('inforegistroPresupuestal') ?>").val(
                            "Número de Registro Presupuestal: " + data[0][0] + "\n" +
                            "Rubro(s) Asociado(os): \n " + rubros +
                            "Valor del Registro Presupuestal: " + new Intl.NumberFormat(["ban", "id"]).format(valorTotal) + ""
                            );

                    $("#<?php echo $this->campoSeguro('vigencia_rp_hidden') ?>").val(data[0][4]);

                }


            }

        });
    }
    ;

    function GenerarDocumento(NumeroContrato) {
        $.ajax({
            url: "<?php echo $urlDocumento ?>",
            dataType: "json",
            data: {numerocontrato: NumeroContrato, fuentedocumento: $("#fuentedocumento").val()},
            success: function (data) {
                window.open(data, "_target")
            }

        });

    }
    ;


//--------------Fin JavaScript y Convenios x Vigenca --------------------------------------------------------------------------------------------------  
    function VerAmparos(idDiv) {
        $("#amparodiv" + idDiv).css('display', 'block');
    }
    function CerrarAmparos(idDiv) {
        $("#amparodiv" + idDiv).css('display', 'none');
    }
    function VerMensajeATC() {
        $("#mensajeATC").css('display', 'block');
    }
    function CerrarMensajeATC() {
        $("#mensajeATC").css('display', 'none');
    }

</script>
