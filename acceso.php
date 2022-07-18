<?php
include('./_db/funciones.php');

session_start();

$error = "";
 
if (isset($_POST['desloguearse']) && $_POST['desloguearse'] ) {
    unset($_SESSION['usuario_id']);
    unset($_SESSION['nombre']);
}

if (isset($_POST['usuario'])) {
    $datos = autenticar_usuario($_POST['usuario'], $_POST['clave']);
    if (isset($_SESSION['usuario_id'])) {
        header('Location: index.php');
        exit;
    } else {
        $error = "No se ha podido autenticar, verifique sus credenciales y reintentelo.";
    }
}
 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SisPen - Control de Acceso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="./css/estilos.min.css" media="all">
    <link href="fa5130/css/all.min.css" rel="stylesheet" >
    <style>
        .marco {
            padding: 1em 2em;
            background-color: rgba(37, 167, 206, 0.75);
            border: 1.5px solid ;
            border-color: rgba(255, 255, 255, 0.75) rgba(28, 165, 206, 0.75) rgba(28, 165, 206, 0.75) rgba(255, 255, 255, 0.75);
            border-radius: 1em;
            -webkit-box-shadow: -10px 0px 13px -7px #110b69ee, 10px 0px 13px -7px #110b69ee, 5px 5px 15px 5px rgba(0,0,0,0.2); 
            box-shadow: -10px 0px 13px -7px #110b69ee, 10px 0px 13px -7px #110b69ee, 5px 5px 15px 5px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body style="overflow: hidden;">
    <div class="contenedor">
        <div class="row justify-content-center align-content-center" style="height: 100vh; ">
            <div class="col-lg-3 col-md-5 text-center">
                <form class="marco" method="post" action="acceso.php">
                    <div class="app_horizontal_barra_logo"><div>Sis</div><div>Pen</div></div>
                    <fieldset>
                        <div class="row align-items-center mr-1">
                            <label for="apellidos" class="col-sm-3 col-form-label text-end">Usuario:</label>
                            <div class="col-sm-9">
                                <input required type="text" id="usuario" name="usuario" class=" form-control form-control-sm" placeholder="Usuario" value="">
                            </div>
                        </div>
                        <div class="row align-items-center mb-1">
                            <label for="dni" class="col-sm-3 col-form-label text-end">Clave:</label>
                            <div class="col-sm-9">
                                <input required type="password" id="clave" name="clave" class="form-control form-control-sm" placeholder="Clave" value="">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-6">
                                <button class="w-100 btn btn-sm btn-warning" type="reset">Cancelar</button>
                            </div>
                            <div class="col-6">
                                <button class="w-100 btn btn-sm btn-primary" type="submit">Ingresar</button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <?php
                                if ($error !== "") echo $error;
                                ?>
                            </div>
                        </div>

                        <p class="mt-3 text-muted fs-6 fw-bold text-white">SisPen &copy; 2022</p>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</body>
</html>