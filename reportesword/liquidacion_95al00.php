<?php 

require_once('../_db/nomina.php');

if ( isset($_POST['cargo_al']) ) $cargo = $_POST['cargo_al'];
if ( isset($_POST['cargo_bl']) ) $cargo = $_POST['cargo_bl'];

list($dia,$mes,$anio) = explode(".",$_POST['f_b']);

$fecha_anterior = "";

if ( $dia <= 30 && $mes >= 10 || $mes <= 4 ) $fecha_anterior = date_create(($anio-1)."/10/31");
if ( $dia <= 31 && $mes >= 5 && $mes <= 8 )  $fecha_anterior = date_create("$anio/4/30");

$fechaini = date_create($_POST['f_a']);
$fechafin = date_create($_POST['f_b']);
$diferencia = date_diff($fechafin, $fechaini);
$diferenciaa = date_diff($fechafin, $fecha_anterior);

$faf = $fecha_anterior->format("d.m.Y");
$fecha_siguiente = date_add($fecha_anterior, date_interval_create_from_date_string("1 days"));
$fsf = $fecha_siguiente->format("d.m.Y");

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
// var_dump($diferenciaa);
$diasa = $diferenciaa->format("%d");
$mesesa = $diasa > 0 ? $diferenciaa->format("%m") + 1 : $diferenciaa->format("%m");
$dias = $diferencia->format("%d");
$meses = $diferencia->format("%m");
$anios = $diferencia->format("%y");
$tiempo = $anios." años y ".$meses." meses";
$anios = $meses > 0 ? $diferencia->format("%y") + 1 : $diferencia->format("%y");

// $sueldo = $_POST['sueldo'];
// echo $_POST['fsueldo'],"<br>";
$sueldos = obtener_sueldo($_POST['fsueldo']);
$sueldo = $sueldos['sueldo_minimo'];
$totalpago = ($sueldo/12)*$mesesa;

// $tretencion = $totalpago*($retencion/100);

$totalapagar = ($totalpago+$total_deven)-($total_deduc);



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
$fuente = [ "color" => "ff0000", "bold" => true ];
$textRun->addText(strtoupper($_POST['empresa']), $fuente);
$textRun->addTextBreak(2);

$fuentea = [ "color" => "ff0000", ];
$fuenteb = [ "color" => "ff0000", "bold" => true ];

$textRun = $seccion->addTextRun([ "alignment" => Jc::CENTER, "lineHeight" => 1, ]);
$fuente = [ "color" => "000000", "bold" => true, "underline" => "single" ];
$textRun->addText("LIQUIDACION POR TIEMPO DE SERVICIOS", $fuente);
// $textRun->addTextBreak(2);


$fuente = [ "color" => "000000", "bold" => true ];
$filaAlto = 300;
$coluAncho = 2500;
$coluAncho2 = 7500;
$coluSeparador = 200;

$styleTable = array('borderBottomSize' => 15, 'borderBottomColor' => '000000', "cellSpacing" => 0);
$documento->addTableStyle('adicionales', $styleTable);
$tabla = $seccion->addTable('adicionales');
// $tabla = $seccion->addTable();

$tabla->addRow($filaAlto, [ "exactHeight" => true ]);
$tabla->addCell($coluAncho)->addText("NOMBRE", $fuente);
$tabla->addCell($coluSeparador)->addText("  ");
$tabla->addCell($coluAncho2)->addText(strtoupper($_POST['nombres']." ".$_POST['apellidos']), $fuenteb);

$tabla->addRow($filaAlto, [ "exactHeight" => true ]);
$tabla->addCell($coluAncho)->addText("CARGO DESEMPEÑADO", $fuente);
$tabla->addCell($coluSeparador)->addText("  ");
$tabla->addCell($coluAncho2)->addText($cargo, $fuenteb);

