<?php
session_start();
 
if(!isset($_SESSION['usuario_id'])){
    header('Location: acceso.php');
    exit;
}

include('./_db/funciones.php');

 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SisPen - Control de Acceso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="./css/estilos.min.css" media="all">
    <link rel="stylesheet" href="./datatables/datatables.min.css">
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
        .marco-tabla {
            background-color: rgba(37, 167, 206, 0.75);
            border: 1.5px solid ;
            border-color: rgba(255, 255, 255, 0.75) rgba(28, 165, 206, 0.75) rgba(28, 165, 206, 0.75) rgba(255, 255, 255, 0.75);
            border-radius: .5em;
            -webkit-box-shadow: -10px 0px 13px -7px #110b69ee, 10px 0px 13px -7px #110b69ee, 5px 5px 15px 5px rgba(0,0,0,0.2); 
            box-shadow: -10px 0px 13px -7px #110b69ee, 10px 0px 13px -7px #110b69ee, 5px 5px 15px 5px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body style="overflow: hidden;">
    <div class="contenedor">
        <div class="row justify-content-center align-content-center" style="height: 100vh; ">
            <div class="col-10 text-center">
                <div class="row justify-content-center mt-3">
                    <div class="col-lg-4 col-md-7">
                        <form class="marco" method="post" action="acceso.php">
                            <div class="app_horizontal_barra_logo"><div>Sis</div><div>Pen</div></div>
                            <fieldset>
        
                                <div class="row align-items-center mr-1">
                                    <label for="apellidos" class="col-sm-3 col-form-label text-end fs-6">Usuario:</label>
                                    <div class="col-sm-9">
                                        <input required type="text" id="usuario" name="usuario" class=" form-control form-control-sm" placeholder="Usuario" value="">
                                    </div>
                                </div>
                                <div class="row align-items-center mb-1">
                                    <label for="dni" class="col-sm-3 col-form-label text-end fs-6">Clave:</label>
                                    <div class="col-sm-9">
                                        <input required type="password" id="clave" name="clave" class="form-control form-control-sm" placeholder="Clave" value="">
                                    </div>
                                </div>
                                <div class="row align-items-center mb-1">
                                    <label for="dni" class="col-sm-3 col-form-label text-end fs-6">Confirmar:</label>
                                    <div class="col-sm-9">
                                        <input required type="password" id="cclave" name="cclave" class="form-control form-control-sm" placeholder="Confirmar" value="">
                                    </div>
                                </div>
        
                                <hr class="divider my-2"/>
                                
                                <div class="row">
                                    <div class="col-6">
                                        <button class="w-100 btn btn-sm btn-warning" type="reset">Cancelar</button>
                                    </div>
                                    <div class="col-6">
                                        <button class="w-100 btn btn-sm btn-primary" type="submit">Ingresar</button>
                                    </div>
                                </div>
        
                                <p class="mt-3 text-muted fs-6 fw-bold text-white">SisPen &copy; 2022</p>
        
                            </fieldset>
                        </form>
                    </div>
                </div>
                <div class="row mt-3 p-0 m-0">
                    <div class="col-12 marco-tabla p-0 m-0">
                        <table id="tabladatos" class=" table table-striped fs-6" style="width:100%; font-size: .7em;">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>NOMBRES</th>
                                    <th>APELLIDOS</th>
                                    <th>ALIAS</th>
                                    <th>ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $listaUsuarios = obtener_usuarios();
                                    foreach ($listaUsuarios as $usuario) {
                                        echo "<tr>\n";
                                        echo "<td>",$usuario['id'],"</td>\n";
                                        echo "<td>",$usuario['nombres'],"</td>\n";
                                        echo "<td>",$usuario['apellidos'],"</td>\n";
                                        echo "<td>",$usuario['alias'],"</td>\n";
                                        echo "</tr>\n";
                                    } 
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <script src="js/moment-with-locales.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="./datatables/datatables.min.js"></script>
    <script>
        $(document).ready( function () {
            $('#tabladatos').DataTable({
              "ordering": false,
              "searching": false,
              "paging": false,
              "info": false
            });
        } );

    </script>
</body>
</html>