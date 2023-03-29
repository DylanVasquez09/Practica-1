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



    public static function mostrarPedidos()
    {
        $conexion = new Conexion();
        $conn = $conexion->conectarBD();

        $sqlReportePedidos = "SELECT pce.id, p.nombre_cliente, p.fecha_pedido, p.hora_pedido, p.cantidad, p.valor_total, p.direccion, p.ciudad, p.telefono_cliente, c. nombre, c.valor,
        pce.estado, pce.fecha_cambio_estado, pce.hora_cambio_estado
        FROM pedidos as p INNER JOIN pedidos_cambio_estado as pce ON p.id_pedidos = pce.pedido_id INNER JOIN comida as c ON p.comida_id = c.id_comida";

        $result = mysqli_query($conn, $sqlReportePedidos);

        while ($row = mysqli_fetch_array($result)) {

            $datos = array(
                "Id" => $row['id'],
                "Nombre cliente" => $row['nombre_cliente'],
                "Fecha pedido" => $row['fecha_pedido'],
                "Hora pedido" => $row['hora_pedido'],
                "Cantidad" => $row['cantidad'],
                "Valor total" => $row['valor_total'],
                "Direccion" => $row['direccion'],
                "Ciudad" => $row['ciudad'],
                "Telefono" => $row['telefono_cliente'],
                "Nombre producto" => $row['nombre'],
                "Valor producto" => $row['valor'],
                "Estado" => $row['estado'],
                "Fecha del cambio de estado" => $row['fecha_cambio_estado'],
                "Hora del cambio de estado" => $row['hora_cambio_estado']
            );

            echo json_encode($datos, JSON_FORCE_OBJECT);
        }
    }



    public static function cambioEstado($id, $estado)
    {
        $conexion = new Conexion();
        $conn = $conexion->conectarBD();
        $fechaCambioEstado = date('Y-m-d');
        $horaCambioEstado = date('h:i');

        if($estado == 1) {
            $sqlCambioEstado = "UPDATE pedidos_cambio_estado SET estado = 'En preparacion', fecha_cambio_estado = NOW(), hora_cambio_estado =  NOW() 
            WHERE id = $id";
            mysqli_query($conn, $sqlCambioEstado);
        } elseif ($estado == 2) {
            $sqlCambioEstado = "UPDATE pedidos_cambio_estado SET estado = 'En reparto', fecha_cambio_estado = NOW(), hora_cambio_estado =  NOW()
            WHERE id = $id";
            mysqli_query($conn, $sqlCambioEstado);
        } elseif ($estado == 3) {
            $sqlCambioEstado = "UPDATE pedidos_cambio_estado SET estado = 'Entregado',fecha_cambio_estado = NOW(), hora_cambio_estado =  NOW() 
            WHERE id = $id";
            mysqli_query($conn, $sqlCambioEstado);
        } else {
            $mensaje = array(
                "Mensaje" => "Tipo de estado no valido"
            );

            echo json_encode($mensaje, JSON_FORCE_OBJECT);
            die();
        }

        PeticionesPedidos::mostrarPedidos();
    }
}

?>