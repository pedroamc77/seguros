<?php 

require_once('../_db/nomina.php');

// echo $_POST['fechaboleta']."-01","<br>","\n";
// echo $_POST['fsueldo'],"<br>","\n";

$fechaBoleta = isset($_POST['fechaboleta']) ? str_replace("-","/",$_POST['fechaboleta']) : '';

$fBoleta = date_create($_POST['fechaboleta']);
$mesboleta = $meses[$fBoleta->format("m")];
$semboleta = $fBoleta->format("W");

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
$remvaca = isset($_POST['remvacacionales']) ? $_POST['remvacacionales'] : 0;
$reintegro = isset($_POST['reintegro']) ? $_POST['reintegro'] : 0;
$hextras = isset($_POST['hextras']) ? $_POST['hextras'] : 0;
$bonificacion = isset($_POST['bonificacion']) ? $_POST['bonificacion'] : 0;
$otrosdeven = isset($_POST['otros_deven']) ? $_POST['otros_deven'] : 0;
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
            <div class="marco_linea1">
                <div>datos de la empresa:&nbsp;</div>
                <div>&nbsp;<?php echo $_POST['empresa'] ?></div>
            </div>
            <div class="marco_linea1">
                <div>razon social:&nbsp;</div>
                <div>&nbsp;<?php echo $_POST['empresa'] ?></div>
            </div>
            <div class="marco_linea2">
                <div>reg. patronal:&nbsp;</div>
                <div>&nbsp;</div>
                <div>Lib. Trib.:&nbsp;</div>
                <div>&nbsp;</div>
            </div>
            <div class="marco_linea1">
                <div>datos del trabajador&nbsp;</div>
                <div>&nbsp;</div>
            </div>
            <div class="marco_linea1">
                <div>apellidos y nombres:&nbsp;</div>
                <div>&nbsp;<?php echo $_POST['apellidos'].", ".$_POST['nombres'] ?></div>
            </div>
            <div class="marco_linea2">
                <div>cotag. ocupación:&nbsp;</div>
                <div>&nbsp;<?php echo $cargo ?></div>
                <div>fecha de ingreso:&nbsp;</div>
                <div>&nbsp;<?php echo $_POST['f_a'] ?></div>
            </div>
            <div class="marco_linea2">
                <div>n° seguro social:&nbsp;</div>
                <div>&nbsp;</div>
                <div>L.E.I.:&nbsp;</div>
                <div>&nbsp;</div>
            </div>
            <div class="marco_cuadro">
                <div class="marco_cuadro_linea1">
                    <div>&nbsp;</div>
                    <div>descuentos</div>
                </div>
                <div class="marco_cuadro_linea2">
                    <div class="marco_cuadro_linea2_secciona">mes de:&nbsp;<div>:&nbsp;&nbsp;<?php echo $mesboleta ?></div></div>
                    <div class="marco_cuadro_linea2_seccionb">
                        <div>&nbsp;</div>
                        <div>trabajador</div>
                        <div>empleador</div>
                        <div>total</div>
                    </div>
                </div>
                <div class="marco_cuadro_linea2">
                    <div class="marco_cuadro_linea2_secciona">Semana:&nbsp;<div>:&nbsp;&nbsp;<?php echo $semboleta ?></div></div>
                    <div class="marco_cuadro_linea2_seccionb">
                        <div style="text-align: start;">Sist. Nac. Pen.</div>
                        <div>&nbsp;<?php echo nf($trasnp) ?></div>
                        <div>&nbsp;<?php echo nf($empsnp) ?></div>
                        <div>&nbsp;<?php echo nf($trasnp+$empsnp) ?></div>
                    </div>
                </div>
                <div class="marco_cuadro_linea2">
                    <div class="marco_cuadro_linea2_secciona">Haber mensual:&nbsp;<div>:&nbsp;&nbsp;<?php echo nf($sueldo) ?></div></div>
                    <div class="marco_cuadro_linea2_seccionb">
                        <div style="text-align: start;">seguro social</div>
                        <div>&nbsp;<?php echo nf($traipss) ?></div>
                        <div>&nbsp;<?php echo nf($empipss) ?></div>
                        <div>&nbsp;<?php echo nf($traipss+$empipss) ?></div>
                    </div>
                </div>
                <div class="marco_cuadro_linea2">
                    <div class="marco_cuadro_linea2_secciona">jornel:&nbsp;<div>:&nbsp;&nbsp;</div></div>
                    <div class="marco_cuadro_linea2_seccionb">
                        <div style="text-align: start;">i.r.f.</div>
                        <div>&nbsp;</div>
                        <div>&nbsp;</div>
                        <div>&nbsp;</div>
                    </div>
                </div>
                <div class="marco_cuadro_linea2">
                    <div class="marco_cuadro_linea2_secciona">hra. trab. dias:&nbsp;<div>:&nbsp;&nbsp;</div></div>
                    <div class="marco_cuadro_linea2_seccionb">
                        <div style="text-align: start;">FONAVIS</div>
                        <div>&nbsp;<?php echo nf($trafonavi) ?></div>
                        <div>&nbsp;<?php echo nf($empfonavi) ?></div>
                        <div>&nbsp;<?php echo nf($trafonavi+$empfonavi) ?></div>
                    </div>
                </div>
                <div class="marco_cuadro_linea2">
                    <div class="marco_cuadro_linea2_secciona">dominical:&nbsp;<div>:&nbsp;&nbsp;</div></div>
                    <div class="marco_cuadro_linea2_seccionb">
                        <div style="text-align: start;">comisión porcent.</div>
                        <div>&nbsp;</div>
                        <div>&nbsp;</div>
                        <div>&nbsp;</div>
                    </div>
                </div>
                <div class="marco_cuadro_linea2">
                    <div class="marco_cuadro_linea2_secciona">horas estras:&nbsp;<div>:&nbsp;&nbsp;<?php echo nf($hextras) ?></div></div>
                    <div class="marco_cuadro_linea2_seccionb">
                        <div style="text-align: start;">asoc. de trabajo</div>
                        <div>&nbsp;</div>
                        <div>&nbsp;</div>
                        <div>&nbsp;</div>
                    </div>
                </div>
                <div class="marco_cuadro_linea2">
                    <div class="marco_cuadro_linea2_secciona">asig. familiar:&nbsp;<div>:&nbsp;&nbsp;</div></div>
                </div>
                <div class="marco_cuadro_linea2">
                    <div class="marco_cuadro_linea2_secciona">part. utilidades:&nbsp;<div>:&nbsp;&nbsp;</div></div>
                </div>
                <div class="marco_cuadro_linea2">
                    <div class="marco_cuadro_linea2_secciona">fortadoa:&nbsp;<div>:&nbsp;&nbsp;</div></div>
                </div>
                <div class="marco_cuadro_linea2">
                    <div class="marco_cuadro_linea2_secciona">bonificaciones:&nbsp;<div>:&nbsp;&nbsp;<?php echo nf($bonificacion) ?></div></div>
                </div>
                <div class="marco_cuadro_linea2">
                    <div class="marco_cuadro_linea2_secciona">reintegros:&nbsp;<div>:&nbsp;&nbsp;<?php echo nf($reintegro) ?></div></div>
                </div>
                <div class="marco_cuadro_linea2">
                    <div class="marco_cuadro_linea2_secciona">vacaciones:&nbsp;<div>:&nbsp;&nbsp;<?php echo nf($remvaca) ?></div></div>
                </div>
                <div class="marco_cuadro_linea2">
                    <div class="marco_cuadro_linea2_secciona">comisiones:&nbsp;<div>:&nbsp;&nbsp;</div></div>
                </div>
                <div class="marco_cuadro_linea2">
                    <div class="marco_cuadro_linea2_secciona">destajos:&nbsp;<div>:&nbsp;&nbsp;</div></div>
                </div>
                <div class="marco_cuadro_linea2">
                    <div class="marco_cuadro_linea2_secciona">anticipos:&nbsp;<div>:&nbsp;&nbsp;</div></div>
                </div>
                <div class="marco_cuadro_linea2">
                    <div class="marco_cuadro_linea2_secciona">&nbsp;<div>:&nbsp;&nbsp;</div></div>
                </div>
                <div class="marco_cuadro_linea2">
                    <div class="marco_cuadro_linea2_secciona">&nbsp;<div>:&nbsp;&nbsp;</div></div>
                </div>
                <div class="marco_cuadro_linea2">
                    <div class="marco_cuadro_linea2_secciona">&nbsp;<div>:&nbsp;&nbsp;</div></div>
                </div>
                <div class="marco_cuadro_linea3">
                    <div class="marco_cuadro_linea3_secciona">total haber<div>:&nbsp;&nbsp;<?php echo nf($total_deven) ?></div></div>
                    <div class="marco_cuadro_linea3_secciona">total descuento<div>:&nbsp;&nbsp;<?php echo nf($tratotaldeduc) ?></div></div>
                </div>
            </div>
            <div class="marco_pie">Neto recibido: S/.&nbsp;<?php echo nf($total_deven-$tratotaldeduc) ?></div>
            <div class="marco_pie"><?php echo $_POST['dpto'] ?> <?php echo $_POST['f_b_b'] ?></div>
            <div class="marco_firmas">
                <div class="marco_firmas_bloques">
                    <div class="marco_firmas_bloques_titulo mayusculas">empleador</div>
                </div>
                <div class="marco_firmas_bloques">
                    <div class="marco_firmas_bloques_titulo mayusculas">trabajador</div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>