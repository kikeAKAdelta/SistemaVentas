<?php

date_default_timezone_set('America/Mexico_City');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="../../scripts/css/dashboard.css" rel="stylesheet" >
    <link href="../../libs/fontawesome-5/css/all.min.css" rel="stylesheet">
    <link href="../../libs/fontawesome-5/css/fontawesome.min.css" rel="stylesheet">
    <link href="../../libs/fontawesome-5/css/solid.min.css" rel="stylesheet">

    <script src="../../scripts/js/login.js"></script>
    <script src="../../scripts/js/dashboard.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

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

    <div class="container-fluid mt-2">
        <div class="row">
            <div class="col-sm-12">
                <div class="card p-2 fw-bold">
                    Usuarios
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card car-principal">
                    <div class="container-fluid">

                        <div class="row mt-2">

                            <div class="col-sm-3">
                                <button type="button" class="btn btn-sm btn-danger" onclick="regresarMenu(); return false;">
                                    <i class="fas fa-arrow-circle-left"></i>  Regresar
                                </button>
                            </div>

                            <div class="col-sm-3">
                                <button type="button" class="btn btn-sm btn-success" onclick="vistaCrearUsuario(); return false;">
                                    <i class="fas fa-plus-circle"></i> Agregar
                                </button>
                            </div>

                        </div>

                    </div>

                    <div class="container-fluid mt-3">
                        <div id="rptUsuarios"></div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
    
</body>
</html>


<script src="../../scripts/js/usuarios.js"></script>


<!-- MODALES -->

<!-- Modal -->
<div class="modal fade" id="modal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-titulo">Agregar Categoria</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="modal-content">
        
      </div>
      
    </div>
  </div>
</div>