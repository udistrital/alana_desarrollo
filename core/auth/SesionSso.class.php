<?php
require_once('core/log/logger.class.php');
class SesionSSO
{
    private static $instancia;
    public $miSql;
    public $site;
    public $hostSSO;
    public $SPSSO;
    public $configurador;
    public $authnRequest;
    public $sesionUsuario;
    public $sesionUsuarioId;
    public $logger;
    public $CLAIMUSERNAME = 'http://wso2.org/claims/username';
    public $CLAIMROLE = 'http://wso2.org/claims/role';

    /**
     *
     * @name sesiones
     *       constructor
     */
    // private
    public function __construct()
    {
        $this->sesionUsuario = Sesion::singleton();
        $this->configurador = \Configurador::singleton();
        $this->site = $this->configurador->getVariableConfiguracion('site');
        $this->hostSSO = $this->configurador->getVariableConfiguracion('hostSSO');
        $this->SPSSO = $this->configurador->getVariableConfiguracion('SPSSO'); // Fuente de autenticación definida en el authsources del SP
        require_once($this->configurador->getVariableConfiguracion('direccionSSOAutoloader'));
        $this->authnRequest = new SimpleSAML_Auth_Simple($this->SPSSO); // Se pasa como parametro la fuente de autenticación
        $this->logger = new logger();
    }
    public static function singleton()
    {
        if (! isset(self::$instancia)) {
            $className = __CLASS__;
            self::$instancia = new $className();
        }
        return self::$instancia;
    }

    /**
     *
     * @name sesiones Verifica la existencia de una sesion válida en la máquina del cliente
     * @param
     *        	string nombre_db
     * @return void
     * @access public
     */
    public function verificarSesion($pagina)
    {
        $resultado = true;
        // Se eliminan las sesiones expiradas
        // $this->borrarSesionExpirada();

        if ($this->verificarSesionAbierta()) {
            $resultado = $this->getParametrosSesionAbierta();
        } else {
            $resultado = $this->crearSesion();
        }

        if ($resultado == false) {
            $this->terminarSesion();
        }

        $resultado = $this->verificarRolesPagina($resultado, $pagina); // Se verifica que la página pertenezca al perfil

        // Si no tiene acceso a alguna página, se desloguea de SSO
        if ($resultado == false) {
            $this->terminarSesion();
        }
        return $resultado;
    }

    /* Fin de la función numero_sesion */
    public function verificarSesionAbierta()
    {
        $respuesta = true;
        // La sesión SP está abierta
        if ($this->authnRequest->isAuthenticated()) {

            // La sesión SP abierta pero usuario no ha iniciado sesión SP en SARA
            if ($this->sesionUsuario->numeroSesion() == '') {
                $respuesta = $this->crearSesion();
            }
        } else {
            $respuesta = false;
        }
        return $respuesta;
    }

