<?php

date_default_timezone_set('America/Mexico_City');

require_once "../../conexion/conexion.php";

class Categoria{

    public function __construct(){}

    public function listarCategorias(): array{

        $objConexion = new Conexion();
        $conexion    = $objConexion->conexion();

        $sql = "SELECT 
                        ID_CATEGORIA
                    ,	ID_USUARIO
                    ,   ( SELECT USUARIO FROM USUARIOS WHERE ID_USUARIO = ID_USUARIO) USUARIO
                    ,	NOMBRECATEGORIA
                    ,	FECHACAPTURA
                FROM 
                    CATEGORIAS
        ";

        $result = $conexion->query($sql);
        $cantReg = $result->num_rows;

        if($cantReg > 0){
            return $result->fetch_all(MYSQLI_ASSOC);
        }else{
            return -1;
        }

    }

    public function eliminarCategoria($idCategoria): array{

        $objConexion = new Conexion();
        $conexion    = $objConexion->conexion();

        $sql = "DELETE FROM CATEGORIAS WHERE ID_CATEGORIA = $idCategoria";

        $result = $conexion->query($sql);
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

    public function crearCategoria($params){

        $usuario    = $params["usuario"];
        $idUsuario  = $params["idUsuario"];
        $categoria  = $params["categoria"];

        $objConexion = new Conexion();
        $conexion    = $objConexion->conexion();

        $sqlMaxId = "SELECT 
                        CASE WHEN ID_CATEGORIA IS NULL THEN
                            (COUNT(ID_CATEGORIA) + 1)
                        ELSE
                            (COUNT(ID_CATEGORIA) + 1)
                        END MAX_ID
                    FROM CATEGORIAS
        ";

        $result = $conexion->query($sqlMaxId);      /**Ejecutamos la query */
        $cantReg = $result->num_rows;               /**Consultamos cantidad de registros */

        if($cantReg > 0){

            $resultId = $result->fetch_array(MYSQLI_ASSOC);          /**Retornamos la data en array asociativo */
            $maxId  = $resultId["MAX_ID"];

            $sql = "INSERT INTO CATEGORIAS
                            (
                                    ID_CATEGORIA
                                ,   ID_USUARIO
                                ,   NOMBRECATEGORIA
                                ,   FECHACAPTURA
                            )
                        VALUES
                            (
                                    $maxId
                                ,   $idUsuario
                                ,   '$categoria'
                                ,   CURDATE() 
                            )
            ";

            $resultInsert = $conexion->query($sql);

            if(($conexion->affected_rows) > 0){
                return 1;
            }else{
                return -1;
            }
        
        }
    }

    public function obtenerCategoria($idCategoria){

        $objConexion = new Conexion();
        $conexion    = $objConexion->conexion();

        $sql = "SELECT
                        ID_CATEGORIA
                    ,	ID_USUARIO
                    ,   ( SELECT USUARIO FROM USUARIOS WHERE ID_USUARIO = ID_USUARIO) USUARIO
                    ,	NOMBRECATEGORIA
                    ,	FECHACAPTURA
                FROM 
                    CATEGORIAS
                WHERE
                    ID_CATEGORIA = $idCategoria
        ";

        $result = $conexion->query($sql);
        $cantReg = $result->num_rows;

        if($cantReg > 0){
            return $result->fetch_all(MYSQLI_ASSOC);
        }else{
            return -1;
        }
    }

    public function editarCategoria($params){

        $usuario        = $params["usuario"];
        $idUsuario      = $params["idUsuario"];
        $categoria      = $params["categoria"];
        $idCategoria    = $params["idCategoria"];

        $objConexion = new Conexion();
        $conexion    = $objConexion->conexion();

        $sql = "UPDATE CATEGORIAS
                    SET
                        NOMBRECATEGORIA = '$categoria'
                    WHERE
                        ID_CATEGORIA = $idCategoria
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