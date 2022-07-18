<?php 

require_once('../_db/nomina.php');

if ( isset($_POST['cargo_al']) ) $cargo = $_POST['cargo_al'];
if ( isset($_POST['cargo_bl']) ) $cargo = $_POST['cargo_bl'];

$fechaini = date_create($_POST['f_a']);
$fechafin = date_create($_POST['f_b']);
$añofin     = date_format($fechafin,"Y");
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
$total_deven = $vacaciones+$gratificaciones+$reintegro+$incentivo+$bonificacion+$bonificacion_graciosa+$bonificacion_extraordinaria;

// var_dump($diferencia);
$meses = $diferencia->format("%m");
$anios = $diferencia->format("%y");
$tiempo = $anios." años y ".$meses." meses";
$anios = $meses > 0 ? $diferencia->format("%y") + 1 : $diferencia->format("%y");

// $sueldo = $_POST['sueldo'];
$sueldos = obtener_sueldo($_POST['fsueldo']);
$sueldo = $sueldos['sueldo_minimo'];

//Deducciones
$traipss = $sueldo*($sueldos['at_ss']/100);
$trasnp = $sueldo*($sueldos['at_fondo_juvi']/100);
$trafonavi = $sueldo*($sueldos['at_pro_desocup']/100);
$tratotaldeduc = $trasnp+$traipss+$trafonavi;

$empipss = $sueldo*($sueldos['ap_ss']/100);
$empsnp = $sueldo*($sueldos['ap_fondo_juvi']/100);
$empfonavi = $sueldo*($sueldos['ap_fonavi']/100);
$emptotaldeduc = $empsnp+$empipss+$empfonavi;

$totalpago = $anios*$sueldo;

$tretencion = $añofin <= 1988 ? $totalpago*($retencion/100) : 0;

$totalapagar = ($totalpago+$total_deven)-($total_deduc+$tratotaldeduc+$tretencion);



/* *************************************************************** */

$ruta = "../word/liquidaciones/";
$nombre_archivo = "liquidacion_".strtoupper($_POST['nombres'])."_".strtoupper($_POST['apellidos'])."_".$_POST['emision']."_.docx";

require_once "../vendor/autoload.php";
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\SimpleType\JcTable;
use PhpOffice\PhpWord\SimpleType\VerticalJc;
use PhpOffice\PhpWord\Style\Language;
$documento = new \PhpOffice\PhpWord\PhpWord();
$documento->setDefaultFontName('Calibri');
$documento->setDefaultFontSize(10);
$propiedades = $documento->getDocInfo();
$propiedades->setCreator("iBritek <www.ibritek.com>");
$propiedades->setTitle("Certificado_95_00");


$seccion = $documento->addSection([ 'marginTop' => 1100, "vAlign" => VerticalJc::CENTER ]);
// $seccion = $documento->addSection([]);

$textRun = $seccion->addTextRun([ "alignment" => Jc::START, "lineHeight" => 1, ]);
$fuente = [ "color" => "000000", "bold" => true ];
$textRun->addText(strtoupper($_POST['empresa']), $fuente);
$textRun->addTextBreak(2);

$fuentea = [ "color" => "ff0000", ];
$fuenteb = [ "color" => "ff0000", "bold" => true ];

$textRun = $seccion->addTextRun([ "alignment" => Jc::END, "lineHeight" => 1, ]);
$textRun->addText(isset($_POST['dpto']) ? strtoupper($_POST['dpto']).". " : "", $fuenteb);
$textRun->addText($_POST['fecha_emision'].".", $fuenteb);
$textRun->addTextBreak(1);

$textRun = $seccion->addTextRun([ "alignment" => Jc::CENTER, "lineHeight" => 1, ]);
$fuente = [ "color" => "000000", "bold" => true, "underline" => "single" ];
$textRun->addText("LIQUIDACION POR TIEMPO DE SERVICIOS", $fuente);
// $textRun->addTextBreak(2);


$fuente = [ "color" => "000000", "bold" => true ];
$filaAlto = 300;
$coluAncho = 2500;
$coluAncho2 = 7500;
$coluSeparador = 200;

