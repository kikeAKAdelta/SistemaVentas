<?php
/**
 * CORS son las siglas de "Cross-origin resource sharing" y es básicamente una restricción de acceso a recursos que están 
 * localizados en otros dominios.
 * 
 * Generalmente, cuando desarrollas una aplicación con tu framework Javascript, usas dominios distintos para lo que es el servidor 
 * de los archivos de tu App y el servidor de PHP. 
 * Por ejemplo, tienes el servidor de tu app (cliente) en un dominio como http://127.0.0.1:8081/ o http://localhost:8080. Pero sin 
 * embargo el archivo al que dirigimos las request Ajax, en nuestra aplicación PHP (server), es algo como http://localhost/post.php.
 * 
 * Nota: Aunque puedas tener dominios iguales, "localhost", o la misma IP, "127.0.0.1", realmente el hecho de estar los servidores en 
 * puertos distintos ya hace que se consideren recursos de dominios distintos.
 * 
 * Para evitar que la barrera de CORS nos afecte, el Servidor tiene que emitir unas cabeceras HTTP en la respuesta. Estas cabeceras le 
 * dicen al navegador que ciertos recursos sí que van a estar disponibles desde otros dominios distintos del habitual. Así que desde 
 * PHP es tan sencillo como escribir unas pocas líneas de código para el envío de esas cabeceras. Así nuestra API estará disponible para 
 * el acceso desde otros dominios.
 * Access-Control-Allow-Origin: los orígenes permitidos, que debe ser el dominio con todo y http o https. 
 *                              Dominio del cual el cliente realiza la peticion.
 * Access-Control-Allow-Headers: encabezados permitidos. En la mayoría de casos solo es el content-type.
 * Access-Control-Allow-Methods: métodos o verbos HTTP permitidos
 */

$dominioPermitido = "http://localhost";
header("Access-Control-Allow-Origin: $dominioPermitido");                       /**Acepta peticiones de este dominio */
header("Access-Control-Allow-Headers: Content-Type");                           /**Acepta peticiones de este tipo de contenido */
header("Access-Control-Allow-Methods: GET");                                    /**Acepta este tipo de metodos HTTP */


?>