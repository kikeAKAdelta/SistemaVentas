<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="../../libs/fontawesome-5/css/all.min.css" rel="stylesheet">
    <link href="../../libs/fontawesome-5/css/fontawesome.min.css" rel="stylesheet">
    <link href="../../libs/fontawesome-5/css/solid.min.css" rel="stylesheet">

    <!-- JS -->
    <script src="../../scripts/js/login.js"></script>
    
</head>
<body>
    
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-lg-12">

                <div clas="card">

                    <div class="card-header">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="text-center">
                                    Inicio de Sesion
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12 col-lg-12 col-xs-12">
                                    <input type="text" name="usuario" id="usuario" class="form-control" placeholder="Ingrese Usuario" />
                                </div>
                                <br>

                                <div class="col-md-12 col-lg-12 col-xs-12 mt-3">
                                    <input type="text" name="password" id="password" class="form-control" placeholder="Ingrese Password" />
                                </div>

                                <div class="col-md-12 col-lg-12 col-xs-12 mt-3 text-center">
                                    <button class="btn btn-sm btn-success" onclick="validarCampos(); return false;">
                                        <i class="fas fa-sign-in-alt"></i> Ingresar
                                    </button>
                                    <button type="button" class="btn btn-sm btn-warning">
                                        <i class="fas fa-eraser"></i> Limpiar
                                    </button>
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