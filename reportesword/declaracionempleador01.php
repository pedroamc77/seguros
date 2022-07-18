<?php 

require_once('../_db/nomina.php');

if ( isset($_POST['cargo_al']) ) $cargo = $_POST['cargo_al'];
if ( isset($_POST['cargo_bl']) ) $cargo = $_POST['cargo_bl'];

$fechaini = date_create($_POST['f_a']);
$fechafin = date_create($_POST['f_b']);
$ff = date_create($_POST['f_b']);
$diferencia = date_diff($fechafin, $fechaini);


/* *************************************************************** */

$ruta = "../word/declaraciones/";
$nombre_archivo = "declaracion_".strtoupper($_POST['nombres'])."_".strtoupper($_POST['apellidos'])."_".$_POST['emision']."_.docx";

require_once "../vendor/autoload.php";
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\SimpleType\JcTable;
use PhpOffice\PhpWord\SimpleType\VerticalJc;
use PhpOffice\PhpWord\SimpleType\Border;
use PhpOffice\PhpWord\Style\Table;
use PhpOffice\PhpWord\Style\Language;
$documento = new \PhpOffice\PhpWord\PhpWord();
$documento->setDefaultFontName('Calibri');
$documento->setDefaultFontSize(10);
$propiedades = $documento->getDocInfo();
$propiedades->setCreator("iBritek <www.ibritek.com>");
$propiedades->setTitle("Certificado_95_00");

$seccion = $documento->addSection([ 'marginTop' => 800, "marginLeft" => 700, "marginRight" => 700, "vAlign" => VerticalJc::CENTER ]);

$fuente  = [ "size" => 14, "color" => "000000", "bold" => true ];
$textRun = $seccion->addTextRun([ "alignment" => Jc::CENTER, "lineHeight" => 1, ]);
$textRun->addText("DECLARACIÓN JURADA DEL", $fuente);
$textRun->addTextBreak(1);
$textRun->addText("EMPLEADOR", $fuente);
$textRun->addTextBreak(1);
$fuente  = [ "size" => 10, "color" => "000000", "bold" => true ];
$textRun->addText("(Supremo N° 054-07-Cf, Dano 1990)", $fuente);
$textRun->addTextBreak(1);
$textRun->addText("(Para Los Fines Señalados En La Segunda Disposición Final Y Transitoria Del Decreto)", $fuente);
$textRun->addTextBreak(1);

$fuente  = [ "color" => "000000", "bold" => true ];
$fuentea = [ "color" => "ff0000", ];
$fuenteb = [ "color" => "ff0000", "bold" => true ];
$fuentec = [ "color" => "ff0000", "bold" => true, "alignment" => Jc::START ];

$filaAltoA      = 300;
$filaAltoB      = 250;
$filaAltoC      = 1800;
$coluSeparador  = 200;
$coluAncho0     = 1500;
$coluAncho1     = 4400;
$coluAncho2     = 4200;
$coluAncho3     = 4800;

$colSTART   = [ "alignment" => JcTable::START];
$colCENTER  = [ "alignment" => JcTable::CENTER];
$colEND     = [ "alignment" => JcTable::END];

$filaEstiloA  = [ "exactHeight" => true ]; 
$celdaEstiloA = [ 
    "borderBottomColor" => "000000", 
    "borderBottomSize" => 0, 
    "borderBottomStyle" => Border::SINGLE, 
];
$celdaEstiloB = [ 
    "borderTopColor" => "000000", 
    "borderLeftColor" => "000000", 
    "borderBottomColor" => "000000", 
    "borderRightColor" => "000000", 
    "borderTopSize" => 0, 
    "borderLeftSize" => 0, 
    "borderBottomSize" => 0, 
    "borderRightSize" => 0, 
    "borderTopStyle" => Border::SINGLE, 
    "borderLeftStyle" => Border::SINGLE, 
    "borderBottomStyle" => Border::SINGLE, 
    "borderRightStyle" => Border::SINGLE, 
];

$tablaEstiloA = [ "cellSpacing" => 20 ];
$documento->addTableStyle("tablaA", $tablaEstiloA);

$tabla = $seccion->addTable("tablaA");
$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell(1600);                $textrun1 = $celda1->addTextRun($colSTART); $textrun1->addText("Por la presente, yo ", $fuente);
$celda2 = $tabla->addCell(5400, $celdaEstiloA); $textrun1 = $celda2->addTextRun($colSTART); $textrun1->addText("   ".$_POST['rep_legal'], $fuente);
$celda3 = $tabla->addCell(1500);                $textrun1 = $celda3->addTextRun($colSTART); $textrun1->addText(", identificado con", $fuente);
$celda4 = $tabla->addCell(2000, $celdaEstiloA); $textrun1 = $celda4->addTextRun($colSTART); $textrun1->addText("   ".$_POST['dni_a'], $fuente);

$tabla = $seccion->addTable("tablaA");
$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell(4200);                $textrun1 = $celda1->addTextRun($colSTART); $textrun1->addText("en calidad de Representante Legal de la Empresa ", $fuente);
$celda2 = $tabla->addCell(6300, $celdaEstiloA); $textrun1 = $celda2->addTextRun($colSTART); $textrun1->addText("   ".$_POST['empresa'], $fuente);

