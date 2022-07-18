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

$textRun = $seccion->addTextRun([ "alignment" => Jc::CENTER, "lineHeight" => 1, ]);
$fuente = [ "size" => 14, "color" => "000000", "bold" => true ];
$textRun->addText("BOLETA DE PAGO DE REMUNERACIONES", $fuente);
$textRun->addTextBreak(1);

$fuente  = [ "color" => "000000", "bold" => true ];
$fuentea = [ "color" => "ff0000", ];
$fuenteb = [ "color" => "ff0000", "bold" => true ];
$fuentec = [ "color" => "ff0000", "bold" => true, "alignment" => Jc::START ];

$fuenteH  = [ "color" => "000000", "bold" => true, "size" => 9 ];

$filaAltoA  = 300;
$filaAltoB  = 350;
$filaAltoC  = 150;
$filaAltoD  = 200;
$coluSeparador = 200;
$coluAncho1 = 2000;
$coluAncho2 = 7000;
$coluAncho3 = 1800;
$coluAncho6 = 4500;

$filaEstiloA  = [ "exactHeight" => true, "cantSplit" => false ]; 
$celdaEstiloA = [ "borderTopSize"    => 0, "borderTopColor"    => "000000", "gridSpan" => 2 ]; 
$celdaEstiloB = [ "borderBottomSize" => 0, "borderBottomColor" => "000000", "gridSpan" => 2 ]; 
$celdaEstiloC = [ 
    "borderTopSize"     => 13, 
    "borderBottomSize"  => 13, 
    "borderRightSize"  => 13, 
    "borderTopColor"    => "000000", 
    "borderBottomColor" => "000000", 
    "borderRightColor" => "000000", 
    "borderTopStyle"    => Border::DASHED, 
    "borderBottomStyle" => Border::DASHED,
    "valign"            => "center", 
]; 
$celdaEstiloD = [ 
    "borderTopSize"     => 13, 
    "borderBottomSize"  => 13, 
    "borderBottomSize"  => 13, 
    "borderTopColor"    => "000000", 
    "borderBottomColor" => "000000", 
    "borderTopStyle"    => Border::DASHED, 
    "borderBottomStyle" => Border::DASHED, 
    "valign"            => "center", 
]; 
$celdaEstiloE = [  
    "borderRightSize"  => 13, 
    "borderRightColor" => "000000", 
    "valign"            => "center", 
]; 
$celdaEstiloF = [  
    "borderRightSize"  => 13, 
    "borderTopSize"     => 13, 
    "borderBottomSize"  => 13, 
    "borderRightColor" => "000000", 
    "borderTopColor"    => "000000", 
    "borderBottomColor" => "000000", 
    "borderTopStyle"    => Border::DASHED, 
    "borderBottomStyle" => Border::DASHED, 
    "valign"            => "center", 
]; 
$celdaEstiloG = [  
    "borderTopSize"     => 13, 
    "borderBottomSize"  => 13, 
    "borderTopColor"    => "000000", 
    "borderBottomColor" => "000000", 
    "borderTopStyle"    => Border::DASHED, 
    "borderBottomStyle" => Border::DASHED, 
    "valign"            => "center", 
]; 
$celdaEstiloH = [  
    "borderRightSize"  => 13, 
    "borderBottomSize"  => 13, 
    "borderRightColor" => "000000", 
    "borderBottomColor" => "000000", 
    "borderBottomStyle" => Border::SINGLE, 
    "valign"            => "center", 
]; 
$celdaEstiloI = [  
    "borderBottomSize"  => 13, 
    "borderBottomColor" => "000000", 
    "borderBottomStyle" => Border::SINGLE, 
    "valign"            => "center", 
]; 

$celdaSTART    = [ "alignment" => JcTable::START,   "lineHeight" => -1.0, ]; 
$celdaCENTER   = [ "alignment" => JcTable::CENTER,  "lineHeight" => -1.0, ]; 
$celdaEND      = [ "alignment" => JcTable::END,     "lineHeight" => -1.0, ]; 

$tabla = $seccion->addTable();
$tabla->addRow($filaAltoC, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho1, $celdaEstiloA); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("");

$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho1); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("Apellidos:", $fuente);
$celda2 = $tabla->addCell($coluAncho2); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText($_POST['apellidos'], $fuente);
$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho1); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("Nombres:", $fuente);
$celda2 = $tabla->addCell($coluAncho2); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText($_POST['nombres'], $fuente);
$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho1); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("Cargo:", $fuente);
$celda2 = $tabla->addCell($coluAncho2); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText($cargo, $fuente);
$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho1); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("Ingresos:", $fuente);
$celda2 = $tabla->addCell($coluAncho2); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText(nf($sueldo), $fuente);

$tabla->addRow($filaAltoD, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho1, $celdaEstiloB); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("");

$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho1); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("", $fuente);
$celda2 = $tabla->addCell($coluAncho2); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText("", $fuente);
$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho1); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("Descanso Vacacional:", $fuente);
$celda2 = $tabla->addCell($coluAncho2); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText("", $fuente);
$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho1); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("Desde:", $fuente);
$celda2 = $tabla->addCell($coluAncho2); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText(" Hasta:", $fuente);

