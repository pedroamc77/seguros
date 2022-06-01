<?php 

if ( isset($_POST['cargo_ac']) ) $cargo = $_POST['cargo_ac'];
if ( isset($_POST['cargo_bc']) ) $cargo = $_POST['cargo_bc'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seguros</title>
    <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="../css/estilos.min.css" media="all">
    <!-- <link rel="stylesheet" href="../css/impresion.min.css" media="print"> -->
</head>
<body>
<?php
    if ( isset($_POST['nombres']) ) {
?>
    <div class="pagina" >
        <div class="certificado7375">
            <div class="cer7375_empresa"><?php echo $_POST['empresa'] ?></div>
            <div class="cer7375_titulo">certificado de trabajo</div>
            <div class="cer7375_cuerpo">Certificamos que <strong class="subrayar" style="color: red"><?php echo $_POST['nombres']." ".$_POST['apellidos'] ?></strong> ha trabajado en nuestra empresa desde el <strong style="color: red"><?php echo $_POST['f_a_b'] ?></strong> y siendo su cese el <strong style="color: red"><?php echo $_POST['f_b_b'] ?></strong> desempeñandose como <strong style="color: red"><?php echo $cargo; ?> </strong>. </div>
            <div class="cer7375_cuerpo">Durante el tiempo de su permanencia, ha demostrado honradez, buena conducta en la empresa, extendiéndose el presente certificado para los fines que estime conveniente.</div>
            <div class="cer7375_fecha"><strong><?php echo isset($_POST['dpto']) ? $_POST['dpto']."," : ""; ?> <?php echo $_POST['emision'] ?></strong> </div>
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