$tabla = $seccion->addTable("tablaA");
$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell(5300);                $textrun1 = $celda1->addTextRun($colSTART); $textrun1->addText("identificada con Registro Único de Contribuyente - R.U.C. - N°", $fuente);
$celda2 = $tabla->addCell(1800, $celdaEstiloA); $textrun1 = $celda2->addTextRun($colSTART); $textrun1->addText("   ".$_POST['ruc'], $fuente);
$celda3 = $tabla->addCell(3400);                $textrun1 = $celda3->addTextRun($colSTART); $textrun1->addText(". Declaro bajo juramento que el señor(a)", $fuente);

$tabla = $seccion->addTable("tablaA");
$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell(6000, $celdaEstiloA); $textrun1 = $celda1->addTextRun($colSTART); $textrun1->addText("   ".$_POST['apellidos'].", ".$_POST['nombres'], $fuente);
$celda2 = $tabla->addCell(1500);                $textrun1 = $celda2->addTextRun($colSTART); $textrun1->addText(", identificado con", $fuente);
$celda3 = $tabla->addCell(3000, $celdaEstiloA); $textrun1 = $celda3->addTextRun($colSTART); $textrun1->addText("   ".$_POST['dni'], $fuente);

$tabla = $seccion->addTable("tablaA");
$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell(1800);                $textrun1 = $celda1->addTextRun($colSTART); $textrun1->addText(". código ESSALUD N°", $fuente);
$celda2 = $tabla->addCell(2900, $celdaEstiloA); $textrun1 = $celda2->addTextRun($colSTART); $textrun1->addText("   ", $fuente);
$celda3 = $tabla->addCell(3000);                $textrun1 = $celda3->addTextRun($colSTART); $textrun1->addText(" y Código Único del SPP (CUSPP) N°", $fuente);
$celda4 = $tabla->addCell(2500, $celdaEstiloA); $textrun1 = $celda4->addTextRun($colSTART); $textrun1->addText("   ".$_POST['numautog'], $fuente);

$tabla = $seccion->addTable("tablaA");
$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell(10500);                $textrun1 = $celda1->addTextRun($colSTART); $textrun1->addText("quien se encuentra tramitando el siguiente tipo de Bono de Reconocimiento.", $fuente);

$tablaEstiloB = [ "cellSpacing" => 40, "alignment" => JcTable::CENTER ];
$documento->addTableStyle("tablaB", $tablaEstiloB);
$tabla = $seccion->addTable("tablaB");
$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell(1000, $celdaEstiloB); $textrun1 = $celda1->addTextRun($colSTART); $textrun1->addText("", $fuente);
$celda2 = $tabla->addCell(5400);                $textrun1 = $celda2->addTextRun($colSTART); $textrun1->addText("   Bono de Reconocimiento 1992 (Decreto Supremo N°180-94-EF)", $fuente);
$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell(1000, $celdaEstiloB); $textrun1 = $celda1->addTextRun($colSTART); $textrun1->addText("", $fuente);
$celda2 = $tabla->addCell(5400);                $textrun1 = $celda2->addTextRun($colSTART); $textrun1->addText("   Bono de Reconocimiento 1998 (Decreto Supremo N°054-97-EF)", $fuente);
$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell(1000, $celdaEstiloB); $textrun1 = $celda1->addTextRun($colSTART); $textrun1->addText("", $fuente);
$celda2 = $tabla->addCell(5400);                $textrun1 = $celda2->addTextRun($colSTART); $textrun1->addText("   Bono de Reconocimiento 2001 (Decreto Supremo N°054-97-EF)", $fuente);



$textRun = $seccion->addTextRun([ "alignment" => Jc::START, "lineHeight" => 1, ]);
$textRun->addTextBreak(1);
$textRun->addText("Ha laborado en esta empresa como se detalla a continuación:", $fuente);
$textRun->addTextBreak(1);


// $textRun = $seccion->addTextRun([ "alignment" => Jc::CENTER, "lineHeight" => 1, "colsNum" => 2, "breakType" => "continuos" ]);
// $textrun1->addText("1. Meses Laborados (1)", $fuente);
// $textRun->addTextBreak(1);
// $textrun1->addText("2. Últimas doce (12) Remuneraciones (1)", $fuente);

$celdaEstiloC = [ 
    "borderTopColor" => "000000", 
    "borderLeftColor" => "000000", 
    "borderTopSize" => 0, 
    "borderLeftSize" => 0, 
    "borderTopStyle" => Border::SINGLE, 
    "borderLeftStyle" => Border::SINGLE, 
    "gridSpan" => 2, 
];
$celdaEstiloD = [ 
    "borderTopColor" => "000000", 
    "borderTopSize" => 0, 
    "borderTopStyle" => Border::SINGLE, 
    "gridSpan" => 2, 
];
$celdaEstiloE = [ 
    "borderTopColor" => "000000", 
    "borderRightColor" => "000000", 
    "borderTopSize" => 0, 
    "borderRightSize" => 0, 
    "borderTopStyle" => Border::SINGLE, 
    "borderRightStyle" => Border::SINGLE, 
];

