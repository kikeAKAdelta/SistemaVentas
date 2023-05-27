<?php

require_once '../../conexion/conexion.php';

class Productos{

    public function __construct(){}

    /**
     * Funcion encargada de obtener una lista de proveedores.
     */
    public function obtenerListaProveedores(){

        $objConexion = new Conexion();
        $conexion    = $objConexion->conexion();

        $sql = "SELECT
                        ID_PROVEEDOR
                    ,   NOMBRE_PROVEEDOR
                    ,   DESCRIPCION
                    ,   ACTIVO
                    ,   FECHA_REGISTRO
                FROM
                    PROVEEDOR
                WHERE
                    ACTIVO = 1
        ";

        $result = $conexion->query($sql);
        $cantReg = $result->num_rows;

        if($cantReg > 0){
            return $result->fetch_all(MYSQLI_ASSOC);
        }else{
            return -1;
        }

    }

    /**
     * Funcion encargada de obtener una lista de proveedores.
     */
    public function obtenerListaCategorias(){

        $objConexion = new Conexion();
        $conexion    = $objConexion->conexion();

        $sql = "SELECT
                        ID_CATEGORIA
                    ,   ID_USUARIO
                    ,   NOMBRECATEGORIA
                    ,   FECHACAPTURA
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

    /**
     * Funcion encargada de crear un producto.
     * @param array $params Arreglo con informacion del producto.
     */
    public function crearProducto($params){

        $nombre         = $params["nombre"];
        $descripcion    = $params["descripcion"];
        $precioUnitario = $params["precioUnitario"];
        $cantidad       = $params["cantidad"];
        $proveedor      = $params["proveedor"];
        $categoria      = $params["categoria"];
        $idUsuario      = $params["idUsuario"];

        $objConexion = new Conexion();
        $conexion    = $objConexion->conexion();

        $sqlMaxId = "SELECT 
                        CASE WHEN ID_PRODUCTO IS NULL THEN
                            (COUNT(ID_PRODUCTO) + 1)
                        ELSE
                            (COUNT(ID_PRODUCTO) + 1)
                        END MAX_ID
                    FROM PRODUCTOS
        ";

        $result  = $conexion->query($sqlMaxId);      /**Ejecutamos la query */
        $cantReg = $result->num_rows;               /**Consultamos cantidad de registros */

        if($cantReg > 0){

            $resultId   = $result->fetch_array(MYSQLI_ASSOC);          /**Retornamos la data en array asociativo */
            $maxId      = $resultId["MAX_ID"];

            $sqlInsert = "INSERT INTO PRODUCTOS
                            (
                                    ID_PRODUCTO
                                ,   ID_CATEGORIA
                                ,   ID_USUARIO
                                ,   ID_PROVEEDOR
                                ,   NOMBRE
                                ,   DESCRIPCION
                                ,   CANTIDAD
                                ,   PRECIOUNITARIO
                                ,   FECHACAPTURA
                            )
                            VALUES
                            (
                                    $maxId
                                ,   $categoria
                                ,   $idUsuario
                                ,   $proveedor
                                ,   '$nombre'
                                ,   '$descripcion'
                                ,   $cantidad
                                ,   $precioUnitario
                                ,   CURDATE()
                            )
            ";

            $resultInsert = $conexion->query($sqlInsert);

            if(($conexion->affected_rows) > 0){
                return 1;
            }else{
                return -1;
            }
        
        }

    }

    public function listarProductos(){

        $objConexion = new Conexion();
        $conexion    = $objConexion->conexion();

        $sql = "SELECT 
                        PR.ID_PRODUCTO
                    , 	PR.ID_CATEGORIA
                    ,	(SELECT NOMBRECATEGORIA FROM CATEGORIAS WHERE ID_CATEGORIA = PR.ID_CATEGORIA) CATEGORIA
                    , 	PR.ID_USUARIO
                    ,	(SELECT USUARIO FROM USUARIOS WHERE ID_USUARIO = PR.ID_USUARIO) USUARIO
                    , 	PR.ID_PROVEEDOR
                    ,	(SELECT NOMBRE_PROVEEDOR FROM PROVEEDOR WHERE ID_PROVEEDOR = PR.ID_PROVEEDOR) PROVEEDOR
                    , 	PR.NOMBRE
                    , 	PR.DESCRIPCION
                    , 	PR.CANTIDAD
                    , 	PR.PRECIOUNITARIO
                    , 	PR.CANTIDADMINIMA
                    , 	PR.ESTADO
                    , 	PR.FECHACAPTURA 
                FROM 
                    PRODUCTOS PR
        ";

        $result  = $conexion->query($sql);
        $cantReg = $result->num_rows;

        if($cantReg > 0){
            return $result->fetch_all(MYSQLI_ASSOC);
        }else{
            return -1;
        }

    }

}




?>