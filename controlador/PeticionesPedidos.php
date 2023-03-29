<?php

 require_once("../api/PedidosApi.php");
 require_once("../clases/Conexion.php");
 require_once("../clases/Pedidos.php");

 class PeticionesPedidos
 {
    public static function guardarPedido($nombreCliente, $comidaId, $cantidad, $direccion, $ciudad, $telefonoCliente)
    {
        $conexion = new Conexion();
        $conn = $conexion->conectarBD();
        $fechaPedido = date('Y-m-d');
        $horaPedido = date('h:i');

        $valorComida = 0;
        $ultimoId = 0;
        $sqlHallarValorComida = "SELECT valor FROM comida WHERE id_comida = $comidaId";
        $resultComida = mysqli_query($conn, $sqlHallarValorComida);

        if(mysqli_num_rows($resultComida) == 1) {
            $row = mysqli_fetch_array($resultComida);
            $valorComida = $row['valor'];
        }

        $valorTotal = $valorComida * $cantidad;
        $nuevoPedido = new Pedidos($nombreCliente, $comidaId, $cantidad, $valorTotal, $direccion, $ciudad, $telefonoCliente);

        $sqlGuardarPedido = "INSERT INTO pedidos(nombre_cliente, fecha_pedido, hora_pedido, comida_id, cantidad, valor_total, direccion, ciudad, telefono_cliente)
        VALUES ('" . $nuevoPedido->getNombreCliente() . "', '$fechaPedido', '$horaPedido', " . $nuevoPedido->getComidaId() . ", " . $nuevoPedido->getCantidad() . 
        ", " . $nuevoPedido->getValorTotal() . ", '" . $nuevoPedido->getDireccion() . "', '" . $nuevoPedido->getCiudad() . "', " . $nuevoPedido->getTelefonoCliente()
        . ")";

        $result = mysqli_query($conn, $sqlGuardarPedido);

        $sqlMaximoId = "SELECT MAX(id_pedidos) AS id_pedidos FROM pedidos";
        $resultMaximoId = mysqli_query($conn, $sqlMaximoId);

        if(mysqli_num_rows($resultMaximoId) == 1) {
            $row = mysqli_fetch_array($resultMaximoId);
            $ultimoId = $row['id_pedidos'];
        }

        $sqlInsertCambio = "INSERT INTO pedidos_cambio_estado(pedido_id, estado, fecha_cambio_estado, hora_cambio_estado) 
        VALUES ($ultimoId, 'En espera','$fechaPedido', '$horaPedido')";
        $resultTableCambioEstado = mysqli_query($conn, $sqlInsertCambio);

        if(!$result) {
            $mensaje = array(
                "mensaje" => $sqlGuardarPedido 
            );

            echo json_encode($mensaje, JSON_FORCE_OBJECT);
        }   else {
            $mensaje = array(
                "mensaje" => "Pedido registrado con exito"
            );

            echo json_encode($mensaje, JSON_FORCE_OBJECT);
        }
    }
}

?>