$tabla->addRow($filaAlto, [ "exactHeight" => true ]);
$tabla->addCell($coluAncho)->addText("FECHA DE INGRESO", $fuente);
$tabla->addCell($coluSeparador)->addText("  ");
$tabla->addCell($coluAncho2)->addText($_POST['f_a_b'], $fuenteb);

$tabla->addRow($filaAlto, [ "exactHeight" => true ]);
$tabla->addCell($coluAncho)->addText("FECHA DE CESE", $fuente);
$tabla->addCell($coluSeparador)->addText("  ");
$tabla->addCell($coluAncho2)->addText($_POST['f_b_b'], $fuenteb);

$tabla->addRow($filaAlto, [ "exactHeight" => true ]);
$tabla->addCell($coluAncho)->addText("TIEMPO DE SERVICIOS", $fuente);
$tabla->addCell($coluSeparador)->addText("  ");
$tabla->addCell($coluAncho2)->addText($tiempo, $fuenteb);

$tabla->addRow($filaAlto, [ "exactHeight" => true ]);
$tabla->addCell($coluAncho)->addText("MOTIVO DE CESE", $fuente);
$tabla->addCell($coluSeparador)->addText("  ");
$tabla->addCell($coluAncho2)->addText("RENUNCIA VOLUNTARIA", $fuente);

$tabla->addRow($filaAlto, [ "exactHeight" => true ]);
$tabla->addCell($coluAncho)->addText("REMUNERACIÓN BÁSICA", $fuente);
$tabla->addCell($coluSeparador)->addText("  ");
$tabla->addCell($coluAncho2)->addText("S/.".nf($sueldo), $fuente);

$tabla->addRow($filaAlto, [ "exactHeight" => true ]);
$tabla->addCell($coluAncho)->addText("PAGO TOTAL", $fuente);
$tabla->addCell($coluSeparador)->addText("  ");
$tabla->addCell($coluAncho2)->addText("S/.".nf($totalapagar), $fuente);

$textRun = $seccion->addTextRun([ "alignment" => Jc::CENTER, "lineHeight" => 1, ]);
$textRun->addTextBreak(1);
$textRun->addText('C Á L C U L O   D E   L A   C O M P E N S A C I Ó N', [ "color" => "000000", "bold" => true, "underline" => "single" ]);

$fuente = [ "color" => "000000", "bold" => true ];
$filaAlto = 200;
$coluAncho1 = 5000;
$coluAncho2 = 5000;
$coluSeparador = 500;

$celdaSTART  = [ "alignment" => JcTable::START , "cellMarginRight" => 50 ];
$celdaCENTER = [ "alignment" => JcTable::CENTER, "cellMarginRight" => 50 ];
$celdaEND    = [ "alignment" => JcTable::END   , "cellMarginRight" => 50 ];

$tabla = $seccion->addTable();

$tabla->addRow();
$celda1 = $tabla->addCell($coluAncho1);     $textrun1 = $celda1->addTextRun($celdaSTART);   $textrun1->addText($fechaini->format("d.m.Y")." AL $faf", $fuente);
$celda2 = $tabla->addCell($coluSeparador);  $textrun1 = $celda2->addTextRun($celdaCENTER);  $textrun1->addText(" = ", $fuente);
$celda3 = $tabla->addCell($coluAncho2);     $textrun1 = $celda3->addTextRun($celdaEND);     $textrun1->addText("CTS DEPOSITADO EN BANCO", $fuente);

$tabla->addRow();
$celda1 = $tabla->addCell($coluAncho1);     $textrun1 = $celda1->addTextRun($celdaSTART);   $textrun1->addText("$fsf AL ".$fechafin->format("d.m.Y"), $fuente);
$celda2 = $tabla->addCell($coluSeparador);  $textrun1 = $celda2->addTextRun($celdaCENTER);  $textrun1->addText(" = ", $fuente);
$celda3 = $tabla->addCell($coluAncho2);     $textrun1 = $celda3->addTextRun($celdaEND);     $textrun1->addText("$mesesa MES", $fuente);

