<?php 

require_once('../_db/nomina.php');

if ( isset($_POST['cargo_al']) ) $cargo = $_POST['cargo_al'];
if ( isset($_POST['cargo_bl']) ) $cargo = $_POST['cargo_bl'];

$fechaini = date_create($_POST['f_a']);
$fechafin = date_create($_POST['f_b']);
$diferencia = date_diff($fechafin, $fechaini);

// Deducciones
$adelanto = isset($_POST['adelanto']) ? $_POST['adelanto'] : 0;
// $retencion = isset($_POST['retencion']) ? $_POST['retencion'] : 0;
$retencion = 2;
$total_deduc = $adelanto;

// Devengaciones
$vacaciones = isset($_POST['vacaciones']) ? $_POST['vacaciones'] : 0;
$gratificaciones = isset($_POST['gratificaciones']) ? $_POST['gratificaciones'] : 0;
$reintegro = isset($_POST['reintegro']) ? $_POST['reintegro'] : 0;
$incentivo = isset($_POST['incentivo']) ? $_POST['incentivo'] : 0;
$bonificacion = isset($_POST['bonificacion']) ? $_POST['bonificacion'] : 0;
$bonificacion_graciosa = isset($_POST['bonificacion_graciosa']) ? $_POST['bonificacion_graciosa'] : 0;
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
$totalpago = $anios*$sueldo;
$retencion = $totalpago*($retencion/100);

$totalliquidacion = ($totalpago+$total_deven)-($total_deduc);



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


$seccion = $documento->addSection([ 'marginTop' => 800, "vAlign" => VerticalJc::CENTER ]);

$textRun = $seccion->addTextRun([ "alignment" => Jc::END, "lineHeight" => 1, ]);
$fuente = [ "size" => 12, "color" => "000000", "bold" => true ];
$textRun->addText($_POST['empresa'], $fuente);
$textRun->addTextBreak(1);

$fuentea = [ "color" => "ff0000", ];
$fuenteb = [ "color" => "ff0000", "bold" => true ];

$textRun = $seccion->addTextRun([ "alignment" => Jc::CENTER, "lineHeight" => 1, ]);
$fuente = [ "size" => 14, "color" => "000000", "bold" => true, "underline" => "single" ];
$textRun->addText("LIQUIDACIÓN DE BENEFICIOS SOCIALES", $fuente);
$textRun->addTextBreak(2);


$fuente = [ "color" => "000000", "bold" => true ];
$filaAlto = 150;
$coluAncho = 2500;
$coluAncho2 = 7500;
$coluSeparador = 200;

$styleTable = array('borderBottomSize' => 15, 'borderBottomColor' => '000000', "cellSpacing" => 0);
$documento->addTableStyle('adicionales', $styleTable);
$tabla = $seccion->addTable('adicionales');

$tabla->addRow($filaAlto);
$tabla->addCell($coluAncho)->addText("NOMBRES Y APELLIDOS", $fuente);
$tabla->addCell($coluSeparador)->addText(" : ");
$tabla->addCell($coluAncho2)->addText(strtoupper($_POST['nombres']." ".$_POST['apellidos']), $fuenteb);
$tabla->addRow($filaAlto);
$tabla->addCell($coluAncho)->addText("FECHA DE INGRESO", $fuente);
$tabla->addCell($coluSeparador)->addText(" : ");
$tabla->addCell($coluAncho2)->addText($_POST['f_a'], $fuenteb);
$tabla->addRow($filaAlto);
$tabla->addCell($coluAncho)->addText("FECHA DE CESE", $fuente);
$tabla->addCell($coluSeparador)->addText(" : ");
$tabla->addCell($coluAncho2)->addText($_POST['f_b'], $fuenteb);
$tabla->addRow($filaAlto);
$tabla->addCell($coluAncho)->addText("TIEMPO DE SERVICIOS", $fuente);
$tabla->addCell($coluSeparador)->addText(" : ");
$tabla->addCell($coluAncho2)->addText($tiempo, $fuenteb);
$tabla->addRow($filaAlto);
$tabla->addCell($coluAncho)->addText("CARGO", $fuente);
$tabla->addCell($coluSeparador)->addText(" : ");
$tabla->addCell($coluAncho2)->addText($cargo, $fuenteb);
$tabla->addRow($filaAlto);
$tabla->addCell($coluAncho)->addText("MOTIVO DE RENUNCIA", $fuente);
$tabla->addCell($coluSeparador)->addText(" : ");
$tabla->addCell($coluAncho2)->addText("VOLUNTARIA", $fuenteb);
$tabla->addRow($filaAlto);
$tabla->addCell($coluAncho)->addText("TOTAL A CANCELAR", $fuente);
$tabla->addCell($coluSeparador)->addText(" : ");
$tabla->addCell($coluAncho2)->addText("S/".nf($totalliquidacion), $fuenteb);

