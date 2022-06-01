<?php 

require_once('../_db/nomina.php');

// echo $_POST['fechaboleta']."-01","<br>","\n";
// echo $_POST['fsueldo'],"<br>","\n";

$fechaBoleta = isset($_POST['fechaboleta']) ? str_replace("-","/",$_POST['fechaboleta']) : '';

if ( isset($_POST['cargo_ab']) ) $cargo = $_POST['cargo_ab'];
if ( isset($_POST['cargo_bb']) ) $cargo = $_POST['cargo_bb'];

// $fechaini = date_create($_POST['f_a']);
// $fechafin = date_create($_POST['f_b']);
// $diferencia = date_diff($fechafin, $fechaini);
$fechaini = date_create($_POST['f_a']);
$fechafin = date_create($fechaBoleta);
$diferencia = date_diff($fechafin, $fechaini);

// var_dump($diferencia);
// exit;

// // var_dump($diferencia);
$mesesd = $diferencia->format("%m");
$aniosd = $diferencia->format("%y");
$diasd = $diferencia->days;
// echo $diasd,"<br>";
$tiempo = $aniosd." años y ".$mesesd." meses";
$anios = $meses > 0 ? $diferencia->format("%y") + 1 : $diferencia->format("%y");

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
$total_deven = $sueldo+$remvaca+$reintegro+$hextras+$bonificacion+$otrosdeven;

//Deducciones
$traipss = $sueldo*(3/100);
$trasnp = $sueldo*(3/100);
$trafonavi = $sueldo*(3/100);
// $traipss = $sueldo*($sueldos['at_ss']/100);
// $trasnp = $sueldo*($sueldos['at_fondo_juvi']/100);
// $trafonavi = $sueldo*($sueldos['at_pro_desocup']/100);
// $traquincena = $_POST['quincena_tra'];
// $traadelanto = $_POST['adelanto_tra'];
// $traotrosdeduc = $_POST['otros_deduc_tra'];
$tratotaldeduc = $trasnp+$traipss+$trafonavi;

