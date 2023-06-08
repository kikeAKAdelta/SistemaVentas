window.onload = () => listarUsuarios();

/**
 * Funcion encargada de listar todos los Usuarios de Sistema de Ventas
 */
var listarUsuarios = async () =>{

    contenido = `
                <table class="table table-sm table-bordered table-hover">
                    <thead>
                        <tr class="bg-celeste text-center">
                            <th>N°</th>
                            <th>Usuario</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Email</th>
                            <th>Tipo Usuario</th>
                            <th>Fecha Registro</th>
                            <th>Estado</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
    `;

    params = {
        "funcion": "listarUsuarios"
    }
   

    const data = await fetch("http://localhost/SistemaVentas/controller/usuarios/usuarios.controller.php",
                        {
                            method: "POST",
                            body: JSON.stringify(params),
                            headers: {"Content-Type": "application/json; charset=UTF-8"}
                        }
    ).then(result => {
        
        /**Si todo esta correcto, retornamos la Informacion */
        if(result.status == 200){

            console.log('Retorno codigo ' + result.status);

            return result.json();

        }else{

            /**Si un error distinto del codigo 200, retornamos el codigo de error, si fue error de error etc */
            responseObj = {
                responseStatus: result.status
            }

            return responseObj;
        }
    });

    if(data.responseStatus != undefined){
        alert('Existio un error de comunicación. Código error: ' + data.responseStatus);
        return;
    }
    
    cantidad = Object.keys(data).length;

    if(cantidad > 0){

        for(indice = 0; indice < cantidad; indice++){

            idUsuario           = data[indice].ID_USUARIO;
            usuario             = data[indice].USUARIO;
            nombre              = data[indice].NOMBRE;
            apellido            = data[indice].APELLIDO;
            email               = data[indice].EMAIL;
            password            = data[indice].PASSWORD;
            fechaCaptura        = data[indice].FECHACAPTURA;
            estado              = data[indice].ESTADO;
            tipoUsuario         = data[indice].TIPO_USUARIO;
            nombreTipoUsuario   = data[indice].NOMBRE_TIPO_USUARIO;

            if(estado == 0){
                estadoDescri = "ACTIVO";
            }else{
                estadoDescri = "INACTIVO";
            }

            contenido += `
                <tr class="text-center">
                    <td>${indice + 1}</td>
                    <td>${usuario}</td>
                    <td>${nombre}</td>
                    <td>${apellido}</td>
                    <td>${email}</td>
                    <td>${nombreTipoUsuario}</td>
                    <td>${fechaCaptura}</td>
                    <td>${estadoDescri}</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-warning" onclick="vistaEditarUsuario(${idUsuario}); return false;">
                            <i class="fas fa-edit"></i> Editar
                        </button>
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-danger" onclick="eliminarUsuario(${idUsuario}); return false;">
                            <i class="fas fa-trash-alt"></i> Eliminar
                        </button>
                    </td>
                </tr>
            `;

        }       /**Fin del For */

        document.getElementById("rptUsuarios").innerHTML = contenido;
    }
}

/**
 * Funcion encargada de eliminar un usuario por medio de su ID
 * @param {*} idUsuario 
 * @returns 
 */
var eliminarUsuario = async (idUsuario) =>{

    params = {
        "funcion"       : "eliminarUsuario",
        "idUsuario"     : idUsuario
    }

    const result = await fetch("http://localhost/SistemaVentas/controller/usuarios/usuarios.controller.php",{
                method: "POST",
                body: JSON.stringify(params),
                headers: {"Content-Type": "application/json; chartset=UTF-8"}
    }).then(result => result.json());

    console.log(result);

    codeStatus  = result.CODIGO;
    mensaje     = result.MENSAJE;

    if(codeStatus == -1){
        alert(mensaje);
        return;
    }

    alert(mensaje);
    listarUsuarios();

}

/**
 * Funcion encargada de crear un usuario de sistema de ventas.
 */
