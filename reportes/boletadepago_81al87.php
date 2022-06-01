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

// $annio = substr($fechaBoleta,0,4);
// $tsnp = "No compatible";
// $tipss = "No compatible";
// $tfonavi = "No compatible";

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
            <div class="marco_titulo">boleta de pago de remuneraciones</div>
            <div class="marco_linea3">
                <div>Apellidos:&nbsp;</div>
                <div>&nbsp;<?php echo $_POST['apellidos'] ?></div>
            </div>
            <div class="marco_linea3">
                <div>nombres:&nbsp;</div>
                <div>&nbsp;<?php echo $_POST['nombres'] ?></div>
            </div>
            <div class="marco_linea3">
                <div>cargos:&nbsp;</div>
                <div>&nbsp;<?php echo $cargo ?></div>
            </div>
            <div class="marco_linea3" style="padding-bottom: 1.5em; border-bottom: solid 1px black; margin-bottom: 1.5em">
                <div>ingresos:&nbsp;</div>
                <div>&nbsp;<?php echo nf($sueldo) ?></div>
            </div>
            <div class="marco_linea3">
                <div>descanso vacacional:&nbsp;</div>
                <div>&nbsp;</div>
            </div>
            <div class="marco_linea3" style="padding-bottom: 1.5em;">
                <div>desde:&nbsp;</div>
                <div>hasta:&nbsp;</div>
            </div>
            <div class="marco_cuadro2">
                <div class="marco_cuadro2_linea1"></div>
                <div class="marco_cuadro2_linea2">
                    <div>remuneraciones</div>
                    <div>&nbsp;</div>
                    <div>descuentos</div>
                    <div>empleador</div>
                    <div>trabajador</div>
                </div>
                <div class="marco_cuadro2_linea1"></div>
                <div class="marco_cuadro2_linea3">
                    <div>haber básico</div>
                    <div>&nbsp;<?php echo nf($sueldo) ?></div>
                    <div>D.L. 22402</div>
                    <div><?php echo nf($traipss) ?></div>
                    <div><?php echo nf($empipss) ?></div>
                </div>
                <div class="marco_cuadro2_linea3">
                    <div>dominical</div>
                    <div>&nbsp;</div>
                    <div>D.L. 19990</div>
                    <div><?php echo nf($trasnp) ?></div>
                    <div><?php echo nf($empsnp) ?></div>
                </div>
                <div class="marco_cuadro2_linea3">
                    <div>horas extras</div>
                    <div>&nbsp;<?php echo nf($hextras) ?></div>
                    <div>fonavi</div>
                    <div><?php echo nf($trafonavi) ?></div>
                    <div><?php echo nf($empfonavi) ?></div>
                </div>
                <div class="marco_cuadro2_linea3">
                    <div>asis. familian</div>
                    <div>&nbsp;</div>
                    <div>A.L. 18846</div>
                    <div></div>
                    <div></div>
                </div>
                <div class="marco_cuadro2_linea3">
                    <div>alimentac-ro</div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
                <div class="marco_cuadro2_linea3">
                    <div>faltas</div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
                <div class="marco_cuadro2_linea3">
                    <div>feriados</div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
                <div class="marco_cuadro2_linea-separador">
                    <div></div>
                    <div><div style="width: 80%; border-bottom: dashed 1px grey;"></div></div>
                    <div></div>
                    <div><div style="width: 80%; border-bottom: dashed 1px grey;"></div></div>
                    <div><div style="width: 80%; border-bottom: dashed 1px grey;"></div></div>
                </div>
                <div class="marco_cuadro2_linea3">
                    <div>sub-totales</div>
                    <div><?php echo nf($sueldo+$hextras) ?></div>
                    <div></div>
                    <div><?php echo nf($tratotaldeduc) ?></div>
                    <div><?php echo nf($emptotaldeduc) ?></div>
                </div>
                <div class="marco_cuadro2_linea-separador">
                    <div></div>
                    <div><div style="width: 80%; border-bottom: dashed 1px grey;"></div></div>
                    <div></div>
                    <div><div style="width: 80%; border-bottom: dashed 1px grey;"></div></div>
                    <div><div style="width: 80%; border-bottom: dashed 1px grey;"></div></div>
                </div>
                <div class="marco_cuadro2_linea3">
                    <div>totales</div>
                    <div></div>
                    <div>neto a pagar</div>
                    <div></div>
                    <div></div>
                </div>
                <div class="marco_cuadro2_linea-separador">
                    <div></div>
                    <div><div style="width: 80%; border-bottom: double 1px grey;"></div></div>
                    <div></div>
                    <div><div style="width: 80%; border-bottom: double 1px grey;"></div></div>
                    <div><div style="width: 80%; border-bottom: double 1px grey;"></div></div>
                </div>
            </div>
            <div class="marco_pie">Neto recibido: S/.&nbsp;<?php echo nf(($sueldo+$hextras)-$tratotaldeduc) ?></div>
            <div class="marco_firmas">
                <div class="marco_firmas_bloques">
                    <div class="marco_firmas_bloques_titulo mayusculas">empleador</div>
                </div>
                <div class="marco_firmas_bloques">
                    <div class="marco_firmas_bloques_titulo mayusculas">trabajador</div>
                </div>
            </div>
            <div class="marco_pie">Fecha:&nbsp;&nbsp;<?php echo $_POST['dpto'] ?> <?php echo $_POST['f_b_b'] ?></div>
        </div>
    </div>
</body>
</html>