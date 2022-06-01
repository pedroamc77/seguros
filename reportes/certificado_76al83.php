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
        <div class="certificado7683">
            <div class="cer7683_empresa"><?php echo $_POST['empresa'] ?></div>
            <div class="cer7683_titulo"><strong>Certificado </strong></div>
            <div class="cer7683_cuerpo">SE CERTIFICA A <strong class="subrayar" style="color: red"><?php echo $_POST['nombres']." ".$_POST['apellidos'] ?></strong>, por haber trabajado para esta empresa, durante el paríodo <strong style="color: red"><?php echo $_POST['f_a'] ?></strong> al <strong style="color: red"><?php echo $_POST['f_b'] ?></strong>, como <strong style="color: red"><?php echo $cargo ?></strong>. </div>
            <div class="cer7683_cuerpo">EL PRESENTE CERTIFICADO SE EXPIDE A SOLICITUD DEL INTERESADO PARA LOS FINES QUE ESTIME CONVENIENTE.</div>
            <div class="cer7683_fecha"><strong><?php echo isset($_POST['dpto']) ? $_POST['dpto']."," : ""; ?> <?php echo $_POST['emision'] ?></strong> </div>
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