window.onload = detectarCarga;

function detectarCarga() {
    $('#marcoDatos').show('slow');
}
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
$cadenaACodificarDependencia = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificarDependencia .= "&procesarAjax=true";
$cadenaACodificarDependencia .= "&action=index.php";
$cadenaACodificarDependencia .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificarDependencia .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificarDependencia .= $cadenaACodificarDependencia . "&funcion=consultarDependencia";
$cadenaACodificarDependencia .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadenaDependencia = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificarDependencia, $enlace);

// URL definitiva
$urlFinalDependencia = $url . $cadenaDependencia;

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
// Variables
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

// Variables

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


$cadenaACodificarCdps = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificarCdps .= "&procesarAjax=true";
$cadenaACodificarCdps .= "&action=index.php";
$cadenaACodificarCdps .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificarCdps .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificarCdps .= $cadenaACodificarCdps . "&funcion=ObtenerCdps";
$cadenaACodificarCdps .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadenaACodificarCdps = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificarCdps, $enlace);

// URL definitiva
$urlFinalCdps = $url . $cadenaACodificarCdps;



$cadenaParticipante = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaParticipante .= "&procesarAjax=true";
$cadenaParticipante .= "&action=index.php";
$cadenaParticipante .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaParticipante .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaParticipante .= $cadenaParticipante . "&funcion=ObtenerParticipanteTemporal";
$cadenaParticipante .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadenaParticipante = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaParticipante, $enlace);

// URL definitiva
$urlParticipante = $url . $cadenaParticipante;


$cadenaInfoParticipante = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaInfoParticipante .= "&procesarAjax=true";
$cadenaInfoParticipante .= "&action=index.php";
$cadenaInfoParticipante .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaInfoParticipante .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaInfoParticipante .= $cadenaInfoParticipante . "&funcion=ObtenerInfoParticipante";
$cadenaInfoParticipante .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadenaInfoParticipante = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaInfoParticipante, $enlace);

