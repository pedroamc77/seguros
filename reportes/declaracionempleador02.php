<?php 

require_once('../_db/nomina.php');

if ( isset($_POST['cargo_al']) ) $cargo = $_POST['cargo_al'];
if ( isset($_POST['cargo_bl']) ) $cargo = $_POST['cargo_bl'];

$fechaini = date_create($_POST['f_a']);
$fechafin = date_create($_POST['f_b']);
$ff = date_create($_POST['f_b']);
$diferencia = date_diff($fechafin, $fechaini);

// $añobono = declaempleador($ff);

// $mes12 = isset($_POST['mes12']) && $_POST['mes12'] !== '' ? $_POST['mes12'] : 0;
// $mes01 = isset($_POST['mes01']) && $_POST['mes01'] !== '' ? $_POST['mes01'] : 0;
// $mes02 = isset($_POST['mes02']) && $_POST['mes02'] !== '' ? $_POST['mes02'] : 0;
// $mes03 = isset($_POST['mes03']) && $_POST['mes03'] !== '' ? $_POST['mes03'] : 0;
// $mes04 = isset($_POST['mes04']) && $_POST['mes04'] !== '' ? $_POST['mes04'] : 0;
// $mes05 = isset($_POST['mes05']) && $_POST['mes05'] !== '' ? $_POST['mes05'] : 0;
// $mes06 = isset($_POST['mes06']) && $_POST['mes06'] !== '' ? $_POST['mes06'] : 0;
// $mes07 = isset($_POST['mes07']) && $_POST['mes07'] !== '' ? $_POST['mes07'] : 0;
// $mes08 = isset($_POST['mes08']) && $_POST['mes08'] !== '' ? $_POST['mes08'] : 0;
// $mes09 = isset($_POST['mes09']) && $_POST['mes09'] !== '' ? $_POST['mes09'] : 0;
// $mes10 = isset($_POST['mes10']) && $_POST['mes10'] !== '' ? $_POST['mes10'] : 0;
// $mes11 = isset($_POST['mes11']) && $_POST['mes11'] !== '' ? $_POST['mes11'] : 0;

// $sueldo = ($mes12+$mes01+$mes02+$mes03+$mes04+$mes05+$mes06+$mes07+$mes08+$mes09+$mes10+$mes11)/12;

// $meseslaborados = ($diferencia->y*12)+$diferencia->m;

// $constante = 0.1831;

// $total = $sueldo*$meseslaborados*$constante;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Declaración Jurada del Empleador</title>
    
    <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="../css/estilos.min.css" media="all">

</head>
<body>
    <div class="pagina_decl" >
        <div class="declaracion">
            <div class="tituloa mayusculas">declaracion jurada del</div>
            <div class="tituloa mayusculas">empleador</div>
            <div class="titulob capitalizar">(supremo n° 054-07-cf, dano 1990)</div>
            <div class="titulob capitalizar">(para los fines señalados en la segunda disposición final y transitoria del decreto)</div>
            <div class="decl">
                <div style="width: content">Por la presente, yo </div><div class="divLinea truncar" style="width: 350px"><?php echo $_POST['rep_legal'] ?></div><div style="width: content">, identificado con </div><div class="divLinea" style="width: 155px"><?php echo $_POST['dni_a'] ?></div>
                <div style="width: content">en calidad de Representante Legal de la Empresa </div><div class="divLinea" style="width: 425px"><?php echo $_POST['empresa'] ?></div>
                <div style="width: content">identificada con Registro Único de Contribuyente - R.U.C. - N° </div><div class="divLinea" style="width: 128px"><?php echo $_POST['ruc'] ?></div><div style="width: content">. Declaro bajo juramento que el señor(a)</div>
                <div class="divLinea" style="width: 400px"><?php echo $_POST['apellidos'],", ",$_POST['nombres'] ?></div><div style="width: content">, identificado con D.N.I. N°</div><div class="divLinea" style="width: 160px"><?php echo $_POST['dni'] ?></div>,
                <div style="width: content">código IPSS N° </div><div class="divLinea" style="width: 240px"></div><div style="width: content">&nbsp;y Código Único SPP N° </div><div class="divLinea" style="width: 250px"></div>,
                <div style="width: content; height: 24px !important; align-items: end; margin-bottom: 1.5em;">ha laborado en esta empresa los períodos que se detallan a continiación.</div>
            </div>
            <!-- <p>
                Por la presente, yo ___________________________________________________________, identificado con D.N.I. N° 
                _____________________________________ en calidad de Representante Legal de la Empresa 
                _____________________________________________________________________ identificada con Registro Único de 
                Contribuyente - R.U.C. - N° __________________________________, declaro bajo juramento que el señor(a)
                ______________________________________________________________________________, identificado con D.N.I. N° 
                _____________________________________, código IPSS N° ___________________________ y Código Único SPP N°
                ______________________________________, ha laborado en esta empresa los períodos que se detallan a continiación.
            </p> -->
            <!-- <div class="decreto"><div></div>Bono de Reconocimiento 1992 (Decreto Supremo N°180-94-EF)</div>
            <div class="decreto"><div></div>Bono de Reconocimiento 1998 (Decreto Supremo N°054-97-EF)</div>
            <div class="decreto"><div></div>Bono de Reconocimiento 2001 (Decreto Supremo N°054-97-EF)</div> -->
            <!-- <div style="margin-top: 1em;">Ha laborado en esta empresa como se detalla a continuación:</div> -->
            <div class="cuadrados">
                <div class="cuadrados_cuadro">
                    <div class="cuadrados_titulo">A. Meses Laborados 1/</div>
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
                    <div class="cuadrados_titulo">B. Últimas doce (12) Remuneraciones 1/</div>
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
            <!-- <div>________________de_______________de_____________</div> -->
            <div><?php echo isset($_POST['dpto']) ? $_POST['dpto'].", " : '' ?><?php echo $_POST['f_a_b'] ?></div>
            <div class="firmaa">Firma y Sello del Representante legal</div>
            <!-- <div class="firma">Total <?php //echo nf($total) ?></div> -->
        </div>
    </div>
</body>
</html>