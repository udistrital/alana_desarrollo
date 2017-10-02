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
$cadenaACodificarIdentificacionSociedad = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificarIdentificacionSociedad .= "&procesarAjax=true";
$cadenaACodificarIdentificacionSociedad .= "&action=index.php";
$cadenaACodificarIdentificacionSociedad .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificarIdentificacionSociedad .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificarIdentificacionSociedad .= "&funcion=consultaIdentificacionSociedad";
$cadenaACodificarIdentificacionSociedad .= "&usuario=" . $_REQUEST['usuario'];
$cadenaACodificarIdentificacionSociedad .="&tiempo=" . $_REQUEST['tiempo'];


// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificarIdentificacionSociedad, $enlace);

// URL definitiva
$urlIdentificacionSociedad = $url . $cadena;



//Variables
$cadenaACodificarCiudadSociedad = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificarCiudadSociedad .= "&procesarAjax=true";
$cadenaACodificarCiudadSociedad .= "&action=index.php";
$cadenaACodificarCiudadSociedad .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificarCiudadSociedad .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificarCiudadSociedad .= $cadenaACodificarCiudadSociedad . "&funcion=consultarCiudadAjax";
$cadenaACodificarCiudadSociedad .= "&tiempo=" . $_REQUEST ['tiempo'];
// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificarCiudadSociedad, $enlace);
// URL definitiva
$urlCiudadSociedad = $url . $cadenaACodificarCiudadSociedad;



$cadenaRepresentantes = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaRepresentantes .= "&procesarAjax=true";
$cadenaRepresentantes .= "&action=index.php";
$cadenaRepresentantes .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaRepresentantes .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaRepresentantes .= $cadenaRepresentantes . "&funcion=ObtenerRepresentantes";
$cadenaRepresentantes .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadenaRepresentantes = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaRepresentantes, $enlace);

