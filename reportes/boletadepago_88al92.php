<?php 

require_once('../_db/nomina.php');

// echo $_POST['fechaboleta']."-01","<br>","\n";
// echo $_POST['fsueldo'],"<br>","\n";

$fechaBoleta = isset($_POST['fechaboleta']) ? $_POST['fechaboleta']."-01" : '';

if ( isset($_POST['cargo_ab']) ) $cargo = $_POST['cargo_ab'];
if ( isset($_POST['cargo_bb']) ) $cargo = $_POST['cargo_bb'];

// $fechaini = date_create($_POST['f_a']);
// $fechafin = date_create($_POST['f_b']);
$fechafin = date_create($fechaBoleta);
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
$remvaca = isset($_POST['remvacacionales']) ? $_POST['remvacacionales'] : 0;
$reintegro = isset($_POST['reintegro']) ? $_POST['reintegro'] : 0;
$hextras = isset($_POST['hextras']) ? $_POST['hextras'] : 0;
$bonificacion = isset($_POST['bonificacion']) ? $_POST['bonificacion'] : 0;
$otrosdeven = isset($_POST['otros_deven']) ? $_POST['otros_deven'] : 0;
$total_deven = $remvaca+$reintegro+$hextras+$bonificacion+$otrosdeven;

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

// if ( $annio >= 1978 && $annio <= 1980 ) {
//     $tipss = "Seguro Social";
//     $tsnp = "Sist. Nac. Pensión";
//     $tfonavi = "FONAVI";
// }

// if ( $annio >= 1981 && $annio <= 1987 ) {
//     $tipss = "D.L. 22482";
//     $tsnp = "D.L. 19990";
//     $tfonavi = "FONAVI";
// }

// if ( $annio >= 1988 && $annio <= 1992 ) {
//     $tipss = "I.P.S.S.";
//     $tsnp = "Sist. Nac. Pensión";
//     $tfonavi = "FONAVI";
// }

// if ( $annio >= 1993 && $annio <= 2000 ) {
//     $tipss = "Reg. Prest. Salud";
//     $tsnp = "S.N.P";
//     $tfonavi = "FONAVI";
// }


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
        <div class="boleta7880">

            <div class="marco_linea5 mayusculas">
                <div>&nbsp;</div>
                <div>&nbsp;</div>
                <div>&nbsp;</div>
                <div><?php echo $meses[nf($fechafin->format("m"),0)],", ",$fechafin->format("Y") ?>&nbsp;</div>
            </div>
            <div class="marco_titulob">boleta de pago</div>
            <div class="marco_linea4 mayusculas">
                <div>nombres y apellidos&nbsp;</div>
                <div>:&nbsp;<?php echo $_POST['nombres'].", ".$_POST['apellidos'] ?></div>
            </div>
            <div class="marco_linea4 mayusculas">
                <div>fecha de ingreso&nbsp;</div>
                <div>:&nbsp;<?php echo $_POST['f_a'] ?></div>
            </div>
            <div class="marco_linea4 mayusculas">
                <div>concepto de la&nbsp;</div>
                <div>:&nbsp;</div>
            </div>
            <div class="marco_linea4 mayusculas">
                <div>remuneracion&nbsp;</div>
                <div>:&nbsp;</div>
            </div>
            <div class="marco_linea4 mayusculas">
                <div>i.e.&nbsp;</div>
                <div>:&nbsp;</div>
            </div>
            <div class="marco_linea4 mayusculas">
                <div>sueldo&nbsp;</div>
                <div>:&nbsp;<?php echo nf($sueldo) ?></div>
            </div>
            <div class="marco_linea4 mayusculas">
                <div>otros&nbsp;</div>
                <div>:&nbsp;<?php echo nf($total_deven) ?></div>
            </div>
            <div class="mayusculas" style="text-decoration: underline;">Vacaciones</div>
            <div class="marco_linea4 mayusculas">
                <div>salida&nbsp;</div>
                <div>:&nbsp;</div>
            </div>
            <div class="marco_linea4 mayusculas">
                <div>regreso&nbsp;</div>
                <div>:&nbsp;</div>
            </div>
            <div class="marco_linea4 mayusculas">
                <div>fecha de cese&nbsp;</div>
                <div>:&nbsp;<?php echo $_POST['f_b'] ?></div>
            </div>
            <div class="mayusculas" style="text-decoration: underline;">aportaciones del trabajador</div>
            <div class="marco_linea4 mayusculas">
                <div>i.p.s.s&nbsp;</div>
                <div>:&nbsp;<?php echo nf($traipss) ?></div>
            </div>
            <div class="marco_linea4 mayusculas">
                <div>s.n.p.&nbsp;</div>
                <div>:&nbsp;<?php echo nf($trasnp) ?></div>
            </div>
            <div class="marco_linea4 mayusculas">
                <div>fonavi&nbsp;</div>
                <div>:&nbsp;<?php echo nf($trafonavi) ?></div>
            </div>
            <div class="marco_linea4 mayusculas">
                <div>adelanto quincena&nbsp;</div>
                <div>:&nbsp;<?php echo nf(0) ?></div>
            </div>
            <div class="marco_linea4 mayusculas">
                <div>otros descuentos&nbsp;</div>
                <div>:&nbsp;<?php echo nf(0) ?></div>
            </div>
            <div class="marco_linea4 mayusculas">
                <div>total descuentos&nbsp;</div>
                <div>:&nbsp;<?php echo nf($tratotaldeduc) ?></div>
            </div>
            <div class="marco_linea4 mayusculas">
                <div>neto a pagar&nbsp;</div>
                <div>:&nbsp;<?php echo nf($sueldo-$tratotaldeduc) ?></div>
            </div>
            <div class="mayusculas" style="text-decoration: underline;">aportaciones del empleador</div>
            <div class="marco_linea4 mayusculas">
                <div>i.p.s.s.&nbsp;</div>
                <div>:&nbsp;<?php echo nf($empipss) ?></div>
            </div>
            <div class="marco_linea4 mayusculas">
                <div>s.n.p.&nbsp;</div>
                <div>:&nbsp;<?php echo nf($empsnp) ?></div>
            </div>
            <div class="marco_linea4 mayusculas">
                <div>fonavi&nbsp;</div>
                <div>:&nbsp;<?php echo nf($empfonavi) ?></div>
            </div>
            <div class="marco_linea4 mayusculas">
                <div>otros&nbsp;</div>
                <div>:&nbsp;<?php echo nf(0) ?></div>
            </div>
            <div class="marco_linea4 mayusculas">
                <div>total descuentos&nbsp;</div>
                <div>:&nbsp;<?php echo nf($emptotaldeduc) ?></div>
            </div>
            <div class="marco_fecha"><?php echo $_POST['dpto'] ?>, <?php echo $_POST['f_b_b'] ?></div>
            <!-- <div class="marco_fecha mayusculas">lima, 28 de octubre de 1995</div> -->
            
            <div class="marco_firmasb">
                <div class="marco_firmas_titulo mayusculas">empleador:&nbsp;</div>
                <div></div>
                <div class="marco_firmas_titulo mayusculas">trabajador:&nbsp;</div>
                <div></div>
            </div>
        </div>
    </div>
</body>
</html>