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
$fuentea = [ "color" => "ff0000", ];
$fuenteb = [ "color" => "ff0000", "bold" => true ];
$fuentec = [ "color" => "ff0000", "bold" => true, "alignment" => Jc::START ];

$filaAltoA      = 300;
$filaAltoB      = 400;
$filaAltoC      = 600;
$filaAltoD      = 200;
$coluSeparador  = 200;
$coluAncho0     = 9000;
$coluAncho1     = 2000;
$coluAncho2     = 7000;
$coluAncho3     = 3200;
$coluAncho4     = 1300;
$coluAncho5     = 2500;
$coluAncho6     = 4500;

$filaEstiloA  = [ "exactHeight" => true ]; 
$celdaEstiloA = [ 
    "borderTopColor" => "000000", 
    "borderRightColor" => "000000", 
    "borderLeftColor" => "000000", 
    "borderTopSize" => 3, 
    "borderRightSize" => 3, 
    "borderLeftSize" => 3, 
    "borderTopStyle" => Border::DASHED, 
    "borderRightStyle" => Border::DASHED, 
    "borderLeftStyle" => Border::DASHED, 
    "gridSpan" => 5, 
];
$celdaEstiloB = [ 
    "borderLeftSize"    => 3, 
    "borderleftColor"   => "000000", 
    "borderLeftStyle" => Border::DASHED, 
];  
$celdaEstiloC = [ 
    "borderRightSize"    => 3, 
    "borderRightColor"   => "000000", 
    "borderRightStyle" => Border::DASHED, 
    "gridSpan" => 2, 
];  
$celdaEstiloD = [ 
    "borderRightSize"    => 3, 
    "borderLeftSize"    => 3, 
    "borderTopSize"    => 3, 
    "borderBottomSize" => 3, 
    "borderRightColor"   => "000000", 
    "borderLeftColor"   => "000000", 
    "borderTopColor"   => "000000", 
    "borderBottomColor" => "000000", 
    "borderRightStyle" => Border::DASHED, 
    "borderLeftStyle" => Border::DASHED, 
    "borderTopStyle" => Border::SINGLE, 
    "borderBottomStyle" => Border::DASHED, 
    "gridSpan" => 4, 
];  
$celdaEstiloE = [ 
    "borderRightSize"    => 3, 
    "borderTopSize"    => 3, 
    "borderBottomSize" => 3, 
    "borderRightColor"   => "000000", 
    "borderTopColor"   => "000000", 
    "borderBottomColor" => "000000", 
    "borderRightStyle" => Border::DASHED, 
    "borderTopStyle" => Border::DASHED, 
    "borderBottomStyle" => Border::SINGLE, 
];  
$celdaEstiloF = [ 
    "borderRightSize"    => 3, 
    "borderLeftSize"    => 3,
    "borderRightColor"   => "000000", 
    "borderLeftColor"   => "000000", 
    "borderRightStyle" => Border::DASHED, 
    "borderLeftStyle" => Border::DASHED, 
    "gridSpan" => 4, 
];  
$celdaEstiloG = [ 
    "borderRightSize"    => 3, 
    "borderRightColor"   => "000000",
    "borderRightStyle" => Border::DASHED,
];  
$celdaEstiloH = [ 
    "borderRightSize"    => 3, 
    "borderLeftSize"    => 3,
    "borderTopSize"    => 3,
    "borderBottomSize"    => 3,
    "borderRightColor"   => "000000", 
    "borderLeftColor"   => "000000", 
    "borderTopColor"   => "000000", 
    "borderBottomColor"   => "000000", 
    "borderRightStyle" => Border::DASHED, 
    "borderLeftStyle" => Border::DASHED, 
    "borderTopStyle" => Border::DASHED, 
    "borderBottomStyle" => Border::SINGLE, 
    "gridSpan" => 4, 
];   
$celdaEstiloI = [ 
    "borderRightSize"    => 3, 
    "borderTopSize"    => 3, 
    "borderBottomSize"    => 3, 
    "borderRightColor"   => "000000",
    "borderTopColor"   => "000000",
    "borderBottomColor"   => "000000",
    "borderRightStyle" => Border::DASHED,
    "borderTopStyle" => Border::SINGLE,
    "borderBottomStyle" => Border::SINGLE,
];   
$celdaEstiloJ = [ 
    "borderRightSize"    => 3, 
    "borderLeftSize"    => 3,
    "borderRightColor"   => "000000", 
    "borderLeftColor"   => "000000", 
    "borderRightStyle" => Border::DASHED, 
    "borderLeftStyle" => Border::DASHED, 
];   
$celdaEstiloK = [ 
    "borderRightSize"    => 3, 
    "borderLeftSize"    => 3,
    "borderRightColor"   => "000000", 
    "borderLeftColor"   => "000000", 
    "borderRightStyle" => Border::DASHED, 
    "borderLeftStyle" => Border::DASHED, 
    "gridSpan" => 2, 
];   
$celdaEstiloL = [ 
    "borderRightSize"    => 3, 
    "borderLeftSize"    => 3,
    "borderTopSize"    => 3,
    "borderBottomSize"    => 3,
    "borderRightColor"   => "000000", 
    "borderLeftColor"   => "000000", 
    "borderTopColor"   => "000000", 
    "borderBottomColor"   => "000000", 
    "borderRightStyle" => Border::DASHED, 
    "borderLeftStyle" => Border::DASHED, 
    "borderToptyle" => Border::SINGLE, 
    "borderBottomStyle" => Border::SINGLE, 
];   
$celdaEstiloM = [ 
    "borderRightSize"    => 3, 
    "borderLeftSize"    => 3,
    "borderTopSize"    => 3,
    "borderBottomSize"    => 3,
    "borderRightColor"   => "000000", 
    "borderLeftColor"   => "000000", 
    "borderTopColor"   => "000000", 
    "borderBottomColor"   => "000000", 
    "borderRightStyle" => Border::DASHED, 
    "borderLeftStyle" => Border::DASHED, 
    "borderToptyle" => Border::SINGLE, 
    "borderBottomStyle" => Border::SINGLE, 
    "gridSpan" => 2, 
];    
$celdaEstiloN = [ 
    "borderRightSize"    => 3, 
    "borderTopSize"    => 3,
    "borderBottomSize"    => 3,
    "borderRightColor"   => "000000",
    "borderTopColor"   => "000000", 
    "borderBottomColor"   => "000000", 
    "borderRightStyle" => Border::DASHED,
    "borderToptyle" => Border::SINGLE, 
    "borderBottomStyle" => Border::SINGLE, 
];  
$celdaEstiloO = [ 
    "borderRightSize"    => 3, 
    "borderLeftSize"    => 3,
    "borderBottomSize"    => 3,
    "borderRightColor"   => "000000", 
    "borderLeftColor"   => "000000", 
    "borderBottomColor"   => "000000", 
    "borderRightStyle" => Border::DASHED, 
    "borderLeftStyle" => Border::DASHED,
    "borderBottomStyle" => Border::DASHED, 
    "gridSpan" => 4, 
];   
$celdaEstiloP = [ 
    "borderRightSize"    => 3, 
    "borderBottomSize"    => 3, 
    "borderRightColor"   => "000000",
    "borderBottomColor"   => "000000",
    "borderRightStyle" => Border::DASHED,
    "borderBottomStyle" => Border::DASHED,
]; 


