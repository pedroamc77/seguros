<?php 

require_once('../_db/nomina.php');

// echo $_POST['fechaboleta']."-01","<br>","\n";
// echo $_POST['fsueldo'],"<br>","\n";

$fechaBoleta = isset($_POST['fechaboleta']) ? str_replace("-","/",$_POST['fechaboleta']) : '';

$fBoleta = date_create($_POST['fechaboleta']);
$mesboleta = $meses[$fBoleta->format("n")];
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
$total_deven = $sueldo+$remvaca+$reintegro+$hextras+$bonificacion;
// $total_deven = $sueldo+$remvaca+$reintegro+$hextras+$bonificacion+$otrosdeven;

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
use PhpOffice\PhpWord\Style\Language;
$documento = new \PhpOffice\PhpWord\PhpWord();
$documento->setDefaultFontName('Calibri');
$documento->setDefaultFontSize(10);
$propiedades = $documento->getDocInfo();
$propiedades->setCreator("iBritek <www.ibritek.com>");
$propiedades->setTitle("Certificado_95_00");

$seccion = $documento->addSection([ 'marginTop' => 800, "vAlign" => VerticalJc::CENTER ]);

$fuente  = [ "color" => "000000", "bold" => true ];
$fuentea = [ "color" => "ff0000", ];
$fuenteb = [ "color" => "ff0000", "bold" => true ];
$fuentec = [ "color" => "ff0000", "bold" => true, "alignment" => Jc::START ];

$filaAltoA  = 300;
$coluSeparador = 200;
$filaAltoB  = 350;
$coluAncho1 = 2000;
$coluAncho2 = 7000;
$coluAncho3 = 2500;
$coluAncho4 = 2000;
$coluAncho5 = 2500;
$coluAncho6 = 4500;
$coluAncho7 = 1500;
$coluAncho8 = 3000;
$coluAncho9 = 1000;

$filaEstiloA  = [ "exactHeight" => true ]; 
$celdaEstiloA = [ "borderBottomSize" => 0, "borderBottomColor" => "000000", "gridSpan" => 3 ]; 
$celdaEstiloB = [ "borderBottomSize" => 0, "borderBottomColor" => "000000" ]; 
$celdaEstiloC = [ 
    "borderTopSize"     => 0, 
    "borderLeftSize"    => 0, 
    "borderBottomSize"  => 0, 
    "borderRightSize"   => 0, 
    "borderTopColor"    => "000000", 
    "borderLeftColor"   => "000000", 
    "borderBottomColor" => "000000", 
    "borderRightColor"  => "000000", 
    "valign"            => "center", 
    "gridSpan"          => 2, 
]; 
$celdaEstiloD = [ 
    "borderTopSize"     => 0, 
    "borderLeftSize"    => 0, 
    "borderBottomSize"  => 0, 
    "borderRightSize"   => 0, 
    "borderTopColor"    => "000000", 
    "borderLeftColor"   => "000000", 
    "borderBottomColor" => "000000", 
    "borderRightColor"  => "000000", 
    "valign"            => "center", 
    "gridSpan"          => 4, 
]; 
$celdaEstiloE = [ 
    "borderLeftSize"    => 0, 
    "borderLeftColor"   => "000000", 
    "valign"            => "center", 
]; 
$celdaEstiloF = [ 
    "borderRightSize"    => 0, 
    "borderRightColor"   => "000000", 
    "valign"            => "center", 
]; 
$celdaEstiloG = [ 
    "borderTopSize"     => 0, 
    "borderLeftSize"    => 0, 
    "borderBottomSize"  => 0, 
    "borderRightSize"   => 0, 
    "borderTopColor"    => "000000", 
    "borderLeftColor"   => "000000", 
    "borderBottomColor" => "000000", 
    "borderRightColor"  => "000000", 
    "valign"            => "center", 
    "gridSpan"          => 2, 
]; 
$celdaEstiloH = [ 
    "borderTopSize"     => 0, 
    "borderLeftSize"    => 0, 
    "borderBottomSize"  => 0, 
    "borderRightSize"   => 0, 
    "borderTopColor"    => "000000", 
    "borderLeftColor"   => "000000", 
    "borderBottomColor" => "000000", 
    "borderRightColor"  => "000000", 
    "valign"            => "center", 
    "gridSpan"          => 4, 
]; 

