<?php 

// require_once('./_db/funciones.php');

// $informacion = consultar_seguros(164);

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
    <link rel="stylesheet" href="../css/estilos.min.css" media="all">
    <link rel="stylesheet" href="../css/impresion.min.css" media="print">
</head>
<body>
<?php
    if ( isset($_POST['nombres']) ) {
?>
    <div class="pagina" >
        <div class="area_impresion">
            <div class="margen_d area_impresion_empresa_a"><?php echo $_POST['empresa'] ?></div>
            <div class="margen_d area_impresion_titulo">certificado de trabajo</div>
            <div class="margen_d area_impresion_cuerpo_a">Se certifica a <strong class="subrayar"><?php echo $_POST['nombres']." ".$_POST['apellidos'] ?></strong> ha trabajado para esta Empresa a partir del <strong><?php echo $_POST['f_a'] ?></strong> hasta el <strong><?php echo $_POST['f_b'] ?></strong> como <strong><?php echo $_POST['cargo_a']; ?></strong>. </div>
            <div class="margen_d area_impresion_cuerpo_b">Se expide el presente certificado, a solicitud de parte interesada.</div>
            <div class="margen_d area_impresion_cuerpo_d"><?php echo $_POST['dpto'] ?> <?php echo $_POST['fecha_emision'] ?> </div>
        </div>
    </div>
<?php
    } else {
?>

<?php
    }
?>    
<?php //var_dump($informacion[0]) ?>
</body>
</html>