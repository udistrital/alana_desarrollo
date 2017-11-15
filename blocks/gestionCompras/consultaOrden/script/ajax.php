
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

//Variables
$cadenaCiudadesxDepto = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaCiudadesxDepto .= "&procesarAjax=true";
$cadenaCiudadesxDepto .= "&action=index.php";
$cadenaCiudadesxDepto .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaCiudadesxDepto .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaCiudadesxDepto .= $cadenaCiudadesxDepto . "&funcion=consultarCiudadAjax";
$cadenaCiudadesxDepto .= "&tiempo=" . $_REQUEST ['tiempo'];
// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadenaCiudadesxDepto = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaCiudadesxDepto, $enlace);
// URL definitiva
$urlFinalCiudadesxDepto = $url . $cadenaCiudadesxDepto;
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

// Variables
$cadenaACodificarServicio = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificarServicio .= "&procesarAjax=true";
$cadenaACodificarServicio .= "&action=index.php";
$cadenaACodificarServicio .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificarServicio .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificarServicio .= $cadenaACodificarServicio . "&funcion=consultarServicios";
$cadenaACodificarServicio .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadenaServicio = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificarServicio, $enlace);

// URL definitiva
$urlFinalServicio = $url . $cadenaServicio;


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
                            '<label for="vigencia">Número de Amparos Registrados : </label>' +
                            '<input id=numR class=\"pull-center btn btn-default\" type="button"  value="' + parseInt($("#<?php echo $this->campoSeguro('cantidadAmparos_hidden') ?>").val()) + '"/>' +
                            '<br><br>' +
                            $("#<?php echo $this->campoSeguro('tablaVigenciaNueva_hidden') ?>").val() +
                            '<input class=\"pull-left btn btn-default\" type="button" value="Añadir Registro" onclick="agregarAmparo()" />' +
                            '<input class=\"pull-right btn btn-default\" type="button" value="Eliminar Último Registro" onclick="eliminarAmparo()" />'
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
        onFinished: function (event, currentIndex) {
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
            $("#consultaOrden").submit();
        },
        labels: {
            cancel: "Cancelar",
            current: "Paso Siguiente :",
            pagination: "Paginación",
            finish: "Actualizar Información",
            next: "Siquiente",
            previous: "Atras",
            loading: "Cargando ..."
        }

    });


    
    var i;
    var numeracion;

    function agregarAmparo() {

        $resultado = $("#modificarContrato").validationEngine("validate");


        if ($resultado) {

            var lista = "<td>" + (numeracion + 1) + "</td><td><select id='amparo" + (i + 1) + "' name='amparo" + (i + 1) + "' class='form-control input-md '/></td>";

            $('#tab_amparos tr:last').after('<tr id="addr' + (i + 1) + '">' +
                    lista +
                    '<td>' + "<input id='porcentajeamparo" + (i + 1) + "' name='porcentajeamparo" + (i + 1) + "' type='text' placeholder='Porcentaje(%)-> 10%' maxlength='3' class='form-control   custom[number]'>" + '</td>' +
                    '<td>' + "<input id='valoramparo" + (i + 1) + "'  name='valoramparo" + (i + 1) + "' type='text' placeholder='Descripción'  maxlength='500' class='form-control input-md  '>" + '</td>' +
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


            $("#addr" + (i)).remove();
            i--;
            numeracion--;
            $("#amparo" + (i)).attr('disabled', false);
            $("#porcentajeamparo" + (i)).attr('readonly', false);
            $("#valoramparo" + (i)).attr('readonly', false);



            $("#porcentajeamparo" + (i)).val(null);
            $("#valoramparo" + (i)).val(null);
        }
        if (i == 0) {
            $('#amparo0').attr('disabled', false);
            $('#porcentajeamparo0').attr('readonly', false);
            $('#valoramparo0').attr('readonly', false);
        }
        $("#<?php echo $this->campoSeguro('cantidadAmparos_hidden') ?>").val(i);
        $("#numR").val(i);
//            $('#tablamparos tr:last').remove();


    }



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



    ///---------------Consulta Proveedor de Contrato---------------------------------------------------

    $("#<?php echo $this->campoSeguro('selec_proveedor') ?>").autocomplete({
        minChars: 3,
        serviceUrl: '<?php echo $urlFinalProveedor; ?>',
        onSelect: function (suggestion) {

            $("#<?php echo $this->campoSeguro('id_proveedor') ?>").val(suggestion.data);
            consultarInformacionProveedor($("#<?php echo $this->campoSeguro('id_proveedor') ?>").val());
        }


    });

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

//---------------Consulta Proveedor SCCIEDAD de Contrato---------------------------------------------------


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
                    var sizeJson = Object.keys(data[0]).length;
                    for (i = 0; i < sizeJson / 2; i++) {
                        if (data[0][i] == null || data[0][i] == '') {
                            data[0][i] = "SIN INFORMACIÓN";
                        }
                    }
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

//.-




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
                }
            }
        });

    });






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


    //---------------Inicio JavaScript y Ajax Proveedor ---------------------------------------------------------------------------------------------------




    function consultarContratistas(elem, request, response) {
        if ($("#<?php echo $this->campoSeguro('selec_proveedor') ?>").val() != "") {
            $.ajax({
                url: "<?php echo $urlFinalProveedor ?>",
                dataType: "json",
                data: {proveedor: $("#<?php echo $this->campoSeguro('selec_proveedor') ?>").val()},
                success: function (data) {

                    if (data.datos != 'null') {
                        if (data.status == 200) {

                            $("#<?php echo $this->campoSeguro('tipo_persona') ?>").val(data.datos.tipo_persona);
                            if (data.datos.tipo_persona != 'NATURAL') {

                                $("#<?php echo $this->campoSeguro('nombre_Razon_Social') ?>").val(data.datos.nom_empresa);
                                $("#<?php echo $this->campoSeguro('numero_identificacion') ?>").val(data.datos.num_nit_empresa);
                                $("#<?php echo $this->campoSeguro('digito_verificacion') ?>").val(data.datos.digito_verificacion_empresa);
                                $("#<?php echo $this->campoSeguro('telefono') ?>").val(data.datos.telefono_empresa + ' - ' + data.datos.movil_empresa);
                                $("#<?php echo $this->campoSeguro('nacionalidad') ?>").val(data.datos.nom_pais_empresa + ' (' + data.datos.nom_departamento_empresa + ' - ' + data.datos.nom_ciudad_empresa + ')');
                                $("#<?php echo $this->campoSeguro('tipo_identificacion') ?>").val("NIT");
                                $("#<?php echo $this->campoSeguro('identifcacion_contratista') ?>").val(data.datos.num_documento_representante);
                                $("#<?php echo $this->campoSeguro('cargo_contratista') ?>").val(data.datos.cargo_representante);
                                $("#<?php echo $this->campoSeguro('genero') ?>").val(data.datos.genero_empresa);
                                $("#<?php echo $this->campoSeguro('perfil') ?>").val(data.datos.perfil_representante);
                                $("#<?php echo $this->campoSeguro('profesion') ?>").val(data.datos.profesion_representante);
                                $("#<?php echo $this->campoSeguro('especialidad') ?>").val(data.datos.especialidad_representante);
                                $("#<?php echo $this->campoSeguro('nombre_representante') ?>").val(data.datos.primer_nombre_representante + ' '
                                        + data.datos.segundo_nombre_representante + ' ' + data.datos.primer_apellido_representante + ' ' + data.datos.segundo_apellido_representante + ' (' + data.datos.cargo_representante + ')');
                                $("#<?php echo $this->campoSeguro('tipo_cuenta') ?>").val(data.datos.tipo_cuenta_bancaria_empresa);
                                $("#<?php echo $this->campoSeguro('numero_cuenta') ?>").val(data.datos.num_cuenta_bancaria_empresa);
                                $("#<?php echo $this->campoSeguro('entidad_bancaria') ?>").val(data.datos.nom_banco_empresa);
                                $("#<?php echo $this->campoSeguro('tipo_configuracion') ?>").val(data.datos.tipo_conformacion_empresa);
                            } else {

                                $("#<?php echo $this->campoSeguro('nombre_Razon_Social') ?>").val(data.datos.primer_nombre_persona_natural +
                                        ' ' + data.datos.segundo_nombre_persona_natural + ' ' + data.datos.primer_apellido_persona_natural + ' ' +
                                        data.datos.segundo_nombre_persona_natural);
                                $("#<?php echo $this->campoSeguro('numero_identificacion') ?>").val(data.datos.num_documento_persona_natural);
                                $("#<?php echo $this->campoSeguro('digito_verificacion') ?>").val(data.datos.digito_verificacion_persona_natural);
                                $("#<?php echo $this->campoSeguro('telefono') ?>").val(data.datos.telefono_persona_natural + ' - ' + data.datos.movil_persona_natural);
                                $("#<?php echo $this->campoSeguro('nacionalidad') ?>").val(data.datos.pais_nacimiento_persona_natural);
                                $("#<?php echo $this->campoSeguro('cargo_contratista') ?>").val(data.datos.cargo_persona_natural);
                                $("#<?php echo $this->campoSeguro('genero') ?>").val(data.datos.genero_persona_natural);
                                $("#<?php echo $this->campoSeguro('tipo_identificacion') ?>").val(data.datos.tipo_documento_persona_natural);
                                $("#<?php echo $this->campoSeguro('nombre_acesor') ?>").val('N/A');
                                $("#<?php echo $this->campoSeguro('nombre_contratista') ?>").val('N/A');
                                $("#<?php echo $this->campoSeguro('identifcacion_contratista') ?>").val('N/A');
                                $("#<?php echo $this->campoSeguro('perfil') ?>").val(data.datos.perfil_persona_natural);
                                $("#<?php echo $this->campoSeguro('profesion') ?>").val(data.datos.profesion_persona_natural);
                                $("#<?php echo $this->campoSeguro('especialidad') ?>").val(data.datos.especialidad_persona_natural);
                                $("#<?php echo $this->campoSeguro('tipo_cuenta') ?>").val(data.datos.tipo_cuenta_bancaria_persona_natural);
                                $("#<?php echo $this->campoSeguro('numero_cuenta') ?>").val(data.datos.num_cuenta_bancaria_persona_natural);
                                $("#<?php echo $this->campoSeguro('entidad_bancaria') ?>").val(data.datos.nom_banco_persona_natural);
                                $("#<?php echo $this->campoSeguro('tipo_configuracion') ?>").val("N/A");
                                $("#<?php echo $this->campoSeguro('nombre_representante') ?>").val("N/A");

                            }


                            $("#<?php echo $this->campoSeguro('direccion') ?>").val(data.datos.dir_contacto);
                            $("#<?php echo $this->campoSeguro('sitio_web') ?>").val(data.datos.web_contacto);
                            $("#<?php echo $this->campoSeguro('pais') ?>").val(data.datos.nom_pais_contacto + ' (' + data.datos.nom_departamento_contacto + ' - ' + data.datos.nom_ciudad_contacto + ')');


                            $("#<?php echo $this->campoSeguro('correo') ?>").val(data.datos.correo_contacto);





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
            data: {ordenador: $("#<?php echo $this->campoSeguro('ordenador_gasto') ?>").val()},
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
            onSelect: function (suggestions) {

                $("#<?php echo $this->campoSeguro('id_proveedor') ?>").val(suggestions.data);
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


        $("#<?php echo $this->campoSeguro('ordenador_gasto') ?>").change(function () {

            if ($("#<?php echo $this->campoSeguro('ordenador_gasto') ?>").val() != '') {
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



    $("#<?php echo $this->campoSeguro('representante_sociedad') ?>").keyup(function () {
        $('#<?php echo $this->campoSeguro('representante_sociedad') ?>').val($('#<?php echo $this->campoSeguro('representante_sociedad') ?>').val());
    });

    $("#<?php echo $this->campoSeguro('identificacion_clase_contratista') ?>").keyup(function () {
        calcularDigitoCedulaRepre($('#<?php echo $this->campoSeguro('identificacion_clase_contratista') ?>').val());

    });

    $("#<?php echo $this->campoSeguro('representante_sociedad') ?>").autocomplete({
        minChars: 2,
        serviceUrl: '<?php echo $urlRepresentanteSuplente; ?>',
    });

    $("#<?php echo $this->campoSeguro('representante_suplente_sociedad') ?>").keyup(function () {
        $('#<?php echo $this->campoSeguro('representante_suplente_sociedad') ?>').val($('#<?php echo $this->campoSeguro('representante_suplente_sociedad') ?>').val());

    });

    $("#<?php echo $this->campoSeguro('representante_suplente_sociedad') ?>").autocomplete({
        minChars: 2,
        serviceUrl: '<?php echo $urlRepresentanteSuplente; ?>',
    });





    $('#confirmarValidar').on('click', function () {

        var valores_porcentajes = "";
        var identificadores_registro = "";
        $('#tablaParticipantesSociedad tr').each(function () {
            /* Obtener todas las celdas */
            var celdas = $(this).find('td');
            var porcentajes = $(celdas[5]).html();
            var identificadores = $(celdas[0]).html();
            if (typeof porcentajes !== "undefined") {
                valores_porcentajes = valores_porcentajes + "-" + porcentajes.replace(",", ".").match(/[0-9].[0-9]+/);
                identificadores_registro = identificadores_registro + "," + identificadores.match(/[0-9]+/);
            }
            ;

        });

        var validacion = ValidarPorcentajes(valores_porcentajes.substr(1));
        if (validacion == 1) {
            alert("La suma de los porcentajes de participacion no puede ser inferior a 1");
        } else if (validacion == 2) {
            alert("La suma de los porcentajes de participacion no puede ser superior a 1");
        } else if (validacion == 3) {
            $('#<?php echo $this->campoSeguro('porcentajes') ?>').val(valores_porcentajes.substr(1));
            $('#<?php echo $this->campoSeguro('identificadores') ?>').val(identificadores_registro.substr(1));
            $('#<?php echo $this->campoSeguro('bandera_de_edicion') ?>').val("true");
            alert("Modificaciones Almacenadas con Exito");
        } else {
            alert("Todas las Filas de la Columna Porcentaje deben tener un formato apropiado y estar registradas");

        }
    });


    function ValidarPorcentajes(Porcentajes) {
        var acumulado = 0;
        Porcentajes = Porcentajes.split("-");
        for (i = 0; i <= Porcentajes.length - 1; i++) {
            acumulado = acumulado + Number(Porcentajes[i]);
        }
        $('#<?php echo $this->campoSeguro('total_acumulado') ?>').val(acumulado);

        if (typeof acumulado !== "undefined") {
            if (acumulado < 1) {
                return 1;
            } else if (acumulado > 1) {
                return 2;
            } else if (acumulado == 1) {
                return 3;
            }
        } else {
            return false;
        }
    }
    ;

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
            $("#<?php echo $this->campoSeguro('digito_verificacion_clase_contratista') ?>").val(digito_verificacion);
        }
    }
    ;



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



    $(function () {
        $(":checkbox").change(function () {
            var id = $(this).attr('id').substr(6);
            if ($(this).is(':checked')) {


                $('.datepicker').datepicker();

                var f1 = document.createElement("INPUT");
                f1.setAttribute("type", "date");
                f1.setAttribute("name", "fecha_inicio_poliza" + id);
                f1.className = "datepicker";
                f1.setAttribute("class", "ui-widget ui-widget-content ui-corner-all validate[required] date-poliza ");
                f1.setAttribute("align", " right");
                $(f1).datepicker({
                    dateFormat: 'yy-mm-dd',
                    changeMonth: true,
                    changeYear: true,
                    monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
                        'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                    monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                    dayNames: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
                    dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
                    dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
                });
                var h1 = document.createElement("P")
                h1.setAttribute("class", "date-text");
                var l1 = document.createTextNode("Fecha Inicial");
                h1.appendChild(l1);
                var f2 = document.createElement("INPUT");
                f2.setAttribute("type", "date");
                f2.setAttribute("name", "fecha_final_poliza" + id);
                f2.className = "datepicker";
                f2.setAttribute("class", "ui-widget ui-widget-content ui-corner-all validate[required] date-poliza");
                f2.setAttribute("align", " right");
                $(f2).datepicker({
                    dateFormat: 'yy-mm-dd',
                    changeMonth: true,
                    changeYear: true,
                    monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
                        'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                    monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                    dayNames: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
                    dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
                    dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
                });

                var h2 = document.createElement("P")
                h2.setAttribute("class", "date-text");
                var l2 = document.createTextNode("Fecha Final");
                h2.appendChild(l2);

                var table = document.createElement("TABLE");
                table.setAttribute("class", "table-poliza");
                table.setAttribute("id", "table")
                var fila1 = document.createElement("TR");
                fila1.setAttribute("id", "tr1")
                var celda1 = document.createElement("TD");
                celda1.setAttribute("id", "td1")
                var celda2 = document.createElement("TD");
                celda2.setAttribute("id", "td2")
                var celda3 = document.createElement("TD");
                celda3.setAttribute("id", "td3")
                var celda4 = document.createElement("TD");
                celda4.setAttribute("id", "td4")

                celda1.appendChild(h1);
                celda2.appendChild(f1);
                celda3.appendChild(h2);
                celda4.appendChild(f2);
                fila1.appendChild(celda1);
                fila1.appendChild(celda2);
                fila1.appendChild(celda3);
                fila1.appendChild(celda4);
                table.appendChild(fila1);


                document.getElementById('divisionPoliza' + id).appendChild(table);
                document.getElementById('divisionPoliza' + id).setAttribute("class", "container-date");
                $("#divisionPoliza" + id).css('display', 'block');

            } else {
                $("#divisionPoliza" + id).css('display', 'none');
                var myNode = document.getElementById('divisionPoliza' + id);
                while (myNode.firstChild) {
                    myNode.removeChild(myNode.firstChild);
                }

            }

        });
    });

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
            url: "<?php echo $urlFinalCiudadesxDepto ?>",
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
//-------------------------------- Fin Ajax Ciudades por Depto.---------------------------------
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
            url: "<?php echo $urlFinal16 ?>",
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
            url: "<?php echo $urlFinalCiudadesxDepto ?>",
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

//--------------Inicio JavaScript y Ajax Clase servicio y servicio---------------------------------------------------------------------------------------------    

    $("#<?php echo $this->campoSeguro('tipo_servicio') ?>").change(function () {

        if ($("#<?php echo $this->campoSeguro('tipo_servicio') ?>").val() != '') {
            consultarServicios();
        } else {
            $("#<?php echo $this->campoSeguro('codigo_ciiu') ?>").attr('disabled', '');
        }

    });

    function consultarServicios(elem, request, response) {
        $.ajax({
            url: "<?php echo $urlFinalServicio ?>",
            dataType: "json",
            data: {valor: $("#<?php echo $this->campoSeguro('tipo_servicio') ?>").val()},
            success: function (data) {



                if (data[0] != " ") {

                    $("#<?php echo $this->campoSeguro('codigo_ciiu') ?>").html('');
                    $("<option value=''>Seleccione  ....</option>").appendTo("#<?php echo $this->campoSeguro('codigo_ciiu') ?>");
                    $.each(data, function (indice, valor) {

                        $("<option value='" + data[ indice ].id_subclase + "'>" + data[ indice ].nombre + "</option>").appendTo("#<?php echo $this->campoSeguro('codigo_ciiu') ?>");

                    });

                    $("#<?php echo $this->campoSeguro('codigo_ciiu') ?>").removeAttr('disabled');

                    $('#<?php echo $this->campoSeguro('codigo_ciiu') ?>').width(350);
                    $("#<?php echo $this->campoSeguro('codigo_ciiu') ?>").select2();



                }


            }

        });
    }
    ;

    //--------------Fin JavaScript y Ajax Clase Servicio y servicio --------------------------------------------------------------------------------------------------   


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

    //Gestion Participantes
    $(document).ready(function () {

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
                            return true;
                        }
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

            }
        });





    });


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


</script>