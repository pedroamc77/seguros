<?php 

require_once('../_db/nomina.php');

// echo $_POST['fechaboleta']."-01","<br>","\n";
// echo $_POST['fsueldo'],"<br>","\n";

$fechaBoleta = isset($_POST['fechaboleta']) ? $_POST['fechaboleta']."-01" : '';

if ( isset($_POST['cargo_ab']) ) $cargo = $_POST['cargo_ab'];
if ( isset($_POST['cargo_bb']) ) $cargo = $_POST['cargo_bb'];

// $fechaini = date_create($_POST['f_a']);
// $fechafin = date_create($_POST['f_b']);
// $diferencia = date_diff($fechafin, $fechaini);

// // var_dump($diferencia);
// $meses = $diferencia->format("%m");
// $anios = $diferencia->format("%y");
// $tiempo = $anios." años y ".$meses." meses";
// $anios = $meses > 0 ? $diferencia->format("%y") + 1 : $diferencia->format("%y");

// $sueldo = $_POST['sueldo'];
// $sueldos = obtener_sueldo($_POST['fsueldo']);
$sueldos = obtener_sueldo($fechaBoleta);
$sueldo = $sueldos['sueldo_minimo'];

// Devengaciones
$remvaca = $_POST['remvacacionales'];
$reintegro = $_POST['reintegro'];
$hextras = $_POST['hextras'];
$bonificacion = $_POST['bonificacion'];
$otrosdeven = $_POST['otros_deven'];
$total_deven = $sueldo+$remvaca+$reintegro+$hextras+$bonificacion+$otrosdeven;

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
$totalpago = $total_deven-$tratotaldeduc;

$annio = substr($fechaBoleta,0,4);
$tsnp = "No compatible";
$tipss = "No compatible";
$tfonavi = "No compatible";

if ( $annio >= 1978 && $annio <= 1980 ) {
    $tipss = "Seguro Social";
    $tsnp = "Sist. Nac. Pensión";
    $tfonavi = "FONAVI";
}

if ( $annio >= 1981 && $annio <= 1987 ) {
    $tipss = "D.L. 22482";
    $tsnp = "D.L. 19990";
    $tfonavi = "FONAVI";
}

if ( $annio >= 1988 && $annio <= 1992 ) {
    $tipss = "I.P.S.S.";
    $tsnp = "Sist. Nac. Pensión";
    $tfonavi = "FONAVI";
}