// URL definitiva
$urlInfoParticipante = $url . $cadenaInfoParticipante;

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
?>
<script type='text/javascript'>



    $(document).ready(function () {

        var table2 = $('#tablaDisponibilidades').DataTable();
        var table3 = $('#tablaRegistros').DataTable();

    });
    //----------------------------Configuracion Paso a Paso--------------------------------------
    $("#ventanaA").steps({
        headerTag: "h3",
        bodyTag: "section",
        enableAllSteps: true,
        enablePagination: true,
        transitionEffect: "slideLeft",
        onStepChanging: function (event, currentIndex, newIndex) {

            resultado = $("#registrarOrden").validationEngine("validate");

            if (currentIndex === 0 && ($("#<?php echo $this->campoSeguro('poliza') ?>").val()) === 'Si Aplica' && $("#ventanaA").find('section').length === 8)
            {
                $("#ventanaA").steps("insert", 1, {
                    title: "Garantias y Mecanismos de Cobertura del Riesgo ",
                    content:
                            '<label for="vigencia">Número de Amparos Registrados : </label>' +
                            '<input id=numR class=\"pull-center btn btn-default\" type="button"  value="0"/>' +
                            '<br><br>' +
                            $("#<?php echo $this->campoSeguro('tablaVigenciaNueva_hidden') ?>").val() +
                            '<input class=\"pull-left btn btn-default\" type="button" value="Añadir Registro" onclick="agregarAmparo()" />' +
                            '<input class=\"pull-right btn btn-default\" type="button" value="Eliminar Último Registro" onclick="eliminarAmparo()" />'
                });
                $("#amparo0").width(300);
                $("#amparo0").select2();
            }
            
            
            if (currentIndex === 0 && ($("#<?php echo $this->campoSeguro('poliza') ?>").val()) === 'No Aplica' && $("#ventanaA").find('section').length !== 8)
            {


                $("#ventanaA").steps("remove", 1, {
                    title: "Step Title",
                    content: "<p>Step Body</p>"
                });
            }

            if (resultado) {
                return true;
            } else {

                return false;
            }

        },
        onFinished: function (event, currentIndex) {
        	 var camposA = '';
            var camposS = '';
            var camposV = '';


            $('#tab_amparos tr').each(function (index, element) {



                camposA = camposA + $('#amparo' + index).val() + ',',
                        camposS = camposS + $('#porcentajeamparo' + index).val() + ',',
                        camposV = camposV + $('#valoramparo' + index).val() + ',';


            });

            $("#<?php echo $this->campoSeguro('tablAmparos_hidden') ?>").val(camposA);
            $("#<?php echo $this->campoSeguro('tablaSuficiencia_hidden') ?>").val(camposS);
            $("#<?php echo $this->campoSeguro('tablaVigencia_hidden') ?>").val(camposV);
            $("#registrarOrden").submit();
        },
        labels: {
            cancel: "Cancelar",
            current: "Paso Siguiente :",
            pagination: "Paginación",
            finish: "Guardar Información",
            next: "Siquiente",
            previous: "Atras",
            loading: "Cargando ..."
        }

    });


    //---------------Consulta Proveedor UNICO de Contrato---------------------------------------------------


    $("#<?php echo $this->campoSeguro('selec_proveedor') ?>").autocomplete({
        minChars: 3,
        serviceUrl: '<?php echo $urlFinalProveedor; ?>',
        onSelect: function (suggestion) {

            $("#<?php echo $this->campoSeguro('id_proveedor') ?>").val(suggestion.data);
            consultarInformacionProveedor($("#<?php echo $this->campoSeguro('id_proveedor') ?>").val());
        }


    });

        var i = 0;
    var numeracion = 1;
    
     
    function agregarAmparo() {
    
    
         

        $resultado = $("#registrarContrato").validationEngine("validate");


        if ($resultado) {

            var lista = "<td>" + (numeracion + 1) + "</td><td><select id='amparo" + (i + 1) + "' name='amparo" + (i + 1) + "' class='form-control input-md'/></td>";

            $('#tab_amparos tr:last').after('<tr id="addr' + (i + 1) + '">' +
                    lista +
                    '<td>' + "<input id='porcentajeamparo" + (i + 1) + "' name='porcentajeamparo" + (i + 1) + "' type='text' placeholder='Porcentaje(%)-> 10%' maxlength='3' class='form-control   custom[number]'>" + '</td>' +
                    '<td>' + "<input id='valoramparo" + (i + 1) + "'  name='valoramparo" + (i + 1) + "' type='text' placeholder='Vigencia'  maxlength='50' class='form-control input-md  '>" + '</td>' +
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
            $("#addr" + (i)).html('');
            i--;
            numeracion--;
            $("#amparo" + (i)).attr('disabled', false);
            $("#porcentajeamparo" + (i)).attr('readonly', false);
            $("#valoramparo" + (i)).attr('readonly', false);
        }
        if (i == 0) {
            $('#amparo0').attr('disabled', false);
            $('#porcentajeamparo0').attr('readonly', false);
            $('#valoramparo0').attr('readonly', false);
        }
        $("#<?php echo $this->campoSeguro('cantidadAmparos_hidden') ?>").val(i);
        $("#numR").val(i);


    }


    function CalcularPorcentajeAmparo(i) {
        var i = i - 1;
        var valorPorcentaje = $("#porcentajeamparo" + i).val();
        if (valorPorcentaje > 0) {
//            var valor_contrato = $('#<?php echo $this->campoSeguro('valor_contrato') ?>').val();
//            var valor_amparo = (valorPorcentaje * valor_contrato) / 100;
//            $("#valoramparo" + i).val(valor_amparo);
        } else {
            $("#valoramparo" + i).val("");
            alert("El porcentaje no es un valor Valido.")
        }
    }

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
            url: "<?php echo $urlFinalDependencia ?>",
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


    //--------------Inicio JavaScript y Ajax Sede y Dependencia Suepervisor ---------------------------------------------------------------------------------------------    
    $("#<?php echo $this->campoSeguro('sede_super') ?>").change(function () {

        if ($("#<?php echo $this->campoSeguro('sede_super') ?>").val() != '') {
            consultarDependenciaSuper();
        } else {
            $("#<?php echo $this->campoSeguro('dependencia_supervisor') ?>").attr('disabled', '');
        }

    });


    function consultarDependenciaSuper(elem, request, response) {
        $.ajax({
            url: "<?php echo $urlFinalDependencia ?>",
            dataType: "json",
            data: {valor: $("#<?php echo $this->campoSeguro('sede_super') ?>").val()},
            success: function (data) {
                if (data[0] != " ") {

                    $("#<?php echo $this->campoSeguro('dependencia_supervisor') ?>").html('');
                    $("<option value=''>Seleccione  ....</option>").appendTo("#<?php echo $this->campoSeguro('dependencia_supervisor') ?>");
                    $.each(data, function (indice, valor) {

                        $("<option value='" + data[ indice ].ESF_CODIGO_DEP + "'>" + data[ indice ].ESF_DEP_ENCARGADA + "</option>").appendTo("#<?php echo $this->campoSeguro('dependencia_supervisor') ?>");

                    });

                    $("#<?php echo $this->campoSeguro('dependencia_supervisor') ?>").removeAttr('disabled');

                    $('#<?php echo $this->campoSeguro('dependencia_supervisor') ?>').width(350);
                    $("#<?php echo $this->campoSeguro('dependencia_supervisor') ?>").select2();

                }


            }

        });
    }
    ;
//--------------Fin JavaScript y Ajax Sede y Dependencia Suepervisor --------------------------------------------------------------------------------------------------   
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

//--------------Inicio JavaScript y Ajax Cargo Suepervisor ---------------------------------------------------------------------------------------------    


    $("#<?php echo $this->campoSeguro('nombre_supervisor') ?>").change(function () {

        if ($("#<?php echo $this->campoSeguro('nombre_supervisor') ?>").val() != '') {
            cargoSuper();
        }

    });

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


//--------------Fin JavaScript y Ajax Cargo Suepervisor ---------------------------------------------------------------------------------------------    


//--------------Inicio JavaScript y Ajax Nombre Ordenador ---------------------------------------------------------------------------------------------    

    $("#<?php echo $this->campoSeguro('ordenador_gasto') ?>").change(function () {

        if ($("#<?php echo $this->campoSeguro('ordenador_gasto') ?>").val() != '') {

            datosOrdenador();
        } else {
            $("#<?php echo $this->campoSeguro('nombreOrdenador') ?>").val('');
        }



    });
    function datosOrdenador(elem, request, response) {
        $.ajax({
            url: "<?php echo $urlFinal6 ?>",
            dataType: "json",
            data: {ordenador: $("#<?php echo $this->campoSeguro('ordenador_gasto') ?>").val()},
            success: function (data) {

                if (data[0] != 'null') {

                    $("#<?php echo $this->campoSeguro('nombreOrdenador') ?>").val(data[0]);
                    $("#<?php echo $this->campoSeguro('id_ordenador') ?>").val(data[1]);

                }

            }

        });
    }
    ;
//--------------Fin JavaScript y Ajax Nombre Ordenador ---------------------------------------------------------------------------------------------    
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



//---------------Inicio JavaScript y Ajax Letras ---------------------------------------------------------------------------------------------------

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
                    $("#<?php echo $this->campoSeguro('cargo_contratista') ?>").val('');


                } else {





                }

            }

        });
    }
    ;

