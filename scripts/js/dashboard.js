/**
 * Funcion encargada de redireccionar a las rutas de las vistas correspondientes.
 * @param {*} view Nombre de la vista.
 */
var redirectView = (view) =>{

    if(view !== ''){

        if(view == 'categorias'){
            window.location.href = 'http://localhost/SistemaVentas/view/categorias/categorias.php';
        }else if(view == 'usuarios'){
            window.location.href = 'http://localhost/SistemaVentas/view/usuarios/usuarios.php';
        }else if(view == 'inventario'){
            window.location.href = 'http://localhost/SistemaVentas/view/productos/productos.php';
        }
    }

    return;
}

/**
 * Funcion encargada de regresar al menu principal
 */
var regresarMenu = () =>{
    window.location.href = "http://localhost/SistemaVentas/view/dashboard/dashboard.php";
}