$celdaEstiloF = [ 
    "borderTopColor" => "000000", 
    "borderLeftColor" => "000000", 
    "borderTopSize" => 0, 
    "borderLeftSize" => 0, 
    "borderTopStyle" => Border::SINGLE, 
    "borderLeftStyle" => Border::SINGLE, 
    "vMerge" => "restart", 
    "valign" => "center", 
];
$celdaEstiloG = [ 
    "borderTopColor" => "000000", 
    "borderTopSize" => 0, 
    "borderTopStyle" => Border::SINGLE, 
    "vMerge" => "restart", 
    "valign" => "center", 
];
$celdaEstiloH = [ 
    "borderTopColor" => "000000", 
    "borderRightColor" => "000000", 
    "borderTopSize" => 0, 
    "borderRightSize" => 0, 
    "borderTopStyle" => Border::SINGLE, 
    "borderRightStyle" => Border::SINGLE, 
    "vMerge" => "restart", 
    "valign" => "center", 
];



$celdaEstiloI = [ 
    "borderLeftColor" => "000000", 
    "borderLeftSize" => 0, 
    "borderLeftStyle" => Border::SINGLE, 
    "vMerge" => "restart", 
    "valign" => "center",
];
$celdaEstiloJ = [ 
    "borderRightColor" => "000000", 
    "borderRightSize" => 0, 
    "borderRightStyle" => Border::SINGLE, 
];
$celdaEstiloK = [ 
    "gridSpan" => 5
];
$celdaEstiloL = [ 
    "gridSpan" => 4
];

$celdaEstiloM = [ 
    "borderBottomColor" => "000000", 
    "borderLeftColor" => "000000", 
    "borderBottomSize" => 0, 
    "borderLeftSize" => 0, 
    "borderBottomStyle" => Border::SINGLE, 
    "borderLeftStyle" => Border::SINGLE, 
];
$celdaEstiloN = [ 
    "borderBottomColor" => "000000", 
    "borderBottomSize" => 0, 
    "borderBottomStyle" => Border::SINGLE, 
];
$celdaEstiloO = [ 
    "borderBottomColor" => "000000", 
    "borderRightColor" => "000000", 
    "borderBottomSize" => 0, 
    "borderRightSize" => 0, 
    "borderBottomStyle" => Border::SINGLE, 
    "borderRightStyle" => Border::SINGLE, 
];

$celdaEstiloP = [ 
    "borderbottomColor" => "000000", 
    "borderLeftColor" => "000000", 
    "borderbottomSize" => 0, 
    "borderLeftSize" => 0, 
    "borderbottomStyle" => Border::SINGLE, 
    "borderLeftStyle" => Border::SINGLE, 
];
$celdaEstiloQ = [ 
    "borderbottomColor" => "000000", 
    "borderbottomSize" => 0, 
    "borderbottomStyle" => Border::SINGLE, 
];
$celdaEstiloR = [ 
    "borderbottomColor" => "000000", 
    "borderRightColor" => "000000", 
    "borderbottomSize" => 0, 
    "borderRightSize" => 0, 
    "borderbottomStyle" => Border::SINGLE, 
    "borderRightStyle" => Border::SINGLE, 
];

$tablaEstiloC = [ "cellSpacing" => 40, "alignment" => JcTable::START, ];
$documento->addTableStyle("tablaC", $tablaEstiloC);
$tabla = $seccion->addTable("tablaC");

$fuente  = [ "size" => 9, "color" => "000000", "bold" => true ];

$tabla->addRow($filaAltoA, $filaEstiloA); 
$celda1 = $tabla->addCell(1000, $celdaEstiloK);  $textrun1 = $celda1->addTextRun($colSTART);  $textrun1->addText("1. Meses Laborados (1)", $fuente);
$celda2 = $tabla->addCell(500); $textrun1 = $celda2->addTextRun($colCENTER); $textrun1->addText("", $fuente);
$celda3 = $tabla->addCell(1250, $celdaEstiloL); $textrun1 = $celda3->addTextRun($colSTART); $textrun1->addText("2. Últimas doce (12) Remuneraciones (1)", $fuente);

$tabla->addRow($filaAltoB, $filaEstiloA);
$celda1 = $tabla->addCell(1000, $celdaEstiloC); $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("DESDE", $fuente);
$celda1 = $tabla->addCell(1000, $celdaEstiloD); $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("HASTA", $fuente);
$celda1 = $tabla->addCell(1000, $celdaEstiloE); $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("N° de", $fuente);

$celda1 = $tabla->addCell(500);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("", $fuente);

$celda1 = $tabla->addCell(1250, $celdaEstiloF); $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("", $fuente);
$celda1 = $tabla->addCell(1250, $celdaEstiloG); $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("", $fuente);
$celda1 = $tabla->addCell(1250, $celdaEstiloG); $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("Remuneración", $fuente);
$celda1 = $tabla->addCell(1250, $celdaEstiloH); $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("", $fuente);

