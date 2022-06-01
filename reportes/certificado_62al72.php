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
    <div class="pagina" >
        <div class="certificado7262">
            <div class="cer6272_empresa"><?php echo $_POST['empresa'] ?></div>
            <div class="cer6272_titulo">certificado de trabajo</div>
            <div class="cer6272_enunciado"><strong>Certifico: </strong></div>
            <div class="cer6272_cuerpo">A <strong class="subrayar" style="color: red"><?php echo $_POST['nombres']." ".$_POST['apellidos'] ?></strong> por haber trabajado para esta empresa como <strong style="color: red"><?php echo $cargo; ?> </strong>, desde el <strong style="color: red"><?php echo $_POST['f_a'] ?></strong> hasta el <strong style="color: red"><?php echo $_POST['f_b'] ?></strong>. </div>
            <div class="cer6272_cuerpo">Doy fe de su buen desenvolvimiento en las funciones asignadas, emitiendo el presente documento para los fines pertinentes.</div>
            <div class="cer6272_fecha"><strong><?php echo isset($_POST['dpto']) ? $_POST['dpto']."," : ""; ?> <?php echo $_POST['emision'] ?></strong> </div>
        </div>
    </div>
</body>
</html>