$textRun = $seccion->addTextRun([ "alignment" => Jc::START, "lineHeight" => 1, ]);
$textRun->addTextBreak(1);
$textRun->addText('CÁLCULO POR INDEMNIZACION POR TIEMPO DE SERVICIOS', [ "color" => "000000", "bold" => true, "underline" => "single" ]);

$fuente = [ "color" => "000000", "bold" => true ];
$filaAlto = 150;
$coluAncho1 = 5000;
$coluAncho2 = 5000;
$coluSeparador = 500;

$styleTable = array('borderBottomSize' => 15, 'borderBottomColor' => '000000', "cellSpacing" => 0);
$documento->addTableStyle('adicionales', $styleTable);
$tabla = $seccion->addTable('adicionales');
$tabla->addRow();

$celda1 = $tabla->addCell($coluAncho1); 
$textrun1 = $celda1->addTextRun([ "alignment" => JcTable::START, "cellMarginRight" => 50 ]); 
$textrun1->addText("$anios años", $fuenteb);
$textrun1->addText(" X ", $fuente);
$textrun1->addText("S/.".nf($sueldo), $fuenteb);
$tabla->addCell($coluSeparador)->addText(" = ", $fuente);
$celda2 = $tabla->addCell($coluAncho2); 
$textrun1 = $celda2->addTextRun([ "alignment" => JcTable::END, "cellMarginRight" => 50 ]); 
$textrun1->addText("S/.".nf($totalpago), $fuenteb);

/* Tabla de Adicionales */
$filaAlto = 100;
$colAncho0 = 500;
$colAncho1 = 6000;
$colAncho2 = 2000;

// $styleTable = array('borderBottomSize' => 15, 'borderBottomColor' => '000000', "cellSpacing" => 0);
// $documento->addTableStyle('adicionales', $styleTable);
$tabla = $seccion->addTable('adicionales');

