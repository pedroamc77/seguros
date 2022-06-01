<?php 

require_once('../_db/nomina.php');

if ( isset($_POST['cargo_al']) ) $cargo = $_POST['cargo_al'];
if ( isset($_POST['cargo_bl']) ) $cargo = $_POST['cargo_bl'];

$fechaini   = date_create($_POST['f_a']);
$fechafin   = date_create($_POST['f_b']);
$diferencia = date_diff($fechafin, $fechaini);

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
$total_deven = $vacaciones+$gratificaciones+$incentivo+$bonificacion_graciosa;

// var_dump($diferencia);
$meses = $diferencia->format("%m");
$anios = $diferencia->format("%y");
$tiempo = $anios." años y ".$meses." meses";
$anios = $meses > 0 ? $diferencia->format("%y") + 1 : $diferencia->format("%y");

// $sueldo = $_POST['sueldo'];
$sueldos = obtener_sueldo($_POST['fsueldo']);
$sueldo = $sueldos['sueldo_minimo'];

// $mc = $sueldo+$incentivo;

$totalpago = $sueldo*$anios;

$tretencion = $totalpago*($retencion/100);

$totalapagar = ($totalpago+$total_deven)-$tretencion;

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
    if ( isset( $_POST['nombres']) ) {
?>
    <div class="pagina_liq" >
        <div class="liquidacion7683">
            <div class="liq7683_empresa"><?php echo $_POST['empresa'] ?></div>
            <div class="liq7683_titulo">liquidación de beneficios sociales</div>
            <div class="liq7683_desglose"><div>nombre </div>                :&nbsp;<div class="valores"><strong class="resaltar" ><?php echo $_POST['nombres']." ".$_POST['apellidos'] ?></strong></div></div>
            <div class="liq7683_desglose"><div>fecha de ingreso </div>      :&nbsp;<div class="valores"><strong class="resaltar" ><?php echo $_POST['f_a'] ?></strong></div></div>
            <div class="liq7683_desglose"><div>fecha de retiro </div>       :&nbsp;<div class="valores"><strong class="resaltar" ><?php echo $_POST['f_b'] ?></strong></div></div>
            <div class="liq7683_desglose"><div>puesto laborado </div>       :&nbsp;<div class="valores"><strong class="resaltar" ><?php echo $cargo ?></strong></div></div>
            <div class="liq7683_desglose"><div>Motivo de cese </div>        :&nbsp;<div class="valores"><strong>Renuncia Voluntaria</strong></div></div>
            <div class="liq7683_desglose"><div>sueldo básico </div>         :&nbsp;<div class="valores"><strong class="resaltar" ><?php echo "S/.".nf($sueldo) ?></strong></div></div>
            <!-- <div class="liq7683_desglose"><div>incentivo </div>             :&nbsp;<div class="valores"><strong class="resaltar" ><?php //echo "S/.",nf($incentivo) ?></strong></div></div> -->
            <div class="liq7683_desglose"><div>monto computable </div>      :&nbsp;<div class="valores"><strong class="resaltar" ><?php echo "S/.",nf($totalpago) ?></strong></div></div>
            <div class="liq7683_desglose"><div>tiempo de servicios </div>   :&nbsp;<div class="valores"><strong class="resaltar" ><?php echo $tiempo ?></strong></div></div>
            <div class="liq7683_desglose" style="border-bottom: solid 2px black;"><div>a pagar </div>:&nbsp;<div class="valores"><strong class="resaltar" ><?php echo "S/.",nf($totalpago) ?></strong></div></div>
            <div class="liq7683_titulo">resumen de cálculo</div>
            <div class="liq7683_calculo">
                <div class="titulo_b"><strong class="resaltar" ><?php echo $anios," años" ?></strong> X <strong class="resaltar" ><?php echo "S/.",nf($sueldo) ?></strong></div>
                <div class="titulo_b"><strong class="resaltar" > <?php echo "S/.",nf($totalpago) ?> </strong></div>
            </div>



            <? if ($adelanto) { ?>
            <div class="liq7683_calculo">
                <div class="titulo_b"><strong class="" >Adelanto</strong></div>
                <div class="titulo_b"><strong class="resaltar" > <?php echo "S/.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",nf($adelanto) ?> </strong></div>
            </div>
            <? } ?>
            <? if ($vacaciones) { ?>
            <div class="liq7683_calculo">
                <div class="titulo_b"><strong class="" >Vacaciones</strong></div>
                <div class="titulo_b"><strong class="resaltar" > <?php echo "S/.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",nf($vacaciones) ?> </strong></div>
            </div>
            <? } ?>
            <? if ($gratificaciones) { ?>
            <div class="liq7683_calculo">
                <div class="titulo_b"><strong class="" >Gratificaciones</strong></div>
                <div class="titulo_b"><strong class="resaltar" > <?php echo "S/.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",nf($gratificaciones) ?> </strong></div>
            </div>
            <? } ?>
            <? if ($incentivo) { ?>
            <div class="liq7683_calculo">
                <div class="titulo_b"><strong class="" >Incentivo</strong></div>
                <div class="titulo_b"><strong class="resaltar" > <?php echo "S/.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",nf($incentivo) ?> </strong></div>
            </div>
            <? } ?>
            <? if ($bonificacion_graciosa) { ?>
            <div class="liq7683_calculo">
                <div class="titulo_b"><strong class="" >Bonificación Graciosa</strong></div>
                <div class="titulo_b"><strong class="resaltar" > <?php echo "S/.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",nf($bonificacion_graciosa) ?> </strong></div>
            </div>
            <? } ?>
            <? if ($tretencion) { ?>
            <div class="liq7683_calculo">
                <!-- <div class="titulo_b"><strong class="resaltar" ><?php //echo "Retención $retencion%" ?></strong></div> -->
                <div class="titulo_b"><strong class="resaltar" ><?php echo "Retención 2%" ?></strong></div>
                <div class="titulo_b"><strong class="resaltar" > (<?php echo "S/.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",nf($tretencion) ?>) </strong></div>
            </div>
            <? } ?>

            <div class="liq7683_calculo">
                <div class="titulo_b"><strong class="mayusculas" ><?php echo "liquidacion a apagar" ?></strong></div>
                <div class="titulo_b"> <strong class="resaltar" > <?php echo "S/.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",nf($totalapagar) ?> </strong></div>
            </div>
            <div class="liq7683_declaracion mayusculas" style="border-bottom: solid 2px black;">RECIBO DE LA EMPRESA <strong class="resaltar" ><?php echo $_POST['empresa'] ?></strong> la suma de <strong class="resaltar" > <?php echo "S/.",nf($totalapagar) ?></strong>, POR EL CONCEPTO DE MI TIEMPO DE SERVICIOS PRESTADOS EN ESTA EMPRESA.</div>
            <div class="liq7683_fecha"><?php echo isset($_POST['dpto']) ? $_POST['dpto']."," : ""; ?> <?php echo $_POST['emision'] ?> </div>
            <div class="liq7683_firmas">
                <div class="liq7683_firmas_bloques">
                    <div class="liq7683_firmas_bloques_titulo mayusculas">trabajador</div>
                </div>
                <div class="liq7683_firmas_bloques">
                    <div class="liq7683_firmas_bloques_titulo mayusculas">empresa</div>
                </div>
            </div>
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