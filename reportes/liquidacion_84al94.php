<?php 

require_once('../_db/nomina.php');

if ( isset($_POST['cargo_al']) ) $cargo = $_POST['cargo_al'];
if ( isset($_POST['cargo_bl']) ) $cargo = $_POST['cargo_bl'];

$fechaini = date_create($_POST['f_a']);
$fechafin = date_create($_POST['f_b']);
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
$total_deven = $vacaciones+$gratificaciones+$reintegro+$bonificacion+$bonificacion_extraordinaria;

// var_dump($diferencia);
$meses = $diferencia->format("%m");
$anios = $diferencia->format("%y");
$tiempo = $anios." años y ".$meses." meses";
$anios = $meses > 0 ? $diferencia->format("%y") + 1 : $diferencia->format("%y");

// $sueldo = $_POST['sueldo'];
$sueldos = obtener_sueldo($_POST['fsueldo']);
$sueldo = $sueldos['sueldo_minimo'];

// Deducciones
$adelanto    = isset($_POST['adelanto'])  ? $_POST['adelanto']  : 0;
$retencion   = isset($_POST['retencion']) ? $_POST['retencion'] : 2;
$total_deduc = $adelanto;

// Devengaciones
$vacaciones                  = isset($_POST['vacaciones'])                  ? $_POST['vacaciones']                  : 0;
$gratificaciones             = isset($_POST['gratificaciones'])             ? $_POST['gratificaciones']             : 0;
$reintegro                   = isset($_POST['reintegro'])                   ? $_POST['reintegro']                   : 0;
$incentivo                   = isset($_POST['incentivo'])                   ? $_POST['incentivo']                   : 0;
$bonificacion                = isset($_POST['bonificacion'])                ? $_POST['bonificacion']                : 0;
$bonificacion_graciosa       = isset($_POST['bonificacion_graciosa'])       ? $_POST['bonificacion_graciosa']       : 0;
$bonificacion_extraordinaria = isset($_POST['bonificacion_extraordinaria']) ? $_POST['bonificacion_extraordinaria'] : 0;
$total_deven = $vacaciones+$gratificaciones+$incentivo+$bonificacion+$bonificacion_graciosa;

//Deducciones
$traipss = $sueldo*($sueldos['at_ss']/100);
$trasnp = $sueldo*($sueldos['at_fondo_juvi']/100);
$trafonavi = $sueldo*($sueldos['at_pro_desocup']/100);
// $traquincena = $_POST['quincena_tra'];
// $traadelanto = $_POST['adelanto_tra'];
// $traotrosdeduc = $_POST['otros_deduc_tra'];
$tratotaldeduc = $trasnp+$traipss+$trafonavi;

$empipss = $sueldo*($sueldos['ap_ss']/100);
$empsnp = $sueldo*($sueldos['ap_fondo_juvi']/100);
$empfonavi = $sueldo*($sueldos['ap_fonavi']/100);
// $empquincena = $_POST['quincena_emp'];
// $empadelanto = $_POST['adelanto_emp'];
// $empotrosdeduc = $_POST['otros_deduc_emp'];
$emptotaldeduc = $empsnp+$empipss+$empfonavi;

// $totalsueldo = $anios*$sueldo;

// $totalpago = ($totalsueldo+$total_deven)-$emptotaldeduc;
// $totalpago = $total_deven-$tratotaldeduc;

$totalpago = $anios*$sueldo;

$tretencion = $totalpago*($retencion/100);