$tabla->addRow($filaAltoB, $filaEstiloA);
$celda1 = $tabla->addCell(1000, $celdaEstiloI); $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("Mes", $fuente);
$celda1 = $tabla->addCell(1000);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("Año", $fuente);
$celda1 = $tabla->addCell(1000);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("Mes", $fuente);
$celda1 = $tabla->addCell(1000);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("Año", $fuente);
$celda1 = $tabla->addCell(1000, $celdaEstiloJ); $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("Meses", $fuente);

$celda1 = $tabla->addCell(500);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("", $fuente);

$celda1 = $tabla->addCell(1250, $celdaEstiloI); $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("Mes", $fuente);
$celda1 = $tabla->addCell(1250);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("Año", $fuente);
$celda1 = $tabla->addCell(1250);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("(S/) 2/", $fuente);
$celda1 = $tabla->addCell(1250, $celdaEstiloJ); $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("Retención 3%", $fuente);


$tabla->addRow($filaAltoB, $filaEstiloA);
$celda1 = $tabla->addCell(1000, $celdaEstiloI); $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText($fechaini->format("m"), $fuente);
$celda1 = $tabla->addCell(1000);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText($fechaini->format("Y"), $fuente);
$celda1 = $tabla->addCell(1000);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText($fechafin->format("m"), $fuente);
$celda1 = $tabla->addCell(1000);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText($fechafin->format("Y"), $fuente);
$celda1 = $tabla->addCell(1000, $celdaEstiloJ); $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText(($diferencia->y * 12)+$diferencia->m, $fuente);

$celda1 = $tabla->addCell(500);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("", $fuente);

$celda1 = $tabla->addCell(1250, $celdaEstiloI); $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("12", $fuente);
$celda1 = $tabla->addCell(1250);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("91", $fuente);
$celda1 = $tabla->addCell(1250);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText($_POST['mes12'], $fuente);
$celda1 = $tabla->addCell(1250, $celdaEstiloJ); $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText(nf($_POST['mes12']*(3/100)), $fuente);

$tabla->addRow($filaAltoB, $filaEstiloA);
$celda1 = $tabla->addCell(1000, $celdaEstiloI); $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("", $fuente);
$celda1 = $tabla->addCell(1000);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("", $fuente);
$celda1 = $tabla->addCell(1000);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("", $fuente);
$celda1 = $tabla->addCell(1000);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("", $fuente);
$celda1 = $tabla->addCell(1000, $celdaEstiloJ); $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("", $fuente);

$celda1 = $tabla->addCell(500);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("", $fuente);

$celda1 = $tabla->addCell(1250, $celdaEstiloI); $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("01", $fuente);
$celda1 = $tabla->addCell(1250);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("92", $fuente);
$celda1 = $tabla->addCell(1250);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText($_POST['mes01'], $fuente);
$celda1 = $tabla->addCell(1250, $celdaEstiloJ); $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText(nf($_POST['mes01']*(3/100)), $fuente);

$tabla->addRow($filaAltoB, $filaEstiloA);
$celda1 = $tabla->addCell(1000, $celdaEstiloI); $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("", $fuente);
$celda1 = $tabla->addCell(1000);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("", $fuente);
$celda1 = $tabla->addCell(1000);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("", $fuente);
$celda1 = $tabla->addCell(1000);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("", $fuente);
$celda1 = $tabla->addCell(1000, $celdaEstiloJ); $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("", $fuente);

$celda1 = $tabla->addCell(500);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("", $fuente);

$celda1 = $tabla->addCell(1250, $celdaEstiloI); $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("02", $fuente);
$celda1 = $tabla->addCell(1250);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("92", $fuente);
$celda1 = $tabla->addCell(1250);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText($_POST['mes02'], $fuente);
$celda1 = $tabla->addCell(1250, $celdaEstiloJ); $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText(nf($_POST['mes02']*(3/100)), $fuente);

$tabla->addRow($filaAltoB, $filaEstiloA);
$celda1 = $tabla->addCell(1000, $celdaEstiloI); $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("", $fuente);
$celda1 = $tabla->addCell(1000);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("", $fuente);
$celda1 = $tabla->addCell(1000);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("", $fuente);
$celda1 = $tabla->addCell(1000);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("", $fuente);
$celda1 = $tabla->addCell(1000, $celdaEstiloJ); $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("", $fuente);

$celda1 = $tabla->addCell(500);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("", $fuente);

$celda1 = $tabla->addCell(1250, $celdaEstiloI); $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("03", $fuente);
$celda1 = $tabla->addCell(1250);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("92", $fuente);
$celda1 = $tabla->addCell(1250);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText($_POST['mes03'], $fuente);
$celda1 = $tabla->addCell(1250, $celdaEstiloJ); $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText(nf($_POST['mes03']*(3/100)), $fuente);

$tabla->addRow($filaAltoB, $filaEstiloA);
$celda1 = $tabla->addCell(1000, $celdaEstiloI); $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("", $fuente);
$celda1 = $tabla->addCell(1000);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("", $fuente);
$celda1 = $tabla->addCell(1000);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("", $fuente);
$celda1 = $tabla->addCell(1000);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("", $fuente);
$celda1 = $tabla->addCell(1000, $celdaEstiloJ); $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("", $fuente);

