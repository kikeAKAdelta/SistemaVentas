<?php

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
                echo json_encode($json);
            }else{
                echo json_encode($listData);
            }
        }else if($funcion == "eliminarUsuario"){

            $idUsuario = $data["idUsuario"];

            $result = $usuario->eliminarUsuario($idUsuario);

            echo json_encode($result);
        }else if($funcion == "obtenerTipoUsuario"){
            $rstTipoUsuario = $usuario->obtenerTipoUsuario();

            if($rstTipoUsuario == -1){
                $responseCode = ["CODIGO"=> 601, "MENSAJE" => "Los tipos de usuario no se pudieron obtener, favor revisar"];
                echo json_encode($responseCode);
            }else{
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

                echo json_encode($responseCode);

            }else if($result == -1){

                $responseCode = [
                    "CODIGO" => 602,
                    "MENSAJE" => "Error, el registro no se logro crear!"
                ];

                echo json_encode($responseCode);
            }


        }else if($funcion == "obtenerUsuario"){

            $idUsuario = $data["idUsuario"];
            $listData = $usuario->obtenerUsuario($idUsuario);

            if($listData == -1){
                $json = ["data" => "-1"];
                echo json_encode($json);
            }else{
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

                echo json_encode($responseCode);

            }else if($result == -1){

                $responseCode = [
                    "CODIGO" => 602,
                    "MENSAJE" => "Error, el registro no se logro editar!"
                ];

                echo json_encode($responseCode);
            }

        }

    }

}



?>