$totalapagar = ($totalpago+$total_deven)-($tratotaldeduc+$tretencion);

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
        <div class="liquidacion8494">
            <div class="liq8494_empresa"><?php echo $_POST['empresa'] ?></div>
            <div class="liq8494_fecha"><?php echo isset($_POST['dpto']) ? $_POST['dpto']."," : ""; ?> <?php echo $_POST['fecha_emision'] ?> </div>
            <div class="liq8494_titulo">LIQUIDACION POR TIEMPO DE SERVICIOS</div>
            <div class="liq8494_desglose"><div>nombre </div>                &nbsp;<div class="valores"><strong class="resaltar" ><?php echo $_POST['nombres']." ".$_POST['apellidos'] ?></strong></div></div>
            <div class="liq8494_desglose"><div>fecha de ingreso </div>      &nbsp;<div class="valores"><strong class="resaltar" ><?php echo $_POST['f_a_b'] ?></strong></div></div>
            <div class="liq8494_desglose"><div>fecha de cese </div>         &nbsp;<div class="valores"><strong class="resaltar" ><?php echo $_POST['f_b_b'] ?></strong></div></div>
            <div class="liq8494_desglose"><div>Cargo Ocupado </div>         &nbsp;<div class="valores"><strong class="resaltar" ><?php echo $cargo ?></strong></div></div>
            <div class="liq8494_desglose"><div>tiempo de servicios </div>   &nbsp;<div class="valores"><strong class="resaltar" ><?php echo "$anios años" ?></strong></div></div>
            <div class="liq8494_desglose"><div>Haber Indemnizable    </div> &nbsp;<div class="valores"><strong class="resaltar" ><?php echo "S/.&nbsp;",nf($sueldo) ?></strong></div></div>
            <div class="liq8494_titulo" style="letter-spacing: 1em; margin-bottom: 3em">liquidacion</div>
            <div class="liq8494_calculo" style="margin-bottom: .2em">
                <div class="titulo_b">1. Tiempos de Servicios <strong class="resaltar" ><?php echo $anios ?></strong> X <strong class="resaltar" ><?php echo nf($sueldo) ?></strong></div>
                <div class="titulo_b"><strong class="resaltar" > <?php echo "S/.".nf($totalpago) ?> </strong></div>
            </div>
            <div class="liq8494_calculo_descuento">
                <div class="titulo_b">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong class="resaltar" ><?php echo "Descuento" ?></strong></div>
                <div class="titulo_b"><strong class="resaltar" > <?php echo "S/.0.00" ?></strong></div>
                <div class="titulo_b"><strong class="resaltar" > <?php echo "S/.",nf(0) ?></strong></div>
            </div>

            <? if ($vacaciones) { ?>
            <div class="liq8494_calculo" style="margin-bottom: 0">
                <div class="titulo_b">2. Vacaciones no gozadas (1 sueldo)</div>
                <div class="titulo_b"><strong class="" > <?php echo nf($vacaciones) ?> </strong></div>
            </div>
            <? } ?>
            <? if ($gratificaciones) { ?>
            <div class="liq8494_calculo" style="margin-bottom: 0">
                <div class="titulo_b">3. Gratificaciones</div>
                <div class="titulo_b"><strong class="" > <?php echo nf($gratificaciones) ?> </strong></div>
            </div>
            <? } ?>
            <? if ($reintegro) { ?>
            <div class="liq8494_calculo" style="margin-bottom: 0">
                <div class="titulo_b">4. Reintegro</div>
                <div class="titulo_b"><strong class="" > <?php echo nf($reintegro) ?> </strong></div>
            </div>
            <? } ?>
            <? if ($bonificacion) { ?>
            <div class="liq8494_calculo" style="margin-bottom: 0">
                <div class="titulo_b">5. Bonificación</div>
                <div class="titulo_b"><strong class="" > <?php echo nf($bonificacion) ?> </strong></div>
            </div>
            <? } ?>
            <? if ($bonificacion_extraordinaria) { ?>
            <div class="liq8494_calculo" style="margin-bottom: 0">
                <div class="titulo_b">6. Bonificación Extraordinaria</div>
                <div class="titulo_b"><strong class="" > <?php echo nf($bonificacion_extraordinaria) ?> </strong></div>
            </div>
            <? } ?>
            <? if ($tretencion) { ?>
            <div class="liq8494_calculo" style="margin-bottom: 0">
                <div class="titulo_b resaltar">7. Retención 2%</div>
                <div class="titulo_b"><strong class="resaltar" >( <?php echo nf($tretencion) ?> )</strong></div>
            </div>
            <? } ?><? if ($adelanto) { ?>
            <div class="liq8494_calculo">
                <div class="titulo_b resaltar"><strong class="" >8. Adelanto</strong></div>
                <div class="titulo_b"><strong class="resaltar" >( <?php echo nf($adelanto) ?> )</strong></div>
            </div>
            <? } ?>

            <div class="liq8494_calculo" style="margin-bottom: 0">
                <div class="titulo_b">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ret. Leyes Sociales</div>
            </div>
            <div class="liq8494_calculo_c8494 mayusculas" style="text-decoration: underline;">
                <div>empresa</div>
                <div>&nbsp;</div>
                <div>trabajador</div>
                <div>&nbsp;</div>
                <div>&nbsp;</div>
            </div>
            <div class="liq8494_calculo_c8494 resaltar">
                <div><?php echo nf($empipss); ?>=</div>
                <div>S.S.E.</div>
                <div><?php echo nf($traipss); ?>=</div>
                <div>&nbsp;</div>
                <div>&nbsp;</div>
            </div>
            <div class="liq8494_calculo_c8494 resaltar">
                <div><?php echo nf($empsnp); ?>=</div>
                <div>S.N.P.</div>
                <div><?php echo nf($trasnp); ?>=</div>
                <div>&nbsp;</div>
                <div>&nbsp;</div>
            </div>
            <div class="liq8494_calculo_c8494 resaltar" style="margin-bottom: 4em">
                <div><?php echo nf($empfonavi); ?>=</div>
                <div>FONAVI</div>
                <div><?php echo nf($trafonavi); ?>=</div>
                <div>(<?php echo nf($tratotaldeduc); ?>)</div>
                <div><?php echo nf($totalapagar) ?></div>
            </div>
            <div class="liq8494_calculo_total" style="margin-bottom: 1em">
                <div class="titulo_b mayusculas truncar" >3. Total a Liquidar<?php echo str_pad("",120,".") ?></div>
                <div class="titulo_b" style="text-align: end"><strong> <?php echo nf($totalapagar) ?>= </strong></div>
            </div>
            <div class="liq8494_declaracion">Al firmar la presente liquidación dejo constancia expresa que los señores de <strong class="resaltar" ><?php echo $_POST['empresa'] ?></strong> han cumplido con abonarme todos los beneficios sociales conforme a Ley, por tanto, firmo dando por cancelado mi liquidación.</div>
            <div class="liq8494_firmas">
                <div class="liq8494_firmas_bloques">
                    <div class="liq8494_firmas_bloques_titulo "><strong class="resaltar" ><?php echo $_POST['nombres']." ".$_POST['apellidos'] ?></strong></div>
                </div>
                <div class="liq8494_firmas_bloques">
                    <div class="liq8494_firmas_bloques_titulo ">Gerencia</div>
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