// URL definitiva
$urlRepresentantes = $url . $cadenaRepresentantes;


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
?>
<script type='text/javascript'>
    $(function () {

        //------Identificacion Sociedad Busqueda--------------------------

        $("#<?php echo $this->campoSeguro('identificacion_sociedad') ?>").autocomplete({
            minChars: 1,
            serviceUrl: '<?php echo $urlIdentificacionSociedad; ?>',
            onSelect: function (suggestion) {

                $("#<?php echo $this->campoSeguro('id_contrato') ?>").val(suggestion.data);
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
                    objetoSPAN.innerHTML = "Información del Contratista :<br><br><br>" + "Numero de Convenio: " + data[13] + " <br><br> "
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
                    if (data[7] = "t") {
                        estado = "Activo";
                    } else {
                        estado = "Inactivo";
                    }
                    var participantes = "Participantes: <br><br>";
                    for (i = 0; i < data[1].length; i++) {
                        participantes = participantes + "Nombre: " + data[1][i][2] + " | Porcentaje de Participacion:  " + data[1][i][3] * 100 + "%<br>";
                    }

                    var objetoSPAN = document.getElementById('spandid');
                    objetoSPAN.innerHTML = "Información de la Sociedad Temporal :<br><br><br>" + "Nombre de Sociedad: " + data[0][2] + " <br><br> "
                            + "Documento: " + data[0][0] + " <br><br>"
                            + "Tipo de Sociedad: " + data[0][1] + " <br><br>"
                            + "Digito de Verificacion: " + data[0][3] + " <br><br>"
                            + "Representante: " + data[0][4] + " <br><br>"
                            + "Suplente: " + data[0][5] + " <br><br>"
                            + "Fecha Registro: " + data[0][6] + " <br><br>"
                            + "Estado: " + estado + " <br><br>"
                            + participantes;



                    $("#ventanaEmergenteContratista").dialog('option', 'title', 'Sociedad Temporal');
                    $("#ventanaEmergenteContratista").dialog("open");


                }
            }

        });

    }


    //------Calculo Digito Verificacion-------------------------

    $("#<?php echo $this->campoSeguro('identificacion_clase_contratista') ?>").keyup(function () {
        calcularDigitoCedulaRepre($('#<?php echo $this->campoSeguro('identificacion_clase_contratista') ?>').val());

    });


    function calcularDigitoCedulaRepre(cadenaCedula) {

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
            $("#<?php echo $this->campoSeguro('digito_verificacion') ?>").val(digito_verificacion);
        }
    }
    ;


    // Departamento y Ciudad de Contacto Sociedad  


    //-------------------------------- Inicio Ajax Ciudades por Depto.---------------------------------

    $("#<?php echo $this->campoSeguro('sociedadDepartamento') ?>").change(function () {
        if ($("#<?php echo $this->campoSeguro('sociedadDepartamento') ?>").val() != '') {
            consultarCiudad();
        } else {
            $("#<?php echo $this->campoSeguro('sociedadCiudad') ?>").attr('disabled', '');
        }
    });
    function consultarCiudad(elem, request, response) {
        $.ajax({
            url: "<?php echo $urlCiudadSociedad ?>",
            dataType: "json",
            data: {valor: $("#<?php echo $this->campoSeguro('sociedadDepartamento') ?>").val()},
            success: function (data) {
                if (data[0] != " ") {
                    $("#<?php echo $this->campoSeguro('sociedadCiudad') ?>").html('');
                    $("<option value=''>Seleccione  ....</option>").appendTo("#<?php echo $this->campoSeguro('sociedadCiudad') ?>");
                    $.each(data, function (indice, valor) {
                        $("<option value='" + data[ indice ].id_ciudad + "'>" + data[ indice ].nombreciudad + "</option>").appendTo("#<?php echo $this->campoSeguro('sociedadCiudad') ?>");

                    });

                    $("#<?php echo $this->campoSeguro('sociedadCiudad') ?>").removeAttr('disabled');
                    $("#<?php echo $this->campoSeguro('sociedadCiudad') ?>").select2();
                    $("#<?php echo $this->campoSeguro('sociedadCiudad') ?>").removeClass("validate[required]");

                }

            }

        });
    }
    ;


    //-------------Representante y Representante Suplente .-----------------------------------

    $("#<?php echo $this->campoSeguro('representante_sociedad') ?>").autocomplete({
        minChars: 2,
        serviceUrl: '<?php echo $urlRepresentantes; ?>',
    });


    $("#<?php echo $this->campoSeguro('representante_suplente_sociedad') ?>").autocomplete({
        minChars: 2,
        serviceUrl: '<?php echo $urlRepresentantes; ?>',
    });

    $("#<?php echo $this->campoSeguro('representante_sociedad') ?>").change(function () {
        $('#<?php echo $this->campoSeguro('id_representante_sociedad') ?>').val($('#<?php echo $this->campoSeguro('representante_sociedad') ?>').val());
    });
    $("#<?php echo $this->campoSeguro('representante_suplente_sociedad') ?>").change(function () {
        $('#<?php echo $this->campoSeguro('id_representante_sociedad') ?>').val($('#<?php echo $this->campoSeguro('representante_suplente_sociedad') ?>').val());
    });



