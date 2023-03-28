<?php

function validacionFormulario($nombre, $valor)
{
    $nombreSinEspaciones = trim($nombre);

    if(strlen($nombreSinEspaciones) <= 0 || strlen($valor) <= 0) {
        $mensaje = array(
            "mensaje" => "No pueden haber campos vacios"
        );
        return json_encode($mensaje, JSON_FORCE_OBJECT);
    } elseif(!is_numeric($valor)) {
        $mensaje = array(
            "mensaje" => "Solo valores numericos en el campo de valor"
        );
        return json_encode($mensaje, JSON_FORCE_OBJECT);
    }
}

?>