// $styleTable = array('borderBottomSize' => 15, 'borderBottomColor' => '000000', "cellSpacing" => 0);
// $documento->addTableStyle('adicionales', $styleTable);
// $tabla = $seccion->addTable('adicionales');
$tabla = $seccion->addTable();

$tabla->addRow($filaAlto, [ "exactHeight" => true ]);
$tabla->addCell($coluAncho)->addText("NOMBRE", $fuente);
$tabla->addCell($coluSeparador)->addText("  ");
$tabla->addCell($coluAncho2)->addText(strtoupper($_POST['nombres']." ".$_POST['apellidos']), $fuenteb);

$tabla->addRow($filaAlto, [ "exactHeight" => true ]);
$tabla->addCell($coluAncho)->addText("FECHA DE INGRESO", $fuente);
$tabla->addCell($coluSeparador)->addText("  ");
$tabla->addCell($coluAncho2)->addText($_POST['f_a'], $fuenteb);

$tabla->addRow($filaAlto, [ "exactHeight" => true ]);
$tabla->addCell($coluAncho)->addText("FECHA DE RETIRO", $fuente);
$tabla->addCell($coluSeparador)->addText("  ");
$tabla->addCell($coluAncho2)->addText($_POST['f_b'], $fuenteb);

$tabla->addRow($filaAlto, [ "exactHeight" => true ]);
$tabla->addCell($coluAncho)->addText("CARGO OCUPADO", $fuente);
$tabla->addCell($coluSeparador)->addText("  ");
$tabla->addCell($coluAncho2)->addText($cargo, $fuenteb);

$tabla->addRow($filaAlto, [ "exactHeight" => true ]);
$tabla->addCell($coluAncho)->addText("TIEMPO DE SERVICIOS", $fuente);
$tabla->addCell($coluSeparador)->addText("  ");
$tabla->addCell($coluAncho2)->addText("$anios años", $fuenteb);

$tabla->addRow($filaAlto, [ "exactHeight" => true ]);
$tabla->addCell($coluAncho)->addText("HABER INDEMNIZABLE", $fuente);
$tabla->addCell($coluSeparador)->addText("  ");
$tabla->addCell($coluAncho2)->addText("S/.".nf($sueldo), $fuenteb);

$textRun = $seccion->addTextRun([ "alignment" => Jc::CENTER, "lineHeight" => 1, ]);
$textRun->addTextBreak(1);
$textRun->addText('L   I   Q   U   I   D   A   C   I   O   N', [ "color" => "000000", "bold" => true, "underline" => "single" ]);

$fuente = [ "color" => "000000", "bold" => true ];
$filaAlto = 300;
$coluAncho1 = 4000;
$coluAncho2 = 2000;
$coluSeparador = 400;

$tabla = $seccion->addTable();
$tabla->addRow($filaAlto, [ "exactHeight" => true ]);
$celda = $tabla->addCell($coluSeparador);
$textrun1 = $celda->addTextRun([ "alignment" => JcTable::END, "cellMarginRight" => 50 ]); 
$textrun1->addText(" 1.", $fuente);

$celda1 = $tabla->addCell($coluAncho1); 
$textrun1 = $celda1->addTextRun([ "alignment" => JcTable::START, "cellMarginRight" => 50 ]); 
$textrun1->addText("Tiempos de Servicios ", $fuente);
$textrun1->addText($anios, $fuenteb);
$textrun1->addText(" X ", $fuente);
$textrun1->addText("S/.".nf($sueldo), $fuenteb);
$celda2 = $tabla->addCell($coluAncho2); 
$textrun1 = $celda2->addTextRun([ "alignment" => JcTable::END, "cellMarginRight" => 50 ]); 
$textrun1->addText("S/.".nf($totalpago), $fuenteb);

