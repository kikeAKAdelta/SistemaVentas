<?php

date_default_timezone_set('America/Mexico_City');

require_once "../../conexion/conexion.php";
require_once "../../libs/php-jwt-main/src/JWT.php";
require_once "../../libs/php-jwt-main/src/Key.php";
require_once "../../libs/php-jwt-main/src/SignatureInvalidException.php";
require_once "../../libs/php-jwt-main/src/ExpiredException.php";

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\SignatureInvalidException;

class Login{

    public function __construct(){}

    /**
     * Funcion encargada de validar que los datos sean los correctos del usuario
     */
    public function validarUsuario($usuario, $password){

        $objConexion = new Conexion();

        $conexion = $objConexion->conexion();

        $sql = "SELECT 
                        ID_USUARIO
                    ,   NOMBRE
                    ,   APELLIDO
                    ,   EMAIL
                    ,   PASSWORD
                    ,   FECHACAPTURA
                    ,   ESTADO
                FROM
                    USUARIOS
                WHERE
                        ESTADO      = 0
                    AND USUARIO     = '$usuario'
                    AND PASSWORD    = '$password'
        ";

        $result     = $conexion->query($sql);       /**Ejecutamos la query */
        $cantReg    = $result->num_rows;            /**Consultamos cantidad de registros */

        if($cantReg > 0){
            return $result->fetch_array(MYSQLI_ASSOC);          /**Retornamos la data en array asociativo */
        }else{
            return -1;
        }
    }

    /**
     * Funcion encargada de iniciar y crear el JWT en el sistema
     */
    public function iniciarSesion($idUsuario, $usuario, $password){

        $jwt = $this->createJwt($idUsuario, $usuario, $password);             /**Creamos el TOKEN con JWT */

        if(isset($jwt)){

            $objConexion = new Conexion();

            $conexion = $objConexion->conexion();

            $sqlMaxId = "SELECT 
                            CASE WHEN IDSESION IS NULL THEN
                                (COUNT(IDSESION) + 1)
                            ELSE
                                (COUNT(IDSESION) + 1)
                            END MAX_ID
                        FROM SESIONES
            ";

            $result = $conexion->query($sqlMaxId);      /**Ejecutamos la query */
            $cantReg = $result->num_rows;               /**Consultamos cantidad de registros */

            if($cantReg > 0){

                $resultId = $result->fetch_array(MYSQLI_ASSOC);          /**Retornamos la data en array asociativo */
                $maxId = $resultId["MAX_ID"];

                $sql = "INSERT INTO SESIONES 
                                    (
                                            IDSESION
                                        ,   TOKEN
                                        ,   USUARIO
                                        ,   PASSWORD
                                        ,   ACTIVO
                                        ,   FECHA
                                    )
                                    VALUES(
                                            $maxId
                                        ,   '$jwt'
                                        ,   '$usuario'
                                        ,   '$password'
                                        ,    1
                                        ,   CURDATE()
                                    )
                ";

                $resultInsert = $conexion->query($sql);

                $resultLocalStorage = [
                    "idSesion"  => $maxId,
                    "idUsuario" => $idUsuario,
                    "usuario"   => $usuario,
                    "password"  => $password,
                    "jwt"       => $jwt
                ];

                if(($conexion->affected_rows) > 0){
                    return $resultLocalStorage;
                }else{
                    return -1;
                }

            }


        }
    }

