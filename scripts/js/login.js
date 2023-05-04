/**
 * Funcion encargada de validar los campos ingresados sean los correctos y ademas de iniciar sesion.
 */
var validarCampos = async () =>{

    usuario = document.getElementById("usuario").value;
    password = document.getElementById("password").value;

    if(usuario == "" || usuario == undefined){
        alert("Favor ingrese el usuario");
        return;
    }

    if(password == "" || password == undefined){
        alert("Favor ingrese la clave");
        return;
    }

    params = {
        funcion: 'validarUsuario',
        usuario: usuario,
        password: password
    }

    const result = await fetch("http://localhost/SistemaVentas/controller/login/login.controller.php", 
                    {
                        method: "POST",
                        body:  JSON.stringify(params),
                        headers: {"Content-type": "application/json; charset=UTF-8"}
                    }
                ).then(result => result.json());

                console.log(result);

    if(result != null && result != ""){

        if(result.data == "-1"){
            alert("No se encontro al usuario, favor verificar las credenciales");
            return;
        }

        params = {
            funcion: 'iniciarSesion',
            usuario: usuario,
            password: password,
            idUsuario: result.ID_USUARIO
        }

        /**Si todo esta correcto entonces, creamos sesion con JWT */
        const resultSesion = await fetch("http://localhost/SistemaVentas/controller/login/login.controller.php",
                            {
                                method: "POST",
                                body: JSON.stringify(params),
                                headers: {"Content-type": "application/json; charset=UTF-8"}
                            }
                        ).then(result => result.json());

        console.log(resultSesion);
        

        if(resultSesion.data == "-1"){
            alert('No se pudo iniciar sesion');
            return;
        }else{

            localStorage.setItem("jwt", JSON.stringify(resultSesion));

            window.location.href = "http://localhost/SistemaVentas/view/dashboard/dashboard.php";

        }


    }


}

/**
 * Funcion encargada de verificar que el token exista y este creado correctamente
 */
var verificarToken = async () =>{

    objToken = JSON.parse(localStorage.getItem("jwt"));

    if(objToken == undefined || objToken == null){

        alert("Su sesion termino");

        window.location.href = "http://localhost/SistemaVentas/view/login/login.php";
    }

    idSesion    = objToken.idSesion;
    jwt         = objToken.jwt;
    password    = objToken.password;
    usuario     = objToken.usuario;
    idUsuario     = objToken.idUsuario;

    params = {
        "funcion"   : "verificarToken",
        "idSesion"  : idSesion,
        "jwt"       : jwt,
        "password"  : password,
        "usuario"   : usuario,
        "idUsuario"   : idUsuario
    }


    verifyToken = await fetch("http://localhost/SistemaVentas/controller/login/login.controller.php",
                    {
                        method: "POST",
                        body: JSON.stringify(params),
                        headers: {"Content-Type": "application/json; charset=UTF-8"}
                    }
    ).then(result => result.json());

    console.log(verifyToken);

    /**Si el Token ya expiro o se produjo un error con el token entonces redireccionamos */
    if(verifyToken.code == 601  || verifyToken.code == 602){

        alert(verifyToken.mensaje);

        window.location.href = "http://localhost/SistemaVentas/view/login/login.php";
    }
    


}