//---------------Fin JavaScript y Ajax Proveedor ---------------------------------------------------------------------------------------------------






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
                        $("#<?php echo $this->campoSeguro('actividades') ?>").val(data[0].OBSERVACIONES);
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
                    $("#<?php echo $this->campoSeguro('actividades') ?>").val("");
                }


            }
        });

    });
//---------------------Fin Ajax Numero de Solicitud de Necesidad------------------   

    $(function () {


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

        $("#<?php echo $this->campoSeguro('unidad_ejecutora') ?>").change(function () {

            if ($("#<?php echo $this->campoSeguro('unidad_ejecutora') ?>").val() != '') {

                disponibilidades();

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


        $("#<?php echo $this->campoSeguro('valor_registro') ?>").keyup(function () {


            if ($("#<?php echo $this->campoSeguro('valor_registro') ?>").val() != "") {

                valorLetras();

            } else {

                $("#<?php echo $this->campoSeguro('valorLetras_registro') ?>").val('');


            }

        });

        $("#<?php echo $this->campoSeguro('cargoJefeSeccion') ?>").change(function () {


            if ($("#<?php echo $this->campoSeguro('cargoJefeSeccion') ?>").val() != '') {
                datosCargo();
            } else {
                $Inicio("#<?php echo $this->campoSeguro('nombreJefeSeccion') ?>").val('');
            }


        });


        $("#<?php echo $this->campoSeguro('dependencia_supervisor') ?>").change(function () {


            if ($("#<?php echo $this->campoSeguro('dependencia_supervisor') ?>").val() != '') {
                datosCargoDe();
            } else {
                $("#<?php echo $this->campoSeguro('nombre_supervisor') ?>").val('');
            }


        });

    });




    $("#<?php echo $this->campoSeguro('cargosExistentes') ?>").change(function () {

        if ($("#<?php echo $this->campoSeguro('cargosExistentes') ?>").val() != '') {
            $("#<?php echo $this->campoSeguro('cargo_supervisor') ?>").val($("#<?php echo $this->campoSeguro('cargosExistentes') ?>").val());
            $("#<?php echo $this->campoSeguro('cargosExistentes') ?>").val("");

        }


    });




    //--------------Fin JavaScript y Ajax CDP x Solicitud --------------------------------------------------------------------------------------------------   





    $(function () {


        $("#<?php echo $this->campoSeguro('participante_sociedad') ?>").keyup(function () {
            $('#<?php echo $this->campoSeguro('participante_sociedad') ?>').val($('#<?php echo $this->campoSeguro('participante_sociedad') ?>').val());

        });

        $("#<?php echo $this->campoSeguro('participante_sociedad') ?>").autocomplete({
            minChars: 2,
            serviceUrl: '<?php echo $urlParticipante; ?>',
            onSelect: function (suggestion) {

                $("#<?php echo $this->campoSeguro('id_participante') ?>").val(suggestion.data);
                InformacionParticipante();

            }


        });


        function InformacionParticipante(elem, request, response) {

            $.ajax({
                url: "<?php echo $urlInfoParticipante ?>",
                dataType: "json",
                data: {id: $("#<?php echo $this->campoSeguro('id_participante') ?>").val()},
                success: function (data) {


                    if (data[0] != " ") {
                        var table = $('#tablaParticipantesSociedad').DataTable();

                        if ($("#<?php echo $this->campoSeguro('porcentaje_clase_contratista') ?>").val() != "") {

                            var bandera = 0;
                            if ($("#<?php echo $this->campoSeguro('porcentajes') ?>").val() != "") {
                                var acumulado = 0;
                                var porcentajes = ($("#<?php echo $this->campoSeguro('porcentajes') ?>").val()).split("-");
                                console.log(porcentajes);
                                for (i = 1; i < porcentajes.length; i++) {
                                    acumulado = acumulado + Number(porcentajes[i]);

                                }
                                acumulado = acumulado + Number($("#<?php echo $this->campoSeguro('porcentaje_clase_contratista') ?>").val());
                                if (acumulado > 1) {
                                    bandera = 1;
                                } else {
                                    bandera = 0;
                                }
                            }
                            if (bandera != 1) {

                                $("#<?php echo $this->campoSeguro('cedulas_participante') ?>").val($("#<?php echo $this->campoSeguro('cedulas_participante') ?>").val() + ',' + data[0][0]);
                                $("#<?php echo $this->campoSeguro('porcentajes') ?>").val($("#<?php echo $this->campoSeguro('porcentajes') ?>").val() + '-' + $("#<?php echo $this->campoSeguro('porcentaje_clase_contratista') ?>").val());



                                table.row.add([(data[0][1]),
                                    (data[0][0]),
                                    (data[0][2]),
                                    (data[0][3]),
                                    ($("#<?php echo $this->campoSeguro('porcentaje_clase_contratista') ?>").val()),
                                    ('eliminar'),
                                ]).draw(false);

                                $("#<?php echo $this->campoSeguro('porcentaje_clase_contratista') ?>").val("");
                                $("#<?php echo $this->campoSeguro('participante_sociedad') ?>").val("");
                                $("#<?php echo $this->campoSeguro('total_acumulado') ?>").val(acumulado);
                            } else {
                                alert("La suma de los porcentajes de participacion no debe ser superior a 1.")
                                $("#<?php echo $this->campoSeguro('porcentaje_clase_contratista') ?>").val("");
                                $("#<?php echo $this->campoSeguro('participante_sociedad') ?>").val("");
                            }

                        } else {

                            alert("Debe Ingresar un porcentaje de participacion antes de agregar al participante.")
                            $("#<?php echo $this->campoSeguro('participante_sociedad') ?>").val("");
                        }
                    }


                }

            });
        }
        ;

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
            $("#<?php echo $this->campoSeguro('digito_verificacion_clase_contratista') ?>").val(digito_verificacion);
        }
    }





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
//
////---------------------------- Lugar de Ejecucion Ajax------------------------------------------------
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
            url: "<?php echo $urlFinalDependencia ?>",
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







</script>