$tabla1 = $seccion->addTable();
$tabla1->addRow($filaAlto, [ "exactHeight" => true ]);
$tabla1->addCell($coluSeparador)->addText(" ", $fuente);
$celda1 = $tabla1->addCell($coluAncho1); 
$textrun1 = $celda1->addTextRun([ "alignment" => JcTable::START, "cellMarginRight" => 50 ]); 
$textrun1->addText("Descuento ", $fuenteb);
$celda2 = $tabla1->addCell($coluAncho2); 
$textrun1 = $celda2->addTextRun([ "alignment" => JcTable::END, "cellMarginRight" => 50 ]); 
$textrun1->addText("S/.0.00", $fuenteb);
$celda3 = $tabla1->addCell(2500); 
$textrun1 = $celda3->addTextRun([ "alignment" => JcTable::END, "cellMarginRight" => 50 ]); 
$textrun1->addText("S/.0.00", $fuenteb);

$textRun = $seccion->addTextRun([ "alignment" => Jc::CENTER, "lineHeight" => 1, ]);
// $textRun->addTextBreak(1);

/* Tabla de Adicionales */
$filaAlto = 250;
$colAncho0 = 500;
$colAncho1 = 6000;
$colAncho2 = 2000;

$styleTable = array('borderBottomSize' => 15, 'borderBottomColor' => '000000', "cellSpacing" => 0);
$documento->addTableStyle('adicionales', $styleTable);
$tabla = $seccion->addTable('adicionales');