$celdaSTART    = [ "alignment" => JcTable::START,   "lineHeight" => -1.3, ]; 
$celdaCENTER   = [ "alignment" => JcTable::CENTER,  "lineHeight" => -1.3, ]; 
$celdaEND      = [ "alignment" => JcTable::END,     "lineHeight" => -1.3, ]; 

$tablaEstilo = [ "cellMarginRight" => 150, "cellMarginLeft" => 150 ];
$documento->addTableStyle('tablaA', $tablaEstilo);
$tabla = $seccion->addTable('tablaA');
$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho0, $celdaEstiloA); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("", $fuente);
$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho1, $celdaEstiloB); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("", $fuente);
$celda2 = $tabla->addCell($coluAncho5);                $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText("", $fuente);
$celda1 = $tabla->addCell($coluAncho3);                $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("BOLETA DE PAGO:", $fuente);
$celda2 = $tabla->addCell($coluAncho4, $celdaEstiloC); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText("", $fuente);
$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho1, $celdaEstiloB); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("FECHA DE INGRESO:", $fuente);
$celda2 = $tabla->addCell($coluAncho5);                $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText("".$_POST['f_a'], $fuente);
$celda1 = $tabla->addCell($coluAncho3);                $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("MES: ".strtoupper($meses[nf($fechafin->format("m"),0)]), $fuente);
$celda2 = $tabla->addCell($coluAncho4, $celdaEstiloC); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText("", $fuente);
$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho1, $celdaEstiloB); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("NOMBRE:", $fuente);
$celda2 = $tabla->addCell($coluAncho5);                $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText("".$_POST['nombres'], $fuente);
$celda1 = $tabla->addCell($coluAncho3);                $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("AÑO: ".$fechafin->format("Y"), $fuente);
$celda2 = $tabla->addCell($coluAncho4, $celdaEstiloC); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText("", $fuente);
$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho1, $celdaEstiloB); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("", $fuente);
$celda2 = $tabla->addCell($coluAncho5);                $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText("".$_POST['apellidos'], $fuente);
$celda1 = $tabla->addCell($coluAncho3);                $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("", $fuente);
$celda2 = $tabla->addCell($coluAncho4, $celdaEstiloC); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText("", $fuente);
$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho1, $celdaEstiloB); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("", $fuente);
$celda2 = $tabla->addCell($coluAncho5);                $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText("", $fuente);
$celda1 = $tabla->addCell($coluAncho3);                $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("OCUPACIÓN:", $fuente);
$celda2 = $tabla->addCell($coluAncho4, $celdaEstiloC); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText("".$cargo, $fuente);
$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho1, $celdaEstiloB); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("", $fuente);
$celda2 = $tabla->addCell($coluAncho5);                $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText("", $fuente);
$celda1 = $tabla->addCell($coluAncho3);                $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("", $fuente);
$celda2 = $tabla->addCell($coluAncho4, $celdaEstiloC); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText("", $fuente);