$celda1 = $tabla->addCell(500);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("", $fuente);

$celda1 = $tabla->addCell(1250, $celdaEstiloI); $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("04", $fuente);
$celda1 = $tabla->addCell(1250);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("92", $fuente);
$celda1 = $tabla->addCell(1250);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText($_POST['mes04'], $fuente);
$celda1 = $tabla->addCell(1250, $celdaEstiloJ); $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText(nf($_POST['mes04']*(3/100)), $fuente);

$tabla->addRow($filaAltoB, $filaEstiloA);
$celda1 = $tabla->addCell(1000, $celdaEstiloI); $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("", $fuente);
$celda1 = $tabla->addCell(1000);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("", $fuente);
$celda1 = $tabla->addCell(1000);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("", $fuente);
$celda1 = $tabla->addCell(1000);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("", $fuente);
$celda1 = $tabla->addCell(1000, $celdaEstiloJ); $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("", $fuente);

$celda1 = $tabla->addCell(500);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("", $fuente);

$celda1 = $tabla->addCell(1250, $celdaEstiloI); $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("05", $fuente);
$celda1 = $tabla->addCell(1250);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("92", $fuente);
$celda1 = $tabla->addCell(1250);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText($_POST['mes05'], $fuente);
$celda1 = $tabla->addCell(1250, $celdaEstiloJ); $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText(nf($_POST['mes05']*(3/100)), $fuente);

$tabla->addRow($filaAltoB, $filaEstiloA);
$celda1 = $tabla->addCell(1000, $celdaEstiloI); $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("", $fuente);
$celda1 = $tabla->addCell(1000);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("", $fuente);
$celda1 = $tabla->addCell(1000);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("", $fuente);
$celda1 = $tabla->addCell(1000);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("", $fuente);
$celda1 = $tabla->addCell(1000, $celdaEstiloJ); $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("", $fuente);

$celda1 = $tabla->addCell(500);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("", $fuente);

$celda1 = $tabla->addCell(1250, $celdaEstiloI); $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("06", $fuente);
$celda1 = $tabla->addCell(1250);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("92", $fuente);
$celda1 = $tabla->addCell(1250);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText($_POST['mes06'], $fuente);
$celda1 = $tabla->addCell(1250, $celdaEstiloJ); $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText(nf($_POST['mes06']*(3/100)), $fuente);

$tabla->addRow($filaAltoB, $filaEstiloA);
$celda1 = $tabla->addCell(1000, $celdaEstiloI); $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("", $fuente);
$celda1 = $tabla->addCell(1000);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("", $fuente);
$celda1 = $tabla->addCell(1000);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("", $fuente);
$celda1 = $tabla->addCell(1000);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("", $fuente);
$celda1 = $tabla->addCell(1000, $celdaEstiloJ); $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("", $fuente);

$celda1 = $tabla->addCell(500);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("", $fuente);

$celda1 = $tabla->addCell(1250, $celdaEstiloI); $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("07", $fuente);
$celda1 = $tabla->addCell(1250);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("92", $fuente);
$celda1 = $tabla->addCell(1250);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText($_POST['mes07'], $fuente);
$celda1 = $tabla->addCell(1250, $celdaEstiloJ); $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText(nf($_POST['mes07']*(3/100)), $fuente);

$tabla->addRow($filaAltoB, $filaEstiloA);
$celda1 = $tabla->addCell(1000, $celdaEstiloI); $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("", $fuente);
$celda1 = $tabla->addCell(1000);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("", $fuente);
$celda1 = $tabla->addCell(1000);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("", $fuente);
$celda1 = $tabla->addCell(1000);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("", $fuente);
$celda1 = $tabla->addCell(1000, $celdaEstiloJ); $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("", $fuente);

$celda1 = $tabla->addCell(500);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("", $fuente);

$celda1 = $tabla->addCell(1250, $celdaEstiloI); $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("08", $fuente);
$celda1 = $tabla->addCell(1250);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("92", $fuente);
$celda1 = $tabla->addCell(1250);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText($_POST['mes08'], $fuente);
$celda1 = $tabla->addCell(1250, $celdaEstiloJ); $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText(nf($_POST['mes08']*(3/100)), $fuente);

$tabla->addRow($filaAltoB, $filaEstiloA);
$celda1 = $tabla->addCell(1000, $celdaEstiloI); $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("", $fuente);
$celda1 = $tabla->addCell(1000);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("", $fuente);
$celda1 = $tabla->addCell(1000);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("", $fuente);
$celda1 = $tabla->addCell(1000);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("", $fuente);
$celda1 = $tabla->addCell(1000, $celdaEstiloJ); $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("", $fuente);

$celda1 = $tabla->addCell(500);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("", $fuente);

$celda1 = $tabla->addCell(1250, $celdaEstiloI); $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("09", $fuente);
$celda1 = $tabla->addCell(1250);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("92", $fuente);
$celda1 = $tabla->addCell(1250);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText($_POST['mes09'], $fuente);
$celda1 = $tabla->addCell(1250, $celdaEstiloJ); $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText(nf($_POST['mes09']*(3/100)), $fuente);

