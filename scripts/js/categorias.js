window.onload = () => listarCategorias();

/**
 * Funcion encargada de listar todas las categorias de productos
 */
var listarCategorias = async () =>{

    contenido = `
                <table class="table table-sm table-bordered table-hover">
                    <thead>
                        <tr class="bg-celeste text-center">
                            <th>N°</th>
                            <th>Categoria</th>
                            <th>Usuario</th>
                            <th>Fecha Registro</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
    `;

    params = {
        "funcion": "listarCategorias"
    }

    const data = await fetch("http://localhost/SistemaVentas/controller/categoria/categoria.controller.php",
                    {
                        method: "POST",
                        body: JSON.stringify(params),
                        headers: {"Content-Type": "application/json; charset=UTF-8"}
                    }
    ).then(result => result.json());

    cantidad = Object.keys(data).length;

    if(cantidad > 0){

        for(indice = 0; indice < cantidad; indice++){

            idCategoria     = data[indice].ID_CATEGORIA;
            idUsuario       = data[indice].ID_USUARIO;
            usuario         = data[indice].USUARIO;
            nombreCategoria = data[indice].NOMBRECATEGORIA;
            fechaCaptura    = data[indice].FECHACAPTURA;

            contenido += `
                <tr class="text-center">
                    <td>${indice + 1}</td>
                    <td>${nombreCategoria}</td>
                    <td>${usuario}</td>
                    <td>${fechaCaptura}</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-warning" onclick="vistaEditarCategoria(${idCategoria}); return false;">
                            <i class="fas fa-edit"></i> Editar
                        </button>
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-danger" onclick="eliminarCategoria(${idCategoria}); return false;">
                            <i class="fas fa-trash-alt"></i> Eliminar
                        </button>
                    </td>
                </tr>
            `;
        }   /**Fin del for */

        contenido += `  </tbody>
                    </table>
        `;

        document.getElementById("rptCategorias").innerHTML = contenido;

    }
}

/**
 * Funcion encargada de eliminar una categoria
 */
var eliminarCategoria = async (idCategoria) =>{

    params = {
        "funcion"       : "eliminarCategoria",
        "idCategoria"   : idCategoria
    }

    const result = await fetch("http://localhost/SistemaVentas/controller/categoria/categoria.controller.php",{
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
    listarCategorias();

}

/**
 * Función encargada de crear la vista para poder crear una nueva Categoria en un Modal
 */
var vistaCrearCategoria = async () =>{

    contenido = ``;

    contenido = `
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <label class="fw-bold"> Ingrese categoria:</label>
                    <input type="text" id="txtCategoria" class="form-control form-control-sm" placeholder="Ingrese categoria" />
                </div>

                <div class="col-sm-12 modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" onclick="agregarCategoria(); return false;">
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
        document.getElementById("txtCategoria").focus();
    }, 500);
}

/**
 * Funcion encargada de crea un nuevo modal
 */
var crearModal = (idModal) =>{
    myModal = new bootstrap.Modal(document.getElementById(idModal));
    myModal.show();

    return myModal;
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

/**
 * Funcion encargada de validar si los campos de categoria esten ingresados correctamente.
 */
var agregarCategoria = async () =>{

    categoria = document.getElementById("txtCategoria").value;

    if(categoria == "" || categoria == undefined){
        alert("Favor ingrese la categoria de los nuevos productos");

        return false;
    }

    verificarToken();       /**Verificamos si el token no ha expirado, si ha expirado entonces redireccionamos */

    jwt         = JSON.parse(localStorage.getItem("jwt"));

    idUsuario   = jwt.idUsuario;
    usuario     = jwt.usuario;

    params = {
        "funcion"   : "crearCategoria",
        "usuario"   : usuario,
        "idUsuario" : idUsuario,
        "categoria" : categoria
    }

    const result = await fetch("http://localhost/SistemaVentas/controller/categoria/categoria.controller.php",{
                method: "POST",
                body: JSON.stringify(params),
                headers: {"Content-Type": "application/json; chartset=UTF-8"}
    }).then(result => result.json());

    codigo = result.code;
    mensaje = result.mensaje;

    if(codigo == 602){      /**Registro no guardado */
        alert(mensaje);
        return;
    }

    if(codigo == 601){
        alert(mensaje);
        listarCategorias();
        modal = getModalInstance("modal1");
        modal.hide();
    }

}

/**
 * Funcion encargada de editar una categoria existente
 * @param {*} idCategoria 
 */
var vistaEditarCategoria = async (idCategoria) =>{

    params = {
        "funcion"       : "obtenerCategoria",
        "idCategoria"   : idCategoria
    };

    const result = await fetch("http://localhost/SistemaVentas/controller/categoria/categoria.controller.php",{
                method: "POST",
                body: JSON.stringify(params),
                headers: {"Content-Type": "application/json; chartset=UTF-8"}
    }).then(result => result.json());

    idCategoria     = result[0].ID_CATEGORIA;
    categoria       = result[0].NOMBRECATEGORIA;
    usuario         = result[0].USUARIO;
    fechaCaptura    = result[0].FECHACAPTURA;

    contenido = ``;

    contenido = `
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <label class="fw-bold"> Ingrese categoria:</label>
                    <input type="text" id="txtCategoria" class="form-control form-control-sm" value="${categoria}" placeholder="Ingrese categoria" />
                    <input type="hidden" id="txtIdCategoria" value="${idCategoria}" />
                </div>

                <div class="col-sm-12 modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" onclick="editarCategoria(${idCategoria}); return false;">
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
    document.getElementById("modal-titulo").innerHTML  = "Editar Categoria";
    
    setTimeout(function(){
        document.getElementById("txtCategoria").focus();
    }, 500);

}

/**
 * Funcion encargada de editar un categoria por medio de su ID
 * @returns 
 */
var editarCategoria = async (idCategoria) =>{

    categoria = document.getElementById("txtCategoria").value;

    if(categoria == "" || categoria == undefined){
        alert("Favor ingrese la categoria de los nuevos productos");
        return false;
    }

    /**Este error se puede dar sin un usuario altera el campo oculto del ID */
    if(idCategoria == "" || idCategoria == undefined){
        alert("Ocurrio un error, favor recargue la pagina nuevamente");
        return false;
    }

    verificarToken();       /**Verificamos si el token no ha expirado, si ha expirado entonces redireccionamos */

    jwt = JSON.parse(localStorage.getItem("jwt"));

    idUsuario   = jwt.idUsuario;
    usuario     = jwt.usuario;

    params = {
        "funcion"       : "editarCategoria",
        "usuario"       : usuario,
        "idUsuario"     : idUsuario,
        "categoria"     : categoria,
        "idCategoria"   : idCategoria,
    }

    const result = await fetch("http://localhost/SistemaVentas/controller/categoria/categoria.controller.php",{
                method: "POST",
                body: JSON.stringify(params),
                headers: {"Content-Type": "application/json; chartset=UTF-8"}
    }).then(result => result.json());

    console.log(result);

    codigo = result.code;
    mensaje = result.mensaje;

    if(codigo == 602){      /**Registro no editado */
        alert(mensaje);
        return;
    }

    if(codigo == 601){
        alert(mensaje);
        listarCategorias();
        modal = getModalInstance("modal1");
        modal.hide();
    }
}