$empipss = $sueldo*(3/100);
$empsnp = $sueldo*(3/100);
$empfonavi = $sueldo*(3/100);
// $empipss = $sueldo*($sueldos['ap_ss']/100);
// $empsnp = $sueldo*($sueldos['ap_fondo_juvi']/100);
// $empfonavi = $sueldo*($sueldos['ap_fonavi']/100);
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
            <div class="marco_cubre">
                <div class="marco_linea5 mayusculas">
                    <div>&nbsp;</div>
                    <div>&nbsp;</div>
                    <div>boleta de pago&nbsp;</div>
                    <div>&nbsp;</div>
                </div>
                <div class="marco_linea5 mayusculas">
                    <div>fecha de ingreso:&nbsp;</div>
                    <div>&nbsp;<?php echo $_POST['f_a'] ?></div>
                    <div>mes:&nbsp;<?php echo $meses[nf($fechafin->format("m"),0)] ?></div>
                    <div>&nbsp;</div>
                </div>
                <div class="marco_linea5 mayusculas">
                    <div>nombre:&nbsp;</div>
                    <div>&nbsp;<?php echo $_POST['nombres'].", ",$_POST['apellidos'] ?></div>
                    <div>año:&nbsp;<?php echo $fechafin->format("Y") ?></div>
                    <div>&nbsp;</div>
                </div>
                <div class="marco_linea5 mayusculas">
                    <div>&nbsp;</div>
                    <div>&nbsp;</div>
                    <div>ocupación:&nbsp;</div>
                    <div>&nbsp;<?php echo $cargo ?></div>
                </div>
                <div class="marco_linea6 mayusculas">
                    <div>jornales:&nbsp;</div>
                    <div>&nbsp;</div>
                </div>
                <div class="marco_linea7 mayusculas">
                    <div>días trabajados:&nbsp;</div><div>&nbsp;<?php echo nf($diasd,0) ?></div>
                </div>
                <div class="marco_linea7 mayusculas">
                    <div>dominicales:&nbsp;</div><div>&nbsp;</div>
                </div>
                <div class="marco_linea7 mayusculas">
                    <div>trabajo en feriado:&nbsp;</div><div>&nbsp;</div>
                </div>
                <div class="marco_linea7 mayusculas">
                    <div>domingo trabajado:&nbsp;</div><div>&nbsp;</div>
                </div>
                <div class="marco_linea7 mayusculas">
                    <div>horas extras:&nbsp;</div><div>&nbsp;<?php echo number_format($hextras,2,",",".") ?></div>
                </div>
                <div class="marco_linea7 mayusculas">
                    <div>bonif de la empresa:&nbsp;</div><div>&nbsp;<?php echo number_format($bonificacion,2,",",".") ?></div>
                </div>
                <div class="marco_linea7 mayusculas">
                    <div>bonificación ponavis:&nbsp;</div><div>&nbsp;</div>
                </div>
                <div class="marco_linea7 mayusculas">
                    <div>bonif familiar:&nbsp;</div><div>&nbsp;</div>
                </div>
                <div class="marco_linea7 mayusculas">
                    <div>vacaciones-período:&nbsp;</div><div>&nbsp;</div>
                </div>
                <div class="marco_linea7 mayusculas">
                    <div>sueldo&nbsp;</div><div>&nbsp;<?php echo number_format($sueldo,2,",",".") ?></div>
                </div>
                <div class="marco_linea8 mayusculas">
                    <div>total de remuneraciones&nbsp;&nbsp;&nbsp;&nbsp;S/.&nbsp;&nbsp;&nbsp;</div>
                    <div>&nbsp;<?php echo number_format($total_deven,2,",",".") ?></div>
                </div>
                <div class="marco_linea9 mayusculas">
                    <div>descuentos empleado:&nbsp;</div><div>&nbsp;</div><div>&nbsp;</div><div>&nbsp;</div>
                </div>
                <div class="marco_linea9 mayusculas">
                    <div>reg. prest. salud 3%&nbsp;</div><div>&nbsp;<?php echo number_format($traipss,2,",",".") ?></div><div>reg. prest. salud 3%&nbsp;</div><div>&nbsp;<?php echo number_format($empipss,2,",",".") ?></div>
                </div>
                <div class="marco_linea9 mayusculas">
                    <div>sist. nac. pensiones 3%&nbsp;</div><div>&nbsp;<?php echo number_format($trasnp,2,",",".") ?></div><div>sist. nac. pensiones 3%&nbsp;</div><div>&nbsp;<?php echo number_format($empsnp,2,",",".") ?></div>
                </div>
                <div class="marco_linea9 mayusculas">
                    <div>descuentos app. 10%&nbsp;</div><div>&nbsp;</div><div>&nbsp;</div><div>&nbsp;</div>
                </div>
                <div class="marco_linea9 mayusculas">
                    <div>acc. de trabajo&nbsp;</div><div>&nbsp;</div><div>acc. de trabajo&nbsp;</div><div>&nbsp;</div>
                </div>
                <div class="marco_linea9 mayusculas">
                    <div>fonavi 3%&nbsp;</div><div>&nbsp;<?php echo number_format($trafonavi,2,",",".") ?></div><div>fonavi 3%&nbsp;</div><div>&nbsp;<?php echo number_format($empfonavi,2,",",".") ?></div>
                </div>
                <div class="marco_linea9 mayusculas">
                    <div>contribución ipss. 1%&nbsp;</div><div>&nbsp;</div><div>contribución ipss. 1%&nbsp;</div><div>&nbsp;</div>
                </div>
                <div class="marco_linea9 mayusculas">
                    <div>seguro de vida 2.30%&nbsp;</div><div>&nbsp;</div><div>seguro de vida 2.30%&nbsp;</div><div>&nbsp;</div>
                </div>
                <div class="marco_linea9 mayusculas">
                    <div>comisión fija&nbsp;</div><div>&nbsp;</div><div>comisión fija&nbsp;</div><div>&nbsp;</div>
                </div>
                <div class="marco_linea9 mayusculas">
                    <div>&nbsp;</div><div>&nbsp;</div><div>&nbsp;</div><div>&nbsp;</div>
                </div>
                <div class="marco_linea10 mayusculas">
                    <div>total desduentos S/.&nbsp;</div><div>&nbsp;<?php echo number_format($tratotaldeduc,2,",",".") ?></div><div>total desduentos S/.&nbsp;</div><div>&nbsp;<?php echo number_format($emptotaldeduc,2,",",".") ?></div>
                </div>
                <div class="marco_linea7 mayusculas" style="">
                    <div style="height: 100%;padding-bottom: 1.5em;">saldo neto a cobrar &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;S/.</div><div>&nbsp;<?php echo number_format($total_deven-$tratotaldeduc,2,",",".") ?></div>
                </div>
            </div>

            <!-- <div class="marco_fecha"><?php echo $_POST['dpto'] ?>, <?php echo $_POST['f_b_b'] ?></div> -->
            <!-- <div class="marco_fecha mayusculas">lima, 28 de octubre de 1995</div> -->
            
            <div class="marco_firmasc">
                <div class="marco_firmasc_bloques">
                    <div class="marco_firmasc_bloques_titulo mayusculas">firma del empleador</div>
                </div>
                <div class="marco_firmasc_bloques">
                    <div class="marco_firmasc_bloques_titulo mayusculas">firma del trabajador</div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>