var vistaCrearUsuario = async () =>{

    contenido = ``;

    tipoUsuario = await cmbTipoUsuario();

    contenido = `
        <div class="container-fluid">
            <div class="row">

                <div class="col-sm-12">
                    <label class="fw-bold">Ingrese nombre:</label>
                    <input type="text" id="txtNombre" class="form-control" placeholder="Nombre" />
                </div>

                <div class="col-sm-12">
                    <label class="fw-bold">Ingrese apellido:</label>
                    <input type="text" id="txtApellido" class="form-control" placeholder="Apellido" />
                </div>

                <div class="col-sm-12">
                    <label class="fw-bold">Ingrese usuario:</label>
                    <input type="text" id="txtUsuario" class="form-control" placeholder="Usuario" />
                </div>

                <div class="col-sm-12">
                    <label class="fw-bold">Tipo Usuario:</label>
                    <div id="divTipoUsuario">
                        ${tipoUsuario}
                    </div>
                </div>

                <div class="col-sm-12">
                    <label class="fw-bold">Ingrese correo:</label>
                    <input type="text" id="txtCorreo" class="form-control" placeholder="Correo" />
                </div>

                <div class="col-sm-12">
                    <label class="fw-bold">Ingrese password:</label>
                    <input type="text" id="txtPassword" class="form-control" placeholder="Password" />
                </div>

                <div class="col-sm-12 modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" onclick="agregarUsuario(); return false;">
                        <i class="fas fa-plus-circle"></i> Registrar
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times-circle"></i> Cerrar
                    </button>
                </div>
            </div>
        </div>
    `;

    crearModal("modal1");
    document.getElementById("modal-content").innerHTML = contenido;

    setTimeout(function(){
        document.getElementById("txtNombre").focus();
    }, 500);

}

/**
 * Funcion encargada de regresar al menu principal
 */
var regresarMenu = () =>{
    window.location.href = "http://localhost/SistemaVentas/view/dashboard/dashboard.php";
}

/**
 * Funcion encargada de crear un nuevo modal.
 * @param {*} idModal Identificador del Modal
 * @returns EL objeto modal actual.
 */
var crearModal = (idModal) =>{
    myModal = new bootstrap.Modal(document.getElementById(idModal));

    myModal.show();
    return myModal;
}

/**
 * Funcion encargada de crear un nuevo usuario de sistema.
 */
var agregarUsuario = async () =>{

    /**Realizamos validaciones de campos obligatorios */
    nombre      = document.getElementById('txtNombre').value;
    apellido    = document.getElementById('txtApellido').value;
    usuarioNew  = document.getElementById('txtUsuario').value;
    correo      = document.getElementById('txtCorreo').value;
    password    = document.getElementById('txtPassword').value;
    tipoUsuario = document.getElementById("selectTipoUsuario").value;

    console.log(usuarioNew);


    if(nombre == "" || nombre == undefined){
        alert("Favor ingresar el nombre del nuevo usuario");
        return;
    }

    if(apellido == "" || apellido == undefined){
        alert("Favor ingresar el apellido del nuevo usuario");
        return;
    }

    if(usuarioNew == "" || usuarioNew == undefined){
        alert("Favor ingresar el usuario");
        return;
    }

    if(apellido == "" || apellido == undefined){
        alert("FAvor ingresar el apellido del nuevo usuario");
        return;
    }

    if(correo == "" || correo == undefined){
        alert("Favor ingresar el correo del nuevo usuario");
        return;
    }

    if(password == "" || password == undefined){
        alert("Favor ingresar el password del nuevo usuario");
        return;
    }

    if(tipoUsuario == -1){
        alert("Favor selecione el tipo de usuario");
        return;
    }

    verificarToken();       /**Verificamos si el token no ha expirado, si ha expirado entonces redireccionamos */

    jwt = JSON.parse(localStorage.getItem("jwt"));

    idUsuario   = jwt.idUsuario;
    usuarioJwt  = jwt.usuario;

    params = {
        "funcion"       : "crearUsuario",
        "nombre"        : nombre,
        "apellido"      : apellido,
        "usuario"       : usuarioNew,
        "tipoUsuario"   : tipoUsuario,
        "correo"        : correo,
        "password"      : password,
        "usuarioCrea"   : usuarioJwt
    }

    const result = await fetch("http://localhost/SistemaVentas/controller/usuarios/usuarios.controller.php",{
                method: "POST",
                body: JSON.stringify(params),
                headers: {"Content-Type": "application/json; chartset=UTF-8"}
    }).then(result => {

        if(result.status == 200){
            return result.json();
        }else{

            /**Si obtenemos un codigo de estado distinto del 200, retornamos el codigo de error */
            objResponse = {
                responseStatus: result.status
            }

            return objResponse;
        }
    });

    if(result.responseStatus != undefined){
        alert('Existio un error de comunicacion. Codigo de error: ' + result.responseStatus);
        return;
    }

    codigo  = result.CODIGO;
    mensaje = result.MENSAJE;

    if(codigo == 602){      /**Registro no guardado */
        alert(mensaje);
        return;
    }

    if(codigo == 601){
        alert(mensaje);
        listarUsuarios();
        modal = getModalInstance("modal1");
        modal.hide();
    }
}

