<?php

$request = $_SERVER["REQUEST_METHOD"];
require_once "../../cors/cors.php";
require_once "./login.class.php";

/** Peticion POST **/
if($request == "POST"){

    $login = new Login();       /**Instanciamos clase */
    
    $params     = file_get_contents("php://input");      /** Recibimos los parametros de la peticion */
    $data       = json_decode($params, true);            

    if(isset($data["funcion"])){

        $funcion = $data["funcion"];

        /**Ingresamos para iniciar sesion */
        if($funcion == "validarUsuario"){

            $usuario    = $data["usuario"];
            $password   = $data["password"];

            $result = $login->validarUsuario($usuario, $password);
            $json = [];

            if($result == -1){

                $json = ["data" => "-1"];
                echo json_encode($json);

            }else{
                echo json_encode($result);
            }
        }else if($funcion == "iniciarSesion"){

            $usuario     = $data["usuario"];
            $password    = $data["password"];
            $idUsuario   = $data["idUsuario"];

            $result = $login->iniciarSesion($idUsuario, $usuario, $password);

            if($result == -1){

                $json = ["data" => "-1"];
                echo json_encode($json);

            }else{
                echo json_encode($result);
            }
        }else if($funcion == "verificarToken"){

            $idSesion   = $data["idSesion"];
            $jwt        = $data["jwt"];
            $password   = $data["password"];
            $usuario    = $data["usuario"];

            $params = [
                "idSesion"  =>$idSesion,
                "jwt"       =>$jwt,
                "password"  =>$password,
                "usuario"   =>$usuario
            ];

            $result = $login->verificarJwt($params);

            echo json_encode($result);

        }
        

    }
}





?>