$textRun = $seccion->addTextRun();

$styleTable = array("cellSpacing" => 0);
$documento->addTableStyle('datos', $styleTable);
$tabla = $seccion->addTable('datos');
$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho3, $celdaEstiloC); $textrun1 = $celda1->addTextRun($celdaCENTER); $textrun1->addText("REMUNERACIONES", $fuenteH);
$celda1 = $tabla->addCell($coluAncho3, $celdaEstiloC); $textrun1 = $celda1->addTextRun($celdaCENTER); $textrun1->addText("", $fuenteH);
$celda1 = $tabla->addCell($coluAncho3, $celdaEstiloC); $textrun1 = $celda1->addTextRun($celdaCENTER); $textrun1->addText("DESCUENTOS", $fuenteH);
$celda1 = $tabla->addCell($coluAncho3, $celdaEstiloC); $textrun1 = $celda1->addTextRun($celdaCENTER); $textrun1->addText("EMPLEADOR", $fuenteH);
$celda1 = $tabla->addCell($coluAncho3, $celdaEstiloD); $textrun1 = $celda1->addTextRun($celdaCENTER); $textrun1->addText("TRABAJADOR", $fuenteH);

$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho3, $celdaEstiloE); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("  HABER BÁSICO", $fuenteH);
$celda1 = $tabla->addCell($coluAncho3, $celdaEstiloE); $textrun1 = $celda1->addTextRun($celdaCENTER); $textrun1->addText(nf($sueldo), $fuenteH);
$celda1 = $tabla->addCell($coluAncho3, $celdaEstiloE); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("  D.L. 22402", $fuenteH);
$celda1 = $tabla->addCell($coluAncho3, $celdaEstiloE); $textrun1 = $celda1->addTextRun($celdaCENTER); $textrun1->addText(nf($traipss), $fuenteH);
$celda1 = $tabla->addCell($coluAncho3);                $textrun1 = $celda1->addTextRun($celdaCENTER); $textrun1->addText(nf($empipss), $fuenteH);

$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho3, $celdaEstiloE); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("  DOMINICAL", $fuenteH);
$celda1 = $tabla->addCell($coluAncho3, $celdaEstiloE); $textrun1 = $celda1->addTextRun($celdaCENTER); $textrun1->addText("", $fuenteH);
$celda1 = $tabla->addCell($coluAncho3, $celdaEstiloE); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("  D.L. 19990", $fuenteH);
$celda1 = $tabla->addCell($coluAncho3, $celdaEstiloE); $textrun1 = $celda1->addTextRun($celdaCENTER); $textrun1->addText(nf($trasnp), $fuenteH);
$celda1 = $tabla->addCell($coluAncho3);                $textrun1 = $celda1->addTextRun($celdaCENTER); $textrun1->addText(nf($empsnp), $fuenteH);

$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho3, $celdaEstiloE); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("  HORAS EXTRAS", $fuenteH);
$celda1 = $tabla->addCell($coluAncho3, $celdaEstiloE); $textrun1 = $celda1->addTextRun($celdaCENTER); $textrun1->addText("", $fuenteH);
$celda1 = $tabla->addCell($coluAncho3, $celdaEstiloE); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("  FONAVI", $fuenteH);
$celda1 = $tabla->addCell($coluAncho3, $celdaEstiloE); $textrun1 = $celda1->addTextRun($celdaCENTER); $textrun1->addText(nf($trafonavi), $fuenteH);
$celda1 = $tabla->addCell($coluAncho3);                $textrun1 = $celda1->addTextRun($celdaCENTER); $textrun1->addText(nf($empfonavi), $fuenteH);

$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho3, $celdaEstiloE); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("  ASIS. FAMILIAR", $fuenteH);
$celda1 = $tabla->addCell($coluAncho3, $celdaEstiloE); $textrun1 = $celda1->addTextRun($celdaCENTER); $textrun1->addText("", $fuenteH);
$celda1 = $tabla->addCell($coluAncho3, $celdaEstiloE); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("  A.L. 18846", $fuenteH);
$celda1 = $tabla->addCell($coluAncho3, $celdaEstiloE); $textrun1 = $celda1->addTextRun($celdaCENTER); $textrun1->addText("", $fuenteH);
$celda1 = $tabla->addCell($coluAncho3);                $textrun1 = $celda1->addTextRun($celdaCENTER); $textrun1->addText("", $fuenteH);

$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho3, $celdaEstiloE); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("  ALIMENTAC-RO", $fuenteH);
$celda1 = $tabla->addCell($coluAncho3, $celdaEstiloE); $textrun1 = $celda1->addTextRun($celdaCENTER); $textrun1->addText("", $fuenteH);
$celda1 = $tabla->addCell($coluAncho3, $celdaEstiloE); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("  ", $fuenteH);
$celda1 = $tabla->addCell($coluAncho3, $celdaEstiloE); $textrun1 = $celda1->addTextRun($celdaCENTER); $textrun1->addText("", $fuenteH);
$celda1 = $tabla->addCell($coluAncho3);                $textrun1 = $celda1->addTextRun($celdaCENTER); $textrun1->addText("", $fuenteH);

