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
            <div class="margen_d area_impresion_empresa_b"><?php echo $_POST['empresa'] ?></div>
            <div class="margen_d area_impresion_titulo">certificado de trabajo</div>
            <div class="margen_d area_impresion_cuerpo_a">Certificamos que <strong class="subrayar"><?php echo $_POST['nombres']." ".$_POST['apellidos'] ?></strong> ha trabajado para esta Empresa desde el <strong><?php echo $_POST['f_a'] ?></strong> y siendo su cese el <strong><?php echo $_POST['f_b'] ?></strong> desempeñándose como <strong><?php echo $_POST['cargo_a']; ?></strong>. </div>
            <div class="margen_d area_impresion_cuerpo_b">Durante el tiempo de su permanencia, ha demostrado honradez, buena conducta en la empresa, extendiéndose el presente certificado para los fines que estime conveniente.</div>
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