$tabla->addRow();
$celda1 = $tabla->addCell($coluAncho1);     $textrun1 = $celda1->addTextRun($celdaSTART);   $textrun1->addText("REM. COMPEMSABLE: S/.".nf($sueldo)."/12x$mesesa", $fuente);
$celda2 = $tabla->addCell($coluSeparador);  $textrun1 = $celda2->addTextRun($celdaCENTER);  $textrun1->addText(" = ", $fuente);
$celda3 = $tabla->addCell($coluAncho2);     $textrun1 = $celda3->addTextRun($celdaEND);     $textrun1->addText("S/.".nf($totalpago), $fuente);

$textRun = $seccion->addTextRun([ "alignment" => Jc::START, "lineHeight" => 1, ]);

/* Tabla de Adicionales */
$filaAlto = 250;
$colAncho0 = 400;
$colAncho1 = 6000;
$colAncho2 = 2000;

$styleTable = array('borderBottomSize' => 15, 'borderBottomColor' => '000000', "cellSpacing" => 0);
$documento->addTableStyle('adicionales', $styleTable);
$tabla = $seccion->addTable('adicionales');

if ($adelanto) {
    $tabla->addRow($filaAlto, [ "exactHeight" => true ]);
    $celda1 = $tabla->addCell($colAncho0); $textrun1 = $celda1->addTextRun($celdaEND);   $textrun1->addText('', $fuente); 
    $celda1 = $tabla->addCell($colAncho1); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText('  Adelanto:', $fuente); 
    $celda1 = $tabla->addCell($colAncho2); $textrun1 = $celda1->addTextRun($celdaEND);   $textrun1->addText("(S/.".nf($adelanto).")", $fuenteb);
    $celda1 = $tabla->addCell($colAncho2); $textrun1 = $celda1->addTextRun($celdaEND);   $textrun1->addText(" ", $fuenteb);
}
if ($vacaciones) {
    $tabla->addRow($filaAlto, [ "exactHeight" => true ]);
    $celda1 = $tabla->addCell($colAncho0); $textrun1 = $celda1->addTextRun($celdaEND); $textrun1->addText('', $fuente);
    $celda1 = $tabla->addCell($colAncho1); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText('  Vacaciones:', $fuente);
    $celda1 = $tabla->addCell($colAncho2); $textrun1 = $celda1->addTextRun($celdaEND); $textrun1->addText("", $fuenteb);
    $celda1 = $tabla->addCell($colAncho2); $textrun1 = $celda1->addTextRun($celdaEND); $textrun1->addText("S/.".nf($vacaciones), $fuenteb);
}
if ($gratificaciones) {
    $tabla->addRow($filaAlto, [ "exactHeight" => true ]);
    $celda1 = $tabla->addCell($colAncho0); $textrun1 = $celda1->addTextRun($celdaEND); $textrun1->addText('', $fuente);
    $celda1 = $tabla->addCell($colAncho1); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText('  Gratificaciones:', $fuente);
    $celda1 = $tabla->addCell($colAncho2); $textrun1 = $celda1->addTextRun($celdaEND); $textrun1->addText("", $fuenteb);
    $celda1 = $tabla->addCell($colAncho2); $textrun1 = $celda1->addTextRun($celdaEND); $textrun1->addText("S/.".nf($gratificaciones), $fuenteb);
}
if ($reintegro) {
    $tabla->addRow($filaAlto, [ "exactHeight" => true ]);
    $celda1 = $tabla->addCell($colAncho0); $textrun1 = $celda1->addTextRun($celdaEND); $textrun1->addText('', $fuente);
    $celda1 = $tabla->addCell($colAncho1); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText('  Reintegro:', $fuente);
    $celda1 = $tabla->addCell($colAncho2); $textrun1 = $celda1->addTextRun($celdaEND); $textrun1->addText("", $fuenteb);
    $celda1 = $tabla->addCell($colAncho2); $textrun1 = $celda1->addTextRun($celdaEND); $textrun1->addText("S/.".nf($reintegro), $fuenteb);
}
if ($incentivo) {
    $tabla->addRow($filaAlto, [ "exactHeight" => true ]);
    $celda1 = $tabla->addCell($colAncho0); $textrun1 = $celda1->addTextRun($celdaEND); $textrun1->addText('', $fuente);
    $celda1 = $tabla->addCell($colAncho1); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText('  Incentivo:', $fuente);
    $celda1 = $tabla->addCell($colAncho2); $textrun1 = $celda1->addTextRun($celdaEND); $textrun1->addText("", $fuenteb);
    $celda1 = $tabla->addCell($colAncho2); $textrun1 = $celda1->addTextRun($celdaEND); $textrun1->addText("S/.".nf($incentivo), $fuenteb);
}
if ($bonificacion) {
    $tabla->addRow($filaAlto, [ "exactHeight" => true ]);
    $celda1 = $tabla->addCell($colAncho0); $textrun1 = $celda1->addTextRun($celdaEND); $textrun1->addText('', $fuente);
    $celda1 = $tabla->addCell($colAncho1); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText('  Bonificación:', $fuente);
    $celda1 = $tabla->addCell($colAncho2); $textrun1 = $celda1->addTextRun($celdaEND); $textrun1->addText("", $fuenteb);
    $celda1 = $tabla->addCell($colAncho2); $textrun1 = $celda1->addTextRun($celdaEND); $textrun1->addText("S/.".nf($bonificacion), $fuenteb);
}
if ($bonificacion_graciosa) {
    $tabla->addRow($filaAlto, [ "exactHeight" => true ]);
    $celda1 = $tabla->addCell($colAncho0); $textrun1 = $celda1->addTextRun($celdaEND); $textrun1->addText('', $fuente);
    $celda1 = $tabla->addCell($colAncho1); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText('  Bonificación Graciosa:', $fuente);
    $celda1 = $tabla->addCell($colAncho2); $textrun1 = $celda1->addTextRun($celdaEND); $textrun1->addText("", $fuenteb);
    $celda1 = $tabla->addCell($colAncho2); $textrun1 = $celda1->addTextRun($celdaEND); $textrun1->addText("S/.".nf($bonificacion_graciosa), $fuenteb);
}
if ($bonificacion_extraordinaria) {
    $tabla->addRow($filaAlto, [ "exactHeight" => true ]);
    $celda1 = $tabla->addCell($colAncho0); $textrun1 = $celda1->addTextRun($celdaEND); $textrun1->addText('', $fuente);
    $celda1 = $tabla->addCell($colAncho1); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText('  Bonificación Extraordinaria:', $fuente);
    $celda1 = $tabla->addCell($colAncho2); $textrun1 = $celda1->addTextRun($celdaEND); $textrun1->addText("", $fuenteb);
    $celda1 = $tabla->addCell($colAncho2); $textrun1 = $celda1->addTextRun($celdaEND); $textrun1->addText("S/.".nf($bonificacion_extraordinaria), $fuenteb);
}

