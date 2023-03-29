<?php

 class Pedidos
 {
    private $nombreCliente;
    private $comidaId;
    private $cantidad;
    private $valorTotal;
    private $direccion;
    private $ciudad;
    private $telefonoCliente;



    public function __construct($nombreCliente, $comidaId, $cantidad, $valorTotal, $direccion, $ciudad, $telefonoCliente)
    {
        $this->nombreCliente = $nombreCliente;
        $this->comidaId = $comidaId;
        $this->cantidad = $cantidad;
        $this->valorTotal = $valorTotal;
        $this->direccion = $direccion;
        $this->ciudad = $ciudad;
        $this->telefonoCliente = $telefonoCliente;
    }



    public function getNombreCliente()
    {
        return $this->nombreCliente;
    }



    public function getComidaId()
    {
        return $this->comidaId;
    }



    public function getCantidad()
    {
        return $this->cantidad;
    }



    public function getValorTotal()
    {
        return $this->valorTotal;
    }



    public function getDireccion()
    {
        return $this->direccion;
    }



    public function getCiudad()
    {
        return $this->ciudad;
    }



    public function getTelefonoCliente()
    {
        return $this->telefonoCliente;
    }
 }

?>