$celdaSTART    = [ "alignment" => JcTable::START,   "lineHeight" => -1.3, ]; 
$celdaCENTER   = [ "alignment" => JcTable::CENTER,  "lineHeight" => -1.3, ]; 
$celdaEND      = [ "alignment" => JcTable::END,     "lineHeight" => -1.3, ]; 

$tabla = $seccion->addTable();
$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho1);                $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("Datos De La Empresa:", $fuente);
$celda2 = $tabla->addCell($coluAncho2, $celdaEstiloA); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText($_POST['empresa'], $fuente);
$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho1);                $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("Razon Social:", $fuente);
$celda2 = $tabla->addCell($coluAncho2, $celdaEstiloA); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText("", $fuente);
$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho1);                $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("Reg. Patronal:", $fuente);
$celda2 = $tabla->addCell($coluAncho3, $celdaEstiloB); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText("", $fuente);
$celda3 = $tabla->addCell($coluAncho4); $textrun1 = $celda3->addTextRun($celdaEND);   $textrun1->addText("Lib. Trib.:", $fuente);
$celda4 = $tabla->addCell($coluAncho5, $celdaEstiloB); $textrun1 = $celda4->addTextRun($celdaSTART); $textrun1->addText("", $fuente);
$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho1);                $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("Datos Del Trabajador:", $fuente);
$celda2 = $tabla->addCell($coluAncho2, $celdaEstiloA); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText("", $fuente);
$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho1);                $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("Apellidos Y Nombres:", $fuente);
$celda2 = $tabla->addCell($coluAncho2, $celdaEstiloA); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText($_POST['apellidos'].", ".$_POST['nombres'], $fuente);
$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho1);                $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("Cotag. Ocupación:", $fuente);
$celda2 = $tabla->addCell($coluAncho3, $celdaEstiloB); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText("", $fuente);
$celda3 = $tabla->addCell($coluAncho4); $textrun1 = $celda3->addTextRun($celdaEND);   $textrun1->addText("Fecha De Ingreso:", $fuente);
$celda4 = $tabla->addCell($coluAncho5, $celdaEstiloB); $textrun1 = $celda4->addTextRun($celdaSTART); $textrun1->addText($_POST['f_a'], $fuente);
$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho1);                $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("N° Seguro Social: ", $fuente);
$celda2 = $tabla->addCell($coluAncho3, $celdaEstiloB); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText("", $fuente);
$celda3 = $tabla->addCell($coluAncho4); $textrun1 = $celda3->addTextRun($celdaEND);   $textrun1->addText("L.E.I.:", $fuente);
$celda4 = $tabla->addCell($coluAncho5, $celdaEstiloB); $textrun1 = $celda4->addTextRun($celdaSTART); $textrun1->addText("", $fuente);

$textRun = $seccion->addTextRun();

$tabla = $seccion->addTable();
$tabla->addRow($filaAltoB, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho6, $celdaEstiloC); $textrun1 = $celda1->addTextRun($celdaCENTER); $textrun1->addText("", $fuente);
$celda2 = $tabla->addCell($coluAncho6, $celdaEstiloD); $textrun1 = $celda2->addTextRun($celdaCENTER); $textrun1->addText("DESCUENTOS", $fuente);

$tabla->addRow($filaAltoB, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho7, $celdaEstiloE); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText(" Mes De", $fuente);
$celda2 = $tabla->addCell($coluAncho8); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText(":  ".$mesboleta, $fuente);
$celda3 = $tabla->addCell($coluAncho7, $celdaEstiloE); $textrun1 = $celda3->addTextRun($celdaSTART); $textrun1->addText(" ", $fuente);
$celda4 = $tabla->addCell($coluAncho9); $textrun1 = $celda4->addTextRun($celdaCENTER); $textrun1->addText("Trabajador", $fuente);
$celda5 = $tabla->addCell($coluAncho9); $textrun1 = $celda5->addTextRun($celdaCENTER); $textrun1->addText("Empleador", $fuente);
$celda6 = $tabla->addCell($coluAncho9, $celdaEstiloF); $textrun1 = $celda6->addTextRun($celdaCENTER); $textrun1->addText("Total", $fuente);

