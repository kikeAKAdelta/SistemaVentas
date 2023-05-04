/**
 * Funcion encargada de redireccionar a las rutas de las vistas correspondientes.
 * @param {*} view Nombre de la vista.
 */
var redirectView = (view) =>{

    if(view !== ''){

        if(view == 'categorias'){
            window.location.href = 'http://localhost/SistemaVentas/view/categorias/categorias.php';
        }
    }

    return;
}