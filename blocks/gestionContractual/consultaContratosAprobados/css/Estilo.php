<?php

$indice = 0;
$estilo[$indice++] = "ui.jqgrid.css";
$estilo[$indice++] = "ui.multiselect.css";
$estilo[$indice++] = "timepicker.css";
$estilo[$indice++] = "jquery-te.css";
$estilo[$indice++] = "validationEngine.jquery.css";
$estilo[$indice++] = "jquery.auto-complete.css";
$estilo[$indice++] = "chosen.css";
$estilo[$indice++] = "select2.css";
$estilo[$indice++] = "jquery_switch.css";
$estilo[$indice++] = "jquery.steps.css";
$estilo[$indice++] = "jquery-ui.css";

// Tablas
$estilo[$indice++] = "demo_page.css";
$estilo[$indice++] = "demo_table.css";
$estilo[$indice++] = "jquery.dataTables.css";
$estilo[$indice++] = "jquery.dataTables_themeroller.css";
$estilo[$indice++] = "modal.css";

// Bootstrap
$estilo[$indice++] = "bootstrap-theme.css";
$estilo[$indice++] = "bootstrap-theme.min.css";
$estilo[$indice++] = "jquery.dataTables.css";
$estilo[$indice++] = "bootstrap.css";
$estilo[$indice++] = "bootstrap.min.css";





$rutaBloque = $this->miConfigurador->getVariableConfiguracion("host");
$rutaBloque.=$this->miConfigurador->getVariableConfiguracion("site");

if ($unBloque["grupo"] == "") {
    $rutaBloque.="/blocks/" . $unBloque["nombre"];
} else {
    $rutaBloque.="/blocks/" . $unBloque["grupo"] . "/" . $unBloque["nombre"];
}

foreach ($estilo as $nombre) {
    echo "<link rel='stylesheet' type='text/css' href='" . $rutaBloque . "/css/" . $nombre . "'>\n";
}
?>
