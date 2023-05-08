<?php

date_default_timezone_set('America/Mexico_City');
require_once "../../conexion/conexion.php";

class Usuarios{
    
    public function __construct(){}

    /**
     * Funcion encargada de listar todos los usuarios
     */
    public function listarUsuarios(): array{

        $objConexion = new Conexion();
        $conexion    = $objConexion->conexion();

        $sql = "SELECT 
                        USU.ID_USUARIO
                    ,	USU.USUARIO
                    ,	USU.NOMBRE
                    ,	USU.APELLIDO
                    ,	USU.TIPO_USUARIO
                    ,   (SELECT NOMBRE FROM TIPO_USUARIO WHERE TIPO_USUARIO = USU.TIPO_USUARIO) NOMBRE_TIPO_USUARIO
                    ,	USU.EMAIL
                    ,	USU.PASSWORD
                    ,	USU.FECHACAPTURA
                    ,	USU.ESTADO
                FROM 
                    USUARIOS USU
        ";

        $result  = $conexion->query($sql);
        $cantReg = $result->num_rows;

        if($cantReg > 0){
            return $result->fetch_all(MYSQLI_ASSOC);
        }else{
            return -1;
        }

    }

    /**
     * Funcion encargada de eliminar un usuario del sistema de ventas por medio del ID
     * @param $idUsuario Id de Usuario a eliminar
     */
    public function eliminarUsuario($idUsuario): array{

        $objConexion = new Conexion();
        $conexion    = $objConexion->conexion();

        $sql = "DELETE FROM USUARIOS WHERE ID_USUARIO = $idUsuario";

        $result         = $conexion->query($sql);
        $filasAfectadas = $conexion->affected_rows;

        if($filasAfectadas >= 1){

            $idEliminado = $conexion->insert_id;

            $codeResponse = [
                "CODIGO" => 1,
                "MENSAJE" => "El registro fue eliminado con exito"
            ];

            return $codeResponse;
        }else{

            $codeResponse = [
                "CODIGO" => -1,
                "MENSAJE" => "El registro no fue eliminado"
            ];
            
            return $codeResponse;

        }
    }

    /**
     * Se obtiene la lista de los tipos de usuario
     */
    public function obtenerTipoUsuario(){

        $objConexion = new Conexion();
        $conexion    = $objConexion->conexion();

        $sql = "SELECT
                        TIPO_USUARIO
                    ,   NOMBRE
                FROM
                    TIPO_USUARIO
        ";

        $result = $conexion->query($sql);
        $cantidad = $result->num_rows;

        if($cantidad > 0){
            return $result->fetch_all(MYSQLI_ASSOC);
        }else{
            return -1;
        }

    }

    /**
     * Funcion encargada de crear un usuarios de sistema a nivel de persistencia de datos.
     * @param $parametros Arreglo de datos de un usuario.
     */
    public function crearUsuario(array $parametros){

        $objConexion = new Conexion();
        $conexion    = $objConexion->conexion();

        $sqlMaxId = "SELECT 
                        CASE WHEN ID_USUARIO IS NULL THEN
                            (COUNT(ID_USUARIO) + 1)
                        ELSE
                            (COUNT(ID_USUARIO) + 1)
                        END MAX_ID
                    FROM USUARIOS
        ";

        $result  = $conexion->query($sqlMaxId);      /**Ejecutamos la query */
        $cantReg = $result->num_rows;               /**Consultamos cantidad de registros */

        if($cantReg > 0){

            $resultId = $result->fetch_array(MYSQLI_ASSOC);          /**Retornamos la data en array asociativo */
            $maxId    = $resultId["MAX_ID"];

            $nombre         = $parametros["nombre"];
            $apellido       = $parametros["apellido"];
            $usu            = $parametros["usuario"];
            $tipoUsuario    = $parametros["tipoUsuario"];
            $correo         = $parametros["correo"];
            $password       = $parametros["password"];
            $usuarioCrea    = $parametros["usuarioCrea"];

            $sql = "INSERT INTO USUARIOS
                        (
                                ID_USUARIO
                            ,   NOMBRE
                            ,   APELLIDO
                            ,   USUARIO
                            ,   TIPO_USUARIO
                            ,   EMAIL
                            ,   PASSWORD
                            ,   FECHACAPTURA
                            ,   ESTADO
                            ,   USUARIOCREA
                        )
                    VALUES
                        (
                                $maxId
                            ,   '$nombre'
                            ,   '$apellido'
                            ,   '$usu'
                            ,   $tipoUsuario
                            ,   '$correo'
                            ,   '$password'
                            ,   CURDATE()
                            ,   0
                            ,   '$usuarioCrea'
                        )
            ";

           

            $result = $conexion->query($sql);

            if($conexion->affected_rows > 0){
                return 1;
            }else{
                return -1;
            }


        }

        
    }

    /**
     * Funcion encargada de obtener un usuario de sistema.
     */
    public function obtenerUsuario($idUsuario){

        $objConexion = new Conexion();
        $conexion    = $objConexion->conexion();

        $sql = "SELECT 
                        USU.ID_USUARIO
                    ,	USU.USUARIO
                    ,	USU.NOMBRE
                    ,	USU.APELLIDO
                    ,	USU.TIPO_USUARIO
                    ,   (SELECT NOMBRE FROM TIPO_USUARIO WHERE TIPO_USUARIO = USU.TIPO_USUARIO) NOMBRE_TIPO_USUARIO
                    ,	USU.EMAIL
                    ,	USU.PASSWORD
                    ,	USU.FECHACAPTURA
                    ,	USU.ESTADO
                FROM 
                    USUARIOS USU
                WHERE 
                    USU.ID_USUARIO = $idUsuario
        ";

        $result  = $conexion->query($sql);
        $cantReg = $result->num_rows;

        if($cantReg > 0){
            return $result->fetch_all(MYSQLI_ASSOC);
        }else{
            return -1;
        }
    }

    public function editarUsuario($parametros){

        $nombre         = $parametros["nombre"];
        $apellido       = $parametros["apellido"];
        $usu            = $parametros["usuario"];
        $tipoUsuario    = $parametros["tipoUsuario"];
        $correo         = $parametros["correo"];
        $password       = $parametros["password"];
        $estado         = $parametros["estado"];
        $idUsuario      = $parametros["idUsuario"];

        $objConexion = new Conexion();
        $conexion    = $objConexion->conexion();

        $sql = "UPDATE USUARIOS
                    SET
                        NOMBRE          = '$nombre',
                        APELLIDO        = '$apellido',
                        USUARIO         = '$usu',
                        TIPO_USUARIO    = $tipoUsuario,
                        EMAIL           = '$correo',
                        PASSWORD        = '$password',
                        ESTADO          = $estado
                    WHERE
                        ID_USUARIO = $idUsuario
        ";

        $result = $conexion->query($sql);

        $filasAfectadas = $conexion->affected_rows;

        if($filasAfectadas >= 1){
            return 1;
        }else{
            return -1;
        }

    }

}




?>