/* Tabla de Totales */
$tabla = $seccion->addTable();

$tabla->addRow($filaAlto);
$celda1 = $tabla->addCell($colAncho0); $textrun1 = $celda1->addTextRun($celdaEND); $textrun1->addText(' ');
$celda1 = $tabla->addCell($colAncho1); $textrun1 = $celda1->addTextRun($celdaSTART); $textrun1->addText("  Totales:", $fuente);
$celda1 = $tabla->addCell($colAncho2); $textrun1 = $celda1->addTextRun($celdaEND); $textrun1->addText("");
$celda1 = $tabla->addCell($colAncho2); $textrun1 = $celda1->addTextRun($celdaEND); $textrun1->addText("S/. ".nf($totalapagar), $fuenteb);

$textRun = $seccion->addTextRun([ "alignment" => Jc::START, "lineHeight" => 1, ]);
$textRun->addTextBreak(1);
$textRun->addText('Al firmar la presente liquidación dejo constancia expresa que los señores de ', $fuente);
$textRun->addText($_POST['empresa'], $fuenteb);
$textRun->addText(', han cumplido con abonarme todos los beneficios sociales conforme a Ley, por tanto, firmo dando por cancelado mi liquidación.', $fuente);
$textRun->addTextBreak(1);

$textRun = $seccion->addTextRun([ "alignment" => Jc::END, "lineHeight" => 1, ]);
$textRun->addText(isset($_POST['dpto']) ? strtoupper($_POST['dpto']).". " : "", $fuenteb);
$textRun->addText($_POST['fecha_emision'].".", $fuenteb);
$textRun->addTextBreak(7);

