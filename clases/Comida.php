<?php

 class Comida
 {
    private $nombre;
    private $valor;



    public function __construct($nombre, $valor) 
    {
        $this->nombre = $nombre;
        $this->valor = $valor;
    }



    public function getNombre() 
    {
        return $this->nombre;
    }



    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }



    public function getValor()
    {   
        return $this->valor;
    }



    public function setValor($valor)
    {
        $this->valor = $valor;
    }
 }

?>