if ($tretencion && $añofin >= 1980) {
    $tabla->addRow($filaAlto, [ "exactHeight" => true ]);

    $celda1 = $tabla->addCell(400); 
    $textrun1 = $celda1->addTextRun([ "alignment" => JcTable::END ]); 
    $textrun1->addText('2.', $fuente);
    
    $celda2 = $tabla->addCell($colAncho1);
    $textrun1 = $celda2->addTextRun([ "alignment" => JcTable::START ]); 
    $textrun1->addText("  Retención:", $fuente);

    $celda3 = $tabla->addCell($colAncho2); 
    $textrun1 = $celda3->addTextRun([ "alignment" => JcTable::END ]); 
    $textrun1->addText("(S/.".nf($tretencion).")", $fuenteb);

    $celda4 = $tabla->addCell($colAncho2); 
    $textrun1 = $celda4->addTextRun([ "alignment" => JcTable::END ]); 
    $textrun1->addText(" ", $fuenteb);
}
if ($adelanto) {
    $tabla->addRow($filaAlto, [ "exactHeight" => true ]);
    $celda1 = $tabla->addCell(400); $textrun1 = $celda1->addTextRun([ "alignment" => JcTable::END, "cellMarginRight" => 50 ]); $textrun1->addText('3.', $fuente);
    $tabla->addCell($colAncho1)->addText("  Adelanto:", $fuente);
    $celda1 = $tabla->addCell($colAncho2); $textrun1 = $celda1->addTextRun([ "alignment" => JcTable::END, "cellMarginRight" => 50 ]); $textrun1->addText("(S/.".nf($adelanto).")", $fuenteb);
    $celda1 = $tabla->addCell($colAncho2); $textrun1 = $celda1->addTextRun([ "alignment" => JcTable::END, "cellMarginRight" => 50 ]); $textrun1->addText(" ", $fuenteb);
}
if ($vacaciones) {
    $tabla->addRow($filaAlto, [ "exactHeight" => true ]);
    $celda1 = $tabla->addCell(400); $textrun1 = $celda1->addTextRun([ "alignment" => JcTable::END, "cellMarginRight" => 50 ]); $textrun1->addText('4.', $fuente);
    $tabla->addCell($colAncho1)->addText("  Vacaciones:", $fuente);
    $celda1 = $tabla->addCell($colAncho2); $textrun1 = $celda1->addTextRun([ "alignment" => JcTable::END, "cellMarginRight" => 50 ]); $textrun1->addText("", $fuenteb);
    $celda1 = $tabla->addCell($colAncho2); $textrun1 = $celda1->addTextRun([ "alignment" => JcTable::END, "cellMarginRight" => 50 ]); $textrun1->addText("S/.".nf($vacaciones), $fuenteb);
}
if ($gratificaciones) {
    $tabla->addRow($filaAlto, [ "exactHeight" => true ]);
    $celda1 = $tabla->addCell(400); $textrun1 = $celda1->addTextRun([ "alignment" => JcTable::END, "cellMarginRight" => 50 ]); $textrun1->addText('5.', $fuente);
    $tabla->addCell($colAncho1)->addText("  Gratificaciones:", $fuente);
    $celda1 = $tabla->addCell($colAncho2); $textrun1 = $celda1->addTextRun([ "alignment" => JcTable::END, "cellMarginRight" => 50 ]); $textrun1->addText("", $fuenteb);
    $celda1 = $tabla->addCell($colAncho2); $textrun1 = $celda1->addTextRun([ "alignment" => JcTable::END, "cellMarginRight" => 50 ]); $textrun1->addText("S/.".nf($gratificaciones), $fuenteb);
}
if ($reintegro) {
    $tabla->addRow($filaAlto, [ "exactHeight" => true ]);
    $celda1 = $tabla->addCell(400); $textrun1 = $celda1->addTextRun([ "alignment" => JcTable::END, "cellMarginRight" => 50 ]); $textrun1->addText('6.', $fuente);
    $tabla->addCell($colAncho1)->addText("  Reintegro:", $fuente);
    $celda1 = $tabla->addCell($colAncho2); $textrun1 = $celda1->addTextRun([ "alignment" => JcTable::END, "cellMarginRight" => 50 ]); $textrun1->addText("", $fuenteb);
    $celda1 = $tabla->addCell($colAncho2); $textrun1 = $celda1->addTextRun([ "alignment" => JcTable::END, "cellMarginRight" => 50 ]); $textrun1->addText("S/.".nf($reintegro), $fuenteb);
}
if ($incentivo) {
    $tabla->addRow($filaAlto, [ "exactHeight" => true ]);
    $celda1 = $tabla->addCell(400); $textrun1 = $celda1->addTextRun([ "alignment" => JcTable::END, "cellMarginRight" => 50 ]); $textrun1->addText('7.', $fuente);
    $tabla->addCell($colAncho1)->addText("  Incentivo:", $fuente);
    $celda1 = $tabla->addCell($colAncho2); $textrun1 = $celda1->addTextRun([ "alignment" => JcTable::END, "cellMarginRight" => 50 ]); $textrun1->addText("", $fuenteb);
    $celda1 = $tabla->addCell($colAncho2); $textrun1 = $celda1->addTextRun([ "alignment" => JcTable::END, "cellMarginRight" => 50 ]); $textrun1->addText("S/.".nf($incentivo), $fuenteb);
}
if ($bonificacion) {
    $tabla->addRow($filaAlto, [ "exactHeight" => true ]);
    $celda1 = $tabla->addCell(400); $textrun1 = $celda1->addTextRun([ "alignment" => JcTable::END, "cellMarginRight" => 50 ]); $textrun1->addText('8.', $fuente);
    $tabla->addCell($colAncho1)->addText("  Bonificación:", $fuente);
    $celda1 = $tabla->addCell($colAncho2); $textrun1 = $celda1->addTextRun([ "alignment" => JcTable::END, "cellMarginRight" => 50 ]); $textrun1->addText("", $fuenteb);
    $celda1 = $tabla->addCell($colAncho2); $textrun1 = $celda1->addTextRun([ "alignment" => JcTable::END, "cellMarginRight" => 50 ]); $textrun1->addText("S/.".nf($bonificacion), $fuenteb);
}
if ($bonificacion_graciosa) {
    $tabla->addRow($filaAlto, [ "exactHeight" => true ]);
    $celda1 = $tabla->addCell(400); $textrun1 = $celda1->addTextRun([ "alignment" => JcTable::END, "cellMarginRight" => 50 ]); $textrun1->addText('9.', $fuente);
    $tabla->addCell($colAncho1)->addText("  Bonificación Graciosa:", $fuente);
    $celda1 = $tabla->addCell($colAncho2); $textrun1 = $celda1->addTextRun([ "alignment" => JcTable::END, "cellMarginRight" => 50 ]); $textrun1->addText("", $fuenteb);
    $celda1 = $tabla->addCell($colAncho2); $textrun1 = $celda1->addTextRun([ "alignment" => JcTable::END, "cellMarginRight" => 50 ]); $textrun1->addText("S/.".nf($bonificacion_graciosa), $fuenteb);
}
if ($bonificacion_extraordinaria) {
    $tabla->addRow($filaAlto, [ "exactHeight" => true ]);
    $celda1 = $tabla->addCell(400); $textrun1 = $celda1->addTextRun([ "alignment" => JcTable::END, "cellMarginRight" => 50 ]); $textrun1->addText('10.', $fuente);
    $tabla->addCell($colAncho1)->addText("  Bonificación Extraordinaria:", $fuente);
    $celda1 = $tabla->addCell($colAncho2); $textrun1 = $celda1->addTextRun([ "alignment" => JcTable::END, "cellMarginRight" => 50 ]); $textrun1->addText("", $fuenteb);
    $celda1 = $tabla->addCell($colAncho2); $textrun1 = $celda1->addTextRun([ "alignment" => JcTable::END, "cellMarginRight" => 50 ]); $textrun1->addText("S/.".nf($bonificacion_extraordinaria), $fuenteb);
}