    public function getParametrosSesionAbierta()
    {
        return $this->authnRequest->getAttributes();
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
    public function crearSesion()
    {
        $aplication_base_url = $this->hostSSO . $this->site . '/';

        // En este caso se va al index, podría irse a la página desde donde lo solicitaron.
        $variable = "pagina=indexAlana";
        $variable = $this->configurador->fabricaConexiones->crypto->codificar($variable);

        $login_params = array(
                // dirige a la página de bienvenida
                'ReturnTo' => $aplication_base_url . 'index.php?data=' . $variable
        );

        $this->authnRequest->requireAuth($login_params);
        $atributos = $this->authnRequest->getAttributes();
        if (!isset($atributos [$this->CLAIMUSERNAME])) {//si no existe el claim
            return false;
        }
        $uid = $atributos [$this->CLAIMUSERNAME] [0];
        $cadenaSql = $this->sesionUsuario->miSql->getCadenaSql('obtenerDocumentoPorUid', $uid);
        $result = $this->sesionUsuario->miConexion->ejecutarAcceso($cadenaSql, 'busqueda');

        if(!(isset($result) && isset($result[0]) && isset($result[0]['id_usuario']))){
        	return false;
        } else {
            $id_usuario = $result[0]['id_usuario'];
        }

        $estaSesion = $this->sesionUsuario->crearSesion($id_usuario);

        $arregloLogin = array(
                'autenticacionExitosa',
                $id_usuario,
                $_SERVER ['REMOTE_ADDR'],
                $_SERVER ['HTTP_USER_AGENT']
        );

        $argumento = json_encode($arregloLogin);
        $arreglo = array(
                $id_usuario,
                $argumento
        );

        if ($estaSesion) {
            $log = array(
                    'accion' => "INGRESO",
                    'id_registro' => $id_usuario . "|" . $estaSesion,
                    'tipo_registro' => "LOGIN",
                    'nombre_registro' => $arreglo [1],
                    'descripcion' => "Ingreso al sistemas del usuario " . $id_usuario . " con la sesion " . $estaSesion,
                    'id_usuario' => $id_usuario
            );

            $_COOKIE ["aplicativo"] = $estaSesion;
            $this->logger->log_usuario($log);
        }

        return $atributos;
    }

    // Fin del método crear_sesion

    /**
     *
     * @name terminar_sesion_expirada
     * @return void
     * @access public
     */
    public function terminarSesionExpirada()
    {
        /*
         * No USADA
         */
        $cadenaSql = $cadenaSql = $this->miSql->getCadenaSql('borrarSesionesExpiradas');

        return ! $this->miConexion->ejecutarAcceso($cadenaSql);
    }

    // Fin del método terminar_sesion_expirada

    /**
     *
     * @name terminar_sesion
     * @return boolean
     * @access public
     */
    public function terminarSesion()
    {
        $sesionUsuarioId = $this->sesionUsuario->numeroSesion();

        if (! isset($_REQUEST ["usuario"])) {
            $_REQUEST ["usuario"] = 0;
        }

        $arregloLogin = array(
                'CierreSesion',
                $_REQUEST ["usuario"],
                $_SERVER ['REMOTE_ADDR'],
                $_SERVER ['HTTP_USER_AGENT']
        );
        $argumento = json_encode($arregloLogin);
        $arreglo = array(
                $_REQUEST ["usuario"],
                $argumento
        );

        $sesionActiva = $sesionUsuarioId;
        $log = array(
                'accion' => "SALIDA",
                'id_registro' => $_REQUEST ["usuario"] . "|" . $sesionActiva,
                'tipo_registro' => "LOGOUT",
                'nombre_registro' => $arreglo [1],
                'descripcion' => "Salida del sistemas del usuario " . $_REQUEST ["usuario"] . " con la sesion " . $sesionActiva
        );

        $this->logger->log_usuario($log);

        $this->sesionUsuario->terminarSesion($sesionUsuarioId);
        // $aplication_base_url = 'http://10.20.0.38/splocal/';
        $aplication_base_url = $this->hostSSO . $this->site . '/';

        $respuesta = $this->authnRequest->logout($aplication_base_url . 'index.php');
        // Cerrar la sesión de SARA al salir.

        return $respuesta;
    }

    // Fin del método terminar_sesion
    public function verificarRolesPagina($atributosSSO, $pagina)
    {
        $uid = $atributosSSO [$this->CLAIMUSERNAME] [0];
        $cadenaSql = $this->sesionUsuario->miSql->getCadenaSql('obtenerDocumentoPorUid', $uid);
        $result = $this->sesionUsuario->miConexion->ejecutarAcceso($cadenaSql, 'busqueda');

        if(!(isset($result) && isset($result[0]) && isset($result[0]['id_usuario']))){
        	return false;
        }

        $id_usuario = $result[0]['id_usuario'];
        $datos_proveedor = array(
                'perfiles' => $atributosSSO [$this->CLAIMROLE],
                'uid' => $uid,
                'id_usuario' => $id_usuario,
                'pagina' => $pagina
        );

        $cadenaSql = $this->sesionUsuario->miSql->getCadenaSql('verificarPerfilUsuario', $datos_proveedor);
        // Se busca en la tabla _menu_rol_enlace si la página pertenece al perfil.
        $roles = $this->sesionUsuario->miConexion->ejecutarAcceso($cadenaSql, 'busqueda');

        if (count($roles) > 0) { // por ahora solo si tiene roles
            return true;
        }
        // Se comenta porque por ahora no tiene los roles mapeados, solo se necesita que exista.
        // 		if ($roles) { // Si la página tiene roles en el menú
        // 			foreach ( $perfiles ['perfil'] as $perfil ) {
        // 				foreach ( $roles as $rol ) {
        // 					if ($rol [0] == $perfil) {
        // 						return true;
        // 					}
        // 				}
        // 			}
        // 		}
        return false;
    }
}
