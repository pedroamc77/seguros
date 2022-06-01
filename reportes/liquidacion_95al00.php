<?php 

require_once('../_db/nomina.php');

if ( isset($_POST['cargo_al']) ) $cargo = $_POST['cargo_al'];
if ( isset($_POST['cargo_bl']) ) $cargo = $_POST['cargo_bl'];

list($dia,$mes,$anio) = explode(".",$_POST['f_b']);

$fecha_anterior = "";

if ( $dia <= 30 && $mes >= 10 || $mes <= 4 ) {
    $fecha_anterior = date_create(($anio-1)."/10/31");
}
if ( $dia <= 31 && $mes >= 5 && $mes <= 8 ) {
    $fecha_anterior = date_create("$anio/4/30");
}


$fechaini = date_create($_POST['f_a']);
$fechafin = date_create($_POST['f_b']);
$diferencia = date_diff($fechafin, $fechaini);
$diferenciaa = date_diff($fechafin, $fecha_anterior);

$faf = $fecha_anterior->format("d.m.Y");
$fecha_siguiente = date_add($fecha_anterior, date_interval_create_from_date_string("1 days"));
$fsf = $fecha_siguiente->format("d.m.Y");

// Deducciones
$adelanto    = isset($_POST['adelanto'])  ? $_POST['adelanto']  : 0;
// $retencion   = isset($_POST['retencion']) ? $_POST['retencion'] : 2;
$retencion   = 2;
$total_deduc = $adelanto;

// Devengaciones
$vacaciones                  = isset($_POST['vacaciones'])                  ? $_POST['vacaciones']                  : 0;
$gratificaciones             = isset($_POST['gratificaciones'])             ? $_POST['gratificaciones']             : 0;
$reintegro                   = isset($_POST['reintegro'])                   ? $_POST['reintegro']                   : 0;
$incentivo                   = isset($_POST['incentivo'])                   ? $_POST['incentivo']                   : 0;
$bonificacion                = isset($_POST['bonificacion'])                ? $_POST['bonificacion']                : 0;
$bonificacion_graciosa       = isset($_POST['bonificacion_graciosa'])       ? $_POST['bonificacion_graciosa']       : 0;
$bonificacion_extraordinaria = isset($_POST['bonificacion_extraordinaria']) ? $_POST['bonificacion_extraordinaria'] : 0;
$total_deven = $vacaciones+$gratificaciones+$bonificacion;

// var_dump($diferencia);
// var_dump($diferenciaa);
$diasa = $diferenciaa->format("%d");
$mesesa = $diasa > 0 ? $diferenciaa->format("%m") + 1 : $diferenciaa->format("%m");
$dias = $diferencia->format("%d");
$meses = $diferencia->format("%m");
$anios = $diferencia->format("%y");
$tiempo = $anios." años y ".$meses." meses";
$anios = $meses > 0 ? $diferencia->format("%y") + 1 : $diferencia->format("%y");

// $sueldo = $_POST['sueldo'];
// echo $_POST['fsueldo'],"<br>";
$sueldos = obtener_sueldo($_POST['fsueldo']);
$sueldo = $sueldos['sueldo_minimo'];
$totalpago = ($sueldo/12)*$mesesa;

$tretencion = $totalpago*($retencion/100);

$totalapagar = ($totalpago+$total_deven)-($total_deduc+$tretencion);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SisPen - Liquidación</title>
    <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="../css/estilos.min.css" media="all">
    <!-- <link rel="stylesheet" href="../css/impresion.min.css" media="print"> -->
