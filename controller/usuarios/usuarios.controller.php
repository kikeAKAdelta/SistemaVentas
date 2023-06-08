<?php

require_once "../../cors/cors.php";
date_default_timezone_set('America/Mexico_City');


$request = $_SERVER["REQUEST_METHOD"];
require_once './usuarios.class.php';

/**Peticion POST */
if($request == "POST"){

    $usuario = new Usuarios();

    $params = file_get_contents("php://input");                 /** Recibimos los parametros de la peticion */
    $data   = json_decode($params, true);                       /** Convertimos Array asociativo */

    if(isset($data["funcion"])){

        $funcion = $data["funcion"];

        if($funcion == "listarUsuarios"){

            $listData = $usuario->listarUsuarios();

            if($listData == -1){
                $json = ["data" => "-1"];

                header('Content-Type: application/json');                         /**Tipo de Contenido de Respuesta */
                http_response_code(200);                                          /**Tipo de Respuesta HTTP */

                echo json_encode($json);
            }else{

                header('Content-Type: application/json');                         /**Tipo de Contenido de Respuesta */
                http_response_code(200);                                          /**Tipo de Respuesta HTTP */

                echo json_encode($listData);
            }
        }else if($funcion == "eliminarUsuario"){

            $idUsuario = $data["idUsuario"];

            $result = $usuario->eliminarUsuario($idUsuario);

            header('Content-Type: application/json');                         /**Tipo de Contenido de Respuesta */
            http_response_code(200);                                          /**Tipo de Respuesta HTTP */


            echo json_encode($result);
        }else if($funcion == "obtenerTipoUsuario"){
            $rstTipoUsuario = $usuario->obtenerTipoUsuario();

            if($rstTipoUsuario == -1){
                $responseCode = ["CODIGO"=> 601, "MENSAJE" => "Los tipos de usuario no se pudieron obtener, favor revisar"];
                
                header('Content-Type: application/json');                         /**Tipo de Contenido de Respuesta */
                http_response_code(200);                                          /**Tipo de Respuesta HTTP */
                
                echo json_encode($responseCode);
            }else{

                header('Content-Type: application/json');                         /**Tipo de Contenido de Respuesta */
                http_response_code(200);                                          /**Tipo de Respuesta HTTP */

                echo json_encode($rstTipoUsuario);
            }
        }else if($funcion == "crearUsuario"){
            
            $nombre         = $data["nombre"];
            $apellido       = $data["apellido"];
            $usu            = $data["usuario"];
            $tipoUsuario    = $data["tipoUsuario"];
            $correo         = $data["correo"];
            $password       = $data["password"];
            $usuarioCrea    = $data["usuarioCrea"];

            $parametros = [
                "nombre"        => $nombre,
                "apellido"      => $apellido,
                "usuario"       => $usu,
                "tipoUsuario"   => $tipoUsuario,
                "correo"        => $correo,
                "password"      => $password,
                "usuarioCrea"   => $usuarioCrea
            ];

            $result = $usuario->crearUsuario($parametros);

            if($result == 1){

                $responseCode = [
                    "CODIGO" => 601,
                    "MENSAJE" => "Registro agregado correctamente a nivel de sistema"
                ];

                header('Content-Type: application/json');                         /**Tipo de Contenido de Respuesta */
                http_response_code(200);                                          /**Tipo de Respuesta HTTP */

                echo json_encode($responseCode);

            }else if($result == -1){

                $responseCode = [
                    "CODIGO" => 602,
                    "MENSAJE" => "Error, el registro no se logro crear!"
                ];

                header('Content-Type: application/json');                         /**Tipo de Contenido de Respuesta */
                http_response_code(500);                                          /**Tipo de Respuesta HTTP */

                echo json_encode($responseCode);
            }


        }else if($funcion == "obtenerUsuario"){

            $idUsuario = $data["idUsuario"];
            $listData = $usuario->obtenerUsuario($idUsuario);

            if($listData == -1){
                $json = ["data" => "-1"];

                header('Content-Type: application/json');                         /**Tipo de Contenido de Respuesta */
                http_response_code(200);                                          /**Tipo de Respuesta HTTP */

                echo json_encode($json);
            }else{

                header('Content-Type: application/json');                         /**Tipo de Contenido de Respuesta */
                http_response_code(200);                                          /**Tipo de Respuesta HTTP */

                echo json_encode($listData);
            }
        }else if($funcion == "editarUsuario"){

            $nombre         = $data["nombre"];
            $apellido       = $data["apellido"];
            $usu            = $data["usuario"];
            $tipoUsuario    = $data["tipoUsuario"];
            $correo         = $data["correo"];
            $password       = $data["password"];
            $estado         = $data["estado"];
            $idUsuario      = $data["idUsuario"];

            $parametros = [
                "nombre"        => $nombre,
                "apellido"      => $apellido,
                "usuario"       => $usu,
                "tipoUsuario"   => $tipoUsuario,
                "correo"        => $correo,
                "password"      => $password,
                "estado"        => $estado,
                "idUsuario"     => $idUsuario
            ];

            $result = $usuario->editarUsuario($parametros);

            if($result == 1){

                $responseCode = [
                    "CODIGO" => 601,
                    "MENSAJE" => "Registro editado correctamente a nivel de sistema"
                ];

                header('Content-Type: application/json');                         /**Tipo de Contenido de Respuesta */
                http_response_code(200);                                          /**Tipo de Respuesta HTTP */

                echo json_encode($responseCode);

            }else if($result == -1){

                $responseCode = [
                    "CODIGO" => 602,
                    "MENSAJE" => "Error, el registro no se logro editar!"
                ];

                header('Content-Type: application/json');                         /**Tipo de Contenido de Respuesta */
                http_response_code(200);                                          /**Tipo de Respuesta HTTP */

                echo json_encode($responseCode);
            }

        }else{
            header('Content-Type: application/json');                         /**Tipo de Contenido de Respuesta */
            http_response_code(404);                                          /**Tipo de Respuesta HTTP: 404 NOT FOUND: Recurso no encontrado */
        }
    }

}else{
    header('Content-Type: application/json');                         /**Tipo de Contenido de Respuesta */
    http_response_code(501);                                          /**Tipo de Respuesta HTTP: 404 NOT FOUND: Recurso no encontrado */
        
}



?>