/* Tabla de Totales */
$tabla = $seccion->addTable();

$tabla->addRow($filaAlto);
$celda1 = $tabla->addCell(400); $textrun1 = $celda1->addTextRun([ "alignment" => JcTable::END, "cellMarginRight" => 50 ]); $textrun1->addText(' ');
$tabla->addCell($colAncho1)->addText("  Totales:", $fuente);
$celda1 = $tabla->addCell($colAncho2); $textrun1 = $celda1->addTextRun([ "alignment" => JcTable::END, "cellMarginRight" => 50 ]); $textrun1->addText("");
$celda1 = $tabla->addCell($colAncho2); $textrun1 = $celda1->addTextRun([ "alignment" => JcTable::END, "cellMarginRight" => 50 ]); $textrun1->addText("S/. ".nf($total_deven-($total_deduc+$tretencion)), $fuenteb);

$textRun = $seccion->addTextRun([ "alignment" => Jc::START, "lineHeight" => 1, ]);
// $textRun->addTextBreak(1);
$textRun->addText('Ret. Leyes Sociales', [ "color" => "000000", "bold" => true, "underline" => "single" ]);

$filaAlto = 300;
$coluAncho1 = 1500;
$coluAncho2 = 2500;
$coluSeparador = 400;

$fuentebs = [ "color" => "000000", "bold" => true, "underline" => "single" ];
$tablaTitulo = [ "alignment" => JcTable::CENTER, "cellMarginRight" => 50 ] ;
$tablaTotal  = [ "alignment" => JcTable::END   , "cellMarginRight" => 50 ] ;

$tabla = $seccion->addTable();
$tabla->addRow($filaAlto, [ "exactHeight" => true ]);
$celda = $tabla->addCell($coluAncho1); $textrun1 = $celda->addTextRun($tablaTitulo); $textrun1->addText("EMPRESA", $fuentebs);
$celda = $tabla->addCell($coluAncho1); $textrun1 = $celda->addTextRun($tablaTitulo); $textrun1->addText("", $fuente);
$celda = $tabla->addCell($coluAncho1); $textrun1 = $celda->addTextRun($tablaTitulo); $textrun1->addText("TRABAJADOR", $fuentebs);

$tabla = $seccion->addTable();
$tabla->addRow($filaAlto, [ "exactHeight" => true ]);
$celda = $tabla->addCell($coluAncho1); $textrun1 = $celda->addTextRun($tablaTitulo); $textrun1->addText(nf($empipss)."=", $fuenteb);
$celda = $tabla->addCell($coluAncho1); $textrun1 = $celda->addTextRun($tablaTitulo); $textrun1->addText("S.S.E.", $fuenteb);
$celda = $tabla->addCell($coluAncho1); $textrun1 = $celda->addTextRun($tablaTitulo); $textrun1->addText(nf($traipss)."=", $fuenteb);

