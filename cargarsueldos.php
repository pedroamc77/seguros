<?php 
session_start();
 
if(!isset($_SESSION['usuario_id'])){
    header('Location: acceso.php');
    exit;
}

require_once('./_db/funciones.php');

// $informacion = consultar_bd();

if ( isset($_FILES['archivo']) ) {
    cargar_sueldos_bd($_FILES['archivo'], $_POST['encabezado'], $_POST['separador']);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seguros</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</head>
<body>
    <form method="POST" class="contenido shadow" enctype="multipart/form-data">
        <div class="mb-3">
            <table class=" table table-light table-responsive " with="100%">
                <tr>
                    <td colspan="2">
                        <input name="archivo" accept=".csv,.txt" class="form-control form-control-sm" id="formFileSm" type="file">
                    </td>
                    <td>
                        <button type="submit" class="btn btn-primary btn-sm">Enviar archivo</button>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" name="encabezado" value="true">
                        <label class="form-check-label" for="flexCheckDefault">
                            La primera linea son encabezados
                        </label>
                    </td>
                    <td>
                        <label style="width: 78% !important; text-align: right;">Seleccione el separador: </label>
                        <div style="max-width: 20% !important; float: right;">
                            <select class="form-select form-select-sm" aria-label=".form-select-sm" name="separador" >
                                <option selected value=",">,</option>
                                <option value=";">;</option>
                                <option value=".">.</option>
                                <option value=":">:</option>
                                <option value="*">*</option>
                                <option value="/">/</option>
                                <option value="-">-</option>
                                <option value="_">_</option>
                                <option value=" ">Espacio</option>
                            </select>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </form>
    <?php

        if ( isset($_FILES['archivo']) ) {

            $delimitador = ";";
            
            $file = fopen( $_FILES['archivo']['tmp_name'], "r");
            $data = array();
            $numFila = 0;
            
            echo "<table class='table table-light table-striped table-hover tablaFenix table-responsive' style='font-size: 10px;'>";
            echo "<thead class='shadow'>";
            if ( isset($_POST['encabezado']) ) {
                $data = fgetcsv($file,null,$delimitador);
                echo "<tr>";
                for ( $i = 0; $i < count($data); $i++ ) echo "<th>",$data[$i],"</th>";
                echo "</tr>";
            }
            echo "</thead>";
            echo "<tbody>";
            while (!feof($file)) {
                $data = fgetcsv($file,null,$delimitador);
                if ( $numFila < 21 ){
                    echo "<tr>";
                    for ( $i = 0; $i < count($data); $i++ ) {
                        if ( $i == 7 || $i == 8 || $i == 11 || $i == 14 ){
                            if ( $data[$i] !== "" && $data[$i] !== "NO REGISTRA"  ) {
                                $fecha = explode("/", $data[$i]);
                                $f = $fecha[2]."-".$fecha[1]."-".$fecha[0];
                                echo "<td>",$f,"</td>";
                            } else {
                                echo "<td>","0000-00-00","</td>";
                            }
                        } else {
                            echo "<td>",$data[$i],"</td>";
                        }
                    }
                    echo "</tr>";
                }
                
            }
            echo "<tfoot>";
            echo "<tr><td colspan=2>Total Registros</td><td align='right'>",number_format($numFila, 0, ',', '.'),"</td></tr>";
            echo "</tfoot>";
            echo "</tbody>";
            echo "</table>";

            fclose($file);
        }

    ?>
    <script src="./js/moment-with-locales.min.js"></script>
</body>
</html>