if ( $annio >= 1993 && $annio <= 2000 ) {
    $tipss = "Reg. Prest. Salud";
    $tsnp = "S.N.P";
    $tfonavi = "FONAVI";
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boleta de Pago</title>
    <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="../css/estilos.min.css" media="all">
    <!-- <link rel="stylesheet" href="../css/impresion.min.css" media="print"> -->
</head>
<body>
    <div class="pagina_bol" >
        <div class="boleta">
            <div class="boleta_empresa">
                <div class=""><strong class="mayusculas"  >razón social</strong></div>
                <div class=""><strong class="" > <?php echo $_POST['empresa'] ?> </strong></div>
            </div>
            <!-- <div class="boleta_empresa"><?php //echo $_POST['empresa'] ?></div> -->
            <div class="boleta_fecha"><strong><?php echo $_POST['dpto'] ?>, <?php echo $_POST['emision'] ?></strong> </div>
            <div class="boleta_titulo"><strong>Boleta de Pago</strong></div>
            <div class="boleta_desglose"><div>nombres y apellidos </div>&nbsp;<div class="valores"><strong class="" ><?php echo $_POST['nombres']." ".$_POST['apellidos'] ?></strong></div></div>
            <div class="boleta_desglose"><div>Cargo </div>              &nbsp;<div class="valores"><strong class="" ><?php echo $cargo ?></strong></div></div>
            <div class="boleta_desglose" style="margin-bottom: 2em;"><div>f/ingreso </div>          &nbsp;<div class="valores"><strong class="" ><?php echo $_POST['f_a'] ?></strong></div></div>
            <div class="boleta_calculo"><div>Sueldo</div>           &nbsp;<div class=""><strong class="" ><?php echo number_format($sueldo,2,".",",") ?></strong></div><div></div></div>
            <div class="boleta_calculo"><div>rem. vacacional</div>  &nbsp;<div class=""><strong class="" ><?php echo number_format($remvaca,2,".",",") ?></strong></div><div></div></div>
            <div class="boleta_calculo"><div>reintegro</div>        &nbsp;<div class=""><strong class="" ><?php echo number_format($reintegro,2,".",",") ?></strong></div><div></div></div>
            <div class="boleta_calculo"><div>h. extras</div>        &nbsp;<div class=""><strong class="" ><?php echo number_format($hextras,2,".",",") ?></strong></div><div></div></div>
            <div class="boleta_calculo"><div>bonificación</div>     &nbsp;<div class=""><strong class="" ><?php echo number_format($bonificacion,2,".",",") ?></strong></div><div></div></div>
            <div class="boleta_calculo"><div>otros</div>            &nbsp;<div class="" style="border-bottom: 2px solid black"><strong class=""><?php echo number_format($otrosdeven,2,".",",") ?></strong></div><div></div></div>
            <div class="boleta_calculo" style="margin-bottom: 2em;"><div>total</div>            &nbsp;<div class=""><strong class="" ><?php echo number_format($total_deven,2,".",",") ?></strong></div><div></div></div>
            <div class="boleta_calculo" style="margin-bottom: 2em;"><div></div>     &nbsp;<div class=""><strong class="" >trabajador</strong></div><div style="text-align: center;">empleador</div></div>
            <div class="boleta_calculo"><div><?php echo $tipss ?></div>             &nbsp;<div class=""><strong class="" ><?php echo number_format($traipss,2,".",",") ?>       </strong></div><div><?php echo number_format($empipss,2,".",",") ?></div></div>
            <div class="boleta_calculo"><div><?php echo $tsnp ?></div>              &nbsp;<div class=""><strong class="" ><?php echo number_format($trasnp,2,".",",") ?>        </strong></div><div><?php echo number_format($empsnp,2,".",",") ?></div></div>
            <div class="boleta_calculo"><div><?php echo $tfonavi ?></div>           &nbsp;<div class=""><strong class="" ><?php echo number_format($trafonavi,2,".",",") ?>     </strong></div><div><?php echo number_format($empfonavi,2,".",",") ?></div></div>
            <div class="boleta_calculo"><div>quincena</div>         &nbsp;<div class=""><strong class="" ><?php // echo number_format($traquincena,2,".",",") ?>   </strong></div><div><?php // echo number_format($empquincena,2,".",",") ?></div></div>
            <div class="boleta_calculo"><div>adelanto</div>         &nbsp;<div class=""><strong class="" ><?php // echo number_format($traadelanto,2,".",",") ?>   </strong></div><div><?php // echo number_format($empadelanto,2,".",",") ?></div></div>
            <div class="boleta_calculo"><div>otros</div>            &nbsp;<div class="" style="border-bottom: 2px solid black"><strong class="" ><?php //echo number_format($traotrosdeduc,2,".",",") ?>&nbsp;</strong></div>   <div style="border-bottom: 2px solid black"><?php //echo number_format($empotrosdeduc,2,".",",") ?>&nbsp;</div></div>
            <div class="boleta_calculo" style="margin-bottom: 2em;"><div>total</div>            &nbsp;<div class=""><strong class="" ><?php echo number_format($tratotaldeduc,2,".",",") ?></strong></div>              <div><?php echo number_format($emptotaldeduc,2,".",",") ?></div></div>
            <div class="boleta_calculo"><div>Neto a pagar</div>         &nbsp;<div class=""><strong><?php echo number_format($totalpago,2,".",",") ?></strong></div><div></div></div>
            <div class="boleta_firmas" style="margin-bottom: 2em; font-weight: bolder;">
                <div class="boleta_firmas_bloques">
                    <div class="boleta_firmas_bloques_titulo mayusculas">Empleador</div>
                </div>
                <div class="boleta_firmas_bloques">
                    <div class="boleta_firmas_bloques_titulo mayusculas"><strong class="" > Don(<span style="text-transform: lowercase">ña</span>) <?php echo $_POST['nombres']." ".$_POST['apellidos'] ?></strong></div>
                </div>
            </div>
            <div class="boleta_calculo" style="margin-top: 4em; font-weight: bolder;"><div>adelanto</div><div class=""><strong style="text-align: start !important;" ><?php echo $_POST['emision'] ?></strong></div><div></div></div>
        </div>
    </div>
</body>
</html>