$tabla = $seccion->addTable();
$tabla->addRow($filaAlto, [ "exactHeight" => true ]);
$celda = $tabla->addCell($coluAncho1); $textrun1 = $celda->addTextRun($tablaTitulo); $textrun1->addText(nf($empsnp)."=", $fuenteb);
$celda = $tabla->addCell($coluAncho1); $textrun1 = $celda->addTextRun($tablaTitulo); $textrun1->addText("S.N.P.", $fuenteb);
$celda = $tabla->addCell($coluAncho1); $textrun1 = $celda->addTextRun($tablaTitulo); $textrun1->addText(nf($trasnp)."=", $fuenteb);

$tabla = $seccion->addTable();
$tabla->addRow($filaAlto, [ "exactHeight" => true ]);
$celda = $tabla->addCell($coluAncho1); $textrun1 = $celda->addTextRun($tablaTitulo); $textrun1->addText(nf($empfonavi)."=", $fuenteb);
$celda = $tabla->addCell($coluAncho1); $textrun1 = $celda->addTextRun($tablaTitulo); $textrun1->addText("FONAVI", $fuenteb);
$celda = $tabla->addCell($coluAncho1); $textrun1 = $celda->addTextRun($tablaTitulo); $textrun1->addText(nf($trafonavi)."=", $fuenteb);
$celda = $tabla->addCell($coluAncho2); $textrun1 = $celda->addTextRun($tablaTotal); $textrun1->addText("(".nf($tratotaldeduc).")", $fuenteb);
$celda = $tabla->addCell($coluAncho2); $textrun1 = $celda->addTextRun($tablaTotal); $textrun1->addText(nf($totalapagar), $fuenteb);

$textRun = $seccion->addTextRun([ "alignment" => Jc::START, "lineHeight" => 1, ]);

$filaAlto = 300;
$coluAncho1 = 7000;
$coluAncho2 = 2500;
$coluSeparador = 400;

$fuentebs = [ "color" => "000000", "bold" => true, "underline" => "single" ];
$tablaTitulo = [ "alignment" => JcTable::CENTER, "cellMarginRight" => 50 ] ;
$tablaContenido = [ "alignment" => JcTable::START, "cellMarginRight" => 50 ] ;
$tablaTotal  = [ "alignment" => JcTable::END   , "cellMarginRight" => 50 ] ;

$tabla = $seccion->addTable();
$tabla->addRow($filaAlto, [ "exactHeight" => true ]);
$celda = $tabla->addCell($coluSeparador); $textrun1 = $celda->addTextRun($tablaContenido); $textrun1->addText("3.", $fuente);
$celda = $tabla->addCell($coluAncho1); $textrun1 = $celda->addTextRun($tablaContenido); $textrun1->addText("TOTAL A LIQUIDAR ...........................................................................................", $fuente);
$celda = $tabla->addCell($coluAncho2); $textrun1 = $celda->addTextRun($tablaTotal); $textrun1->addText(nf($totalapagar)."=", $fuente);

$textRun = $seccion->addTextRun([ "alignment" => Jc::START, "lineHeight" => 1, ]);
$textRun->addTextBreak(1);
$textRun->addText('Al firmar la presente liquidación dejo constancia expresa que los señores de ', $fuente);
$textRun->addText($_POST['empresa'], $fuenteb);
$textRun->addText(' han cumplido con abonarme todos los beneficios sociales conforme a Ley, por tanto, firmo dando por cancelado mi liquidación.', $fuente);
$textRun->addTextBreak(5);

$fuente = [ "color" => "000000", "bold" => true ];
$filaAlto = 150;
$coluAncho1 = 5000;
$coluAncho2 = 5000;
$coluSeparador = 500;

$styleTable = array("cellSpacing" => 0);
$documento->addTableStyle('firmas', $styleTable);
$tabla = $seccion->addTable('firmas');

$tabla->addRow();
$celda1 = $tabla->addCell($coluAncho1); 
$textrun1 = $celda1->addTextRun([ "alignment" => JcTable::CENTER, "cellMarginRight" => 50 ]); 
$textrun1->addText("_______________________________", $fuente);