$tabla->addRow($filaAltoB, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho7, $celdaEstiloE); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText(" Semana", $fuente);
$celda2 = $tabla->addCell($coluAncho8); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText(":  ".$semboleta, $fuente);
$celda3 = $tabla->addCell($coluAncho7, $celdaEstiloE); $textrun1 = $celda3->addTextRun($celdaSTART); $textrun1->addText(" Sist. Nac. Pen.", $fuente);
$celda4 = $tabla->addCell($coluAncho9); $textrun1 = $celda4->addTextRun($celdaCENTER); $textrun1->addText(nf($trasnp), $fuente);
$celda5 = $tabla->addCell($coluAncho9); $textrun1 = $celda5->addTextRun($celdaCENTER); $textrun1->addText(nf($empsnp), $fuente);
$celda6 = $tabla->addCell($coluAncho9, $celdaEstiloF); $textrun1 = $celda6->addTextRun($celdaCENTER); $textrun1->addText(nf($trasnp+$empsnp), $fuente);

$tabla->addRow($filaAltoB, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho7, $celdaEstiloE); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText(" Haber Mensual", $fuente);
$celda2 = $tabla->addCell($coluAncho8); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText(":  ".nf($sueldo), $fuente);
$celda3 = $tabla->addCell($coluAncho7, $celdaEstiloE); $textrun1 = $celda3->addTextRun($celdaSTART); $textrun1->addText(" Seguro Social", $fuente);
$celda4 = $tabla->addCell($coluAncho9); $textrun1 = $celda4->addTextRun($celdaCENTER); $textrun1->addText(nf($traipss), $fuente);
$celda5 = $tabla->addCell($coluAncho9); $textrun1 = $celda5->addTextRun($celdaCENTER); $textrun1->addText(nf($empipss), $fuente);
$celda6 = $tabla->addCell($coluAncho9, $celdaEstiloF); $textrun1 = $celda6->addTextRun($celdaCENTER); $textrun1->addText(nf($traipss+$empipss), $fuente);

$tabla->addRow($filaAltoB, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho7, $celdaEstiloE); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText(" Jornel", $fuente);
$celda2 = $tabla->addCell($coluAncho8); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText(":  ", $fuente);
$celda3 = $tabla->addCell($coluAncho7, $celdaEstiloE); $textrun1 = $celda3->addTextRun($celdaSTART); $textrun1->addText(" I.R.F.", $fuente);
$celda4 = $tabla->addCell($coluAncho9); $textrun1 = $celda4->addTextRun($celdaCENTER); $textrun1->addText(" ", $fuente);
$celda5 = $tabla->addCell($coluAncho9); $textrun1 = $celda5->addTextRun($celdaCENTER); $textrun1->addText(" ", $fuente);
$celda6 = $tabla->addCell($coluAncho9, $celdaEstiloF); $textrun1 = $celda6->addTextRun($celdaCENTER); $textrun1->addText(" ", $fuente);

$tabla->addRow($filaAltoB, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho7, $celdaEstiloE); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText(" Hra. Trab. Dias:", $fuente);
$celda2 = $tabla->addCell($coluAncho8); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText(":  ", $fuente);
$celda3 = $tabla->addCell($coluAncho7, $celdaEstiloE); $textrun1 = $celda3->addTextRun($celdaSTART); $textrun1->addText(" FONAVIS", $fuente);
$celda4 = $tabla->addCell($coluAncho9); $textrun1 = $celda4->addTextRun($celdaCENTER); $textrun1->addText(nf($trafonavi), $fuente);
$celda5 = $tabla->addCell($coluAncho9); $textrun1 = $celda5->addTextRun($celdaCENTER); $textrun1->addText(nf($empfonavi), $fuente);
$celda6 = $tabla->addCell($coluAncho9, $celdaEstiloF); $textrun1 = $celda6->addTextRun($celdaCENTER); $textrun1->addText(nf($trafonavi+$empfonavi), $fuente);

$tabla->addRow($filaAltoB, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho7, $celdaEstiloE); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText(" Dominical", $fuente);
$celda2 = $tabla->addCell($coluAncho8); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText(":  ", $fuente);
$celda3 = $tabla->addCell($coluAncho7, $celdaEstiloE); $textrun1 = $celda3->addTextRun($celdaSTART); $textrun1->addText(" Comisión Porcent.", $fuente);
$celda4 = $tabla->addCell($coluAncho9); $textrun1 = $celda4->addTextRun($celdaCENTER); $textrun1->addText(" ", $fuente);
$celda5 = $tabla->addCell($coluAncho9); $textrun1 = $celda5->addTextRun($celdaCENTER); $textrun1->addText(" ", $fuente);
$celda6 = $tabla->addCell($coluAncho9, $celdaEstiloF); $textrun1 = $celda6->addTextRun($celdaCENTER); $textrun1->addText(" ", $fuente);

