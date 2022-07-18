<?php 

require_once('../_db/nomina.php');

if ( isset($_POST['cargo_al']) ) $cargo = $_POST['cargo_al'];
if ( isset($_POST['cargo_bl']) ) $cargo = $_POST['cargo_bl'];

$fechaini = date_create($_POST['f_a']);
$fechafin = date_create($_POST['f_b']);
$diferencia = date_diff($fechafin, $fechaini);

// Deducciones
$adelanto = isset($_POST['adelanto']) ? $_POST['adelanto'] : 0;
// $retencion = isset($_POST['retencion']) ? $_POST['retencion'] : 0;
$retencion = 2;
$total_deduc = $adelanto;

// Devengaciones
$vacaciones = isset($_POST['vacaciones']) ? $_POST['vacaciones'] : 0;
$gratificaciones = isset($_POST['gratificaciones']) ? $_POST['gratificaciones'] : 0;
$reintegro = isset($_POST['reintegro']) ? $_POST['reintegro'] : 0;
$incentivo = isset($_POST['incentivo']) ? $_POST['incentivo'] : 0;
$bonificacion = isset($_POST['bonificacion']) ? $_POST['bonificacion'] : 0;
$bonificacion_graciosa = isset($_POST['bonificacion_graciosa']) ? $_POST['bonificacion_graciosa'] : 0;
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
$totalpago = $anios*$sueldo;
$retencion = $totalpago*($retencion/100);

