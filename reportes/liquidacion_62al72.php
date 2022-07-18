<?php 

require_once('../_db/nomina.php');

if ( isset($_POST['cargo_al']) ) $cargo = $_POST['cargo_al'];
if ( isset($_POST['cargo_bl']) ) $cargo = $_POST['cargo_bl'];

$fechaini   = date_create($_POST['f_a']);
$fechafin   = date_create($_POST['f_b']);
$diferencia = date_diff($fechafin, $fechaini);

// Deducciones
$adelanto = isset($_POST['adelanto']) ? $_POST['adelanto'] : 0;
// $retencion = isset($_POST['retencion']) ? $_POST['retencion'] : 0;
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
$total_deven = $vacaciones+$gratificaciones+$reintegro+$incentivo+$bonificacion+$bonificacion_graciosa+$bonificacion_extraordinaria;

// var_dump($diferencia);
$meses = $diferencia->format("%m");
$anios = $diferencia->format("%y");
$tiempo = $anios." años y ".$meses." meses";
$anios = $meses > 0 ? $diferencia->format("%y") + 1 : $diferencia->format("%y");

// $sueldo = $_POST['sueldo'];
$sueldos = obtener_sueldo($_POST['fsueldo']);
$sueldo = $sueldos['sueldo_minimo'];
$totalsueldo = $anios*$sueldo;

$retencion = $totalsueldo*($retencion/100);

