<?php

require_once ("core/auth/SesionSql.class.php");
require_once ("core/auth/SesionBase.class.php");

class Sesion extends SesionBase {

    private static $instancia;

    const SESIONID = 'sesionId';
    const EXPIRACION = 'expiracion';
    const APLICATIVO = 'aplicativo';
    const ACCEDER = 'acceso';
    const BUSCAR = 'busqueda';

    /**
     *
     * @name sesiones
     *       constructor
     */
    private function __construct() {

        $this->miSql = new SesionSql ();

        // Valores predefinidos para las sesiones
        $this->sesionUsuarioNombre = '';
        $this->sesionNivel = 0;
    }

    public static function singleton() {

        if (!isset(self::$instancia)) {
            $className = __CLASS__;
            self::$instancia = new $className ();
        }
        return self::$instancia;
    }

    /**
     *
     * @name sesiones Verifica la existencia de una sesion válida en la máquina del cliente
     * @param
     *            string nombre_db
     * @return void
     * @access public
     */
    function verificarSesion() {
		
        $resultado = true;

        // Se eliminan las sesiones expiradas
        $this->borrarSesionExpirada();

        if ($this->sesionNivel > 0) {

            // Verificar si en el cliente existe y tenga registrada una cookie que identifique la sesion
            $this->sesionId = $this->numeroSesion();
            
           
            if ($this->sesionId) {
                $resultado = $this->abrirSesion($this->sesionId);

                /* Detecta errores */
                if ($resultado) {

                    // Si no hubo errores se puede actualizar los valores
                    // Update, porque se tiene un identificador
                    /* Crear una nueva cookie */
                    $parametro [self::EXPIRACION] = time() + 60 * $this->tiempoExpiracion;
                    $parametro ['sesionId'] = $this->sesionId;

                    setcookie(self::APLICATIVO, $this->sesionId, ($parametro [self::EXPIRACION]), "/");

                    $cadenaSql = $this->miSql->getCadenaSql("actualizarSesion", $parametro);

                    /**
                     * Ejecutar una consulta
                     */
                    $resultado = $this->miConexion->ejecutarAcceso($cadenaSql, self::ACCEDER, $parametro, 'actualizarSesion');
                }
            } else {
                $resultado = false;
            }
        }
        return $resultado;
    }

    /**
     * @METHOD numero_sesion
     *
     * Rescata el número de sesion correspondiente a la máquina
     * @PARAM sesion
     *
     * @return valor
     * @access public
     */
    function numeroSesion() {
    	
        if (isset($_COOKIE [self::APLICATIVO])) {
            $this->sesionId = $_COOKIE [self::APLICATIVO];
        } else {
            if (isset($_REQUEST [self::SESIONID])) {
                $this->sesionId = $_REQUEST [self::SESIONID];
            } else {
                return false;
            }
        }

        return $this->sesionId;
    }

    /* Fin de la función numero_sesion */

    /**
     * @METHOD abrir_sesion
     *
     * Busca la sesión en la base de datos
     * @PARAM sesion
     *
     * @return valor
     * @access public
     */
    function abrirSesion($sesion) {

        $resultado = true;
        // Primero se verifica la longitud del parámetro
        if (strlen($sesion) != 32) {
            $resultado = false;
        } else {
            // Verifica la validez del id de sesion

            if ($this->caracteresValidos($sesion) != strlen($sesion)) {
                $resultado = false;
            } else {
                $this->setSesionId($sesion);

                // Busca una sesión que coincida con el id del computador y el nivel de acceso de la página
                $this->sesionUsuarioId = trim($this->getValorSesion('idUsuario'));
                $nivelPagina = $this->getSesionNivel();

                $cadenaSql = $this->miSql->getCadenaSql("verificarNivelUsuario", $this->sesionUsuarioId);
                $resultadoNivel = $this->miConexion->ejecutarAcceso($cadenaSql, self::BUSCAR);

                if ($nivelPagina == $resultadoNivel [0] ['tipo'] && ($this->sesionExpiracion > time())) {
                    $resultado = true;
                } else {
                    $resultado = false;
                }
            }
        }

        return $resultado;
    }

    // Final del método abrir_sesion

