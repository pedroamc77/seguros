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


/* *************************************************************** */

$ruta = "../word/boletas/";
$nombre_archivo = "boleta_".strtoupper($_POST['nombres'])."_".strtoupper($_POST['apellidos'])."_".$_POST['emision']."_.docx";

require_once "../vendor/autoload.php";
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\SimpleType\JcTable;
use PhpOffice\PhpWord\SimpleType\VerticalJc;
use PhpOffice\PhpWord\SimpleType\Border;
use PhpOffice\PhpWord\Style\Language;
$documento = new \PhpOffice\PhpWord\PhpWord();
$documento->setDefaultFontName('Calibri');
$documento->setDefaultFontSize(10);
$propiedades = $documento->getDocInfo();
$propiedades->setCreator("iBritek <www.ibritek.com>");
$propiedades->setTitle("Certificado_95_00");

$seccion = $documento->addSection([ 'marginTop' => 800, "vAlign" => VerticalJc::CENTER ]);

$fuente  = [ "color" => "000000", "bold" => true ];

$textRun = $seccion->addTextRun([ "alignment" => Jc::END, "lineHeight" => 1, ]);
$textRun->addTextBreak(2);
$textRun->addText($meses[nf($fechafin->format("m"),0)].", ".$fechafin->format("Y"), $fuente);

$textRun = $seccion->addTextRun([ "alignment" => Jc::CENTER, "lineHeight" => 1, ]);
$fuente = [ "size" => 14, "color" => "000000", "bold" => true ];
$textRun->addText("BOLETA DE PAGO", $fuente);
$textRun->addTextBreak(1);

$fuente  = [ "color" => "000000", "bold" => true ];
$fuentea = [ "color" => "ff0000", ];
$fuenteb = [ "color" => "ff0000", "bold" => true ];
$fuentec = [ "color" => "ff0000", "bold" => true, "alignment" => Jc::START ];
$fuented = [ "color" => "000000", "bold" => true, "underline" => "single" ];
$fuenteH  = [ "color" => "000000", "bold" => true, "size" => 9 ];

$filaAltoA  = 300;
$filaAltoB  = 350;
$filaAltoC  = 150;
$filaAltoD  = 200;
$coluSeparador = 200;
$coluAncho1 = 2500;
$coluAncho2 = 6500;
$coluAncho3 = 1300;
$coluAncho4 = 3200;

$filaEstiloA  = [ "exactHeight" => true, "cantSplit" => false ];  
$celdaEstiloA = [ "gridSpan" => 2 ]; 
$celdaEstiloB = [ "borderBottomSize"  => 0, "borderBottomColor" => "000000" ]; 

$celdaSTART    = [ "alignment" => JcTable::START,   "lineHeight" => -1.3, ]; 
$celdaCENTER   = [ "alignment" => JcTable::CENTER,  "lineHeight" => -1.3, ]; 
$celdaEND      = [ "alignment" => JcTable::END,     "lineHeight" => -1.3, ]; 

$tabla = $seccion->addTable();
$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho1); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("NOMBRES Y APELLIDOS", $fuente);
$celda2 = $tabla->addCell($coluAncho2); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText(": ".$_POST['nombres'].", ".$_POST['apellidos'], $fuente);
$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho1); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("FECHA DE INGRESO", $fuente);
$celda2 = $tabla->addCell($coluAncho2); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText(": ".$_POST['f_a'], $fuente);
$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho1); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("CONCEPTO DE LA ", $fuente);
$celda2 = $tabla->addCell($coluAncho2); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText(": ", $fuente);
$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho1); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("REMUNERACION ", $fuente);
$celda2 = $tabla->addCell($coluAncho2); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText(": ", $fuente);
$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho1); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("I.E.", $fuente);
$celda2 = $tabla->addCell($coluAncho2); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText(": ", $fuente);
$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho1); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("SUELDO ", $fuente);
$celda2 = $tabla->addCell($coluAncho2); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText(": ".nf($sueldo), $fuente);
$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho1); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("OTROS ", $fuente);
$celda2 = $tabla->addCell($coluAncho2); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText(": ".nf($total_deven), $fuente);

$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho1, $celdaEstiloA); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("VACACIONES", $fuented);