$totalpago = ($totalsueldo+$total_deven)-($total_deduc)

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
    <div class="pagina_liq" >
        <div class="liquidacion6272">
            <!-- <div class="liq6272_empresa"><?php //echo $diferencia ?></div> -->
            <div class="liq6272_empresa"><?php echo $_POST['empresa'] ?></div>
            <div class="liq6272_titulo">liquidación de beneficios sociales</div>
            <div class="liq6272_desglose"><div>Trabajador </div>            :&nbsp;<div class="valores"><strong class="resaltar" ><?php echo $_POST['nombres']." ".$_POST['apellidos'] ?></strong></div></div>
            <div class="liq6272_desglose"><div>Ingreso </div>               :&nbsp;<div class="valores"><strong class="resaltar" ><?php echo $_POST['f_a'] ?></strong></div></div>
            <div class="liq6272_desglose"><div>Salida </div>                :&nbsp;<div class="valores"><strong class="resaltar" ><?php echo $_POST['f_b'] ?></strong></div></div>
            <div class="liq6272_desglose"><div>Ocupación </div>             :&nbsp;<div class="valores"><strong class="resaltar" ><?php echo $cargo ?></strong></div></div>
            <div class="liq6272_desglose"><div>Tiempo de Servicios </div>   :&nbsp;<div class="valores"><strong class="resaltar" ><?php echo $tiempo ?></strong></div></div>
            <div class="liq6272_desglose"><div>Motivo de Salida </div>      :&nbsp;<div class="valores"><strong>Renuncia Voluntaria</strong></div></div>
            <div class="liq6272_tcalculo">I Cálculo de Tiempo de Servicios</div>
            <div class="liq6272_calculo"><div class="titulo_a" style="margin-right: 5px">Del <strong class="resaltar" ><?php echo $_POST['f_a'] ?></strong> al <strong class="resaltar" ><?php echo $_POST['f_b'] ?></strong> = </div><span class="valores"><strong ><?php echo $tiempo ?></strong></span></div>
            <div class="liq6272_tcalculo">II Cálculo de Sueldo Imdemnisatorio</div>
            <div class="liq6272_calculo"><div class="titulo_a" style="margin-right: 5px">Sueldo Básico </div><div class="titulo_a" style=""> <strong class="resaltar">S/.<?php echo nf($sueldo) ?></strong></div></div>
            <div class="liq6272_tcalculo">III Cálculo de Indemnización por Tiempo de Servicios</div>
            <div class="liq6272_calculo"><div class="titulo_a" style="margin-right: 30px"><strong class="resaltar" ><?php echo $anios," años" ?></strong></div><span class="valores"><strong class="resaltar">S/.<?php echo nf($sueldo)," x ",$anios," = S/.",nf($totalsueldo); ?></strong></span></div>

            <div class="" style="margin-top: 1.5em;" >
                <?php //if ($retencion)                   { echo "<div class='liq6272_ret'><div>IV</div>     <div>Retención:</div>                   <div><strong class='resaltar'>(&nbsp;S/.",nf($retencion)                   ," )</strong></div></div>"; } ?>
                <?php if ($adelanto)                    { echo "<div class='liq6272_ret'><div>IV</div>      <div>Adelanto:</div>                    <div><strong class='resaltar'>(&nbsp;S/.",nf($adelanto)                    ," )</strong></div></div>"; } ?>
                <?php if ($vacaciones)                  { echo "<div class='liq6272_dev'><div>V</div>     <div>Vacaciones:</div>                  <div></div><div><strong class='resaltar'>&nbsp;S/." ,nf($vacaciones)                   ," </strong></div></div>"; } ?>
                <?php if ($gratificaciones)             { echo "<div class='liq6272_dev'><div>VI</div>    <div>Gratificaciones:</div>             <div></div><div><strong class='resaltar'>&nbsp;S/." ,nf($gratificaciones)              ," </strong></div></div>"; } ?>
                <?php if ($reintegro)                   { echo "<div class='liq6272_dev'><div>VII</div>   <div>Reintegro:</div>                   <div></div><div><strong class='resaltar'>&nbsp;S/." ,nf($reintegro)                   ,"  </strong></div></div>"; } ?>
                <?php if ($incentivo)                   { echo "<div class='liq6272_dev'><div>VIII</div>     <div>Incentivo:</div>                   <div></div><div><strong class='resaltar'>&nbsp;S/." ,nf($incentivo)                   ,"  </strong></div></div>"; } ?>
                <?php if ($bonificacion)                { echo "<div class='liq6272_dev'><div>IX</div>      <div>Bonificación:</div>                <div></div><div><strong class='resaltar'>&nbsp;S/." ,nf($bonificacion)                ,"  </strong></div></div>"; } ?>
                <?php if ($bonificacion_graciosa)       { echo "<div class='liq6272_dev'><div>X</div>     <div>Bonificación Graciosa:</div>       <div></div><div><strong class='resaltar'>&nbsp;S/." ,nf($bonificacion_graciosa)       ,"  </strong></div></div>"; } ?>
                <?php if ($bonificacion_extraordinaria) { echo "<div class='liq6272_dev'><div>XI</div>    <div>Bonificación Extraordinaria:</div> <div></div><div><strong class='resaltar'>&nbsp;S/." ,nf($bonificacion_extraordinaria) ,"  </strong></div></div>"; } ?>
            </div>
            <div class="" style="margin-top: 1.5em;border-top: 1px solid black;" >
                <?php if ($total_deduc && $total_deven) { echo "<div class='liq6272_total'><div></div>     <div>Totales:</div>                     <div></div><div><strong class='resaltar'>&nbsp;S/.",nf($total_deven-$total_deduc),"</strong></div></div>"; } ?>
            </div>
            
            <div class="liq6272_numerosletras">SON: <strong class="resaltar"><?php echo convertir(number_format($totalpago,0,"","")) ?> y 00/100 <?php echo "Soles de Oro"; ?></strong></div>
            <div class="liq6272_declaracion">Declaro bajo juramento haber recibido la suma de S/. <span class="resaltar"><?php echo nf($totalpago) ?></span> por el concepto de mi Indemnización por Tiempo de Servicios, la misma que está conforme a Ley, y afirmo no mantener deuda alguna con la Empresa <strong class="resaltar mayusculas"><?php echo $_POST['nombres'] ?>, <?php echo $_POST['apellidos'] ?></strong>  Firmo la presente Liquidación. </div>
            <div class="liq6272_fecha"><?php echo isset($_POST['dpto']) ? $_POST['dpto']."," : ""; ?> <?php echo $_POST['emision'] ?> </div>
            <div class="liq6272_recibiconforme">recibi conforme</div>
            <!-- <div class="liq6272_firma"> Juan Pérez Zúñiga </div> -->
            <div class="liq6272_firma"> <?php echo $_POST['nombres']." ".$_POST['apellidos'] ?> </div>
        </div>
    </div>
</body>
</html>