<?php

 class Conexion
 {
    private $server;
    private $user;
    private $password;
    private $bd;



    public function __construct()
    {

    }



    public function conectarBD() 
    {

        $this->server = 'localhost';
        $this->user = 'admin';
        $this->password = 'admin';
        $this->bd = 'practica';

        return mysqli_connect($this->server, $this->user, $this->password, $this->bd);
    }
 }

?>