$totalliquidacion = ($totalpago+$total_deven)-($total_deduc);

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
        <div class="liquidacion7375">
            <div class="liq7375_empresa"><?php echo $_POST['empresa'] ?></div>
            <div class="liq7375_titulo">liquidación de beneficios sociales</div>
            <div class="liq7375_desglose"><div>nombres y apellidos                </div>   &nbsp;<div class="valores"><strong class="resaltar" ><?php echo $_POST['nombres']." ".$_POST['apellidos'] ?></strong></div></div>
            <div class="liq7375_desglose"><div>fecha de ingreso                   </div>   &nbsp;<div class="valores"><strong class="resaltar" ><?php echo $_POST['f_a'] ?>                            </strong></div></div>
            <div class="liq7375_desglose"><div>fecha de cese                      </div>   &nbsp;<div class="valores"><strong class="resaltar" ><?php echo $_POST['f_b'] ?>                            </strong></div></div>
            <div class="liq7375_desglose"><div>Tiempo de Servicios                </div>   &nbsp;<div class="valores"><strong class="resaltar" ><?php echo $tiempo ?>                                  </strong></div></div>
            <div class="liq7375_desglose"><div>Cargo                              </div>   &nbsp;<div class="valores"><strong class="resaltar" ><?php echo $cargo ?>                                   </strong></div></div>
            <div class="liq7375_desglose"><div>Motivo de Renuncia                 </div>   &nbsp;<div class="valores"><strong class="resaltar" >Voluntaria                                             </strong></div></div>
            <div class="liq7375_desglose" style="border-bottom: solid 2px black;"><div>Total a Cancelar </div>      &nbsp;<div class="valores"><strong class="resaltar" ><?php echo "S/".nf($totalliquidacion) ?></strong></div></div>
            <div class="liq7375_tcalculo">CÁLCULO POR INDEMNIZACION POR TIEMPO DE SERVICIOS</div>

            <div class="liq7375_calculo">
                <div class="titulo_b"><strong class="resaltar" ><?php echo "$anios años" ?></strong> X <strong class="resaltar" ><?php echo "S/.".nf($sueldo) ?></strong></div>
                &nbsp;=&nbsp;
                <div class="titulo_c"><strong class="resaltar" > <?php echo "S/.".nf($totalpago) ?> </strong></div>
            </div>

            <div class="" style="margin-top: 1.5em;" >
                <?php //if ($retencion)                   { echo "<div class='liq6272_ret'><div>IV</div>     <div>Retención:</div>                   <div><strong class='resaltar'>(&nbsp;S/.",nf($retencion)                   ," )</strong></div></div>"; } ?>
                <?php if ($adelanto)                    { echo "<div class='liq6272_ret'><div></div>      <div>Adelanto:</div>                    <div><strong class='resaltar'>(&nbsp;S/.",nf($adelanto)                    ," )</strong></div></div>"; } ?>
                <?php if ($vacaciones)                  { echo "<div class='liq6272_dev'><div></div>     <div>Vacaciones:</div>                  <div></div><div><strong class='resaltar'>&nbsp;S/." ,nf($vacaciones)                   ," </strong></div></div>"; } ?>
                <?php if ($gratificaciones)             { echo "<div class='liq6272_dev'><div></div>    <div>Gratificaciones:</div>             <div></div><div><strong class='resaltar'>&nbsp;S/." ,nf($gratificaciones)              ," </strong></div></div>"; } ?>
                <?php if ($reintegro)                   { echo "<div class='liq6272_dev'><div></div>   <div>Reintegro:</div>                   <div></div><div><strong class='resaltar'>&nbsp;S/." ,nf($reintegro)                   ,"  </strong></div></div>"; } ?>
                <?php if ($incentivo)                   { echo "<div class='liq6272_dev'><div></div>     <div>Incentivo:</div>                   <div></div><div><strong class='resaltar'>&nbsp;S/." ,nf($incentivo)                   ,"  </strong></div></div>"; } ?>
                <?php if ($bonificacion)                { echo "<div class='liq6272_dev'><div></div>      <div>Bonificación:</div>                <div></div><div><strong class='resaltar'>&nbsp;S/." ,nf($bonificacion)                ,"  </strong></div></div>"; } ?>
                <?php if ($bonificacion_graciosa)       { echo "<div class='liq6272_dev'><div></div>     <div>Bonificación Graciosa:</div>       <div></div><div><strong class='resaltar'>&nbsp;S/." ,nf($bonificacion_graciosa)       ,"  </strong></div></div>"; } ?>
                <?php if ($bonificacion_extraordinaria) { echo "<div class='liq6272_dev'><div></div>    <div>Bonificación Extraordinaria:</div> <div></div><div><strong class='resaltar'>&nbsp;S/." ,nf($bonificacion_extraordinaria) ,"  </strong></div></div>"; } ?>
            </div>
            <div class="" style="margin-top: 1.5em;border-top: 1px solid black;" >
                <?php if ($total_deduc && $total_deven) { echo "<div class='liq6272_total'><div></div>     <div>Total:</div>                       <div></div><div><strong class='resaltar'>&nbsp;S/.",nf($total_deven-$total_deduc),"</strong></div></div>"; } ?>
            </div>

            <div class="liq7375_calculo" style="margin-top: 1em;">
                <div class="titulo_b">Total: <strong class="resaltar" > <?php echo "S/.".nf($totalpago) ?> </strong> + <strong class="resaltar" ><?php echo "S/.".nf($total_deven-$total_deduc) ?></strong></div>
                &nbsp;=&nbsp;
                <div class="titulo_c"><strong class="resaltar" > <?php echo "S/.".nf($totalliquidacion) ?> </strong></div>
            </div>

            <div class="liq7375_declaracion">HE RECIBIDO DE LA EMPRESA  <strong class="resaltar mayusculas"><?php echo $_POST['empresa'] ?></strong>  LA SUMA DE <strong class="resaltar mayusculas"><?php echo convertir($totalliquidacion)."  Y 00/100 SOLES ORO" ?></strong>, POR EL CONCEPTO DE MI INDEMNIZACION POR MI TIEMPO DE SERVICIOS PRESTADOS EN ESTA EMPRESA, FIRMANDO EL PRESENTE DOCUMENTO, EN SEÑAL DE MI CONFORMIDAD. </div>
            <div class="liq7375_fecha"><?php echo isset($_POST['dpto']) ? $_POST['dpto']."," : ""; ?> <?php echo $_POST['fecha_emision'] ?> </div>
            <div class="liq7375_firmas">
                <div class="liq7375_firmas_bloques">
                    <div class="liq7375_firmas_bloques_titulo mayusculas">Empleador</div>
                </div>
                <div class="liq7375_firmas_bloques">
                    <div class="liq7375_firmas_bloques_titulo mayusculas"><strong class="resaltar" > Don(<span style="text-transform: lowercase">ña</span>) <?php echo $_POST['nombres']." ".$_POST['apellidos'] ?></strong></div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>