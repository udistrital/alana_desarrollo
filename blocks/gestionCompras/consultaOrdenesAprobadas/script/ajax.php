
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
$cadenaACodificar .= $cadenaACodificar . "&funcion=letrasNumeros";
$cadenaACodificar .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar, $enlace);

// URL definitiva
$urlFinal = $url . $cadena;

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

// Variables
$cadenaACodificar7 = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificar7 .= "&procesarAjax=true";
$cadenaACodificar7 .= "&action=index.php";
$cadenaACodificar7 .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificar7 .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificar7 .= $cadenaACodificar . "&funcion=SeleccionCargo";
$cadenaACodificar7 .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace7 = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena7 = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar7, $enlace7);

// URL definitiva
$urlFinal7 = $url . $cadena7;

// Variables
$cadenaACodificar9 = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificar9 .= "&procesarAjax=true";
$cadenaACodificar9 .= "&action=index.php";
$cadenaACodificar9 .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificar9 .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificar9 .= $cadenaACodificar9 . "&funcion=letrasNumeros";
$cadenaACodificar9 .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena9 = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar9, $enlace);

// URL definitiva
$urlFinal9 = $url . $cadena9;

// Variables
$cadenaACodificar10 = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificar10 .= "&procesarAjax=true";
$cadenaACodificar10 .= "&action=index.php";
$cadenaACodificar10 .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificar10 .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificar10 .= $cadenaACodificar10 . "&funcion=disponibilidades";
$cadenaACodificar10 .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena10 = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar10, $enlace);

// URL definitiva
$urlFinal10 = $url . $cadena10;

// Variables
$cadenaACodificar12 = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificar12 .= "&procesarAjax=true";
$cadenaACodificar12 .= "&action=index.php";
$cadenaACodificar12 .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificar12 .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificar12 .= $cadenaACodificar12 . "&funcion=Infodisponibilidades";
$cadenaACodificar12 .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena12 = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar12, $enlace);

// URL definitiva
$urlFinal12 = $url . $cadena12;

// Variables
$cadenaACodificar13 = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificar13 .= "&procesarAjax=true";
$cadenaACodificar13 .= "&action=index.php";
$cadenaACodificar13 .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificar13 .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificar13 .= $cadenaACodificar13 . "&funcion=registroPresupuestal";
$cadenaACodificar13 .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena13 = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar13, $enlace);

// URL definitiva
$urlFinal13 = $url . $cadena13;

// Variables
$cadenaACodificar14 = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificar14 .= "&procesarAjax=true";
$cadenaACodificar14 .= "&action=index.php";
$cadenaACodificar14 .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificar14 .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificar14 .= $cadenaACodificar14 . "&funcion=Inforegistro";
$cadenaACodificar14 .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena14 = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar14, $enlace);

// URL definitiva
$urlFinal14 = $url . $cadena14;

// Variables
$cadenaACodificar15 = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificar15 .= "&procesarAjax=true";
$cadenaACodificar15 .= "&action=index.php";
$cadenaACodificar15 .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificar15 .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificar15 .= $cadenaACodificar15 . "&funcion=consultarContratistas";
$cadenaACodificar15 .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena15 = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar15, $enlace);

// URL definitiva
$urlFinal15 = $url . $cadena15;

// Variables
$cadenaACodificar16 = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificar16 .= "&procesarAjax=true";
$cadenaACodificar16 .= "&action=index.php";
$cadenaACodificar16 .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificar16 .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificar16 .= $cadenaACodificar16 . "&funcion=consultarDependencia";
$cadenaACodificar16 .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena16 = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar16, $enlace);

// URL definitiva
$urlFinal16 = $url . $cadena16;

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
$cadenaACodificar18 = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificar18 .= "&procesarAjax=true";
$cadenaACodificar18 .= "&action=index.php";
$cadenaACodificar18 .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificar18 .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificar18 .= "&funcion=SeleccionProveedor";
$cadenaACodificar18 .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace18 = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena18 = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar18, $enlace18);