$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho3, $celdaEstiloE); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("  FALTAS", $fuenteH);
$celda1 = $tabla->addCell($coluAncho3, $celdaEstiloE); $textrun1 = $celda1->addTextRun($celdaCENTER); $textrun1->addText("", $fuenteH);
$celda1 = $tabla->addCell($coluAncho3, $celdaEstiloE); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("  ", $fuenteH);
$celda1 = $tabla->addCell($coluAncho3, $celdaEstiloE); $textrun1 = $celda1->addTextRun($celdaCENTER); $textrun1->addText("", $fuenteH);
$celda1 = $tabla->addCell($coluAncho3);                $textrun1 = $celda1->addTextRun($celdaCENTER); $textrun1->addText("", $fuenteH);

$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho3, $celdaEstiloE); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("  FERIADOS", $fuenteH);
$celda1 = $tabla->addCell($coluAncho3, $celdaEstiloE); $textrun1 = $celda1->addTextRun($celdaCENTER); $textrun1->addText("", $fuenteH);
$celda1 = $tabla->addCell($coluAncho3, $celdaEstiloE); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("  ", $fuenteH);
$celda1 = $tabla->addCell($coluAncho3, $celdaEstiloE); $textrun1 = $celda1->addTextRun($celdaCENTER); $textrun1->addText("", $fuenteH);
$celda1 = $tabla->addCell($coluAncho3);                $textrun1 = $celda1->addTextRun($celdaCENTER); $textrun1->addText("", $fuenteH);

$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho3, $celdaEstiloE); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("  SUB-TOTALES", $fuenteH);
$celda1 = $tabla->addCell($coluAncho3, $celdaEstiloF); $textrun1 = $celda1->addTextRun($celdaCENTER); $textrun1->addText(nf($sueldo+$hextras), $fuenteH);
$celda1 = $tabla->addCell($coluAncho3, $celdaEstiloE); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("  ", $fuenteH);
$celda1 = $tabla->addCell($coluAncho3, $celdaEstiloF); $textrun1 = $celda1->addTextRun($celdaCENTER); $textrun1->addText(nf($tratotaldeduc), $fuenteH);
$celda1 = $tabla->addCell($coluAncho3, $celdaEstiloG);                $textrun1 = $celda1->addTextRun($celdaCENTER); $textrun1->addText(nf($emptotaldeduc), $fuenteH);

$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho3, $celdaEstiloE); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("  TOTALES", $fuenteH);
$celda1 = $tabla->addCell($coluAncho3, $celdaEstiloH); $textrun1 = $celda1->addTextRun($celdaCENTER); $textrun1->addText("", $fuenteH);
$celda1 = $tabla->addCell($coluAncho3, $celdaEstiloE); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("  NETO A PAGAR", $fuenteH);
$celda1 = $tabla->addCell($coluAncho3, $celdaEstiloH); $textrun1 = $celda1->addTextRun($celdaCENTER); $textrun1->addText("", $fuenteH);
$celda1 = $tabla->addCell($coluAncho3, $celdaEstiloI);                $textrun1 = $celda1->addTextRun($celdaCENTER); $textrun1->addText("", $fuenteH);

$textRun = $seccion->addTextRun([ "alignment" => Jc::END, "lineHeight" => 1, ]);
$textRun->addTextBreak(1);
$textRun->addText("Neto recibido: S/.".nf(($sueldo+$hextras)-$tratotaldeduc), $fuente);
$textRun->addTextBreak(7);

$styleTable = array("cellSpacing" => 0);
$documento->addTableStyle('firmas', $styleTable);
$tabla = $seccion->addTable('firmas');

$tabla->addRow();
$celda1 = $tabla->addCell($coluAncho6); 
$textrun1 = $celda1->addTextRun([ "alignment" => JcTable::CENTER, "cellMarginRight" => 50 ]); 
$textrun1->addText("_______________________________", $fuente);

$celda2 = $tabla->addCell($coluAncho6); 
$textrun1 = $celda2->addTextRun([ "alignment" => JcTable::CENTER, "cellMarginRight" => 50 ]); 
$textrun1->addText("_______________________________", $fuente);

$tabla->addRow();
$celda1 = $tabla->addCell($coluAncho6); 
$textrun1 = $celda1->addTextRun([ "alignment" => JcTable::CENTER, "cellMarginRight" => 50 ]); 
$textrun1->addText("EMPLEADOR", $fuente);

$celda2 = $tabla->addCell($coluAncho6); 
$textrun1 = $celda2->addTextRun([ "alignment" => JcTable::CENTER, "cellMarginRight" => 50 ]); 
$textrun1->addText("TRABAJADOR", $fuente);

$textRun = $seccion->addTextRun([ "alignment" => Jc::END, "lineHeight" => 1, ]);
$textRun->addTextBreak(2);
$textRun->addText("Fecha: ".$_POST['dpto']." ".$_POST['f_b_b'], $fuente);









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
                    <div>asis. familiar</div>
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