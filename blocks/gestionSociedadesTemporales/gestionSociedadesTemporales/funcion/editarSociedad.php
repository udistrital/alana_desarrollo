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
            'fecha_ultima_modificacion' => date('Y-m-d' . ' - ' . 'h:i:s A'),
            'nom_proveedor' => strtoupper($nombre_sociedad_temporal),
            'telefono' => $_REQUEST['telefono_sociedad'],
            'id_sociedad' => $_REQUEST['id_sociedad'],
            'id_sociedad_proveedor' => $_REQUEST['id_sociedad_proveedor']
        );

        $SqlactualizarSociedadTemporal['sql'] = $this->miSql->getCadenaSql('actualizar_proveedor_sociedad_temporal', $datos_proveedor);
        $SqlactualizarSociedadTemporal['descripcion'] = 'actualizarproveedorsociedad';
        $SqlactualizarSociedadTemporal['valores'] = $datos_proveedor;
        array_push($SQLsAgora, $SqlactualizarSociedadTemporal);

        $datos_sociedad_temporal = array(
            'id_sociedad' => $_REQUEST['id_sociedad'],
            'documento_representante' => substr($representante[0], 1, -1),
            'documento_suplente' => substr($suplente[0], 1, -1),
            'digito_verificacion' => $_REQUEST ['digito_verificacion'],
        );

        $SqlSociedadTemporal['sql'] = $this->miSql->getCadenaSql('actualizar_sociedad_temporal', $datos_sociedad_temporal);
        $SqlSociedadTemporal['descripcion'] = 'actualizarsociedad';
        $SqlSociedadTemporal['valores'] = $datos_sociedad_temporal;
        array_push($SQLsAgora, $SqlSociedadTemporal);

        $SqlActualizaTelefono['sql'] = $this->miSql->getCadenaSql('actualizar_telefono_sociedad', $datos_proveedor);
        $SqlActualizaTelefono['descripcion'] = 'actualizartelefono';
        $SqlActualizaTelefono['valores'] = $datos_proveedor;
        array_push($SQLsAgora, $SqlActualizaTelefono);

        $SqlEliminarParticipantesActuales['sql'] = $this->miSql->getCadenaSql('eliminar_participantes_actuales', $_REQUEST['id_sociedad_proveedor']);
        $SqlEliminarParticipantesActuales['descripcion'] = 'eliminarparticipantes';
        $SqlEliminarParticipantesActuales['valores'] = $_REQUEST['id_sociedad_proveedor'];
        array_push($SQLsAgora, $SqlEliminarParticipantesActuales);
        for ($i = 0; $i < count($_POST); $i++) {
            if (isset($_POST["porcentaje$i"])) {
                $datos_participantes = array(
                    'id_sociedad' => $_REQUEST['id_sociedad_proveedor'],
                    'documento_contratista' => substr(explode("-", $_POST["participante$i"])[0], 1, -1),
                    'porcentaje_participacion' => $_POST["porcentaje$i"],
                );
                $SqlSociedadContratista['sql'] = $this->miSql->getCadenaSql('registrar_participante_sociedad', $datos_participantes);
                $SqlSociedadContratista['descripcion'] = 'registrarparticipante';
                $SqlSociedadContratista['valores'] = $datos_participantes;
                array_push($SQLsAgora, $SqlSociedadContratista);
            }
        }
        $trans_Edito_Sociedad = $esteRecursoDBAgora->transaccion($SQLsAgora);
        if ($trans_Edito_Sociedad != false) {
            redireccion::redireccionar('actualizoSociedad', $datos_proveedor);
            exit();
        } else {

            redireccion::redireccionar('noActualizoSociedad', $datos_proveedor);
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