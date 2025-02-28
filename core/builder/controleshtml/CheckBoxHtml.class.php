<?php
require_once ("core/builder/HtmlBase.class.php");


class CheckBoxHtml extends HtmlBase{
    
    function campoCuadroSeleccion($atributos) {
    
        $this->cadenaHTML = "";
        
        $this->campoSeguro();
    
        if (! isset ( $atributos [self::SINDIVISION] )) {
    
            if (isset ( $atributos [self::ESTILO] ) && $atributos [self::ESTILO] != "") {
                $this->cadenaHTML .= "<div class='" . $atributos [self::ESTILO] . "'>\n";
            } else {
                $this->cadenaHTML .= "<div class='campoCuadroSeleccion anchoColumna1'>\n";
            }
        }
    
        $this->cadenaHTML .= $this->checkBox ($atributos );
        if (! isset ( $atributos [self::SINDIVISION] )) {
            $this->cadenaHTML .= "\n</div>\n";
        }
        return $this->cadenaHTML;
    
    }
    
    function checkBox($misAtributos) {
    
        $this->setAtributos ( $misAtributos );
    
        $this->miOpcion = "";
        $this->miOpcion .= self::HTMLLABEL . "'" . $this->atributos [self::ID] . "'>";
        $this->miOpcion .= $this->atributos [self::ETIQUETA];
        $this->miOpcion .= self::HTMLENDLABEL;
    
        $this->miOpcion .= "<input type='checkbox' ";
    
        if (isset ( $this->atributos [self::ID] )) {
            $this->miOpcion .= self::HTMLNAME . "'" . $this->atributos [self::ID] . "' ";
            $this->miOpcion .= "id='" . $this->atributos [self::ID] . "' ";
        }
    
        if (isset ( $this->atributos [self::VALOR] )) {
            $this->miOpcion .= self::HTMLVALUE . "'" . $this->atributos [self::VALOR] . "' ";
        }
    
        if (isset ( $this->atributos [self::TABINDEX] )) {
            $this->miOpcion .= self::HTMLTABINDEX . "'" . $this->atributos [self::TABINDEX] . "' ";
        }
    
        if (isset ( $this->atributos [self::EVENTO] )) {
            $this->miOpcion .= $this->atributos [self::EVENTO] . "=\"" . $this->atributos ["eventoFuncion"] . "\" ";
        }
    
        if (isset ( $this->atributos [self::SELECCIONADO] ) && $this->atributos [self::SELECCIONADO]) {
            $this->miOpcion .= "checked ";
        }
    
        $this->miOpcion .= "/>";
        return $this->miOpcion;
    
    }
    
    
    
}