$tabla->addRow($filaAltoB, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho2, $celdaEstiloD); $textrun1 = $celda1->addTextRun($celdaCENTER); $textrun1->addText("JORNALES:", $fuente);
$celda2 = $tabla->addCell($coluAncho3, $celdaEstiloE); $textrun1 = $celda2->addTextRun($celdaSTART);  $textrun1->addText("", $fuente);
$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho2, $celdaEstiloF); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("DÍAS TRABAJADOS: ", $fuente);
$celda2 = $tabla->addCell($coluAncho3, $celdaEstiloG); $textrun1 = $celda2->addTextRun($celdaSTART);  $textrun1->addText("".nf($diasd,0), $fuente);
$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho2, $celdaEstiloF); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("DOMINICALES: ", $fuente);
$celda2 = $tabla->addCell($coluAncho3, $celdaEstiloG); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText("", $fuente);
$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho2, $celdaEstiloF); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("TRABAJO EN FERIADO: ", $fuente);
$celda2 = $tabla->addCell($coluAncho3, $celdaEstiloG); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText("", $fuente);
$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho2, $celdaEstiloF); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("DOMINGO TRABAJADO: ", $fuente);
$celda2 = $tabla->addCell($coluAncho3, $celdaEstiloG); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText("", $fuente);
$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho2, $celdaEstiloF); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("HORAS EXTRAS: ", $fuente);
$celda2 = $tabla->addCell($coluAncho3, $celdaEstiloG); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText("".nf($hextras), $fuente);
$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho2, $celdaEstiloF); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("BONIF DE LA EMPRESA: ", $fuente);
$celda2 = $tabla->addCell($coluAncho3, $celdaEstiloG); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText("".nf($bonificacion), $fuente);
$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho2, $celdaEstiloF); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("BONIFICACIÓN PONAVIS: ", $fuente);
$celda2 = $tabla->addCell($coluAncho3, $celdaEstiloG); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText("", $fuente);
$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho2, $celdaEstiloF); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("BONIF FAMILIAR: ", $fuente);
$celda2 = $tabla->addCell($coluAncho3, $celdaEstiloG); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText("", $fuente);
$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho2, $celdaEstiloF); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("VACACIONES-PERÍODO: ", $fuente);
$celda2 = $tabla->addCell($coluAncho3, $celdaEstiloG); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText("", $fuente);
$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho2, $celdaEstiloF); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("SUELDO ", $fuente);
$celda2 = $tabla->addCell($coluAncho3, $celdaEstiloG); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText("".nf($sueldo), $fuente);
$tabla->addRow($filaAltoC, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho2, $celdaEstiloH); $textrun1 = $celda1->addTextRun($celdaEND);   $textrun1->addText("TOTAL DE REMUNERACIONES    S/.  ", $fuente);
$celda2 = $tabla->addCell($coluAncho3, $celdaEstiloI); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText("".nf($total_deven), $fuente);

