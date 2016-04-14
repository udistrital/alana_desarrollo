<?php
/**
 *
 * Los datos del bloque se encuentran en el arreglo $esteBloque.
 */
// URL base
$url = $this->miConfigurador->getVariableConfiguracion("host");
$url .= $this->miConfigurador->getVariableConfiguracion("site");
$url .= "/index.php?";
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");

// Variables
$cadenaACodificar16 = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificar16 .= "&procesarAjax=true";
$cadenaACodificar16 .= "&action=index.php";
$cadenaACodificar16 .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificar16 .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificar16 .= $cadenaACodificar16 . "&funcion=consultarPerfil";
if (isset($_REQUEST['id_usuario'])) {
    $cadenaACodificar16 .= "&id_usuario=" . $_REQUEST['id_usuario'];
}
$cadenaACodificar16 .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables

$cadena16 = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar16, $enlace);

// URL definitiva
$urlFinal16 = $url . $cadena16;





$cadenaACodificar17 = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificar17 .= "&procesarAjax=true";
$cadenaACodificar17 .= "&action=index.php";
$cadenaACodificar17 .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificar17 .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificar17 .= $cadenaACodificar16 . "&funcion=consultaDependencia";
$cadenaACodificar17 .= "&tiempo=" . $_REQUEST ['tiempo'];
// Codificar las variables

$cadena17 = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar17, $enlace);
// URL definitiva
$urlFinal17 = $url . $cadena17;
?>

<script type='text/javascript'>



    function marcar(obj) {
        elem = obj.elements;
        for (i = 0; i < elem.length; i++)
            if (elem[i].type == "checkbox")
                elem[i].checked = true;
    }

    function desmarcar(obj) {
        elem = obj.elements;
        for (i = 0; i < elem.length; i++)
            if (elem[i].type == "checkbox")
                elem[i].checked = false;
    }



    function consultarPerfil(elem, request, response) {
        $.ajax({
            url: "<?php echo $urlFinal16 ?>",
            dataType: "json",
            data: {valor: $("#<?php echo $this->campoSeguro('subsistema') ?>").val()},
            success: function (data) {
                if (data[0] != " ") {
                    $("#<?php echo $this->campoSeguro('perfil') ?>").html('');
                    $("<option value=''>Seleccione  ....</option>").appendTo("#<?php echo $this->campoSeguro('perfil') ?>");
                    $.each(data, function (indice, valor) {
                        $("<option value='" + data[ indice ].rol_id + "'>" + data[ indice ].rol_alias + "</option>").appendTo("#<?php echo $this->campoSeguro('perfil') ?>");
                    });
                    $("#<?php echo $this->campoSeguro('perfil') ?>").removeAttr('disabled');
                    $('#<?php echo $this->campoSeguro('perfil') ?>').width(210);
                    $("#<?php echo $this->campoSeguro('perfil') ?>").select2();
                }
            }

        });
    }
    ;

    $(function () {
        $("#<?php echo $this->campoSeguro('subsistema') ?>").change(function () {
            if ($("#<?php echo $this->campoSeguro('subsistema') ?>").val() != '') {
                
                consultarPerfil();
            } else {
                $("#<?php echo $this->campoSeguro('perfil') ?>").attr('disabled', '');
            }
        });
    });
    



      function consultaDependencia(elem, request, response) {
     
        $.ajax({
            url: "<?php echo $urlFinal17 ?>",
            dataType: "json",
            data: {valor: $("#<?php echo $this->campoSeguro('sede') ?>").val()},
            success: function (data) {
                if (data[0] != " ") {
                    $("#<?php echo $this->campoSeguro('dependencia') ?>").html('');
                    $("<option value=''>Seleccione  ....</option>").appendTo("#<?php echo $this->campoSeguro('dependencia') ?>");
                    $.each(data, function (indice, valor) {
                        $("<option value='" + data[ indice ].id + "'>" + data[ indice ].nombre + "</option>").appendTo("#<?php echo $this->campoSeguro('dependencia') ?>");
                    });
                    $("#<?php echo $this->campoSeguro('dependencia') ?>").removeAttr('disabled');
                    $('#<?php echo $this->campoSeguro('dependencia') ?>').width(210);
                    $("#<?php echo $this->campoSeguro('dependencia') ?>").select2();
                }
            }

        });
    }
    ;

    $(function () {
        $("#<?php echo $this->campoSeguro('sede') ?>").change(function () {
            if ($("#<?php echo $this->campoSeguro('sede') ?>").val() != '') {
                consultaDependencia();
            } else {
                $("#<?php echo $this->campoSeguro('dependencia') ?>").attr('disabled', '');
            }
        });
    });



    
</script>