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
        <div class="certificado9500">
            <div class="cer9500_empresa resaltar"><?php echo $_POST['empresa'] ?></div>
            <div class="cer9500_titulo"><strong>Constancia de Trabjao </strong></div>
            <div class="cer9500_cuerpo">SE DEJA CONSTANCIA QUE EL SEÑOR(A) <strong class="resaltar"><?php echo $_POST['nombres']." ".$_POST['apellidos'] ?></strong>, HA LABORADO PARA NUESTRA EMPRESA COMO <strong style="color: red"><?php echo $cargo ?></strong> A PARTIR DEL <strong class="resaltar"><?php echo $_POST['f_a_b'] ?></strong> AL <strong style="color: red"><?php echo $_POST['f_b_b'] ?></strong>. </div>
            <div class="cer9500_cuerpo">DURANTE SU TIEMPO DE SERVICIOS EL MENCIONADO SEÑOR, DEMOSTRO EN TODO MOMENTO UN ALTO GRADO DE RESPONSABILIDAD EN LAS TAREAS ENCOMENDADAS POR LA EMPRESA.</div>
            <div class="cer9500_cuerpo">A SOLICITUD DEL INTERESADO, SE EXTIENDE LA CONSTANCIA PARA EL USO QUE EL, LE PUEDA DAR.</div>
            <div class="cer9500_fecha"><strong><?php echo isset($_POST['dpto']) ? $_POST['dpto']."," : ""; ?> <?php echo $_POST['emision'] ?></strong> </div>
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