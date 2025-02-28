<?php

use usuarios\gestionUsuarios\Sql;

$conexion = "estructura";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

$conexionArka = "inventarios";
$recursoArka = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexionArka);
$conexionArgo = "contractual";
$recursoArgo = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexionArgo);

if ($_REQUEST ['funcion'] == 'consultarPerfil') {

    $parametro['subsistema'] = $_REQUEST ['valor'];
    if (isset($_REQUEST['id_usuario'])) {
        $parametro['id_usuario'] = $_REQUEST['id_usuario'];
        //datos perfiles
        $cadena_sql = $this->sql->getCadenaSql("consultarPerfilUsuario", $parametro);
        $resultadoPerfil = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");
              
        if ($resultadoPerfil) {
            $tam = count($resultadoPerfil);
            $rolUs = '';
            foreach ($resultadoPerfil as $key => $value) {
                $rolUs.="'" . $resultadoPerfil[$key]['rol_id'] . "'";
                $tam > ($key + 1) ? $rolUs.=',' : '';
            }
            $parametro['roles'] = $rolUs;
        }
    }

    $cadenaSql = $this->sql->getCadenaSql('consultaPerfiles', $parametro);
    $resultado = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
   
   
    $resultado = json_encode($resultado);
    echo $resultado;
}
if ($_REQUEST ['funcion'] == 'consultaDependenciaEspecifica') {
    $parametro = $_REQUEST['valor'];
    $cadenaSql = $this->sql->getCadenaSql('dependencias', $parametro);
    $resultado = $recursoArka->ejecutarAcceso($cadenaSql, "busqueda");
    $resultado = json_encode($resultado);
    echo $resultado;
}

if ($_REQUEST ['funcion'] == 'consultarDependencia') {

    $cadenaSql = $this->sql->getCadenaSql('dependenciasConsultadas', $_REQUEST ['valor']);
    $resultado = $recursoArgo->ejecutarAcceso($cadenaSql, "busqueda");
    $resultado = json_encode($resultado);
    echo $resultado;
}
?>