$tablaEstilo = [ "cellMarginRight" => 150, "cellMarginLeft" => 150 ];
$documento->addTableStyle('tablaA', $tablaEstilo);
$tabla = $seccion->addTable('tablaA');
$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho3, $celdaEstiloJ); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("DESCUENTOS EMPLEADO:", $fuente);
$celda2 = $tabla->addCell($coluAncho4, $celdaEstiloG); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText("", $fuente);
$celda2 = $tabla->addCell($coluAncho3, $celdaEstiloK); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText("", $fuente);
$celda2 = $tabla->addCell($coluAncho4, $celdaEstiloG); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText("", $fuente);
$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho3, $celdaEstiloJ); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("REG. PREST. SALUD 3%", $fuente);
$celda2 = $tabla->addCell($coluAncho4, $celdaEstiloG); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText(nf($traipss), $fuente);
$celda2 = $tabla->addCell($coluAncho3, $celdaEstiloK); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText("", $fuente);
$celda2 = $tabla->addCell($coluAncho4, $celdaEstiloG); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText("", $fuente);
$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho3, $celdaEstiloJ); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("SIST. NAC. PENSIONES 3%", $fuente);
$celda2 = $tabla->addCell($coluAncho4, $celdaEstiloG); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText(nf($trasnp), $fuente);
$celda2 = $tabla->addCell($coluAncho3, $celdaEstiloK); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText("", $fuente);
$celda2 = $tabla->addCell($coluAncho4, $celdaEstiloG); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText("", $fuente);
$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho3, $celdaEstiloJ); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("DESCUENTOS APP. 10%", $fuente);
$celda2 = $tabla->addCell($coluAncho4, $celdaEstiloG); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText("", $fuente);
$celda2 = $tabla->addCell($coluAncho3, $celdaEstiloK); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText("", $fuente);
$celda2 = $tabla->addCell($coluAncho4, $celdaEstiloG); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText("", $fuente);
$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho3, $celdaEstiloJ); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("ACC. DE TRABAJO", $fuente);
$celda2 = $tabla->addCell($coluAncho4, $celdaEstiloG); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText("", $fuente);
$celda2 = $tabla->addCell($coluAncho3, $celdaEstiloK); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText("", $fuente);
$celda2 = $tabla->addCell($coluAncho4, $celdaEstiloG); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText("", $fuente);
$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho3, $celdaEstiloJ); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("FONAVI 3%", $fuente);
$celda2 = $tabla->addCell($coluAncho4, $celdaEstiloG); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText(nf($trafonavi), $fuente);
$celda2 = $tabla->addCell($coluAncho3, $celdaEstiloK); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText("", $fuente);
$celda2 = $tabla->addCell($coluAncho4, $celdaEstiloG); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText("", $fuente);
$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho3, $celdaEstiloJ); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("CONTRIBUCIÓN IPSS. 1%", $fuente);
$celda2 = $tabla->addCell($coluAncho4, $celdaEstiloG); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText("", $fuente);
$celda2 = $tabla->addCell($coluAncho3, $celdaEstiloK); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText("", $fuente);
$celda2 = $tabla->addCell($coluAncho4, $celdaEstiloG); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText("", $fuente);
$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho3, $celdaEstiloJ); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("SEGURO DE VIDA 2.30%", $fuente);
$celda2 = $tabla->addCell($coluAncho4, $celdaEstiloG); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText("", $fuente);
$celda2 = $tabla->addCell($coluAncho3, $celdaEstiloK); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText("", $fuente);
$celda2 = $tabla->addCell($coluAncho4, $celdaEstiloG); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText("", $fuente);
$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho3, $celdaEstiloJ); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("COMISIÓN FIJA", $fuente);
$celda2 = $tabla->addCell($coluAncho4, $celdaEstiloG); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText("", $fuente);
$celda2 = $tabla->addCell($coluAncho3, $celdaEstiloK); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText("", $fuente);
$celda2 = $tabla->addCell($coluAncho4, $celdaEstiloG); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText("", $fuente);
$tabla->addRow($filaAltoA, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho3, $celdaEstiloJ); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("", $fuente);
$celda2 = $tabla->addCell($coluAncho4, $celdaEstiloG); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText("", $fuente);
$celda2 = $tabla->addCell($coluAncho3, $celdaEstiloK); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText("", $fuente);
$celda2 = $tabla->addCell($coluAncho4, $celdaEstiloG); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText("", $fuente);
$tabla->addRow($filaAltoC, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho3, $celdaEstiloL); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("TOTAL DESDUENTOS S/.", $fuente);
$celda2 = $tabla->addCell($coluAncho4, $celdaEstiloN); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText(nf($tratotaldeduc), $fuente);
$celda2 = $tabla->addCell($coluAncho3, $celdaEstiloM); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText("", $fuente);
$celda2 = $tabla->addCell($coluAncho4, $celdaEstiloN); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText("", $fuente);