$tabla->addRow($filaAltoB, $filaEstiloA);
$celda1 = $tabla->addCell(1000, $celdaEstiloI); $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("", $fuente);
$celda1 = $tabla->addCell(1000);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("", $fuente);
$celda1 = $tabla->addCell(1000);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("", $fuente);
$celda1 = $tabla->addCell(1000);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("", $fuente);
$celda1 = $tabla->addCell(1000, $celdaEstiloJ); $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("", $fuente);

$celda1 = $tabla->addCell(500);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("", $fuente);

$celda1 = $tabla->addCell(1250, $celdaEstiloI); $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("10", $fuente);
$celda1 = $tabla->addCell(1250);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("92", $fuente);
$celda1 = $tabla->addCell(1250);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText($_POST['mes10'], $fuente);
$celda1 = $tabla->addCell(1250, $celdaEstiloJ); $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText(nf($_POST['mes10']*(3/100)), $fuente);

$tabla->addRow($filaAltoB, $filaEstiloA);
$celda1 = $tabla->addCell(1000, $celdaEstiloM); $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("", $fuente);
$celda1 = $tabla->addCell(1000, $celdaEstiloN); $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("", $fuente);
$celda1 = $tabla->addCell(1000, $celdaEstiloN); $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("", $fuente);
$celda1 = $tabla->addCell(1000, $celdaEstiloN); $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("", $fuente);
$celda1 = $tabla->addCell(1000, $celdaEstiloO); $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("", $fuente);

$celda1 = $tabla->addCell(500);                $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("", $fuente);

$celda1 = $tabla->addCell(1250, $celdaEstiloP); $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("11", $fuente);
$celda1 = $tabla->addCell(1250, $celdaEstiloQ); $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText("92", $fuente);
$celda1 = $tabla->addCell(1250, $celdaEstiloQ); $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText($_POST['mes11'], $fuente);
$celda1 = $tabla->addCell(1250, $celdaEstiloR); $textrun1 = $celda1->addTextRun($colCENTER); $textrun1->addText(nf($_POST['mes11']*(3/100)), $fuente);

$fuente  = [ "size" => 8, "color" => "000000", "bold" => true ];

$tabla->addRow($filaAltoC, $filaEstiloA);
$celda1 = $tabla->addCell(1000, $celdaEstiloK); 
$textrun1 = $celda1->addTextRun($colSTART); 
$textrun1->addText("1/ Incluir todos los meses efectivamente laborados. Incluso hasta la fecha, de ser el caso, para los casos de meses en que no se realizaron retenciones el trabajador sobre su remuneración (p.e. Licencia sin goce de haber)", $fuente);

$celda2 = $tabla->addCell(500); 
$textrun1 = $celda2->addTextRun($colCENTER); 
$textrun1->addText("", $fuente);

$celda3 = $tabla->addCell(1250, $celdaEstiloL); 
$textrun1 = 
$celda3->addTextRun($colSTART); 
$textrun1->addText("1/ Solo llenar para el caso de las generadas con anterioridad al 06 de Dic. 92, consecutivo o no.", $fuente);
$textrun1->addTextBreak();
$textrun1->addText("2/ Considérese como remuneración, todos los pagos realizados en ese mes (Básico, gratificaciones, etc.) que estuvieron afectos al descuento por IPSS-Pensiones.", $fuente);
$textrun1->addTextBreak();
$textrun1->addText("3/ Señalar la retención efectuada al trabajador por concepto de pensiones IPSS, sobre la remuneración de ese mes.", $fuente);

$fuente  = [ "size" => 10, "color" => "000000", "bold" => true ];
$textrun1 = $seccion->addTextRun([ "alignment" => Jc::CENTER, "lineHeight" => 1, ]);
$textrun1->addText("Por lo demás, declaro que en los meses q que se hace referencia anteriormente se ha realizado las retenciones por concepto de los aportes a algunos de los Sistemas de Pensiones administrados por la ONP.", $fuente);
$textrun1->addTextBreak(5);
$textrun1 = $seccion->addTextRun([ "alignment" => Jc::END, "lineHeight" => 1, ]);
$textrun1->addText("____________________________________________________", $fuente);
$textrun1->addTextBreak();
$textrun1->addText("Firma y Sello del Representante legal                   .", $fuente);








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
    <title>Declaración Jurada del Empleador</title>
    <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="../css/estilos.min.css" media="all">
    <link rel="stylesheet" href="../css/impresion.min.css" media="print">