//Gestion Participantes editar
    $(document).ready(function () {


        if ($("#<?php echo $this->campoSeguro('banderaFormulario') ?>").val() == 'editarSociedad') {

            var i = parseFloat($("#<?php echo $this->campoSeguro('contador_filas') ?>").val());
           
            for (k = 0; k < i; k++) {
                $('#participante' + k).autocomplete({
                    minChars: 2,
                    serviceUrl: '<?php echo $urlParticipante; ?>',
                });
            }
            $("#add_row").click(function () {

                $resultado = $("#registrarContrato").validationEngine("validate");
                $resultado = true;
                if ($resultado) {

                    var anteriorRegistro = i - 1;
                    if ($('#porcentaje' + anteriorRegistro).val() <= 0) {
                        $('#estadoRegistro').val("Debe Ingresar un Porcentaje Correcto.");
                        $('#porcentaje' + anteriorRegistro).val("");
                    } else {

                        var anteriorRegistro = i - 1;
                        var valor = parseFloat($('#porcentaje' + anteriorRegistro).val());
                        if ((parseFloat($('#acumuladoPorcentajes').val()) + valor) <= 100) {

                            if ((parseFloat($('#acumuladoPorcentajes').val()) + valor) == 100) {
                                $('#estadoRegistro').val("La suma de los porcentajes cubre el 100 por ciento de participacion.");

                                $('#participante' + (i - 1)).attr('readonly', true);
                                $('#porcentaje' + (i - 1)).attr('readonly', true);
                                $('#div-color').css('background-color', '#fffff');
                                $("#add_row").hide();
                                var acumulado = parseFloat($('#acumuladoPorcentajes').val()) + valor;
                                $('#acumuladoPorcentajes').val(acumulado);

                            } else {

                                $('#addr' + i).html("<td>" + (i + 1) + "</td><td><input id='participante" + i + "' name='participante" + i + "' type='text' placeholder='Participante'  class='form-control  validate[required]'></td>\n\
                                        <td><input id='porcentaje" + i + "'  name='porcentaje" + i + "' type='text' placeholder='Porcentaje(%)-> 10%'   class='form-control input-md validate[required] custom[number]' ></td>\n\ ");
                                $('#tab_participante').append('<tr id="addr' + (i + 1) + '"></tr>');

                                $('#participante' + i).autocomplete({
                                    minChars: 2,
                                    serviceUrl: '<?php echo $urlParticipante; ?>',
                                });


                                if (i == 1) {

                                    $('#participante0').attr('readonly', true);
                                    $('#porcentaje0').attr('readonly', true);
                                    var acumulado = parseFloat($('#porcentaje0').val());
                                    $('#acumuladoPorcentajes').val(acumulado);
                                } else {
                                    var temp = i - 1;
                                    $('#participante' + temp).attr('readonly', true);
                                    $('#porcentaje' + temp).attr('readonly', true);
                                    var acumulado = parseFloat($('#acumuladoPorcentajes').val()) + parseFloat($('#porcentaje' + temp).val());
                                    $('#acumuladoPorcentajes').val(acumulado);
                                }
                                $("#<?php echo $this->campoSeguro('id_tabla') ?>").val(i);
                                $('#div-color').css('background-color', '#d6effc');
                                i++;
                                $("#delete_row").show();
                                return true;
                            }
                            $("#delete_row").show();
                        } else {
                            $('#estadoRegistro').val("La suma de los porcentajes no debe ser superior a 100.");
                        }

                    }
                } else {
                    return false;
                }


            });
            $("#delete_row").click(function () {
                if (i > 1) {
                    if (parseFloat($('#acumuladoPorcentajes').val()) != 100) {
                        $('#div-color').css('background-color', '#d6effc');
                        $("#add_row").show();
                        $('#participante' + (i - 2)).attr('readonly', false);
                        $('#porcentaje' + (i - 2)).attr('readonly', false);
                        $("#addr" + (i - 1)).html('');
                        var acumulado = parseFloat($('#acumuladoPorcentajes').val()) - parseFloat($('#porcentaje' + (i - 2)).val());
                        $('#acumuladoPorcentajes').val(acumulado);
                        i--;
                    } else {
                        $('#div-color').css('background-color', '#d6effc');
                        $('#participante' + (i - 1)).attr('readonly', false);
                        $('#porcentaje' + (i - 1)).attr('readonly', false);
                        var acumulado = parseFloat($('#acumuladoPorcentajes').val()) - parseFloat($('#porcentaje' + (i - 1)).val());
                        $('#acumuladoPorcentajes').val(acumulado);
                        $("#add_row").show();
                    }

                    $('#estadoRegistro').val("");

                }
                if (i == 1) {
                    $('#participante0').attr('readonly', false);
                    $('#porcentaje0').attr('readonly', false);
                    $('#estadoRegistro').val("");
                    $("#add_row").show();
                    $("#delete_row").hide();

                }
            });


        } else {

            $('#participante0').autocomplete({
                minChars: 2,
                serviceUrl: '<?php echo $urlParticipante; ?>',
                formatItem: function (item, position, length) {
                    return item.data;
                }

            });
            var i = 1;

            $("#delete_row").hide();

            $("#add_row").click(function () {

                $resultado = $("#registrarContrato").validationEngine("validate");
                if ($resultado) {

                    var anteriorRegistro = i - 1;
                    if ($('#porcentaje' + anteriorRegistro).val() <= 0) {
                        $('#estadoRegistro').val("Debe Ingresar un Porcentaje Correcto.");
                        $('#porcentaje' + anteriorRegistro).val("");
                    } else {

                        var anteriorRegistro = i - 1;
                        var valor = parseFloat($('#porcentaje' + anteriorRegistro).val());
                        if ((parseFloat($('#acumuladoPorcentajes').val()) + valor) <= 100) {

                            if ((parseFloat($('#acumuladoPorcentajes').val()) + valor) == 100) {
                                $('#estadoRegistro').val("La suma de los porcentajes cubre el 100 por ciento de participacion.");

                                $('#participante' + (i - 1)).attr('readonly', true);
                                $('#porcentaje' + (i - 1)).attr('readonly', true);
                                $('#div-color').css('background-color', '#fffff');
                                $("#add_row").hide();
                                var acumulado = parseFloat($('#acumuladoPorcentajes').val()) + valor;
                                $('#acumuladoPorcentajes').val(acumulado);

                            } else {

                                $('#addr' + i).html("<td>" + (i + 1) + "</td><td><input id='participante" + i + "' name='participante" + i + "' type='text' placeholder='Participante'  class='form-control  validate[required]'></td>\n\
                                        <td><input id='porcentaje" + i + "'  name='porcentaje" + i + "' type='text' placeholder='Porcentaje(%)-> 10%'   class='form-control input-md validate[required] custom[number]' ></td>\n\ ");
                                $('#tab_participante').append('<tr id="addr' + (i + 1) + '"></tr>');

                                $('#participante' + i).autocomplete({
                                    minChars: 2,
                                    serviceUrl: '<?php echo $urlParticipante; ?>',
                                });


                                if (i == 1) {

                                    $('#participante0').attr('readonly', true);
                                    $('#porcentaje0').attr('readonly', true);
                                    var acumulado = parseFloat($('#porcentaje0').val());
                                    $('#acumuladoPorcentajes').val(acumulado);
                                } else {
                                    var temp = i - 1;
                                    $('#participante' + temp).attr('readonly', true);
                                    $('#porcentaje' + temp).attr('readonly', true);
                                    var acumulado = parseFloat($('#acumuladoPorcentajes').val()) + parseFloat($('#porcentaje' + temp).val());
                                    $('#acumuladoPorcentajes').val(acumulado);
                                }
                                $("#<?php echo $this->campoSeguro('id_tabla') ?>").val(i);
                                $('#div-color').css('background-color', '#d6effc');
                                $("#delete_row").show();

                                i++;
                                return true;
                            }

                            $("#delete_row").show();
                        } else {
                            $('#estadoRegistro').val("La suma de los porcentajes no debe ser superior a 100.");
                        }

                    }
                } else {
                    return false;
                }


            });
            $("#delete_row").click(function () {
                if (i > 1) {
                    if (parseFloat($('#acumuladoPorcentajes').val()) != 100) {
                        $('#div-color').css('background-color', '#d6effc');
                        $("#add_row").show();
                        $('#participante' + (i - 2)).attr('readonly', false);
                        $('#porcentaje' + (i - 2)).attr('readonly', false);
                        $("#addr" + (i - 1)).html('');
                        var acumulado = parseFloat($('#acumuladoPorcentajes').val()) - parseFloat($('#porcentaje' + (i - 2)).val());
                        $('#acumuladoPorcentajes').val(acumulado);
                        i--;
                    } else {
                        $('#div-color').css('background-color', '#d6effc');
                        $('#participante' + (i - 1)).attr('readonly', false);
                        $('#porcentaje' + (i - 1)).attr('readonly', false);
                        var acumulado = parseFloat($('#acumuladoPorcentajes').val()) - parseFloat($('#porcentaje' + (i - 1)).val());
                        $('#acumuladoPorcentajes').val(acumulado);
                        $("#add_row").show();
                    }

                    $('#estadoRegistro').val("");

                }
                if (i == 1) {
                    $('#participante0').attr('readonly', false);
                    $('#porcentaje0').attr('readonly', false);
                    $('#estadoRegistro').val("");
                    $("#add_row").show();
                    $("#delete_row").hide();

                }
            });



        }


    });


</script>