/**
 * Funcion encargada de crear la vista para poder editar un usuario.
 * @param {*} idUsuario 
 */
var vistaEditarUsuario = async (idUsuario) =>{

    contenido = ``;

    params = {
        "funcion"   : "obtenerUsuario",
        "idUsuario" : idUsuario
    }

    const data = await fetch("http://localhost/SistemaVentas/controller/usuarios/usuarios.controller.php",{
                method: "POST",
                body: JSON.stringify(params),
                headers: {"Content-Type": "application/json; chartset=UTF-8"}   
    }).then(result => result.json());

    idUsu               = data[0].ID_USUARIO;
    usuario             = data[0].USUARIO;
    nombreUsu           = data[0].NOMBRE;
    apellido            = data[0].APELLIDO;
    email               = data[0].EMAIL;
    password            = data[0].PASSWORD;
    fechaCaptura        = data[0].FECHACAPTURA;
    estado              = data[0].ESTADO;
    tipoUsuario         = data[0].TIPO_USUARIO;
    nombreTipoUsuario   = data[0].NOMBRE_TIPO_USUARIO;

    tipoUsuario = await cmbTipoUsuario(tipoUsuario);

    if(estado == 0){            /**Activo */
        options = `
            <option selected value="${estado}">ACTIVO</option>
            <option value="1">INACTIVO</option>
        `;
    }else if(estado == 1){
        options = `
            <option value="0">ACTIVO</option>
            <option selected value="${estado}">INACTIVO</option>
        `;
    }

    cmbEstado = `
        <select id="cmbEstado" class="form-control">
            ${options}
        </select>
    `;

    contenido = `
        <div class="container-fluid">
            <div class="row">

                <div class="col-sm-12">
                    <label class="fw-bold">Ingrese nombre:</label>
                    <input type="text" id="txtNombre" class="form-control" placeholder="Nombre" value="${nombreUsu}" />
                </div>

                <div class="col-sm-12">
                    <label class="fw-bold">Ingrese apellido:</label>
                    <input type="text" id="txtApellido" class="form-control" placeholder="Apellido" value="${apellido}" />
                </div>

                <div class="col-sm-12">
                    <label class="fw-bold">Ingrese usuario:</label>
                    <input type="text" id="txtUsuario" class="form-control" placeholder="Usuario" value="${usuario}" />
                </div>

                <div class="col-sm-12">
                    <label class="fw-bold">Tipo Usuario:</label>
                    <div id="divTipoUsuario">
                        ${tipoUsuario}
                    </div>
                </div>

                <div class="col-sm-12">
                    <label class="fw-bold">Ingrese correo:</label>
                    <input type="text" id="txtCorreo" class="form-control" placeholder="Correo" value="${email}" />
                </div>

                <div class="col-sm-12">
                    <label class="fw-bold">Ingrese password:</label>
                    <input type="text" id="txtPassword" class="form-control" placeholder="Password" value="${password}" />
                </div>

                <div class="col-sm-12">
                    <label class="fw-bold">Seleccione Estado:</label>
                    ${cmbEstado}
                </div>

                <div class="col-sm-12 modal-footer">
                    <button type="button" class="btn btn-sm btn-warning" onclick="editarUsuario(${idUsu}); return false;">
                        <i class="fas fa-plus-circle"></i> Editar
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times-circle"></i> Cerrar
                    </button>
                </div>
            </div>
        </div>
    `;

    crearModal("modal1");
    document.getElementById("modal-content").innerHTML = contenido;
    document.getElementById("modal-titulo").innerHTML = "Editar Usuario";

    setTimeout(function(){
        document.getElementById("txtNombre").focus();
    }, 500);
}

/**
 * Funcion encargada de crear el Cmb de Tipo de Usuario
 */