// URL definitiva
$urlFinal18 = $url . $cadena18;


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

// Variables
$cadenaACodificarTipoBien = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificarTipoBien .= "&procesarAjax=true";
$cadenaACodificarTipoBien .= "&action=index.php";
$cadenaACodificarTipoBien .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificarTipoBien .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificarTipoBien .= "&funcion=SeleccionTipoBien";
$cadenaACodificarTipoBien .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificarTipoBien, $enlace);

// URL definitiva
$urlFinalTipobien = $url . $cadena;


// Variables
$cadenaACodificariva = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificariva .= "&procesarAjax=true";
$cadenaACodificariva .= "&action=index.php";
$cadenaACodificariva .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificariva .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificariva .= "&funcion=consultarIva";
$cadenaACodificariva .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadenaiva = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificariva, $enlace);

// URL definitiva
$urlFinaliva = $url . $cadenaiva;


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


    //----------------------------Configuracion Paso a Paso--------------------------------------
    $("#ventanaA").steps({
        headerTag: "h3",
        bodyTag: "section",
        enableAllSteps: true,
        enablePagination: true,
        transitionEffect: "slideLeft",
        onStepChanging: function (event, currentIndex, newIndex) {
            $resultado = $("#consultaOrden").validationEngine("validate");

             if (currentIndex === 0 && ($("#<?php echo $this->campoSeguro('poliza') ?>").val()) === 'Si Aplica' && $("#ventanaA").find('section').length === 8)
            {
                $("#ventanaA").steps("insert", 1, {
                    title: "Garantias y Mecanismos de Cobertura del Riesgo ",
                    content:
                            '<br><br>' +  
                            $("#<?php echo $this->campoSeguro('tablaVigenciaNueva_hidden') ?>").val() 
                         
                });

            }


            var seleccion = Number($("#<?php echo $this->campoSeguro('contadorSelect_hidden') ?>").val());


            for (var j = 0; j <= (seleccion); j++) {


                if (j < seleccion) {


                    $("#amparo" + (j)).attr('disabled', true);
                    $("#porcentajeamparo" + (j)).attr('readonly', true);
                    $("#valoramparo" + (j)).attr('readonly', true);


                }

                $("#amparo" + (j)).width(300);
                $("#amparo" + (j)).select2();




            }
            i = j - 1;
            numeracion = j;


            if (currentIndex === 0 && ($("#<?php echo $this->campoSeguro('poliza') ?>").val()) === 'No Aplica' && $("#ventanaA").find('section').length !== 8)
            {


                $("#ventanaA").steps("remove", 1, {
                    title: "Step Title",
                    content: "<p>Step Body</p>"
                });
            }
            if ($resultado) {
                return true;
            } else {
                alert("Verifique que todos los campos requeridos del formulario este debidamente registrados.");
                return false;

            }
        },
        labels: {
            cancel: "Cancelar",
            current: "Paso Siguiente :",
            pagination: "Paginación",
            finish: "",
            next: "Siquiente",
            previous: "Atras",
            loading: "Cargando ..."
        }

    });

//----------------------------Fin Configuracion Paso a Paso--------------------------------------

    //--------------------Autocomplete Contratista y Numero de Contrato 


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