if ($adelanto) {
    $tabla->addRow();
    $celda1 = $tabla->addCell(400); $textrun1 = $celda1->addTextRun([ "alignment" => JcTable::END, "cellMarginRight" => 50 ]); $textrun1->addText('', $fuente);
    $tabla->addCell($colAncho1)->addText("  Adelanto:", $fuente);
    $celda1 = $tabla->addCell($colAncho2); $textrun1 = $celda1->addTextRun([ "alignment" => JcTable::END, "cellMarginRight" => 50 ]); $textrun1->addText("(S/.".nf($adelanto).")", $fuenteb);
    $celda1 = $tabla->addCell($colAncho2); $textrun1 = $celda1->addTextRun([ "alignment" => JcTable::END, "cellMarginRight" => 50 ]); $textrun1->addText(" ", $fuenteb);
}
if ($vacaciones) {
    $tabla->addRow($filaAlto);
    $celda1 = $tabla->addCell(400); $textrun1 = $celda1->addTextRun([ "alignment" => JcTable::END, "cellMarginRight" => 50 ]); $textrun1->addText('', $fuente);
    $tabla->addCell($colAncho1)->addText("  Vacaciones:", $fuente);
    $celda1 = $tabla->addCell($colAncho2); $textrun1 = $celda1->addTextRun([ "alignment" => JcTable::END, "cellMarginRight" => 50 ]); $textrun1->addText("", $fuenteb);
    $celda1 = $tabla->addCell($colAncho2); $textrun1 = $celda1->addTextRun([ "alignment" => JcTable::END, "cellMarginRight" => 50 ]); $textrun1->addText("S/.".nf($vacaciones), $fuenteb);
}
if ($gratificaciones) {
    $tabla->addRow($filaAlto);
    $celda1 = $tabla->addCell(400); $textrun1 = $celda1->addTextRun([ "alignment" => JcTable::END, "cellMarginRight" => 50 ]); $textrun1->addText('', $fuente);
    $tabla->addCell($colAncho1)->addText("  Gratificaciones:", $fuente);
    $celda1 = $tabla->addCell($colAncho2); $textrun1 = $celda1->addTextRun([ "alignment" => JcTable::END, "cellMarginRight" => 50 ]); $textrun1->addText("", $fuenteb);
    $celda1 = $tabla->addCell($colAncho2); $textrun1 = $celda1->addTextRun([ "alignment" => JcTable::END, "cellMarginRight" => 50 ]); $textrun1->addText("S/.".nf($gratificaciones), $fuenteb);
}
if ($reintegro) {
    $tabla->addRow($filaAlto);
    $celda1 = $tabla->addCell(400); $textrun1 = $celda1->addTextRun([ "alignment" => JcTable::END, "cellMarginRight" => 50 ]); $textrun1->addText('', $fuente);
    $tabla->addCell($colAncho1)->addText("  Reintegro:", $fuente);
    $celda1 = $tabla->addCell($colAncho2); $textrun1 = $celda1->addTextRun([ "alignment" => JcTable::END, "cellMarginRight" => 50 ]); $textrun1->addText("", $fuenteb);
    $celda1 = $tabla->addCell($colAncho2); $textrun1 = $celda1->addTextRun([ "alignment" => JcTable::END, "cellMarginRight" => 50 ]); $textrun1->addText("S/.".nf($reintegro), $fuenteb);
}
if ($incentivo) {
    $tabla->addRow($filaAlto);
    $celda1 = $tabla->addCell(400); $textrun1 = $celda1->addTextRun([ "alignment" => JcTable::END, "cellMarginRight" => 50 ]); $textrun1->addText('', $fuente);
    $tabla->addCell($colAncho1)->addText("  Incentivo:", $fuente);
    $celda1 = $tabla->addCell($colAncho2); $textrun1 = $celda1->addTextRun([ "alignment" => JcTable::END, "cellMarginRight" => 50 ]); $textrun1->addText("", $fuenteb);
    $celda1 = $tabla->addCell($colAncho2); $textrun1 = $celda1->addTextRun([ "alignment" => JcTable::END, "cellMarginRight" => 50 ]); $textrun1->addText("S/.".nf($incentivo), $fuenteb);
}
if ($bonificacion) {
    $tabla->addRow($filaAlto);
    $celda1 = $tabla->addCell(400); $textrun1 = $celda1->addTextRun([ "alignment" => JcTable::END, "cellMarginRight" => 50 ]); $textrun1->addText('', $fuente);
    $tabla->addCell($colAncho1)->addText("  Bonificación:", $fuente);
    $celda1 = $tabla->addCell($colAncho2); $textrun1 = $celda1->addTextRun([ "alignment" => JcTable::END, "cellMarginRight" => 50 ]); $textrun1->addText("", $fuenteb);
    $celda1 = $tabla->addCell($colAncho2); $textrun1 = $celda1->addTextRun([ "alignment" => JcTable::END, "cellMarginRight" => 50 ]); $textrun1->addText("S/.".nf($bonificacion), $fuenteb);
}
if ($bonificacion_graciosa) {
    $tabla->addRow($filaAlto);
    $celda1 = $tabla->addCell(400); $textrun1 = $celda1->addTextRun([ "alignment" => JcTable::END, "cellMarginRight" => 50 ]); $textrun1->addText('', $fuente);
    $tabla->addCell($colAncho1)->addText("  Bonificación Graciosa:", $fuente);
    $celda1 = $tabla->addCell($colAncho2); $textrun1 = $celda1->addTextRun([ "alignment" => JcTable::END, "cellMarginRight" => 50 ]); $textrun1->addText("", $fuenteb);
    $celda1 = $tabla->addCell($colAncho2); $textrun1 = $celda1->addTextRun([ "alignment" => JcTable::END, "cellMarginRight" => 50 ]); $textrun1->addText("S/.".nf($bonificacion_graciosa), $fuenteb);
}
if ($bonificacion_extraordinaria) {
    $tabla->addRow($filaAlto);
    $celda1 = $tabla->addCell(400); $textrun1 = $celda1->addTextRun([ "alignment" => JcTable::END, "cellMarginRight" => 50 ]); $textrun1->addText('', $fuente);
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
$celda1 = $tabla->addCell($colAncho2); $textrun1 = $celda1->addTextRun([ "alignment" => JcTable::END, "cellMarginRight" => 50 ]); $textrun1->addText("S/. ".nf($total_deven-$total_deduc), $fuenteb);

$fuente = [ "color" => "000000", "bold" => true ];
$filaAlto = 150;
$coluAncho1 = 5000;
$coluAncho2 = 5000;
$coluSeparador = 500;

$styleTable = array("cellSpacing" => 0);
$documento->addTableStyle('totales', $styleTable);
$tabla = $seccion->addTable('totales');
$tabla->addRow();

$celda1 = $tabla->addCell($coluAncho1); 
$textrun1 = $celda1->addTextRun([ "alignment" => JcTable::START, "cellMarginRight" => 50 ]); 
$textrun1->addText("TOTAL: ", $fuente);
$textrun1->addText("S/.".nf($totalpago), $fuenteb);
$textrun1->addText(" + ", $fuente);
$textrun1->addText("S/.".nf($total_deven-$total_deduc), $fuenteb);

$tabla->addCell($coluSeparador)->addText(" = ", $fuente);

$celda2 = $tabla->addCell($coluAncho2); 
$textrun1 = $celda2->addTextRun([ "alignment" => JcTable::END, "cellMarginRight" => 50 ]); 
$textrun1->addText("S/.".nf($totalliquidacion), $fuenteb);

$textRun = $seccion->addTextRun();
$textRun->addTextBreak();
$textRun = $seccion->addTextRun([ "alignment" => Jc::LOW_KASHIDA, "lineHeight" => 1, "hanging" => -3.5 ]);
$textRun->addText("HE RECIBIDO DE LA EMPRESA ", $fuente);
$textRun->addText($_POST['empresa'], $fuenteb);
$textRun->addText(" LA SUMA DE ", $fuente);
$textRun->addText(strtoupper(convertir($totalliquidacion)), $fuenteb);
$textRun->addText(", POR EL CONCEPTO DE MI INDEMNIZACION POR MI TIEMPO DE SERVICIOS PRESTADOS EN ESTA EMPRESA, FIRMANDO EL PRESENTE DOCUMENTO, EN SEÑAL DE MI CONFORMIDAD.", $fuente);
$textRun->addTextBreak(1);

$textRun = $seccion->addTextRun([ "alignment" => Jc::END, "lineHeight" => 1, ]);
$textRun->addText(isset($_POST['dpto']) ? strtoupper($_POST['dpto']).". " : "", $fuenteb);
$textRun->addText($_POST['fecha_emision'].".", $fuenteb);
$textRun->addTextBreak(3);

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
$textrun1->addText("EMPLEADOR", $fuente);

$celda2 = $tabla->addCell($coluAncho2); 
$textrun1 = $celda2->addTextRun([ "alignment" => JcTable::CENTER, "cellMarginRight" => 50 ]); 
$textrun1->addText("Don(ña) ".$_POST['nombres']." ".$_POST['apellidos'], $fuenteb);

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
        <div class="liquidacion7375">
            <div class="liq7375_empresa"><?php echo $_POST['empresa'] ?></div>
            <div class="liq7375_titulo">liquidación de beneficios sociales</div>
            <div class="liq7375_desglose"><div>nombres y apellidos                </div>   &nbsp;<div class="valores"><strong class="resaltar" ><?php echo $_POST['nombres']." ".$_POST['apellidos'] ?></strong></div></div>
            <div class="liq7375_desglose"><div>fecha de ingreso                   </div>   &nbsp;<div class="valores"><strong class="resaltar" ><?php echo $_POST['f_a'] ?>                            </strong></div></div>
            <div class="liq7375_desglose"><div>fecha de cese                      </div>   &nbsp;<div class="valores"><strong class="resaltar" ><?php echo $_POST['f_b'] ?>                            </strong></div></div>
            <div class="liq7375_desglose"><div>Tiempo de Servicios                </div>   &nbsp;<div class="valores"><strong class="resaltar" ><?php echo $tiempo ?>                                  </strong></div></div>
            <div class="liq7375_desglose"><div>Cargo                              </div>   &nbsp;<div class="valores"><strong class="resaltar" ><?php echo $cargo ?>                                   </strong></div></div>
            <div class="liq7375_desglose"><div>Motivo de Renuncia                 </div>   &nbsp;<div class="valores"><strong class="resaltar" >Voluntaria                                             </strong></div></div>
            <div class="liq7375_desglose" style="border-bottom: solid 2px black;"><div>Total a Cancelar </div>      &nbsp;<div class="valores"><strong class="resaltar" ><?php echo "S/".nf($totalliquidacion) ?></strong></div></div>
            <div class="liq7375_tcalculo">CÁLCULO POR INDEMNIZACION POR TIEMPO DE SERVICIOS</div>

            <div class="liq7375_calculo">
                <div class="titulo_b"><strong class="resaltar" ><?php echo "$anios años" ?></strong> X <strong class="resaltar" ><?php echo "S/.".nf($sueldo) ?></strong></div>
                &nbsp;=&nbsp;
                <div class="titulo_c"><strong class="resaltar" > <?php echo "S/.".nf($totalpago) ?> </strong></div>
            </div>

            <div class="" style="margin-top: 1.5em;" >
                <?php //if ($retencion)                   { echo "<div class='liq6272_ret'><div>IV</div>     <div>Retención:</div>                   <div><strong class='resaltar'>(&nbsp;S/.",nf($retencion)                   ," )</strong></div></div>"; } ?>
                <?php if ($adelanto)                    { echo "<div class='liq6272_ret'><div></div>      <div>Adelanto:</div>                    <div><strong class='resaltar'>(&nbsp;S/.",nf($adelanto)                    ," )</strong></div></div>"; } ?>
                <?php if ($vacaciones)                  { echo "<div class='liq6272_dev'><div></div>     <div>Vacaciones:</div>                  <div></div><div><strong class='resaltar'>&nbsp;S/." ,nf($vacaciones)                   ," </strong></div></div>"; } ?>
                <?php if ($gratificaciones)             { echo "<div class='liq6272_dev'><div></div>    <div>Gratificaciones:</div>             <div></div><div><strong class='resaltar'>&nbsp;S/." ,nf($gratificaciones)              ," </strong></div></div>"; } ?>
                <?php if ($reintegro)                   { echo "<div class='liq6272_dev'><div></div>   <div>Reintegro:</div>                   <div></div><div><strong class='resaltar'>&nbsp;S/." ,nf($reintegro)                   ,"  </strong></div></div>"; } ?>
                <?php if ($incentivo)                   { echo "<div class='liq6272_dev'><div></div>     <div>Incentivo:</div>                   <div></div><div><strong class='resaltar'>&nbsp;S/." ,nf($incentivo)                   ,"  </strong></div></div>"; } ?>
                <?php if ($bonificacion)                { echo "<div class='liq6272_dev'><div></div>      <div>Bonificación:</div>                <div></div><div><strong class='resaltar'>&nbsp;S/." ,nf($bonificacion)                ,"  </strong></div></div>"; } ?>
                <?php if ($bonificacion_graciosa)       { echo "<div class='liq6272_dev'><div></div>     <div>Bonificación Graciosa:</div>       <div></div><div><strong class='resaltar'>&nbsp;S/." ,nf($bonificacion_graciosa)       ,"  </strong></div></div>"; } ?>
                <?php if ($bonificacion_extraordinaria) { echo "<div class='liq6272_dev'><div></div>    <div>Bonificación Extraordinaria:</div> <div></div><div><strong class='resaltar'>&nbsp;S/." ,nf($bonificacion_extraordinaria) ,"  </strong></div></div>"; } ?>
            </div>
            <div class="" style="margin-top: 1.5em;border-top: 1px solid black;" >
                <?php if ($total_deduc && $total_deven) { echo "<div class='liq6272_total'><div></div>     <div>Total:</div>                       <div></div><div><strong class='resaltar'>&nbsp;S/.",nf($total_deven-$total_deduc),"</strong></div></div>"; } ?>
            </div>

            <div class="liq7375_calculo" style="margin-top: 1em;">
                <div class="titulo_b">Total: <strong class="resaltar" > <?php echo "S/.".nf($totalpago) ?> </strong> + <strong class="resaltar" ><?php echo "S/.".nf($total_deven-$total_deduc) ?></strong></div>
                &nbsp;=&nbsp;
                <div class="titulo_c"><strong class="resaltar" > <?php echo "S/.".nf($totalliquidacion) ?> </strong></div>
            </div>

            <div class="liq7375_declaracion">HE RECIBIDO DE LA EMPRESA  <strong class="resaltar mayusculas"><?php echo $_POST['empresa'] ?></strong>  LA SUMA DE <strong class="resaltar mayusculas"><?php echo convertir($totalliquidacion)."  Y 00/100 SOLES ORO" ?></strong>, POR EL CONCEPTO DE MI INDEMNIZACION POR MI TIEMPO DE SERVICIOS PRESTADOS EN ESTA EMPRESA, FIRMANDO EL PRESENTE DOCUMENTO, EN SEÑAL DE MI CONFORMIDAD. </div>
            <div class="liq7375_fecha"><?php echo isset($_POST['dpto']) ? $_POST['dpto']."," : ""; ?> <?php echo $_POST['fecha_emision'] ?> </div>
            <div class="liq7375_firmas">
                <div class="liq7375_firmas_bloques">
                    <div class="liq7375_firmas_bloques_titulo mayusculas">Empleador</div>
                </div>
                <div class="liq7375_firmas_bloques">
                    <div class="liq7375_firmas_bloques_titulo mayusculas"><strong class="resaltar" > Don(<span style="text-transform: lowercase">ña</span>) <?php echo $_POST['nombres']." ".$_POST['apellidos'] ?></strong></div>
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