$tabla->addRow($filaAltoC, $filaEstiloA);
$celda1 = $tabla->addCell($coluAncho2, $celdaEstiloO); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("SALDO NETO A COBRAR                     S/.", $fuente);
$celda2 = $tabla->addCell($coluAncho3, $celdaEstiloP); $textrun1 = $celda2->addTextRun($celdaSTART); $textrun1->addText(nf($total_deven-$tratotaldeduc), $fuente);


$textRun = $seccion->addTextRun([ "alignment" => Jc::END, "lineHeight" => 1, ]);
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
$textrun1->addText("FIRMA DEL EMPLEADOR", $fuente);

$celda2 = $tabla->addCell($coluAncho6); 
$textrun1 = $celda2->addTextRun([ "alignment" => JcTable::CENTER, "cellMarginRight" => 50 ]); 
$textrun1->addText("FIRMA DEL TRABAJADOR", $fuente);








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
                    <div>horas extras:&nbsp;</div><div>&nbsp;<?php echo nf($hextras) ?></div>
                </div>
                <div class="marco_linea7 mayusculas">
                    <div>bonif de la empresa:&nbsp;</div><div>&nbsp;<?php echo nf($bonificacion) ?></div>
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
                    <div>sueldo&nbsp;</div><div>&nbsp;<?php echo nf($sueldo) ?></div>
                </div>
                <div class="marco_linea8 mayusculas">
                    <div>total de remuneraciones&nbsp;&nbsp;&nbsp;&nbsp;S/.&nbsp;&nbsp;&nbsp;</div>
                    <div>&nbsp;<?php echo nf($total_deven) ?></div>
                </div>
                <div class="marco_linea9 mayusculas">
                    <div>descuentos empleado:&nbsp;</div><div>&nbsp;</div><div>&nbsp;</div><div>&nbsp;</div>
                </div>
                <div class="marco_linea9 mayusculas">
                    <div>reg. prest. salud 3%&nbsp;</div><div>&nbsp;<?php echo nf($traipss) ?></div><div>&nbsp;</div><div>&nbsp;</div>
                </div>
                <div class="marco_linea9 mayusculas">
                    <div>sist. nac. pensiones 3%&nbsp;</div><div>&nbsp;<?php echo nf($trasnp) ?></div><div>&nbsp;</div><div>&nbsp;</div>
                </div>
                <div class="marco_linea9 mayusculas">
                    <div>descuentos app. 10%&nbsp;</div><div>&nbsp;</div><div>&nbsp;</div><div>&nbsp;</div>
                </div>
                <div class="marco_linea9 mayusculas">
                    <div>acc. de trabajo&nbsp;</div><div>&nbsp;</div><div>&nbsp;</div><div>&nbsp;</div>
                </div>
                <div class="marco_linea9 mayusculas">
                    <div>fonavi 3%&nbsp;</div><div>&nbsp;<?php echo nf($trafonavi) ?></div><div>&nbsp;</div><div>&nbsp;</div>
                </div>
                <div class="marco_linea9 mayusculas">
                    <div>contribución ipss. 1%&nbsp;</div><div>&nbsp;</div><div>&nbsp;</div><div>&nbsp;</div>
                </div>
                <div class="marco_linea9 mayusculas">
                    <div>seguro de vida 2.30%&nbsp;</div><div>&nbsp;</div><div>&nbsp;</div><div>&nbsp;</div>
                </div>
                <div class="marco_linea9 mayusculas">
                    <div>comisión fija&nbsp;</div><div>&nbsp;</div><div>&nbsp;</div><div>&nbsp;</div>
                </div>
                <div class="marco_linea9 mayusculas">
                    <div>&nbsp;</div><div>&nbsp;</div><div>&nbsp;</div><div>&nbsp;</div>
                </div>
                <div class="marco_linea10 mayusculas">
                    <div>total desduentos S/.&nbsp;</div><div>&nbsp;<?php echo nf($tratotaldeduc) ?></div><div>&nbsp;</div><div>&nbsp;</div>
                </div>
                <div class="marco_linea7 mayusculas" style="">
                    <div style="height: 100%;padding-bottom: 1.5em;">saldo neto a cobrar &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;S/.</div><div>&nbsp;<?php echo nf($total_deven-$tratotaldeduc) ?></div>
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