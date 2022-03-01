<?php 

require_once('./_db/funciones.php');

$informacion = consultar_seguros(164);

// if ( isset($_FILES['archivo']) ) {
//     cargar_csv_bd($_FILES['archivo'], $_POST['encabezado'], $_POST['separador']);
// }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seguros</title>
    <link rel="stylesheet" href="css/estilos.min.css" media="all">
    <link rel="stylesheet" href="css/impresion.min.css" media="print">
</head>
<body>
<?php
    if ( isset($_POST['nombre']) ) {
?>
    <div class="pagina" >
        <div class="area_impresion">
            <div class="titulo">constancia de trabajo</div>
            <div class="cuerpo_a">Se deja constancia que la sra.<strong><?php echo $_POST['nombre']." ".$_POST['apellidos'] ?></strong>, ha laborado para nuestra empresa como <strong><?php echo "ELCARGO"; ?></strong> a partir del <strong><?php echo $informacion[0]['f_inic_act'] ?></strong> al <strong><?php echo $informacion[0]['f_baja_act'] ?></strong>. </div>
            <div class="cuerpo_b">Durante su tiempo de servicios la mencionada señora, demostro en todo momento un alto grado de responsabilidad en las tareas encomendadas por la empresa.</div>
            <div class="cuerpo_c">A solucitud de la interesada, se extiende la constancia para el uso que le pueda dar.</div>
            <div class="cuerpo_d">Lima <?php echo date("d.m.Y") ?> </div>
        </div>
    </div>
<?php
    } else {
?>

<?php
    }
?>    
<?php var_dump($informacion[0]) ?>
</body>
</html>