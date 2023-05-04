<?php

/**
 * Clase de Usuarios de la base de datos
 */
class Usuarios{

    private int $id_usuario;
    private string $nombre;
    private string $apellido;
    private string $email;
    private string $password;
    private $fechaCaptura;
    private int $estado;

    public __construct(){}

    public function setIdUsuario(int $id_usuario){
        $this->id_usuario = $id_usuario;
    }

    public function getIdUsuario(){
        return $this->id_usuario;
    }

    public function setNombre(string $nombre){
        $this->nombre = $nombre;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function setApellido(string $apellido){
        $this->apellido = $apellido;
    }

    public function getApellido(){
        return $this->apellido;
    }

    public function setEmail(string $email;){
        $this->email = $email;
    }

    public function getEmail(){
        return $this->email;
    }

    public function setPassword(string $password){
        $this->password = $password;
    }

    public function getPassword(){
        return $this->password;
    }

    public function setFechaCaptura($fechaCaptura){
        $this->fechaCaptura = $fechaCaptura; 
    }

    public function getFechaCaptura(){
        return $this->fechaCaptura;
    }

    public function setEstado(int $estado){
        $this->estado = $estado;
    }

    public function getEstado(){
        return $this->estado;
    }
}



?>