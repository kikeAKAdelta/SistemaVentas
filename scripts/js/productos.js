window.onload = () => listarProductos();

/**
 * Funcion encargada de crear la vista para crear un nuevo producto que llegue a la sucursal.
 */
var vistaCrearProductos = async () =>{

    contenido = ``;

    cmbProveedores = await cmbProveedor();
    cmbCategorias  = await cmbCategoria();

    contenido = `<div class="container-fluid">
                    <div class="row">

                        <div class="col-sm-12 mb-2">
                            <label class="fw-bold"> Ingrese nombre producto:</label>
                            <input type="text" id="txtNombre" class="form-control form-control-sm" placeholder="Ingrese nombre" />
                        </div>

                        <div class="col-sm-12 mb-2">
                            <label class="fw-bold"> Ingrese descripción:</label>
                            <input type="text" id="txtDescripcion" class="form-control form-control-sm" placeholder="Ingrese descripción" />
                        </div>

                        <div class="col-sm-12 mb-2">
                            <label class="fw-bold"> Ingrese precio unitario:</label>
                            <input type="number" id="txtPrecio" class="form-control form-control-sm" placeholder="Ingrese precio unitario" />
                        </div>

                        <div class="col-sm-12 mb-2">
                            <label class="fw-bold"> Ingrese cantidad:</label>
                            <input type="number" id="txtCantidad" class="form-control form-control-sm" placeholder="Ingrese cantidad" />
                        </div>

                        <div class="col-sm-12 mb-2">
                            <label class="fw-bold"> Seleccione Proveedor:</label>
                            <div id="divProveedor">
                                ${cmbProveedores}
                            </div>
                        </div>

                        <div class="col-sm-12 mb-2">
                            <label class="fw-bold"> Seleccione Categoria:</label>
                            <div id="divCategoria">
                                ${cmbCategorias}
                            </div>
                        </div>

                        <div class="col-sm-12 modal-footer">
                            <button type="button" class="btn btn-sm btn-primary" onclick="agregarProducto(); return false;">
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
 * Funcion encargada de obtener los proveedores y crear el select correspondiente.
 * @returns string contenido El Select de Proveedores
 */
var cmbProveedor = async () =>{

    contenido = ``;

    params = {
        "funcion": "obtenerProveedores"
    };

    const result = await fetch('http://localhost/SistemaVentas/controller/productos/productos.controller.php',{
        method: "POST",
        body: JSON.stringify(params),
        headers: {"Content-Type": "application/json; chartset=UTF-8"}
    }).then(result => result.json());

    /**Validamos que existan los registros de proveedor */
    if(result.CODIGO != undefined){

        codigo  = result.CODIGO;
        mensaje = result.MENSAJE;

        alert(mensaje);

        contenido = `
            <select id="selectProveedor" class="form-control">
                <option value="-1">[ NO DEFINIDOS ]</option>
            </select>
        `;

        return contenido;

    }

    contenido += `<select id="selectProveedor" class="form-control">
                    <option value="-1">[ SELECCIONE ]</option>
    `;

    options = ``;

    cantidad = Object.keys(result).length;

    if(cantidad > 0){

        for(indice = 0; indice < cantidad; indice++){

            idProveedor         = result[indice].ID_PROVEEDOR;
            nombredProveedor    = result[indice].NOMBRE_PROVEEDOR;

            options += `<option value="${idProveedor}">${nombredProveedor}</option>`;
        }

        contenido += options;
    }

    contenido += `</select>`;

    return contenido;

}

/**
 * Funcion encargada de obtener los proveedores y crear el select correspondiente.
 * @returns string contenido El Select de Proveedores
 */
var cmbCategoria = async () =>{

    contenido = ``;

    params = {
        "funcion": "obtenerCategorias"
    };

    const result = await fetch('http://localhost/SistemaVentas/controller/productos/productos.controller.php',{
        method: "POST",
        body: JSON.stringify(params),
        headers: {"Content-Type": "application/json; chartset=UTF-8"}
    }).then(result => result.json());

    /**Validamos que existan los registros de proveedor */
    if(result.CODIGO != undefined){

        codigo  = result.CODIGO;
        mensaje = result.MENSAJE;

        alert(mensaje);

        contenido = `
            <select id="selectCategorias" class="form-control">
                <option value="-1">[ NO DEFINIDOS ]</option>
            </select>
        `;

        return contenido;

    }

    contenido += `<select id="selectCategorias" class="form-control">
                    <option value="-1">[ SELECCIONE ]</option>
    `;

    options = ``;

    cantidad = Object.keys(result).length;

    if(cantidad > 0){

        for(indice = 0; indice < cantidad; indice++){

            idCategoria         = result[indice].ID_CATEGORIA;
            nombredCategoria    = result[indice].NOMBRECATEGORIA;

            options += `<option value="${idCategoria}">${nombredCategoria}</option>`;
        }

        contenido += options;
    }

    contenido += `</select>`;

    return contenido;

}

/**
 * Funcion encargada de validar los campos y enviar los datos al servidor para que se pueda registrar.
 */
var agregarProducto = async () =>{

    nombre          = document.getElementById('txtNombre').value;
    descripcion     = document.getElementById('txtDescripcion').value;
    precioUnitario  = document.getElementById('txtPrecio').value;
    cantidad        = document.getElementById('txtCantidad').value;
    proveedor       = document.getElementById('selectProveedor').value;
    categoria       = document.getElementById('selectCategorias').value;

    if(nombre == ''){
        alert('Ingrese el nombre del producto por favor');
        return;
    }

    if(descripcion == ''){
        alert('Ingrese la descripcion del producto por favor');
        return;
    }

    if(precioUnitario <= 0){
        alert('El precio unitario debe de ser mayor que cero');
        return;
    }

    if(cantidad <= 0){
        alert('La cantidad debe de ser mayor que cero');
        return;
    }

    if(proveedor == -1){
        alert('Seleccione un proveedor por favor');
        return;
    }

    if(categoria == -1){
        alert('Seleccione una categoria por favor');
        return;
    }

    verificarToken();       /**Verificamos si el token no ha expirado, si ha expirado entonces redireccionamos */

    jwt         = JSON.parse(localStorage.getItem("jwt"));

    idUsuario   = jwt.idUsuario;
    usuario     = jwt.usuario;

    params = {
        "funcion"           : "crearProducto",
        "nombre"            : nombre,
        "descripcion"       : descripcion,
        "precioUnitario"    : precioUnitario,
        "cantidad"          : cantidad,
        "proveedor"         : proveedor,
        "categoria"         : categoria,
        "idUsuario"         : idUsuario,
        "usuario"           : usuario,
    }

    const result = await fetch("http://localhost/SistemaVentas/controller/productos/productos.controller.php",{
                method: "POST",
                body: JSON.stringify(params),
                headers: {"Content-Type": "application/json; chartset=UTF-8"}
    }).then(result => result.json());

    codigo  = result.code;
    mensaje = result.mensaje;

    if(codigo == 602){      /**Registro no guardado */
        alert(mensaje);
        return;
    }

    if(codigo == 601){
        alert(mensaje);
        listarProductos();
        modal = getModalInstance("modal1");
        modal.hide();
    }
    
}

/**
 * Funcion encargada de listar todos los productos
 */
var listarProductos = async () =>{

    contenido = ``;

    params = {
        "funcion": "listarProductos"
    };

    const result = await fetch('http://localhost/SistemaVentas/controller/productos/productos.controller.php',
                            {
                                method: "POST",
                                body: JSON.stringify(params),
                                headers: {"Content-Type": "application/json; chartset=UTF-8"}
                            }
    ).then(result => result.json());

    cantidad = Object.keys(result).length;

    console.log(result);
    fila = 0;

    if(cantidad > 0){

        contenido += `
            <table class="table table-sm table-bordered table-hover">
                <thead>
                    <tr class="bg-celeste text-center">
                        <th>N°</th>
                        <th>Producto</th>
                        <th>Descripcion</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Cantidad Minima</th>
                        <th>Estado</th>
                        <th>Fecha Registro</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
        `;

        for(indice = 0; indice < cantidad; indice++){

            idProducto      = result[indice].ID_PRODUCTO;
            idCategoria     = result[indice].ID_CATEGORIA;
            idUsuario       = result[indice].ID_USUARIO;
            idProvedor      = result[indice].ID_PROVEEDOR;
            nombre          = result[indice].NOMBRE;
            descripcion     = result[indice].DESCRIPCION;
            cant            = result[indice].CANTIDAD;
            precioUnitario  = result[indice].PRECIOUNITARIO;
            cantidadMinima  = result[indice].CANTIDADMINIMA;
            estado          = result[indice].ESTADO;
            fecha           = result[indice].FECHACAPTURA;

            fila = fila + 1;

            contenido += `
                    <tr class="text-center">
                        <td>${fila}</td>
                        <td>${nombre}</td>
                        <td>${descripcion}</td>
                        <td>${cant}</td>
                        <td>${precioUnitario}</td>
                        <td>${cantidadMinima}</td>
                        <td>${estado}</td>
                        <td>${fecha}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i> Editar
                            </button>
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i> Eliminar
                            </button>
                        </td>
                    </tr>
            `;

        }

        contenido +=`
                    </tbody>
                </table>
        `;

    }else{

        contenido += `
            <div class="alert alert-danger" role="alert">
                <i class="fas fa-exclamation-triangle"></i> No se han registrado productos.
            </div>
        `;

    }

    document.getElementById('rptProductos').innerHTML = contenido;

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