    /**
     * @METHOD caracteres_validos
     *
     * Verifica que los caracteres en el identificador de sesión sean válidos
     * @PARAM cadena
     *
     * @return valor
     * @access public//Realizar un barrido por la matriz de resultados para comprobar que se tiene los privilegios para la pagina
     *         $this->validacion=0;
     *         for($this->i=0;$this->i<$this->count;$this->i++)
     *         {
     */
    function caracteresValidos($cadena) {
        // Retorna el número de elementos que coinciden con la lista de caracteres
        return strspn($cadena, "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789");
    }

    /**
     * @METHOD crear_sesion
     *
     * Crea una nueva sesión en la base de datos.
     * @PARAM usuario_aplicativo
     * @PARAM nivel_acceso
     * @PARAM expiracion
     * @PARAM conexion_id
     *
     * @return boolean
     * @access public
     */
    function crearSesion($usuarioId) {
    	
        // 0. Borrar todas las sesiones del equipo
        if ($this->verificarSesion()) {
            $this->terminarSesion($this->sesionId);
        }

        // 1. Identificador de sesion
        $this->fecha = explode(" ", microtime());
        $this->sesionId = md5($this->fecha [1] . substr($this->fecha [0], 2) . rand());

        if (strlen($this->sesionId) == 32 && $this->caracteresValidos($this->sesionId) == strlen($this->sesionId)) {
            /**
             * Borra todas las sesiones que existan con el id del computador
             */
            if (isset($_COOKIE [self::APLICATIVO])) {
                $this->la_sesion = $_COOKIE [self::APLICATIVO];
                $this->terminarSesion($this->la_sesion);
            }

            /* Actualizar la cookie, la sesión tiene un tiempo de 1 hora */

            $this->sesionExpiracion = time() + $this->tiempoExpiracion * 60;
            setcookie(self::APLICATIVO, $this->sesionId, $this->sesionExpiracion, "/");

            // Insertar id_usuario
            $this->resultado = $this->guardarValorSesion('idUsuario', $usuarioId, $this->sesionId, $this->sesionExpiracion);
            
            if ($this->resultado) {
                return $this->sesionId;
            }
        }

        return false;
    }

    // Fin del método crear_sesion

    /**
     * @METHOD guardarValorSesion
     * @PARAM variable
     * @PARAM valor
     *
     * @return boolean
     * @access public
     */
    function guardarValorSesion($variable, $valor, $sesion = '', $expiracion = '') {
    	
        $totalArgumentos = func_num_args();
        if ($totalArgumentos == 0) {
            return FALSE;
        } else {
        	
            if (strlen($sesion) != 32) {
            	
                if (isset($_COOKIE [self::APLICATIVO])) {
                    $this->sesionId = $_COOKIE [self::APLICATIVO];
                } else {
                    return FALSE;
                }
            } else {
                $this->sesionId = $sesion;
            }

            // Si el valor de sesión existe entonces se actualiza, si no se crea un registro con el valor.
            
            $parametro [self::SESIONID] = $this->sesionId;
            $parametro ["variable"] = $variable;
            $parametro ["valor"] = $valor;
            $parametro [self::EXPIRACION] = $expiracion;
            $cadenaSql = $this->miSql->getCadenaSql("buscarValorSesion", $parametro);

            
            $resultado = $this->miConexion->ejecutarAcceso($cadenaSql, self::BUSCAR);
			
            if ($resultado) {

                $cadenaSql = $this->miSql->getCadenaSql("actualizarValorSesion", $parametro);
            } else {
            	
                $cadenaSql = $this->miSql->getCadenaSql("insertarValorSesion", $parametro);
            }

            return $this->miConexion->ejecutarAcceso($cadenaSql, self::ACCEDER);
        }
    }

    // Fin del método guardar_valor_sesion
    function setValorSesion($variable, $valor) {

        return $this->guardarValorSesion($variable, $valor);
    }

    // Fin del método guardar_valor_sesion

    /**
     * @METHOD borrarValorSesion
     * @PARAM variable
     * @PARAM valor
     *
     * @return boolean
     * @access public
     */
    function borrarValorSesion($variable, $sesion = "") {

        if (strlen($sesion) != 32) {
            if (isset($_COOKIE [self::APLICATIVO])) {
                $sesion = $_COOKIE [self::APLICATIVO];
            } else {
                return false;
            }
        }

        $parametro [self::SESIONID] = $sesion;
        $parametro ["dato"] = $variable;

        if ($variable != 'TODOS') {
            $cadenaSql = $this->miSql->getCadenaSql("borrarVariableSesion", $parametro);
        } else {
            $cadenaSql = $this->miSql->getCadenaSql("borrarSesion", $parametro);
        }

        return !$this->miConexion->ejecutarAcceso($cadenaSql);
    }