//---------------------------------------------------------------------------

    function resetIva(elem, request, response) {
        $.ajax({
            url: "<?php echo $urlFinaliva ?>",
            dataType: "json",
            success: function (data) {




                if (data[0] != " ") {

                    $("#<?php echo $this->campoSeguro('iva') ?>").html('');
                    $("<option value=''>Seleccione  ....</option>").appendTo("#<?php echo $this->campoSeguro('iva') ?>");
                    $.each(data, function (indice, valor) {

                        $("<option value='" + data[ indice ].id_iva + "'>" + data[ indice ].descripcion + "</option>").appendTo("#<?php echo $this->campoSeguro('iva') ?>");

                    });


                    $('#<?php echo $this->campoSeguro('iva') ?>').width(150);
                    $("#<?php echo $this->campoSeguro('iva') ?>").select2();



                }


            }

        });
    }
    ;

    function tipo_bien(elem, request, response) {
        $.ajax({
            url: "<?php echo $urlFinalTipobien ?>",
            dataType: "json",
            data: {valor: $("#<?php echo $this->campoSeguro('nivel') ?>").val()},
            success: function (data) {


                $("#<?php echo $this->campoSeguro('id_tipo_bien') ?>").val(data[0]);
                $("#<?php echo $this->campoSeguro('tipo_bien') ?>").val(data[1]);

                switch ($("#<?php echo $this->campoSeguro('id_tipo_bien') ?>").val())
                {


                    case '2':


                        $("#<?php echo $this->campoSeguro('devolutivo') ?>").css('display', 'none');
                        $("#<?php echo $this->campoSeguro('consumo_controlado') ?>").css('display', 'block');
                        $("#<?php echo $this->campoSeguro('cantidad') ?>").val('1');
                        $('#<?php echo $this->campoSeguro('cantidad') ?>').attr('disabled', '');

                        break;

                    case '3':

                        $("#<?php echo $this->campoSeguro('devolutivo') ?>").css('display', 'block');
                        $("#<?php echo $this->campoSeguro('consumo_controlado') ?>").css('display', 'none');
                        $("#<?php echo $this->campoSeguro('tipo_poliza') ?>").select2();

                        $("#<?php echo $this->campoSeguro('cantidad') ?>").val('1');
                        $('#<?php echo $this->campoSeguro('cantidad') ?>').attr('disabled', '');

                        break;


                        break;


                    default:

                        $("#<?php echo $this->campoSeguro('devolutivo') ?>").css('display', 'none');
                        $("#<?php echo $this->campoSeguro('consumo_controlado') ?>").css('display', 'none');
                        $("#<?php echo $this->campoSeguro('cantidad') ?>").removeProp('readonly');

                        $("#<?php echo $this->campoSeguro('cantidad') ?>").val('');

                        $('#<?php echo $this->campoSeguro('cantidad') ?>').removeAttr('disabled');

                        break;

                }








            }

        });
    }
    ;


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


    $("#<?php echo $this->campoSeguro('sede_super') ?>").change(function () {

        if ($("#<?php echo $this->campoSeguro('sede_super') ?>").val() != '') {
            consultarDependenciaSuper();
        } else {
            $("#<?php echo $this->campoSeguro('dependencia_supervisor') ?>").attr('disabled', '');
        }

    });


    function consultarDependenciaSuper(elem, request, response) {
        $.ajax({
            url: "<?php echo $urlFinal16 ?>",
            dataType: "json",
            data: {valor: $("#<?php echo $this->campoSeguro('sede_super') ?>").val()},
            success: function (data) {



                if (data[0] != " ") {

                    $("#<?php echo $this->campoSeguro('dependencia_supervisor') ?>").html('');
                    $('<option value=" ">Seleccione  ....</option>').appendTo("#<?php echo $this->campoSeguro('dependencia_supervisor') ?>");
                    $.each(data, function (indice, valor) {

                        $("<option value='" + data[ indice ].ESF_CODIGO_DEP + "'>" + data[ indice ].ESF_DEP_ENCARGADA + "</option>").appendTo("#<?php echo $this->campoSeguro('dependencia_supervisor') ?>");

                    });

                    $("#<?php echo $this->campoSeguro('dependencia_supervisor') ?>").removeAttr('disabled');

                    $('#<?php echo $this->campoSeguro('dependencia_supervisor') ?>').width(400);
                    $("#<?php echo $this->campoSeguro('dependencia_supervisor') ?>").select2();



                }


            }

        });
    }
    ;



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
            url: "<?php echo $urlFinalConsultaDependencia ?>",
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
    function restCargoSuper(elem, request, response) {
        $("#<?php echo $this->campoSeguro('cargo_supervisor') ?>").val($("#<?php echo $this->campoSeguro('cargo_inicial') ?>").val());
    }
    ;



    function datosInfo(elem, request, response) {
        $.ajax({
            url: "<?php echo $urlFinal18 ?>",
            dataType: "json",
            data: {proveedor: $("#<?php echo $this->campoSeguro('id_proveedor') ?>").val()},
            success: function (data) {

                if (data[0] != 'null') {

                    $("#<?php echo $this->campoSeguro('identifcacion_proveedor') ?>").val(data[0]);
                    $("#<?php echo $this->campoSeguro('nombre_razon_proveedor') ?>").val(data[1]);
                    $("#<?php echo $this->campoSeguro('digito_verificacion') ?>").val(data[2]);
                    $("#<?php echo $this->campoSeguro('direccion_proveedor') ?>").val(data[3]);
                    $("#<?php echo $this->campoSeguro('correo_proveedor') ?>").val(data[4]);
                    $("#<?php echo $this->campoSeguro('telefono_proveedor') ?>").val(data[5]);
                    $("#<?php echo $this->campoSeguro('pais') ?>").val(data[6]);
                    var tipo_persona = '';
                    if (data[7] == 'J') {
                        tipo_persona = 'Jurídica'
                    } else {
                        tipo_persona = 'Natural'
                    }
                    ;
                    $("#<?php echo $this->campoSeguro('tipo_persona') ?>").val(tipo_persona);
                    $("#<?php echo $this->campoSeguro('nombre_contratista') ?>").val(data[8]);
                    $("#<?php echo $this->campoSeguro('tipo_documento') ?>").val(data[9]);
                    $("#<?php echo $this->campoSeguro('identifcacion_contratista') ?>").val(data[10]);
                    $("#<?php echo $this->campoSeguro('registro_mercantil') ?>").val(data[11]);
                    $("#<?php echo $this->campoSeguro('cargo_contratista') ?>").val("");


                } else {





                }

            }

        });
    }
    ;








    function consultarDependenciaConsulta(elem, request, response) {
        $.ajax({
            url: "<?php echo $urlFinal16 ?>",
            dataType: "json",
            data: {valor: $("#<?php echo $this->campoSeguro('sede_consultar') ?>").val()},
            success: function (data) {



                if (data[0] != " ") {

                    $("#<?php echo $this->campoSeguro('selec_dependencia_Sol') ?>").html('');
                    $("<option value=''>Seleccione  ....</option>").appendTo("#<?php echo $this->campoSeguro('selec_dependencia_Sol') ?>");
                    $.each(data, function (indice, valor) {

                        $("<option value='" + data[ indice ].ESF_ID_ESPACIO + "'>" + data[ indice ].ESF_NOMBRE_ESPACIO + "</option>").appendTo("#<?php echo $this->campoSeguro('selec_dependencia_Sol') ?>");

                    });

                    $("#<?php echo $this->campoSeguro('selec_dependencia_Sol') ?>").removeAttr('disabled');
                    $('#<?php echo $this->campoSeguro('selec_dependencia_Sol') ?>').width(300);

                    $("#<?php echo $this->campoSeguro('selec_dependencia_Sol') ?>").select2();



                }


            }

        });
    }
    ;