$tabla->addRow($filaAltoB, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho7, $celdaEstiloE); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText(" Horas Estras", $fuente);
$celda2 = $tabla->addCell($coluAncho8); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText(": ".nf($hextras), $fuente);
$celda3 = $tabla->addCell($coluAncho7, $celdaEstiloE); $textrun1 = $celda3->addTextRun($celdaSTART); $textrun1->addText(" Asoc. De Trabajo", $fuente);
$celda4 = $tabla->addCell($coluAncho9); $textrun1 = $celda4->addTextRun($celdaCENTER); $textrun1->addText(" ", $fuente);
$celda5 = $tabla->addCell($coluAncho9); $textrun1 = $celda5->addTextRun($celdaCENTER); $textrun1->addText(" ", $fuente);
$celda6 = $tabla->addCell($coluAncho9, $celdaEstiloF); $textrun1 = $celda6->addTextRun($celdaCENTER); $textrun1->addText(" ", $fuente);

$tabla->addRow($filaAltoB, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho7, $celdaEstiloE); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText(" Asig. Familiar", $fuente);
$celda2 = $tabla->addCell($coluAncho8); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText(":  ", $fuente);
$celda3 = $tabla->addCell($coluAncho7, $celdaEstiloE); $textrun1 = $celda3->addTextRun($celdaSTART); $textrun1->addText(" ", $fuente);
$celda4 = $tabla->addCell($coluAncho9); $textrun1 = $celda4->addTextRun($celdaCENTER); $textrun1->addText(" ", $fuente);
$celda5 = $tabla->addCell($coluAncho9); $textrun1 = $celda5->addTextRun($celdaCENTER); $textrun1->addText(" ", $fuente);
$celda6 = $tabla->addCell($coluAncho9, $celdaEstiloF); $textrun1 = $celda6->addTextRun($celdaCENTER); $textrun1->addText(" ", $fuente);

$tabla->addRow($filaAltoB, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho7, $celdaEstiloE); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText(" Part. Utilidades", $fuente);
$celda2 = $tabla->addCell($coluAncho8); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText(":  ", $fuente);
$celda3 = $tabla->addCell($coluAncho7, $celdaEstiloE); $textrun1 = $celda3->addTextRun($celdaSTART); $textrun1->addText(" ", $fuente);
$celda4 = $tabla->addCell($coluAncho9); $textrun1 = $celda4->addTextRun($celdaCENTER); $textrun1->addText(" ", $fuente);
$celda5 = $tabla->addCell($coluAncho9); $textrun1 = $celda5->addTextRun($celdaCENTER); $textrun1->addText(" ", $fuente);
$celda6 = $tabla->addCell($coluAncho9, $celdaEstiloF); $textrun1 = $celda6->addTextRun($celdaCENTER); $textrun1->addText(" ", $fuente);

$tabla->addRow($filaAltoB, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho7, $celdaEstiloE); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText(" Fortadoa", $fuente);
$celda2 = $tabla->addCell($coluAncho8); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText(":  ", $fuente);
$celda3 = $tabla->addCell($coluAncho7, $celdaEstiloE); $textrun1 = $celda3->addTextRun($celdaSTART); $textrun1->addText(" ", $fuente);
$celda4 = $tabla->addCell($coluAncho9); $textrun1 = $celda4->addTextRun($celdaCENTER); $textrun1->addText(" ", $fuente);
$celda5 = $tabla->addCell($coluAncho9); $textrun1 = $celda5->addTextRun($celdaCENTER); $textrun1->addText(" ", $fuente);
$celda6 = $tabla->addCell($coluAncho9, $celdaEstiloF); $textrun1 = $celda6->addTextRun($celdaCENTER); $textrun1->addText(" ", $fuente);

