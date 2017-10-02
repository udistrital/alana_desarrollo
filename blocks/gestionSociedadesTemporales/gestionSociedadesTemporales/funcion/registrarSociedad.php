<?php

namespace gestionSociedadesTemporales\gestionSociedadesTemporales\funcion;

use gestionSociedadesTemporales\gestionSociedadesTemporales\funcion\redireccion;

include_once ('redireccionar.php');
if (!isset($GLOBALS ["autorizado"])) {
    include ("../index.php");
    exit();
}

class RegistradorOrden {

    var $miConfigurador;
    var $lenguaje;
    var $miFormulario;
    var $miFuncion;
    var $miSql;
    var $conexion;

    function __construct($lenguaje, $sql, $funcion) {
        $this->miConfigurador = \Configurador::singleton();
        $this->miConfigurador->fabricaConexiones->setRecursoDB('principal');
        $this->lenguaje = $lenguaje;
        $this->miSql = $sql;
        $this->miFuncion = $funcion;
    }

    function procesarFormulario() {

        $conexionAgora = "agora";
        $esteRecursoDBAgora = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexionAgora);
        $SQLsAgora = [];


        if ($_REQUEST ['clase_sociedad'] == "31") {
            $tipopersona = "UNION TEMPORAL";
        } else {
            $tipopersona = "CONSORCIO";
        }

        $sociedad_temporal = $_REQUEST['identificacion_clase_contratista'];
        $nombre_sociedad_temporal = $_REQUEST['nombre_Consorcio_union'];
        $representante = explode("-", $_REQUEST['representante_sociedad']);
        $suplente = explode("-", $_REQUEST['representante_suplente_sociedad']);
        $datos_proveedor = array(
            'tipopersona' => $tipopersona,
            'num_documento' => $sociedad_temporal,
            'id_ciudad_contacto' => $_REQUEST['sociedadCiudad'],
            'correo' => $_REQUEST['correo_sociedad_temporal'],
            'web' => $_REQUEST['sitio_web_temporal'],
            'estado' => 1,
            'anexorut' => "NO APLICA",
            'direccion' => "NO APLICA",
            'tipo_cuenta_bancaria' => $_REQUEST['tipoCuenta'],
            'num_cuenta_bancaria' => $_REQUEST['numeroCuenta'],
            'id_entidad_bancaria' => $_REQUEST['entidadBancaria'],
            'mensaje_titulo' => $_REQUEST['mensaje_titulo'],
            'usuario' => $_REQUEST['usuario'],
            'arreglo' => $_REQUEST['arreglo'],
            'fecha_registro' => date('Y-m-d' . ' - ' . 'h:i:s A'),
            'fecha_ultima_modificacion' => date('Y-m-d' . ' - ' . 'h:i:s A'),
            'nom_proveedor' => strtoupper($nombre_sociedad_temporal),
            'telefono' => $_REQUEST['telefono_sociedad']
        );
        $SqlSociedadProveedor['sql'] = $this->miSql->getCadenaSql('registrar_proveedor_sociedad', $datos_proveedor);
        $SqlSociedadProveedor['descripcion'] = 'registroproveedorsociedad';
        $SqlSociedadProveedor['valores'] = $datos_proveedor;
        array_push($SQLsAgora, $SqlSociedadProveedor);
        $datos_sociedad_temporal = array(
            'identificacion' => "currval('agora.prov_proveedor_info_id_proveedor_seq')",
            'documento_representante' => substr($representante[0], 1, -1),
            'documento_suplente' => substr($suplente[0], 1, -1),
            'digito_verificacion' => $_REQUEST ['digito_verificacion'],
        );

        $SqlSociedadTemporal['sql'] = $this->miSql->getCadenaSql('registrar_sociedad_temporal', $datos_sociedad_temporal);
        $SqlSociedadTemporal['descripcion'] = 'registrosociedad';
        $SqlSociedadTemporal['valores'] = $datos_sociedad_temporal;
        array_push($SQLsAgora, $SqlSociedadTemporal);

        for ($i = 0; $i < count($_POST); $i++) {
            if (isset($_POST["porcentaje$i"])) {
                $datos_participantes = array(
                    'id_sociedad' => "currval('agora.prov_proveedor_info_id_proveedor_seq')",
                    'documento_contratista' => substr(explode("-", $_POST["participante$i"])[0], 1, -1),
                    'porcentaje_participacion' => $_POST["porcentaje$i"],
                );
                $SqlSociedadContratista['sql'] = $this->miSql->getCadenaSql('registrar_participante_sociedad', $datos_participantes);
                $SqlSociedadContratista['descripcion'] = 'registroParticipante';
                $SqlSociedadContratista['valores'] = $datos_participantes;
                array_push($SQLsAgora, $SqlSociedadContratista);
            }
        }

        $SqlTelefonoProveedor['sql'] = $this->miSql->getCadenaSql('registrar_telefono', $datos_proveedor);
        $SqlTelefonoProveedor['descripcion'] = 'registrotelefonosociedad';
        $SqlTelefonoProveedor['valores'] = $datos_proveedor;
        array_push($SQLsAgora, $SqlTelefonoProveedor);

        $SqlVicularTelefonoProveedor['sql'] = $this->miSql->getCadenaSql('vincular_telefono_sociedad');
        $SqlVicularTelefonoProveedor['descripcion'] = 'vinculaTelefonoSociedad';
        $SqlVicularTelefonoProveedor['valores'] = "";
        array_push($SQLsAgora, $SqlVicularTelefonoProveedor);

        $trans_Registro_Sociedad = $esteRecursoDBAgora->transaccion($SQLsAgora);
        if ($trans_Registro_Sociedad != false) {
            redireccion::redireccionar('registroSociedad', $datos_proveedor);
            exit();
        } else {

            redireccion::redireccionar('noregistroSociedad', $datos_proveedor);
            exit();
        }
    }

    function resetForm() {
        foreach ($_REQUEST as $clave => $valor) {

            if ($clave != 'pagina' && $clave != 'development' && $clave != 'jquery' && $clave != 'tiempo') {
                unset($_REQUEST [$clave]);
            }
        }
    }

}

$miRegistrador = new RegistradorOrden($this->lenguaje, $this->sql, $this->funcion);

$resultado = $miRegistrador->procesarFormulario();
?>