</head>
<body>
<?php
    if ( isset($_POST['nombres']) ) {
?>
    <div class="pagina_liq" >
        <div class="liquidacion9500">
            <div class="liq9500_empresa"><?php echo $_POST['empresa'] ?></div>
            <div class="liq9500_titulo">LIQUIDACION DE BENEFICIOS SOCIALES</div>
            <div class="liq9500_desglose"><div>nombres </div>               &nbsp;<div class="valores"><strong class="resaltar" ><?php echo $_POST['nombres']." ".$_POST['apellidos'] ?></strong></div></div>
            <div class="liq9500_desglose"><div>Cargo desempeñado </div>     &nbsp;<div class="valores"><strong class="resaltar" ><?php echo $cargo ?></strong></div></div>
            <div class="liq9500_desglose"><div>fecha de ingreso </div>      &nbsp;<div class="valores"><strong class="resaltar" ><?php echo $_POST['f_a_b'] ?></strong></div></div>
            <div class="liq9500_desglose"><div>fecha de cese </div>         &nbsp;<div class="valores"><strong class="resaltar" ><?php echo $_POST['f_b_b'] ?></strong></div></div>
            <div class="liq9500_desglose"><div>tiempo de servicios </div>   &nbsp;<div class="valores"><strong class="resaltar" ><?php echo $tiempo ?></strong></div></div>
            <div class="liq9500_desglose"><div>motivo de cese </div>        &nbsp;<div class="valores"><strong>renuncia voluntaria</strong></div></div>
            <div class="liq9500_desglose"><div>remuneración básica </div>   &nbsp;<div class="valores"><strong ><?php echo "S/.&nbsp;",nf($sueldo) ?></strong></div></div>
            <div class="liq9500_desglose" style="border-bottom: solid 2px black;"><div>pago total </div>&nbsp;<div class="valores"><strong ><?php echo "S/.&nbsp;",nf($totalapagar) ?></strong></div></div>
            <div class="liq9500_titulo" style="letter-spacing: .2em; margin-bottom: 3em">cálculo de la compensación</div>
            <div class="liq9500_calculo">
                <div class="titulo_b"><strong><?php echo $fechaini->format("d.m.Y")." AL $faf" ?></strong></div>
                &nbsp;=&nbsp;
                <div class="titulo_c"><strong> <?php echo "CTS DEPOSITADO EN BANCO" ?> </strong></div>
            </div>
            <div class="liq9500_calculo">
                <div class="titulo_b"><strong><?php echo "$fsf AL ".$fechafin->format("d.m.Y") ?></strong></strong></div>
                &nbsp;=&nbsp;
                <div class="titulo_c"><strong> <?php echo "$mesesa MES" ?> </strong></div>
            </div>
            <div class="liq9500_calculo">
                <div class="titulo_b"><strong><?php echo "REM. COMPEMSABLE: S/.".nf($sueldo)."/12x$mesesa" ?></strong></div>
                &nbsp;=&nbsp;
                <div class="titulo_c"><strong> <?php echo "S/.".nf($totalpago) ?> </strong></div>
            </div>

            
            <? if ($adelanto) { ?>
            <div class="liq9500_calculo">
                <div class="titulo_b"><strong><?php echo "ADELANTO" ?></strong></div>
                &nbsp;=&nbsp;
                <div class="titulo_c"><strong>( <?php echo "S/.".nf($adelanto) ?> )</strong></div>
            </div>
            <? } ?>
            <? if ($retencion) { ?>
            <div class="liq9500_calculo">
                <div class="titulo_b"><strong><?php echo "RETENCIÓN $retencion%" ?></strong></div>
                &nbsp;=&nbsp;
                <div class="titulo_c"><strong>( <?php echo "S/.".nf($tretencion) ?> )</strong></div>
            </div>
            <? } ?>
            <? if ($vacaciones) { ?>
            <div class="liq9500_calculo">
                <div class="titulo_b"><strong><?php echo "VACACIONES" ?></strong></div>
                &nbsp;=&nbsp;
                <div class="titulo_c"><strong> <?php echo "S/.".nf($vacaciones) ?> </strong></div>
            </div>
            <? } ?>
            <? if ($gratificaciones) { ?>
            <div class="liq9500_calculo">
                <div class="titulo_b"><strong><?php echo "GRATIFICACIÓN" ?></strong></div>
                &nbsp;=&nbsp;
                <div class="titulo_c"><strong> <?php echo "S/.".nf($gratificaciones) ?> </strong></div>
            </div>
            <? } ?>
            <? if ($bonificacion) { ?>
            <div class="liq9500_calculo">
                <div class="titulo_b"><strong><?php echo "BONIFICACIÓN" ?></strong></div>
                &nbsp;=&nbsp;
                <div class="titulo_c"><strong> <?php echo "S/.".nf($bonificacion) ?> </strong></div>
            </div>
            <? } ?>

            <div class="liq9500_declaracion">Al firmar la presente liquidación dejo constancia expresa que los señores de <strong class="resaltar" ><?php echo $_POST['empresa'] ?></strong> han cumplido con abonarme todos los beneficios sociales conforme a Ley, por tanto, firmo dando por cancelado mi liquidación.</div>
            <div class="liq9500_fecha"><?php echo isset($_POST['dpto']) ? $_POST['dpto']."," : ""; ?> <?php echo $_POST['fecha_emision'] ?> </div>
            <div class="liq9500_firma"> <?php echo $_POST['nombres']." ".$_POST['apellidos'] ?> </div>
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