$tabla->addRow($filaAltoB, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho7, $celdaEstiloE); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText(" Bonificaciones", $fuente);
$celda2 = $tabla->addCell($coluAncho8); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText(": ".nf($bonificacion), $fuente);
$celda3 = $tabla->addCell($coluAncho7, $celdaEstiloE); $textrun1 = $celda3->addTextRun($celdaSTART); $textrun1->addText(" ", $fuente);
$celda4 = $tabla->addCell($coluAncho9); $textrun1 = $celda4->addTextRun($celdaCENTER); $textrun1->addText(" ", $fuente);
$celda5 = $tabla->addCell($coluAncho9); $textrun1 = $celda5->addTextRun($celdaCENTER); $textrun1->addText(" ", $fuente);
$celda6 = $tabla->addCell($coluAncho9, $celdaEstiloF); $textrun1 = $celda6->addTextRun($celdaCENTER); $textrun1->addText(" ", $fuente);

$tabla->addRow($filaAltoB, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho7, $celdaEstiloE); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText(" Reintegros", $fuente);
$celda2 = $tabla->addCell($coluAncho8); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText(": ".nf($reintegro), $fuente);
$celda3 = $tabla->addCell($coluAncho7, $celdaEstiloE); $textrun1 = $celda3->addTextRun($celdaSTART); $textrun1->addText(" ", $fuente);
$celda4 = $tabla->addCell($coluAncho9); $textrun1 = $celda4->addTextRun($celdaCENTER); $textrun1->addText(" ", $fuente);
$celda5 = $tabla->addCell($coluAncho9); $textrun1 = $celda5->addTextRun($celdaCENTER); $textrun1->addText(" ", $fuente);
$celda6 = $tabla->addCell($coluAncho9, $celdaEstiloF); $textrun1 = $celda6->addTextRun($celdaCENTER); $textrun1->addText(" ", $fuente);

$tabla->addRow($filaAltoB, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho7, $celdaEstiloE); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText(" Vacaciones", $fuente);
$celda2 = $tabla->addCell($coluAncho8); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText(": ".nf($remvaca), $fuente);
$celda3 = $tabla->addCell($coluAncho7, $celdaEstiloE); $textrun1 = $celda3->addTextRun($celdaSTART); $textrun1->addText(" ", $fuente);
$celda4 = $tabla->addCell($coluAncho9); $textrun1 = $celda4->addTextRun($celdaCENTER); $textrun1->addText(" ", $fuente);
$celda5 = $tabla->addCell($coluAncho9); $textrun1 = $celda5->addTextRun($celdaCENTER); $textrun1->addText(" ", $fuente);
$celda6 = $tabla->addCell($coluAncho9, $celdaEstiloF); $textrun1 = $celda6->addTextRun($celdaCENTER); $textrun1->addText(" ", $fuente);

$tabla->addRow($filaAltoB, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho7, $celdaEstiloE); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText(" Comisiones", $fuente);
$celda2 = $tabla->addCell($coluAncho8); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText(": ", $fuente);
$celda3 = $tabla->addCell($coluAncho7, $celdaEstiloE); $textrun1 = $celda3->addTextRun($celdaSTART); $textrun1->addText(" ", $fuente);
$celda4 = $tabla->addCell($coluAncho9); $textrun1 = $celda4->addTextRun($celdaCENTER); $textrun1->addText(" ", $fuente);
$celda5 = $tabla->addCell($coluAncho9); $textrun1 = $celda5->addTextRun($celdaCENTER); $textrun1->addText(" ", $fuente);
$celda6 = $tabla->addCell($coluAncho9, $celdaEstiloF); $textrun1 = $celda6->addTextRun($celdaCENTER); $textrun1->addText(" ", $fuente);

$tabla->addRow($filaAltoB, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho7, $celdaEstiloE); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText(" Destajos", $fuente);
$celda2 = $tabla->addCell($coluAncho8); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText(": ", $fuente);
$celda3 = $tabla->addCell($coluAncho7, $celdaEstiloE); $textrun1 = $celda3->addTextRun($celdaSTART); $textrun1->addText(" ", $fuente);
$celda4 = $tabla->addCell($coluAncho9); $textrun1 = $celda4->addTextRun($celdaCENTER); $textrun1->addText(" ", $fuente);
$celda5 = $tabla->addCell($coluAncho9); $textrun1 = $celda5->addTextRun($celdaCENTER); $textrun1->addText(" ", $fuente);
$celda6 = $tabla->addCell($coluAncho9, $celdaEstiloF); $textrun1 = $celda6->addTextRun($celdaCENTER); $textrun1->addText(" ", $fuente);

