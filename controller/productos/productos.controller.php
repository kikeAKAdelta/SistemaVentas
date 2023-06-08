<?php

date_default_timezone_set('America/Mexico_City');
require_once "../../cors/cors.php";
require_once './productos.class.php';

$request = $_SERVER['REQUEST_METHOD'];

if($request == "POST"){

    $params = file_get_contents('php://input');                 /** Recibimos los parametros de la peticion */
    $data   = json_decode($params, true);                       /** Convertimos Array asociativo */

    if(isset($data["funcion"])){

        $funcion = $data["funcion"];
        $producto = new Productos();

        if($funcion == "obtenerProveedores"){

            $listaProveedores = $producto->obtenerListaProveedores();

            if($listaProveedores == -1){

                $responseCode = [
                    'CODIGO' => 601,
                    'MENSAJE' => 'No se han registrado proveedores'
                ];

                echo json_encode($responseCode);
            }else{
                echo json_encode($listaProveedores);
            }

        }else if($funcion == "obtenerCategorias"){

            $listaCategorias = $producto->obtenerListaCategorias();

            if($listaCategorias == -1){

                $responseCode = [
                    'CODIGO' => 601,
                    'MENSAJE' => 'No se han registrado categorias'
                ];

                echo json_encode($responseCode);

            }else{
                echo json_encode($listaCategorias);
            }
        }else if($funcion == "crearProducto"){

            $nombre         = $data["nombre"];
            $descripcion    = $data["descripcion"];
            $precioUnitario = $data["precioUnitario"];
            $cantidad       = $data["cantidad"];
            $proveedor      = $data["proveedor"];
            $categoria      = $data["categoria"];
            $idUsuario      = $data["idUsuario"];

            $params = [
                "nombre"            => $nombre,
                "descripcion"       => $descripcion,
                "precioUnitario"    => $precioUnitario,
                "cantidad"          => $cantidad,
                "proveedor"         => $proveedor,
                "categoria"         => $categoria,
                "idUsuario"         => $idUsuario,
            ];

            $result = $producto->crearProducto($params);

            if($result == 1){

                $responseCode = [
                    "code"      => 601,
                    "mensaje"   => "Registro creado correctamente"
                ];

                echo json_encode($responseCode);
                
            }else if($result == -1){

                $responseCode = [
                    "code"      => 602,
                    "mensaje"   => "Hubo un inconveniente, intente nuevamente"
                ];

                echo json_encode($responseCode);
            }

        }else if($funcion == "listarProductos"){

            $rst = $producto->listarProductos();

            if($rst == -1){
                $json = ["data" => "-1"];
                echo json_encode($json);
            }else{
                echo json_encode($rst);
            }

        }
    }
}

?>