
<?php

date_default_timezone_set('America/Mexico_City');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="../../scripts/css/dashboard.css" rel="stylesheet" >
    <link href="../../libs/fontawesome-5/css/all.min.css" rel="stylesheet">
    <link href="../../libs/fontawesome-5/css/fontawesome.min.css" rel="stylesheet">
    <link href="../../libs/fontawesome-5/css/solid.min.css" rel="stylesheet">

    <script src="../../scripts/js/login.js"></script>
    <script src="../../scripts/js/dashboard.js"></script>
    <script>
        verificarToken();
    </script>
</head>
<body>

    <!-- HEADER -->
    <div id="body_header">
        <nav class="navbar navbar-expand-lg header_menu">
            <div class="container-fluid">
                <span class="navbar-brand fw-bold">Sistema de Ventas</span>
                </div>
            </div>
        </nav>
    </div>


    <!-- BODY -->
    <div id="body_main">

        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card car-principal">
                        <div class="container-fluid">
                            <div class="row mt-4">

                                <!-- Ventas -->
                                <div class="col-sm-3 mb-3">
                                    <div class="card car-principal-items">
                                        <div class="card-header fw-bold text-center">
                                            Ventas
                                        </div>

                                        <div class="card-body text-center icon-clientes">
                                            <i class="fas fa-address-card fa-3x"></i>
                                        </div>
                                    </div>
                                </div>

                                <!-- Clientes -->
                                <div class="col-sm-3 mb-3">
                                    <div class="card car-principal-items">
                                        <div class="card-header fw-bold text-center">
                                            Clientes
                                        </div>

                                        <div class="card-body text-center icon-clientes">
                                            <i class="fas fa-users fa-3x"></i>
                                        </div>
                                    </div>
                                </div>

                                <!-- Proveedores -->
                                <div class="col-sm-3 mb-3">
                                    <div class="card car-principal-items">
                                        <div class="card-header fw-bold text-center">
                                            Proveedores
                                        </div>

                                        <div class="card-body text-center icon-proveedor">
                                            <i class="fas fa-box fa-3x"></i>
                                        </div>
                                    </div>
                                </div>

                                <!-- Usuarios -->
                                <div class="col-sm-3 mb-3" onclick="redirectView('usuarios'); return false;">
                                    <div class="card car-principal-items">
                                        <div class="card-header fw-bold text-center">
                                            Usuarios
                                        </div>

                                        <div class="card-body text-center icon-usuarios">
                                            <i class="fas fa-users-cog fa-3x"></i>
                                        </div>
                                    </div>
                                </div>

                                <!-- Categorias Productos -->
                                <div class="col-sm-3 mb-3" onclick="redirectView('categorias'); return false;">
                                    <div class="card car-principal-items">
                                        <div class="card-header fw-bold text-center">
                                            Categorias
                                        </div>

                                        <div class="card-body text-center icon-usuarios">
                                            <i class="fas fa-tasks fa-3x"></i>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>


            </div>


        </div>

    </div>

    
</body>
</html>