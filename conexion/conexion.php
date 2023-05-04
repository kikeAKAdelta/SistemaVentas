<?php

/**
 * Clase por medio de la cual nos conectamos a la BD
 */
class Conexion{

    private $servidor;
    private $usuario;
    private $password;
    private $bd;

    public function __construct(){
        $this->servidor     = "localhost";
        $this->usuario      = "root";
        $this->password     = "";
        $this->bd           = "ventas";
    }

    public function conexion(){

        $conexion = new mysqli($this->servidor, $this->usuario, $this->password, $this->bd);

        return $conexion;
    }

}





?>