var cmbTipoUsuario = async(tipoUsu = 0) =>{

    contenido = ``;

    params = {
        "funcion"   : "obtenerTipoUsuario"
    }

    const rstTipoUsuario = await fetch("http://localhost/SistemaVentas/controller/usuarios/usuarios.controller.php",{
                method: "POST",
                body: JSON.stringify(params),
                headers: {"Content-Type": "application/json; chartset=UTF-8"}   
    }).then(result => result.json());

    contenido += `
        <select id="selectTipoUsuario" class="form-control">
            <option value="-1">[ SELECCIONE ]</option>
    `;

    /**Si han eliminado el tipo usuario */
    if((rstTipoUsuario.CODIGO) != undefined){
        codigo  = rstTipoUsuario.CODIGO;
        mensaje = rstTipoUsuario.MENSAJE;

        alert(mensaje);

        contenido = `
            <select id="selectTipoUsuario" class="form-control">
                <option value="-1">[ NO DEFINIDOS ]</option>
            </select>
        `;

        return contenido;
    }

    cantidad = Object.keys(rstTipoUsuario).length;

    if(cantidad > 0){
        for(indice = 0; indice < cantidad; indice++){

            tipoUsuario = rstTipoUsuario[indice].TIPO_USUARIO;
            nombre      = rstTipoUsuario[indice].NOMBRE; 

            if(tipoUsu != 0){

                if(tipoUsu == tipoUsuario){
                    contenido += `
                        <option selected value="${tipoUsuario}">${nombre}</option>
                    `;
                }else{
                    contenido += `
                        <option value="${tipoUsuario}">${nombre}</option>
                    `;
                }
                
            }else{
                contenido += `
                    <option value="${tipoUsuario}">${nombre}</option>
                `;
            }
        }

        contenido += `</select>`;
    }

    return contenido;
}

/**
 * Funcion encargada de editar un usuario
 */
var editarUsuario = async (idUsuario) =>{

    /**Este error se puede dar sin un usuario altera el campo oculto del ID */
    if(idUsuario == "" || idUsuario == undefined){
        alert("Ocurrio un error, favor recargue la pagina nuevamente");
        return false;
    }

    /**Realizamos validaciones de campos obligatorios */
    nombre      = document.getElementById('txtNombre').value;
    apellido    = document.getElementById('txtApellido').value;
    usuarioNew  = document.getElementById('txtUsuario').value;
    correo      = document.getElementById('txtCorreo').value;
    password    = document.getElementById('txtPassword').value;
    tipoUsuario = document.getElementById("selectTipoUsuario").value;
    estado      = document.getElementById("cmbEstado").value;

    console.log(usuarioNew);


    if(nombre == "" || nombre == undefined){
        alert("Favor ingresar el nombre del nuevo usuario");
        return;
    }

    if(apellido == "" || apellido == undefined){
        alert("Favor ingresar el apellido del nuevo usuario");
        return;
    }

    if(usuarioNew == "" || usuarioNew == undefined){
        alert("Favor ingresar el usuario");
        return;
    }

    if(apellido == "" || apellido == undefined){
        alert("FAvor ingresar el apellido del nuevo usuario");
        return;
    }

    if(correo == "" || correo == undefined){
        alert("Favor ingresar el correo del nuevo usuario");
        return;
    }

    if(password == "" || password == undefined){
        alert("Favor ingresar el password del nuevo usuario");
        return;
    }

    if(tipoUsuario == -1){
        alert("Favor selecione el tipo de usuario");
        return;
    }

    verificarToken();       /**Verificamos si el token no ha expirado, si ha expirado entonces redireccionamos */

    params = {
        "funcion"       : "editarUsuario",
        "idUsuario"     : idUsuario,
        "nombre"        : nombre,
        "apellido"      : apellido,
        "usuario"       : usuarioNew,
        "tipoUsuario"   : tipoUsuario,
        "correo"        : correo,
        "password"      : password,
        "estado"        : estado
    }

    const result = await fetch("http://localhost/SistemaVentas/controller/usuarios/usuarios.controller.php",{
                method: "POST",
                body: JSON.stringify(params),
                headers: {"Content-Type": "application/json; chartset=UTF-8"}
    }).then(result => result.json());

    codigo  = result.CODIGO;
    mensaje = result.MENSAJE;

    if(codigo == 602){      /**Registro no guardado */
        alert(mensaje);
        return;
    }

    if(codigo == 601){
        alert(mensaje);
        listarUsuarios();
        modal = getModalInstance("modal1");
        modal.hide();
    }

}

/**
 * Funcion encargada de retornar una Instancia de un Modal creado.
 * @param {*} idModal 
 * @returns Object Modal
 */
var getModalInstance = (idModal) =>{
    var myModalEl = document.getElementById(idModal)
    var modal = bootstrap.Modal.getInstance(myModalEl) // Returns a Bootstrap modal instance

    return modal;
}