    /**
     * Creamos un JWT para la sesion.
     */
    public function createJwt($idUsuario, $usuario, $password){

        $time = time();

        $token = [
            "iat" => $time,                      //Tiempo en el que inicia el Token
            "exp" => $time + (60*60*24),            //Tiempo de Expiracion del Token
            "data" =>[
                "id"            => $idUsuario,
                "usuario"       => $usuario,
                "password"      => $password
            ]
        ];

        $privateKey = <<<EOD
        -----BEGIN RSA PRIVATE KEY-----
        MIIEowIBAAKCAQEAuzWHNM5f+amCjQztc5QTfJfzCC5J4nuW+L/aOxZ4f8J3Frew
        M2c/dufrnmedsApb0By7WhaHlcqCh/ScAPyJhzkPYLae7bTVro3hok0zDITR8F6S
        JGL42JAEUk+ILkPI+DONM0+3vzk6Kvfe548tu4czCuqU8BGVOlnp6IqBHhAswNMM
        78pos/2z0CjPM4tbeXqSTTbNkXRboxjU29vSopcT51koWOgiTf3C7nJUoMWZHZI5
        HqnIhPAG9yv8HAgNk6CMk2CadVHDo4IxjxTzTTqo1SCSH2pooJl9O8at6kkRYsrZ
        WwsKlOFE2LUce7ObnXsYihStBUDoeBQlGG/BwQIDAQABAoIBAFtGaOqNKGwggn9k
        6yzr6GhZ6Wt2rh1Xpq8XUz514UBhPxD7dFRLpbzCrLVpzY80LbmVGJ9+1pJozyWc
        VKeCeUdNwbqkr240Oe7GTFmGjDoxU+5/HX/SJYPpC8JZ9oqgEA87iz+WQX9hVoP2
        oF6EB4ckDvXmk8FMwVZW2l2/kd5mrEVbDaXKxhvUDf52iVD+sGIlTif7mBgR99/b
        c3qiCnxCMmfYUnT2eh7Vv2LhCR/G9S6C3R4lA71rEyiU3KgsGfg0d82/XWXbegJW
        h3QbWNtQLxTuIvLq5aAryV3PfaHlPgdgK0ft6ocU2de2FagFka3nfVEyC7IUsNTK
        bq6nhAECgYEA7d/0DPOIaItl/8BWKyCuAHMss47j0wlGbBSHdJIiS55akMvnAG0M
        39y22Qqfzh1at9kBFeYeFIIU82ZLF3xOcE3z6pJZ4Dyvx4BYdXH77odo9uVK9s1l
        3T3BlMcqd1hvZLMS7dviyH79jZo4CXSHiKzc7pQ2YfK5eKxKqONeXuECgYEAyXlG
        vonaus/YTb1IBei9HwaccnQ/1HRn6MvfDjb7JJDIBhNClGPt6xRlzBbSZ73c2QEC
        6Fu9h36K/HZ2qcLd2bXiNyhIV7b6tVKk+0Psoj0dL9EbhsD1OsmE1nTPyAc9XZbb
        OPYxy+dpBCUA8/1U9+uiFoCa7mIbWcSQ+39gHuECgYAz82pQfct30aH4JiBrkNqP
        nJfRq05UY70uk5k1u0ikLTRoVS/hJu/d4E1Kv4hBMqYCavFSwAwnvHUo51lVCr/y
        xQOVYlsgnwBg2MX4+GjmIkqpSVCC8D7j/73MaWb746OIYZervQ8dbKahi2HbpsiG
        8AHcVSA/agxZr38qvWV54QKBgCD5TlDE8x18AuTGQ9FjxAAd7uD0kbXNz2vUYg9L
        hFL5tyL3aAAtUrUUw4xhd9IuysRhW/53dU+FsG2dXdJu6CxHjlyEpUJl2iZu/j15
        YnMzGWHIEX8+eWRDsw/+Ujtko/B7TinGcWPz3cYl4EAOiCeDUyXnqnO1btCEUU44
        DJ1BAoGBAJuPD27ErTSVtId90+M4zFPNibFP50KprVdc8CR37BE7r8vuGgNYXmnI
        RLnGP9p3pVgFCktORuYS2J/6t84I3+A17nEoB4xvhTLeAinAW/uTQOUmNicOP4Ek
        2MsLL2kHgL8bLTmvXV4FX+PXphrDKg1XxzOYn0otuoqdAQrkK4og
        -----END RSA PRIVATE KEY-----
        EOD;


        //$keys       = $this->getKeysPrivate();
        //$keyToken   = $keys["keyPrivateToken"];
        //$algoritmo  = $keys["hash"];
        $algoritmo  = 'RS256';

        $jwtToken = JWT::encode($token, $privateKey, $algoritmo);

        return $jwtToken;
    }

    public function verificarJwt($params){

        $idSesion   = $params["idSesion"];
        $jwt        = $params["jwt"];
        $password   = $params["password"];
        $usuario    = $params["usuario"];

        $responseCode = [];

        try{

            $decodeToken = $this->decodeJwt($jwt);

            $iat = $decodeToken["iat"];
            $exp = $decodeToken["exp"];

            /**Verificaremos si el token ya caduco */
            $timeCurrent = time();

            if($timeCurrent > $exp){

                $responseCode = [
                    "code"=> 601,
                    "mensaje"=> "El token esta expirado"
                ];

                return $responseCode;
            }

            $fechaInicio = date('d/m/Y H:i:s', $iat);
            $fechaFin    = date('d/m/Y H:i:s', $exp);

            $responseCode = [
                "code"=> 200,
                "mensaje"=> "Token válido",
                "data" => $fechaFin
            ];

            return $responseCode;

        }catch(Exception $e){

            $message =  'Excepción capturada: ' .  $e->getMessage();

            $responseCode = [
                "code"=> 602,
                "mensaje"=> $message
            ];

            return $responseCode;
        }

    }
    
    /**
     * Decodificamos el JWT pasado como parametro
     */
    private function decodeJwt($jwt){

        //$keys       = $this->getKeysPrivate();

        //$keyToken   = $keys["keyPrivateToken"];
        //$algoritmo  = $keys["hash"];
        $algoritmo  = 'RS256';

        $publicKey = <<<EOD
        -----BEGIN PUBLIC KEY-----
        MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAuzWHNM5f+amCjQztc5QT
        fJfzCC5J4nuW+L/aOxZ4f8J3FrewM2c/dufrnmedsApb0By7WhaHlcqCh/ScAPyJ
        hzkPYLae7bTVro3hok0zDITR8F6SJGL42JAEUk+ILkPI+DONM0+3vzk6Kvfe548t
        u4czCuqU8BGVOlnp6IqBHhAswNMM78pos/2z0CjPM4tbeXqSTTbNkXRboxjU29vS
        opcT51koWOgiTf3C7nJUoMWZHZI5HqnIhPAG9yv8HAgNk6CMk2CadVHDo4IxjxTz
        TTqo1SCSH2pooJl9O8at6kkRYsrZWwsKlOFE2LUce7ObnXsYihStBUDoeBQlGG/B
        wQIDAQAB
        -----END PUBLIC KEY-----
        EOD;

        $decodeJwt = JWT::decode($jwt, new Key($publicKey, $algoritmo)); 

        return (array) $decodeJwt;
    }

    /**
     * Obtenemos la llave privada que servira para poder crear nuestro token seguro
     */
    private function getKeysPrivate(){

        $body = file_get_contents("../../keys/claves.json");
        
        $keys = json_decode($body, true);

        return $keys;
    }

}




?>