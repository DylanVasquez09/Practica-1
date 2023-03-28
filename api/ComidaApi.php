<?php

 require_once("../controlador/PeticionesComida.php");
 header("Content-Type: application/json");

 switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':

        $_POST = json_decode(file_get_contents('php://input'), true);
        PeticionesComida::guardarComida($_POST['nombre'], $_POST['valor']);
        break;
    
    case 'GET':
        
        $mensaje = array(
            "Mensaje" => "Funcionando correctamente"
        );
        echo json_encode($mensaje, JSON_FORCE_OBJECT);

    default:
        # code...
        break;
 }


?>