    // Fin del método borrar_valor_sesion

    /**
     *
     * @name borrar_sesion_expirada
     * @return void
     * @access public
     */
    function borrarSesionExpirada() {

        $cadenaSql = $this->miSql->getCadenaSql("borrarSesionesExpiradas");
        return !$this->miConexion->ejecutarAcceso($cadenaSql);
    }

    // Fin del método borrar_sesion_expirada

    /**
     *
     * @name terminar_sesion
     * @return boolean
     * @access public
     */
    function terminarSesion($sesion) {

        if (strlen($sesion) != 32) {
            return FALSE;
        }
        $parametro [self::SESIONID] = $sesion;
        // Borrar cookies anteriores
        setcookie(self::APLICATIVO, "", time() - 3600, "/");
        $cadenaSql = $cadenaSql = $this->miSql->getCadenaSql("borrarSesion", $parametro);
        return !$this->miConexion->ejecutarAcceso($cadenaSql);
    }

    // Fin del método terminar_sesion

    /**
     * @METHOD obtener_nivel
     * Retorna el nivel de usuario en la base de datos
     * @PARAM 
     *
     * @return valor
     * @access public
     */
    function nivelSesion() {
        $this->sesionUsuarioId = trim($this->getValorSesion('idUsuario'));
        $cadenaSql = $this->miSql->getCadenaSql("verificarNivelUsuario", $this->sesionUsuarioId);
        $resultadoNivel = $this->miConexion->ejecutarAcceso($cadenaSql, self::BUSCAR);
        $nivel = $resultadoNivel[0][0];

        return $nivel;
    }

    /**
     * @METHOD obtener_nivel
     *
     * Retorna el nivel de usuario en la base de datos
     * @PARAM 
     *
     * @return valor
     * @access public
     */
    function idUsuario() {
        return $this->sesionUsuarioId = trim($this->getValorSesion('idUsuario'));
    }    
     /**
     * @METHOD obtener_roles
     * Retorna los roles de usuario en la base de datos
     * @PARAM 
     *
     * @return valor
     * @access public
     */
    function RolesSesion() {
        $this->sesionUsuarioId = trim($this->getValorSesion('idUsuario'));
        $cadenaSql = $this->miSql->getCadenaSql("verificarRolesUsuario", $this->sesionUsuarioId);
        $resultadoRoles = $this->miConexion->ejecutarAcceso($cadenaSql, self::BUSCAR);
        return $resultadoRoles;
    }
    
    
         /**
     * @METHOD obtener_roles
     * Devuelve los roles de usuario en la base de datos sin el valor de la aplicacion
     * @PARAM 
     *
     * @return valor
     * @access public
     */
    function RolesSesion_unico() {
        $this->sesionUsuarioId = trim($this->getValorSesion('idUsuario'));
      $cadenaSql = $this->miSql->getCadenaSql("verificarRolesUsuario_unico", $this->sesionUsuarioId);
        $resultadoRoles = $this->miConexion->ejecutarAcceso($cadenaSql, self::BUSCAR);
        return $resultadoRoles;
    }



    /**
     * @METHOD obtener_sesion activa
     *
     * Retorna false o array para una sesion activa
     * @PARAM 
     *
     * @return boolean
     * @access public
     */
    function sesionActiva($parametrosSesion) {
        $cadenaSql = $this->miSql->getCadenaSql("buscarSesionActiva", $parametrosSesion);
        $resultadoSesion = $this->miConexion->ejecutarAcceso($cadenaSql, self::BUSCAR);

        if ($resultadoSesion) {
            $sesion = $resultadoSesion;
        } else {
            $sesion = false;
        }

        return $sesion;
    }

    // Fin del método  sesion_activa

    /**
     *
     * @name borrar_sesion_activa
     * @return void
     * @access public
     */
    function borrarSesionActiva($parametro) {
        $cadenaSql = $cadenaSql = $this->miSql->getCadenaSql("borrarSesionActiva", $parametro);
        return !$this->miConexion->ejecutarAcceso($cadenaSql);
    }

    // Fin del método borrar_sesion_activa    
}

?>
