<?php

 require_once("../clases/Comida.php");
 include("../clases/Conexion.php");
 include("../validaciones/validaciones.php");

 class PeticionesComida
 {

    public static function guardarComida($nombre, $valor)
    {
        $conexion = new Conexion();
        $conn = $conexion->conectarBD();
        $validacion = validacionFormulario($nombre, $valor);
        
        if(isset($validacion)) {
            echo $validacion;
            die();
        }

        $comida = new Comida($nombre, $valor);
        $sql = "INSERT INTO comida(nombre, valor) VALUES ('". $comida->getNombre() . "', " . $comida->getValor() . ")";
        $result = mysqli_query($conn, $sql);

        if(!$result) {
            $mensaje = array(
                "mensaje" => "Hubo un error en la base de datos"
            );

            echo json_encode($mensaje, JSON_FORCE_OBJECT);
        } else {

            $mensaje = array(
                "mensaje" => "Comida creada con exito"
            );

            echo json_encode($mensaje, JSON_FORCE_OBJECT);
        }
    }
 }

?>