$tabla->addRow($filaAltoB, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho7, $celdaEstiloE); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText(" Anticipos", $fuente);
$celda2 = $tabla->addCell($coluAncho8); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText(": ", $fuente);
$celda3 = $tabla->addCell($coluAncho7, $celdaEstiloE); $textrun1 = $celda3->addTextRun($celdaSTART); $textrun1->addText(" ", $fuente);
$celda4 = $tabla->addCell($coluAncho9); $textrun1 = $celda4->addTextRun($celdaCENTER); $textrun1->addText(" ", $fuente);
$celda5 = $tabla->addCell($coluAncho9); $textrun1 = $celda5->addTextRun($celdaCENTER); $textrun1->addText(" ", $fuente);
$celda6 = $tabla->addCell($coluAncho9, $celdaEstiloF); $textrun1 = $celda6->addTextRun($celdaCENTER); $textrun1->addText(" ", $fuente);

$tabla->addRow($filaAltoB, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho7, $celdaEstiloE); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText(" ", $fuente);
$celda2 = $tabla->addCell($coluAncho8); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText(": ", $fuente);
$celda3 = $tabla->addCell($coluAncho7, $celdaEstiloE); $textrun1 = $celda3->addTextRun($celdaSTART); $textrun1->addText(" ", $fuente);
$celda4 = $tabla->addCell($coluAncho9); $textrun1 = $celda4->addTextRun($celdaCENTER); $textrun1->addText(" ", $fuente);
$celda5 = $tabla->addCell($coluAncho9); $textrun1 = $celda5->addTextRun($celdaCENTER); $textrun1->addText(" ", $fuente);
$celda6 = $tabla->addCell($coluAncho9, $celdaEstiloF); $textrun1 = $celda6->addTextRun($celdaCENTER); $textrun1->addText(" ", $fuente);

$tabla->addRow($filaAltoB, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho7, $celdaEstiloE); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText(" ", $fuente);
$celda2 = $tabla->addCell($coluAncho8); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText(": ", $fuente);
$celda3 = $tabla->addCell($coluAncho7, $celdaEstiloE); $textrun1 = $celda3->addTextRun($celdaSTART); $textrun1->addText(" ", $fuente);
$celda4 = $tabla->addCell($coluAncho9); $textrun1 = $celda4->addTextRun($celdaCENTER); $textrun1->addText(" ", $fuente);
$celda5 = $tabla->addCell($coluAncho9); $textrun1 = $celda5->addTextRun($celdaCENTER); $textrun1->addText(" ", $fuente);
$celda6 = $tabla->addCell($coluAncho9, $celdaEstiloF); $textrun1 = $celda6->addTextRun($celdaCENTER); $textrun1->addText(" ", $fuente);

$tabla->addRow($filaAltoB, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho7, $celdaEstiloE); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText(" ", $fuente);
$celda2 = $tabla->addCell($coluAncho8); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText(": ", $fuente);
$celda3 = $tabla->addCell($coluAncho7, $celdaEstiloE); $textrun1 = $celda3->addTextRun($celdaSTART); $textrun1->addText(" ", $fuente);
$celda4 = $tabla->addCell($coluAncho9); $textrun1 = $celda4->addTextRun($celdaCENTER); $textrun1->addText(" ", $fuente);
$celda5 = $tabla->addCell($coluAncho9); $textrun1 = $celda5->addTextRun($celdaCENTER); $textrun1->addText(" ", $fuente);
$celda6 = $tabla->addCell($coluAncho9, $celdaEstiloF); $textrun1 = $celda6->addTextRun($celdaCENTER); $textrun1->addText(" ", $fuente);

$tabla->addRow($filaAltoB, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho1, $celdaEstiloG); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText(" TOTAL HABER        : ".nf($total_deven), $fuente);
$celda2 = $tabla->addCell($coluAncho1, $celdaEstiloH); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText(" TOTAL DESCUENTO    : ".nf($tratotaldeduc), $fuente);

$textRun = $seccion->addTextRun([ "alignment" => Jc::END, "lineHeight" => 1, ]);
$textRun->addTextBreak(1);
$textRun->addText("Neto recibido: S/.".nf($total_deven-$tratotaldeduc), $fuente);
$textRun->addTextBreak(2);
$textRun->addText($_POST['dpto']." ".$_POST['f_b_b'], $fuente);
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