$celda2 = $tabla->addCell($coluAncho2); 
$textrun1 = $celda2->addTextRun([ "alignment" => JcTable::CENTER, "cellMarginRight" => 50 ]); 
$textrun1->addText("_______________________________", $fuente);

$tabla->addRow();
$celda1 = $tabla->addCell($coluAncho1); 
$textrun1 = $celda1->addTextRun([ "alignment" => JcTable::CENTER, "cellMarginRight" => 50 ]); 
$textrun1->addText($_POST['nombres']." ".$_POST['apellidos'], $fuenteb);

$celda2 = $tabla->addCell($coluAncho2); 
$textrun1 = $celda2->addTextRun([ "alignment" => JcTable::CENTER, "cellMarginRight" => 50 ]); 
$textrun1->addText("Gerencia", $fuente);

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
    <title>SisPen - Liquidación</title>
    <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="../css/estilos.min.css" media="all">
    <link rel="stylesheet" href="../css/impresion.min.css" media="print">
</head>
<body>
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
            
            <div class="" style="margin-top: 1.5em;" >
                <?php if ($tretencion)                   { echo "<div class='liq6272_ret'><div>2</div>     <div>Retención:</div>                   <div><strong class='resaltar'>(&nbsp;S/.",nf($tretencion)                   ," )</strong></div></div>"; } ?>
                <?php if ($adelanto)                    { echo "<div class='liq6272_ret'><div>3</div>      <div>Adelanto:</div>                    <div><strong class='resaltar'>(&nbsp;S/.",nf($adelanto)                    ," )</strong></div></div>"; } ?>
                <?php if ($vacaciones)                  { echo "<div class='liq6272_dev'><div>4</div>     <div>Vacaciones:</div>                  <div></div><div><strong class='resaltar'>&nbsp;S/." ,nf($vacaciones)                   ," </strong></div></div>"; } ?>
                <?php if ($gratificaciones)             { echo "<div class='liq6272_dev'><div>5</div>    <div>Gratificaciones:</div>             <div></div><div><strong class='resaltar'>&nbsp;S/." ,nf($gratificaciones)              ," </strong></div></div>"; } ?>
                <?php if ($reintegro)                   { echo "<div class='liq6272_dev'><div>6</div>   <div>Reintegro:</div>                   <div></div><div><strong class='resaltar'>&nbsp;S/." ,nf($reintegro)                   ,"  </strong></div></div>"; } ?>
                <?php if ($incentivo)                   { echo "<div class='liq6272_dev'><div>7</div>     <div>Incentivo:</div>                   <div></div><div><strong class='resaltar'>&nbsp;S/." ,nf($incentivo)                   ,"  </strong></div></div>"; } ?>
                <?php if ($bonificacion)                { echo "<div class='liq6272_dev'><div>8</div>      <div>Bonificación:</div>                <div></div><div><strong class='resaltar'>&nbsp;S/." ,nf($bonificacion)                ,"  </strong></div></div>"; } ?>
                <?php if ($bonificacion_graciosa)       { echo "<div class='liq6272_dev'><div>9</div>     <div>Bonificación Graciosa:</div>       <div></div><div><strong class='resaltar'>&nbsp;S/." ,nf($bonificacion_graciosa)       ,"  </strong></div></div>"; } ?>
                <?php if ($bonificacion_extraordinaria) { echo "<div class='liq6272_dev'><div>10</div>    <div>Bonificación Extraordinaria:</div> <div></div><div><strong class='resaltar'>&nbsp;S/." ,nf($bonificacion_extraordinaria) ,"  </strong></div></div>"; } ?>
            </div>
            <div class="" style="margin-top: 1.5em;border-top: 1px solid black; margin-bottom: 1.5em;" >
                <?php if ($total_deduc && $total_deven) { echo "<div class='liq6272_total'><div></div>     <div>Total:</div>                       <div></div><div><strong class='resaltar'>&nbsp;S/.",nf($total_deven-($total_deduc+$tretencion)),"</strong></div></div>"; } ?>
            </div>

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