//-------------------------------------------------------------------

    function valorLetras(elem, request, response) {
        $.ajax({
            url: "<?php echo $urlFinal ?>",
            dataType: "json",
            data: {valor: $("#<?php echo $this->campoSeguro('valor_registro') ?>").val()},
            success: function (data) {


                $("#<?php echo $this->campoSeguro('valorLetras_registro') ?>").val(data);

            }

        });
    }
    ;




    function valorLetrasDis(elem, request, response) {
        $.ajax({
            url: "<?php echo $urlFinal9 ?>",
            dataType: "json",
            data: {valor: $("#<?php echo $this->campoSeguro('valor_disponibilidad') ?>").val()},
            success: function (data) {


                $("#<?php echo $this->campoSeguro('valorLetras_disponibilidad') ?>").val(data);

            }

        });
    }
    ;






    function valorLetrasReg(elem, request, response) {
        $.ajax({
            url: "<?php echo $urlFinal9 ?>",
            dataType: "json",
            data: {valor: $("#<?php echo $this->campoSeguro('valor_registro') ?>").val()},
            success: function (data) {


                $("#<?php echo $this->campoSeguro('valorL_registro') ?>").val(data);

            }

        });
    }
    ;


    function datosCargo(elem, request, response) {
        $.ajax({
            url: "<?php echo $urlFinal7 ?>",
            dataType: "json",
            data: {cargo: $("#<?php echo $this->campoSeguro('cargoJefeSeccion') ?>").val()},
            success: function (data) {

                if (data[0] != 'null') {

                    $("#<?php echo $this->campoSeguro('nombreJefeSeccion') ?>").val(data[0]);
                    $("#<?php echo $this->campoSeguro('id_jefe') ?>").val(data[1]);


                } else {





                }

            }

        });
    }
    ;


    function datosCargoDe(elem, request, response) {
        $.ajax({
            url: "<?php echo $urlFinal7 ?>",
            dataType: "json",
            data: {cargo: $("#<?php echo $this->campoSeguro('dependencia_supervisor') ?>").val()},
            success: function (data) {

                if (data[0] != 'null') {

                    $("#<?php echo $this->campoSeguro('nombre_supervisor') ?>").val(data[0]);



                } else {





                }

            }

        });
    }
    ;


    function consultarContratistas(elem, request, response) {

        if ($("#<?php echo $this->campoSeguro('selec_proveedor') ?>").val() != "") {


            $.ajax({
                url: "<?php echo $urlFinalProveedor ?>",
                dataType: "json",
                data: {proveedor: $("#<?php echo $this->campoSeguro('selec_proveedor') ?>").val()},
                success: function (data) {

                    if (data != 'null') {

                        if (data.status == 200) {
                            $("#<?php echo $this->campoSeguro('identifcacion_proveedor') ?>").val(data.datos.nit);
                            $("#<?php echo $this->campoSeguro('nombre_razon_proveedor') ?>").val(data.datos.nomempresa);
                            $("#<?php echo $this->campoSeguro('digito_verificacion') ?>").val(data.datos.digitoverificacion);
                            $("#<?php echo $this->campoSeguro('direccion_proveedor') ?>").val(data.datos.direccion);
                            $("#<?php echo $this->campoSeguro('correo_proveedor') ?>").val(data.datos.correo);
                            $("#<?php echo $this->campoSeguro('telefono_proveedor') ?>").val(data.datos.telefono);
                            if (data.datos.pais == null) {
                                $("#<?php echo $this->campoSeguro('pais') ?>").val('Colombia');
                            } else {
                                $("#<?php echo $this->campoSeguro('pais') ?>").val(data.datos.pais);
                            }
                            $("#<?php echo $this->campoSeguro('tipo_persona') ?>").val(data.datos.tipopersona);
                            $("#<?php echo $this->campoSeguro('nombre_contratista') ?>").val(data.datos.primernombre + ' ' + data.datos.segundonombre + ' '
                                    + data.datos.primerapellido + ' ' + data.datos.segundoapellido);
                            $("#<?php echo $this->campoSeguro('tipo_documento') ?>").val(data.datos.tipodocumento);
                            if (data.datos.numdocumento != null) {
                                $("#<?php echo $this->campoSeguro('identifcacion_contratista') ?>").val(data.datos.numdocumento);
                            } else {
                                $("#<?php echo $this->campoSeguro('identifcacion_contratista') ?>").val(data.datos.cedula_extranjeria);
                            }
                            $("#<?php echo $this->campoSeguro('sitio_web') ?>").val(data.datos.web);
                            if (data.datos.tipo_doc_extranjero != null) {
                                $("#<?php echo $this->campoSeguro('procedencia') ?>").val(data.datos.tipo_procedencia + '(' + data.datos.tipo_doc_extranjero + ')');
                            } else {
                                $("#<?php echo $this->campoSeguro('procedencia') ?>").val(data.datos.tipo_procedencia);
                            }
                            $("#<?php echo $this->campoSeguro('ubicacion_proveedor') ?>").val(data.datos.municipio);
                            $("#<?php echo $this->campoSeguro('nombre_acesor') ?>").val(data.datos.nomasesor);
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


    function datosOrdenador(elem, request, response) {
        $.ajax({
            url: "<?php echo $urlFinal6 ?>",
            dataType: "json",
            data: {ordenador: $("#<?php echo $this->campoSeguro('asignacionOrdenador') ?>").val()},
            success: function (data) {

                if (data[0] != 'null') {

                    $("#<?php echo $this->campoSeguro('nombreOrdenador') ?>").val(data[0]);
                    $("#<?php echo $this->campoSeguro('id_ordenador') ?>").val(data[1]);
                    $("#<?php echo $this->campoSeguro('tipo_ordenador') ?>").val(data[2]);

                } else {





                }

            }

        });
    }
    ;





    $(function () {


        $("#<?php echo $this->campoSeguro('unidad_ejecutora') ?>").change(function () {

            if ($("#<?php echo $this->campoSeguro('unidad_ejecutora') ?>").val() != '') {

                disponibilidades();

            } else {
            }


        });



//----














//----


        $("#<?php echo $this->campoSeguro('cantidad') ?>").keyup(function () {

            $("#<?php echo $this->campoSeguro('valor') ?>").val('');
            $("#<?php echo $this->campoSeguro('subtotal_sin_iva') ?>").val('');
            $("#<?php echo $this->campoSeguro('total_iva') ?>").val('');
            $("#<?php echo $this->campoSeguro('total_iva_con') ?>").val('');

        });



        $("#<?php echo $this->campoSeguro('valor') ?>").keyup(function () {
            $("#<?php echo $this->campoSeguro('subtotal_sin_iva') ?>").val('');
            $("#<?php echo $this->campoSeguro('total_iva') ?>").val('');
            $("#<?php echo $this->campoSeguro('total_iva_con') ?>").val('');

            cantidad = Number($("#<?php echo $this->campoSeguro('cantidad') ?>").val());
            valor = Number($("#<?php echo $this->campoSeguro('valor') ?>").val());

            precio = cantidad * valor;


            if (precio == 0) {
                $("#<?php echo $this->campoSeguro('subtotal_sin_iva') ?>").val('');
            } else {
                $("#<?php echo $this->campoSeguro('subtotal_sin_iva') ?>").val(precio);
            }

        });









        $("#<?php echo $this->campoSeguro('nitproveedor') ?>").keyup(function () {


            $('#<?php echo $this->campoSeguro('nitproveedor') ?>').val($('#<?php echo $this->campoSeguro('nitproveedor') ?>').val());


        });




        $("#<?php echo $this->campoSeguro('nitproveedor') ?>").autocomplete({
            minChars: 3,
            serviceUrl: '<?php echo $urlProveedorFiltro; ?>',
            onSelect: function (suggestion) {

                $("#<?php echo $this->campoSeguro('id_proveedor') ?>").val(suggestion.data);
            }

        });



        $("#<?php echo $this->campoSeguro('nombre_supervisor') ?>").change(function () {

            if ($("#<?php echo $this->campoSeguro('nombre_supervisor') ?>").val() != '') {
                cargoSuper();
            }

        });









        $("#<?php echo $this->campoSeguro('vigencia_contratista') ?>").change(function () {

            if ($("#<?php echo $this->campoSeguro('vigencia_contratista') ?>").val() != '') {

                contratistasC();

            } else {
            }


        });

        $("#<?php echo $this->campoSeguro('vigencia_disponibilidad') ?>").change(function () {

            if ($("#<?php echo $this->campoSeguro('vigencia_disponibilidad') ?>").val() != '') {

                disponibilidades();

            } else {
            }


        });




        $("#<?php echo $this->campoSeguro('nivel') ?>").change(function () {

            if ($("#<?php echo $this->campoSeguro('nivel') ?>").val() != '') {

                tipo_bien();

            } else {
            }

        });



        $("#<?php echo $this->campoSeguro('diponibilidad') ?>").change(function () {

            if ($("#<?php echo $this->campoSeguro('diponibilidad') ?>").val() != '') {

                infodisponibilidades();
                registrosP();

            } else {
            }


        });











        $("#<?php echo $this->campoSeguro('registro') ?>").change(function () {

            if ($("#<?php echo $this->campoSeguro('registro') ?>").val() != '') {

                inforegistrosP();

            } else {
            }


        });



        $("#<?php echo $this->campoSeguro('nombreContratista') ?>").select2({
            placeholder: "Search for a repository",
            minimumInputLength: 3,
        });

        $("#<?php echo $this->campoSeguro('valor_registro') ?>").keyup(function () {


            if ($("#<?php echo $this->campoSeguro('valor_registro') ?>").val() != "") {

                valorLetras();

            } else {

                $("#<?php echo $this->campoSeguro('valorLetras_registro') ?>").val('');


            }

        });


        $("#<?php echo $this->campoSeguro('asignacionOrdenador') ?>").change(function () {

            if ($("#<?php echo $this->campoSeguro('asignacionOrdenador') ?>").val() != '') {
                datosOrdenador();
            } else {
                $("#<?php echo $this->campoSeguro('nombreOrdenador') ?>").val('');
            }



        });

        $("#<?php echo $this->campoSeguro('cargoJefeSeccion') ?>").change(function () {


            if ($("#<?php echo $this->campoSeguro('cargoJefeSeccion') ?>").val() != '') {
                datosCargo();
            } else {
                $("#<?php echo $this->campoSeguro('nombreJefeSeccion') ?>").val('');
            }


        });





        $("#<?php echo $this->campoSeguro('sede_consultar') ?>").change(function () {

            if ($("#<?php echo $this->campoSeguro('sede_consultar') ?>").val() != '') {
                consultarDependenciaConsulta();
            } else if ($("#<?php echo $this->campoSeguro('sede_consultar') ?>").val() == '') {

                $('#<?php echo $this->campoSeguro('selec_dependencia_Sol') ?>').removeClass("select2");

                $("#<?php echo $this->campoSeguro('selec_dependencia_Sol') ?>").html('');

                $("<option value=''>Seleccione  ....</option>").appendTo("#<?php echo $this->campoSeguro('selec_dependencia_Sol') ?>");
                $("#<?php echo $this->campoSeguro('selec_dependencia_Sol') ?>").attr('disabled', '');
            }

        });





        $("#<?php echo $this->campoSeguro('dependencia_supervisor') ?>").change(function () {


            if ($("#<?php echo $this->campoSeguro('dependencia_supervisor') ?>").val() != '') {
                datosCargoDe();
            } else {
                $("#<?php echo $this->campoSeguro('nombre_supervisor') ?>").val('');
            }


        });


        function disponibilidades(elem, request, response) {
            $.ajax({
                url: "<?php echo $urlFinal10 ?>",
                dataType: "json",
                data: {vigencia: $("#<?php echo $this->campoSeguro('vigencia_disponibilidad') ?>").val(),
                    unidad: $("#<?php echo $this->campoSeguro('unidad_ejecutora') ?>").val()},
                success: function (data) {
                    if (data[0] != " ") {

                        $("#<?php echo $this->campoSeguro('diponibilidad') ?>").html('');
                        $("<option value=''>Seleccione  ....</option>").appendTo("#<?php echo $this->campoSeguro('diponibilidad') ?>");
                        $.each(data, function (indice, valor) {

                            $("<option value='" + data[ indice ].identificador + "'>" + data[ indice ].numero + "</option>").appendTo("#<?php echo $this->campoSeguro('diponibilidad') ?>");

                        });
                        $("#<?php echo $this->campoSeguro('diponibilidad') ?>").removeAttr('disabled');

                        $("#<?php echo $this->campoSeguro('diponibilidad') ?>").select2({
                            placeholder: "Search for a repository",
                            minimumInputLength: 1,
                        });


                    }




                }

            });
        }
        ;


        function infodisponibilidades(elem, request, response) {
            $.ajax({
                url: "<?php echo $urlFinal12 ?>",
                dataType: "json",
                data: {vigencia: $("#<?php echo $this->campoSeguro('vigencia_disponibilidad') ?>").val(),
                    disponibilidad: $("#<?php echo $this->campoSeguro('diponibilidad') ?>").val()},
                success: function (data) {

                    if (data[0] != "null") {
                        $("#<?php echo $this->campoSeguro('fecha_diponibilidad') ?>").val(data[0]);
                        $("#<?php echo $this->campoSeguro('valor_disponibilidad') ?>").val(data[1]);

                        valorLetrasDis();


                    }




                }

            });
        }
        ;


        function registrosP(elem, request, response) {

            $.ajax({
                url: "<?php echo $urlFinal13 ?>",
                dataType: "json",
                data: {vigencia: $("#<?php echo $this->campoSeguro('vigencia_disponibilidad') ?>").val(),
                    disponibilidad: $("#<?php echo $this->campoSeguro('diponibilidad') ?>").val(),
                    unidad: $("#<?php echo $this->campoSeguro('unidad_ejecutora') ?>").val()},
                success: function (data) {
                    if (data[0] != " ") {

                        $("#<?php echo $this->campoSeguro('registro') ?>").html('');
                        $("<option value=''>Seleccione  ....</option>").appendTo("#<?php echo $this->campoSeguro('registro') ?>");
                        $.each(data, function (indice, valor) {

                            $("<option value='" + data[ indice ].identificador + "'>" + data[ indice ].numero + "</option>").appendTo("#<?php echo $this->campoSeguro('registro') ?>");

                        });

                        $("#<?php echo $this->campoSeguro('registro') ?>").removeAttr('disabled');

                        $("#<?php echo $this->campoSeguro('registro') ?>").select2();


                    }




                }

            });
        }
        ;



        function inforegistrosP(elem, request, response) {
            $.ajax({
                url: "<?php echo $urlFinal14 ?>",
                dataType: "json",
                data: {vigencia: $("#<?php echo $this->campoSeguro('vigencia_disponibilidad') ?>").val(),
                    registro: $("#<?php echo $this->campoSeguro('registro') ?>").val()},
                success: function (data) {

                    if (data[0] != "null") {
                        $("#<?php echo $this->campoSeguro('fecha_registro') ?>").val(data[0]);
                        $("#<?php echo $this->campoSeguro('valor_registro') ?>").val(data[1]);

                        valorLetrasReg();


                    }




                }

            });
        }
        ;


        function contratistasC(elem, request, response) {

            $.ajax({
                url: "<?php echo $urlFinal15 ?>",
                dataType: "json",
                data: {vigencia: $("#<?php echo $this->campoSeguro('vigencia_contratista') ?>").val()},
                success: function (data) {
                    if (data[0] != " ") {

                        $("#<?php echo $this->campoSeguro('nombreContratista') ?>").html('');
                        $("<option value=''>Seleccione  ....</option>").appendTo("#<?php echo $this->campoSeguro('nombreContratista') ?>");
                        $.each(data, function (indice, valor) {

                            $("<option value='" + data[ indice ].IDENTIFICADOR + "'>" + data[ indice ].CONTRATISTA + "</option>").appendTo("#<?php echo $this->campoSeguro('nombreContratista') ?>");

                        });

                        $("#<?php echo $this->campoSeguro('nombreContratista') ?>").removeAttr('disabled');


                        $('#<?php echo $this->campoSeguro('nombreContratista') ?>').attr("style", "width: 400px ; '");

                        $("#<?php echo $this->campoSeguro('nombreContratista') ?>").select2({
                            placeholder: "Search for a repository",
                            minimumInputLength: 3,
                        });


                    }





                }

            });
        }
        ;


    });

    $("#<?php echo $this->campoSeguro('cargosExistentes') ?>").change(function () {

        if ($("#<?php echo $this->campoSeguro('cargosExistentes') ?>").val() != '') {
            $("#<?php echo $this->campoSeguro('cargo_supervisor') ?>").val($("#<?php echo $this->campoSeguro('cargosExistentes') ?>").val());
            $("#<?php echo $this->campoSeguro('cargosExistentes') ?>").val("");

        }


    });



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







</script>

<script>

    function registrarNuevoCargo() {
        var cargo = prompt("Por favor digite el nuevo cargo:", "");

        if (cargo != null) {
            var Campo = document.getElementById("<?php echo $this->campoSeguro('cargo_supervisor') ?>");
            Campo.value = cargo;
        }
    }

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
                    $("#ventanaEmergenteContratista").dialog('option', 'title', 'Convenio:');
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