$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho1); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("SALIDA  ", $fuente);
$celda2 = $tabla->addCell($coluAncho2); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText(": ", $fuente);
$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho1); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("REGRESO  ", $fuente);
$celda2 = $tabla->addCell($coluAncho2); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText(": ", $fuente);
$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho1); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("FECHA DE CESE ", $fuente);
$celda2 = $tabla->addCell($coluAncho2); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText(": ".$_POST['f_b'], $fuente);

$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho1, $celdaEstiloA); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("APORTACIONES DEL TRABAJADOR", $fuented);

$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho1); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("I.P.S.S  ", $fuente);
$celda2 = $tabla->addCell($coluAncho2); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText(": ".nf($traipss), $fuente);
$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho1); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("S.N.P.  ", $fuente);
$celda2 = $tabla->addCell($coluAncho2); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText(": ".nf($trasnp), $fuente);
$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho1); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("FONAVI ", $fuente);
$celda2 = $tabla->addCell($coluAncho2); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText(": ".nf($trafonavi), $fuente);
$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho1); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("ADELANTO QUINCENA ", $fuente);
$celda2 = $tabla->addCell($coluAncho2); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText(": ".nf(0), $fuente);
$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho1); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("OTROS DESCUENTOS ", $fuente);
$celda2 = $tabla->addCell($coluAncho2); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText(": ".nf(0), $fuente);
$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho1); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("TOTAL DESCUENTOS ", $fuente);
$celda2 = $tabla->addCell($coluAncho2); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText(": ".nf($tratotaldeduc), $fuente);
$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho1); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("NETO A PAGAR ", $fuente);
$celda2 = $tabla->addCell($coluAncho2); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText(": ".nf($sueldo-$tratotaldeduc), $fuente);

$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho1, $celdaEstiloA); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("APORTACIONES DEL EMPLEADOR", $fuented);

$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho1); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("I.P.S.S  ", $fuente);
$celda2 = $tabla->addCell($coluAncho2); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText(": ".nf($empipss), $fuente);
$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho1); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("S.N.P.  ", $fuente);
$celda2 = $tabla->addCell($coluAncho2); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText(": ".nf($empsnp), $fuente);
$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho1); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("FONAVI ", $fuente);
$celda2 = $tabla->addCell($coluAncho2); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText(": ".nf($empfonavi), $fuente);
$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho1); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("OTROS ", $fuente);
$celda2 = $tabla->addCell($coluAncho2); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText(": ".nf(0), $fuente);
$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho1); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("TOTAL DESCUENTOS ", $fuente);
$celda2 = $tabla->addCell($coluAncho2); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText(": ".nf($emptotaldeduc), $fuente);

$textRun = $seccion->addTextRun([ "alignment" => Jc::CENTER, "lineHeight" => 1, ]);
$textRun->addTextBreak(2);
$textRun->addText($_POST['dpto'].", ".$_POST['f_b_b'], $fuente);
$textRun->addTextBreak(5);

$tabla = $seccion->addTable();
$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho3); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("EMPLEADOR:", $fuente);
$celda2 = $tabla->addCell($coluAncho4, $celdaEstiloB); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText("", $fuente);
$celda1 = $tabla->addCell($coluAncho3); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("TRABAJADOR:", $fuente);
$celda2 = $tabla->addCell($coluAncho4, $celdaEstiloB); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText("", $fuente);






# Para que no diga que se abre en modo de compatibilidad
$documento->getCompatibility()->setOoxmlVersion(15);
$documento->getSettings()->setThemeFontLang(new Language("ES-VE"));
$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($documento, "Word2007");
$objWriter->save($ruta.$nombre_archivo);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boleta de Pago</title>
    <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="../css/estilos.min.css" media="all">
    <link rel="stylesheet" href="../css/impresion.min.css" media="print">
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
    <div class="tarjeta_descarga">
        <div class="card text-center shadow">
            <img src="../imagenes/pantalla_word.jpeg" width="100%" class="card-img-top" alt="...">
            <div class="card-body">
                <p class="card-text" style="font-size: .7em;">
                    Utilice el siquiente boton para descargar el archivo:
                    <hr style="margin: 0 10%; width: 80%; " />
                    <strong style="font-size: .7em;"><?php echo $nombre_archivo; ?></strong>
                    <hr style="margin: 0 10%; width: 80%;" />
                </p>
                <a href="./<?php echo $ruta.$nombre_archivo; ?>" class="btn btn-primary" style="margin-bottom: 10px;">Descargar el archivo</a>
            </div>
        </div>
    </div>
</body>
</html>