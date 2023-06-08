<?php

$request = $_SERVER["REQUEST_METHOD"];
require_once "../../cors/cors.php";
require_once './categoria.class.php';

if($request == "POST"){

    $categoria = new Categoria();

    $params = file_get_contents("php://input");                     /** Recibimos los parametros de la peticion */
    $data   = json_decode($params, true);                           /** Convertimos Array asociativo */

    if(isset($data["funcion"])){

        $funcion = $data["funcion"];

        if($funcion == "listarCategorias"){

            $listData = $categoria->listarCategorias();         /**Obtenemos los registros de la lista de usuarios */

            if($listData == -1){
                $json = ["data" => "-1"];
                echo json_encode($json);
            }else{
                echo json_encode($listData);
            }

        }else if($funcion == "eliminarCategoria"){
            $idCategoria = $data["idCategoria"];

            $result = $categoria->eliminarCategoria($idCategoria);

            echo json_encode($result);
        }else if($funcion == "crearCategoria"){

            $usuario        = $data["usuario"];
            $idUsuario      = $data["idUsuario"];
            $nomCategoria   = $data["categoria"];

            $params = [
                "usuario"   => $usuario,
                "idUsuario" => $idUsuario,
                "categoria" => $nomCategoria
            ];

            $result = $categoria->crearCategoria($params);

            if($result == 1){

                $responseCode = [
                    "code" => 601,
                    "mensaje" => "Registro creado correctamente"
                ];

                echo json_encode($responseCode);
                
            }else if($result == -1){

                $responseCode = [
                    "code" => 602,
                    "mensaje" => "Hubo un inconveniente, intente nuevamente"
                ];

                echo json_encode($responseCode);
            }

        }else if($funcion == "obtenerCategoria"){

            /**API REST encargada de Obtener una categoria por medio de su ID */
            $idCategoria = $data["idCategoria"];

            $result = $categoria->obtenerCategoria($idCategoria);
            $codigo = $result;
            
            if($codigo == -1){

                $responseCode = [
                    "code" => "-1",
                    "mensaje" => "No se pudo obtener el registro"
                ];

                echo json_encode($responseCode);
            }else{
                echo json_encode($result);
            }
        }else if($funcion == "editarCategoria"){

            $usuario        = $data["usuario"];
            $idUsuario      = $data["idUsuario"];
            $nomCategoria   = $data["categoria"];
            $idCategoria    = $data["idCategoria"];

            $params = [
                "usuario"       => $usuario,
                "idUsuario"     => $idUsuario,
                "categoria"     => $nomCategoria,
                "idCategoria"   => $idCategoria,
            ];

            $result = $categoria->editarCategoria($params);

            if($result == -1){
                $responseCode = [
                    "code" => 602,
                    "mensaje"=> "Hubo un inconveniente, no se pudo editar"
                ];

                echo json_encode($responseCode);
    
            }else{

                $responseCode = [
                    "code" => 601,
                    "mensaje"=> "Registro editado correctamente"
                ];
    
                echo json_encode($responseCode);

            }

        }
    }

}




?>