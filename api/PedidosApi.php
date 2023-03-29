<?php

 require_once("../controlador/PeticionesPedidos.php");
 header("Content-Type: application/json");

 switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        $_POST = json_decode(file_get_contents('php://input'), true);
        PeticionesPedidos::guardarPedido($_POST['nombreCliente'], $_POST['comidaId'], $_POST['cantidad'],
        $_POST['direccion'], $_POST['ciudad'], $_POST['telefonoCliente']);
        break;
    
    default:
        # code...
        break;
 }

?>