$textRun = $seccion->addTextRun([ "alignment" => Jc::CENTER, "lineHeight" => 1, ]);
$textRun->addText("________________________________", $fuente);
$textRun->addTextBreak(1);
$textRun->addText($_POST['nombres'].", ".$_POST['apellidos'], $fuentea);

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
        <div class="liquidacion9500">
            <div class="liq9500_empresa"><?php echo $_POST['empresa'] ?></div>
            <div class="liq9500_titulo">LIQUIDACION DE BENEFICIOS SOCIALES</div>
            <div class="liq9500_desglose"><div>nombres </div>               &nbsp;<div class="valores"><strong class="resaltar" ><?php echo $_POST['nombres']." ".$_POST['apellidos'] ?></strong></div></div>
            <div class="liq9500_desglose"><div>Cargo desempeñado </div>     &nbsp;<div class="valores"><strong class="resaltar" ><?php echo $cargo ?></strong></div></div>
            <div class="liq9500_desglose"><div>fecha de ingreso </div>      &nbsp;<div class="valores"><strong class="resaltar" ><?php echo $_POST['f_a_b'] ?></strong></div></div>
            <div class="liq9500_desglose"><div>fecha de cese </div>         &nbsp;<div class="valores"><strong class="resaltar" ><?php echo $_POST['f_b_b'] ?></strong></div></div>
            <div class="liq9500_desglose"><div>tiempo de servicios </div>   &nbsp;<div class="valores"><strong class="resaltar" ><?php echo $tiempo ?></strong></div></div>
            <div class="liq9500_desglose"><div>motivo de cese </div>        &nbsp;<div class="valores"><strong>renuncia voluntaria</strong></div></div>
            <div class="liq9500_desglose"><div>remuneración básica </div>   &nbsp;<div class="valores"><strong ><?php echo "S/.&nbsp;",nf($sueldo) ?></strong></div></div>
            <div class="liq9500_desglose" style="border-bottom: solid 2px black;"><div>pago total </div>&nbsp;<div class="valores"><strong ><?php echo "S/.&nbsp;",nf($totalapagar) ?></strong></div></div>
            <div class="liq9500_titulo" style="letter-spacing: .2em; margin-bottom: 3em">cálculo de la compensación</div>
            <div class="liq9500_calculo">
                <div class="titulo_b"><strong><?php echo $fechaini->format("d.m.Y")." AL $faf" ?></strong></div>
                &nbsp;=&nbsp;
                <div class="titulo_c"><strong> <?php echo "CTS DEPOSITADO EN BANCO" ?> </strong></div>
            </div>
            <div class="liq9500_calculo">
                <div class="titulo_b"><strong><?php echo "$fsf AL ".$fechafin->format("d.m.Y") ?></strong></strong></div>
                &nbsp;=&nbsp;
                <div class="titulo_c"><strong> <?php echo "$mesesa MES" ?> </strong></div>
            </div>
            <div class="liq9500_calculo">
                <div class="titulo_b"><strong><?php echo "REM. COMPEMSABLE: S/.".nf($sueldo)."/12x$mesesa" ?></strong></div>
                &nbsp;=&nbsp;
                <div class="titulo_c"><strong> <?php echo "S/.".nf($totalpago) ?> </strong></div>
            </div>
            
            <div class="" style="margin-top: 1.5em;" >
                <?php //if ($tretencion)                   { echo "<div class='liq6272_ret'><div></div> <div>Retención:</div>                   <div><strong class='resaltar'>(&nbsp;S/.",nf($tretencion)                   ," )</strong></div></div>"; } ?>
                <?php if ($adelanto)                    { echo "<div class='liq6272_ret'><div></div>  <div>Adelanto:</div>                    <div><strong class='resaltar'>(&nbsp;S/.",nf($adelanto)                    ," )</strong></div></div>"; } ?>
                <?php if ($vacaciones)                  { echo "<div class='liq6272_dev'><div></div>  <div>Vacaciones:</div>                  <div></div><div><strong class='resaltar'>&nbsp;S/." ,nf($vacaciones)                   ," </strong></div></div>"; } ?>
                <?php if ($gratificaciones)             { echo "<div class='liq6272_dev'><div></div>  <div>Gratificaciones:</div>             <div></div><div><strong class='resaltar'>&nbsp;S/." ,nf($gratificaciones)              ," </strong></div></div>"; } ?>
                <?php if ($reintegro)                   { echo "<div class='liq6272_dev'><div></div>  <div>Reintegro:</div>                   <div></div><div><strong class='resaltar'>&nbsp;S/." ,nf($reintegro)                   ,"  </strong></div></div>"; } ?>
                <?php if ($incentivo)                   { echo "<div class='liq6272_dev'><div></div>  <div>Incentivo:</div>                   <div></div><div><strong class='resaltar'>&nbsp;S/." ,nf($incentivo)                   ,"  </strong></div></div>"; } ?>
                <?php if ($bonificacion)                { echo "<div class='liq6272_dev'><div></div>  <div>Bonificación:</div>                <div></div><div><strong class='resaltar'>&nbsp;S/." ,nf($bonificacion)                ,"  </strong></div></div>"; } ?>
                <?php if ($bonificacion_graciosa)       { echo "<div class='liq6272_dev'><div></div>  <div>Bonificación Graciosa:</div>       <div></div><div><strong class='resaltar'>&nbsp;S/." ,nf($bonificacion_graciosa)       ,"  </strong></div></div>"; } ?>
                <?php if ($bonificacion_extraordinaria) { echo "<div class='liq6272_dev'><div></div>  <div>Bonificación Extraordinaria:</div> <div></div><div><strong class='resaltar'>&nbsp;S/." ,nf($bonificacion_extraordinaria) ,"  </strong></div></div>"; } ?>
            </div>
            <div class="" style="margin-top: 1.5em;border-top: 1px solid black; margin-bottom: 1.5em;" >
                <?php if ($total_deduc && $total_deven) { echo "<div class='liq6272_total'><div></div>     <div>Total:</div>                       <div></div><div><strong class='resaltar'>&nbsp;S/.",nf($totalapagar),"</strong></div></div>"; } ?>
            </div>

            <div class="liq9500_declaracion">Al firmar la presente liquidación dejo constancia expresa que los señores de <strong class="resaltar" ><?php echo $_POST['empresa'] ?></strong> han cumplido con abonarme todos los beneficios sociales conforme a Ley, por tanto, firmo dando por cancelado mi liquidación.</div>
            <div class="liq9500_fecha"><?php echo isset($_POST['dpto']) ? $_POST['dpto']."," : ""; ?> <?php echo $_POST['fecha_emision'] ?> </div>
            <div class="liq9500_firma"> <?php echo $_POST['nombres']." ".$_POST['apellidos'] ?> </div>
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