</head>
<body>
    <div class="pagina_decl" >
        <div class="declaracion">
            <div class="tituloa mayusculas">declaracion jurada del</div>
            <div class="tituloa mayusculas">empleador</div>
            <div class="titulob capitalizar">(supremo n° 054-07-cf, dano 1990)</div>
            <div class="titulob capitalizar" style="margin-bottom: 2em;">(para los fines señalados en la segunda disposición final y transitoria del decreto)</div>
            <div class="decl">
                <div style="width: content">Por la presente, yo </div><div class="divLinea truncar" style="width: 350px"><?php echo $_POST['rep_legal'] ?></div><div style="width: content">, identificado con </div><div class="divLinea" style="width: 140px"><?php echo $_POST['dni_a'] ?></div>
                <div style="width: content">en calidad de Representante Legal de la Empresa </div><div class="divLinea" style="width: 405px"><?php echo $_POST['empresa'] ?></div>
                <div style="width: content">identificada con Registro Único de Contribuyente - R.U.C. - N° </div><div class="divLinea" style="width: 125px"><?php echo $_POST['ruc'] ?></div><div style="width: content">. Declaro bajo juramento que el señor(a)</div>
                <div class="divLinea" style="width: 400px"><?php echo $_POST['apellidos'],", ",$_POST['nombres'] ?></div><div style="width: content">, identificado con </div><div class="divLinea" style="width: 205px"><?php echo $_POST['dni'] ?></div>
                <div style="width: content">. código ESSALUD N° </div><div class="divLinea" style="width: 170px"></div><div style="width: content"> y Código Único del SPP (CUSPP) N° </div><div class="divLinea" style="width: 190px"><?php echo $_POST['numautog'] ?></div>
                <div style="width: content; height: 24px !important; align-items: end; margin-bottom: 1.5em;">quien se encuentra tramitando el siguiente tipo de Bono de Reconocimiento.</div>
                <!-- en calidad de Representante Legal de la Empresa ________________________________________________________________
                identificada con Registro Único de Contribuyente - R.U.C. - N° ______________. Declaro bajo juramento que el señor(a)
                ___________________________________________________________, identificado con _____________________________________
                . código ESSALUD N° ___________________________ y Código Único del SPP (CUSPP) N° _____________________________
                quien se encuentra tramitando el siguiente tipo de Bono de Reconocimiento. -->
            </div>
            <div class="decreto"><div></div>Bono de Reconocimiento 1992 (Decreto Supremo N°180-94-EF)</div>
            <div class="decreto"><div></div>Bono de Reconocimiento 1998 (Decreto Supremo N°054-97-EF)</div>
            <div class="decreto"><div></div>Bono de Reconocimiento 2001 (Decreto Supremo N°054-97-EF)</div>
            <div style="margin-top: 1em;">Ha laborado en esta empresa como se detalla a continuación:</div>
            <div class="cuadrados">
                <div class="cuadrados_cuadro">
                    <div class="cuadrados_titulo">1. Meses Laborados (1)</div>
                    <table align="left" width="100%" border="1" cellspacing="0" cellpadding="1">
                        <!-- <tr><td width="100%" colspan="5" style="border: none">1. Meses Laborados (1)</td></tr> -->
                        <tr style="height: 22px;">
                            <td width="40%" colspan="2" align="center">DESDE</td>
                            <td width="40%" colspan="2" align="center">HASTA</td>
                            <td width="20%" rowspan="2" align="center">N° de<br>Meses</td>
                        </tr>
                        <tr style="height: 22px;">
                            <td width="20%" align="center">Mes</td>
                            <td width="20%" align="center">Año</td>
                            <td width="20%" align="center">Mes</td>
                            <td width="20%" align="center">Año</td>
                        </tr>
                        <tr style="height: 23px;">
                            <td align="center">&nbsp;<?php echo $fechaini->format("m") ?></td>
                            <td align="center">&nbsp;<?php echo $fechaini->format("Y") ?></td>
                            <td align="center">&nbsp;<?php echo $fechafin->format("m") ?></td>
                            <td align="center">&nbsp;<?php echo $fechafin->format("Y") ?></td>
                            <td align="center">&nbsp;<?php echo ($diferencia->y * 12)+$diferencia->m ?></td>
                        </tr>
                        <tr style="height: 23px;"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                        <tr style="height: 23px;"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                        <tr style="height: 23px;"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                        <tr style="height: 23px;"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                        <tr style="height: 23px;"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                        <tr style="height: 23px;"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                        <tr style="height: 23px;"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                        <tr style="height: 23px;"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                        <tr style="height: 23px;"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                        <tr style="height: 23px;"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                        <tr style="height: 23px;"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                    </table>
                    <div style="font-size: 10px;">1/ Incluir todos los meses efectivamente laborados. Incluso hasta la fecha, de ser el caso, para los casos de meses en que no se realizaron retenciones el trabajador sobre su remuneración (p.e. Licencia sin goce de haber)</div>
                </div>
                <div class="cuadrados_cuadro">
                    <div class="cuadrados_titulo">2. Últimas doce (12) Remuneraciones (1)</div>
                    <table align="left" width="100%" border="1" cellspacing="0" cellpadding="1">
                        <!-- <tr><td width="100%" colspan="5" style="border: none">1. Meses Laborados (1)</td></tr> -->
                        <tr height="44px">
                            <td width="25%" align="center">Mes</td>
                            <td width="25%" align="center">Año</td>
                            <td width="25%" align="center">Remuneración (S/) 2/</td>
                            <td width="25%" align="center">Retención 3/</td>
                        </tr>
                        <?php //for ($i=0;$i<=11;$i++) { ?>
                            <!-- <tr style="height: 23px;">
                                <td align="center">&nbsp;<?php // echo $añobono[$i]['mes']; ?></td>
                                <td align="center">&nbsp;<?php // echo $añobono[$i]['anio']; ?></td>
                                <td align="center">&nbsp;<?php // echo $añobono[$i]['remuneracion']; ?></td>
                                <td align="center">&nbsp;<?php // echo $añobono[$i]['retencion']; ?></td>
                            </tr> -->
                        <?php //} ?>
                        
                        <tr style="height: 23px;"><td align="center">12&nbsp;</td><td align="center">91&nbsp;</td><td align="center"><?php echo $_POST['mes12'] ?>&nbsp;</td><td align="center"><?php echo nf($_POST['mes12']*(3/100)) ?>&nbsp;</td></tr>
                        <tr style="height: 23px;"><td align="center">01&nbsp;</td><td align="center">92&nbsp;</td><td align="center"><?php echo $_POST['mes01'] ?>&nbsp;</td><td align="center"><?php echo nf($_POST['mes01']*(3/100)) ?>&nbsp;</td></tr>
                        <tr style="height: 23px;"><td align="center">02&nbsp;</td><td align="center">92&nbsp;</td><td align="center"><?php echo $_POST['mes02'] ?>&nbsp;</td><td align="center"><?php echo nf($_POST['mes02']*(3/100)) ?>&nbsp;</td></tr>
                        <tr style="height: 23px;"><td align="center">03&nbsp;</td><td align="center">92&nbsp;</td><td align="center"><?php echo $_POST['mes03'] ?>&nbsp;</td><td align="center"><?php echo nf($_POST['mes03']*(3/100)) ?>&nbsp;</td></tr>
                        <tr style="height: 23px;"><td align="center">04&nbsp;</td><td align="center">92&nbsp;</td><td align="center"><?php echo $_POST['mes04'] ?>&nbsp;</td><td align="center"><?php echo nf($_POST['mes04']*(3/100)) ?>&nbsp;</td></tr>
                        <tr style="height: 23px;"><td align="center">05&nbsp;</td><td align="center">92&nbsp;</td><td align="center"><?php echo $_POST['mes05'] ?>&nbsp;</td><td align="center"><?php echo nf($_POST['mes05']*(3/100)) ?>&nbsp;</td></tr>
                        <tr style="height: 23px;"><td align="center">06&nbsp;</td><td align="center">92&nbsp;</td><td align="center"><?php echo $_POST['mes06'] ?>&nbsp;</td><td align="center"><?php echo nf($_POST['mes06']*(3/100)) ?>&nbsp;</td></tr>
                        <tr style="height: 23px;"><td align="center">07&nbsp;</td><td align="center">92&nbsp;</td><td align="center"><?php echo $_POST['mes07'] ?>&nbsp;</td><td align="center"><?php echo nf($_POST['mes07']*(3/100)) ?>&nbsp;</td></tr>
                        <tr style="height: 23px;"><td align="center">08&nbsp;</td><td align="center">92&nbsp;</td><td align="center"><?php echo $_POST['mes08'] ?>&nbsp;</td><td align="center"><?php echo nf($_POST['mes08']*(3/100)) ?>&nbsp;</td></tr>
                        <tr style="height: 23px;"><td align="center">08&nbsp;</td><td align="center">92&nbsp;</td><td align="center"><?php echo $_POST['mes09'] ?>&nbsp;</td><td align="center"><?php echo nf($_POST['mes09']*(3/100)) ?>&nbsp;</td></tr>
                        <tr style="height: 23px;"><td align="center">10&nbsp;</td><td align="center">92&nbsp;</td><td align="center"><?php echo $_POST['mes10'] ?>&nbsp;</td><td align="center"><?php echo nf($_POST['mes10']*(3/100)) ?>&nbsp;</td></tr>
                        <tr style="height: 23px;"><td align="center">11&nbsp;</td><td align="center">92&nbsp;</td><td align="center"><?php echo $_POST['mes11'] ?>&nbsp;</td><td align="center"><?php echo nf($_POST['mes11']*(3/100)) ?>&nbsp;</td></tr>
                       
                    </table>
                    <div style="font-size: 10px;">
                        1/ Solo llenar para el caso de las generadas con anterioridad al 06 de Dic. 92, consecutivo o no.<br>
                        2/ Considérese como remuneración, todos los pagos realizados en ese mes (Básico, gratificaciones, etc.) que estuvieron afectos al descuento por IPSS-Pensiones.<br>
                        3/ Señalar la retención efectuada al trabajador por concepto de pensiones IPSS, sobre la remuneración de ese mes.
                    </div>
                </div>
            </div>
            <div style="margin: 2em 0">Por lo demás, declaro que en los meses q que se hace referencia anteriormente se ha realizado las retenciones por concepto de los aportes a algunos de los Sistemas de Pensiones administrados por la ONP.</div>
            <div class="firmaa">Firma y Sello del Representante legal</div>
            <!-- <div class="firma">Total <?php // echo nf($total) ?></div> -->
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