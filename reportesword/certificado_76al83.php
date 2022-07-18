<?php

if ( isset($_POST['cargo_ac']) ) $cargo = $_POST['cargo_ac'];
if ( isset($_POST['cargo_bc']) ) $cargo = $_POST['cargo_bc'];

$ruta = "../word/certificados/";
$nombre_archivo = "certificado_".strtoupper($_POST['nombres'])."_".strtoupper($_POST['apellidos'])."_".$_POST['emision']."_.docx";

require_once "../vendor/autoload.php";
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\Style\Language;
$documento = new \PhpOffice\PhpWord\PhpWord();
$documento->setDefaultFontName('Calibri');
$documento->setDefaultFontSize(16);
$propiedades = $documento->getDocInfo();
$propiedades->setCreator("iBritek <www.ibritek.com>");
$propiedades->setTitle("Certificado_73_75");

$seccion = $documento->addSection();

$textRun = $seccion->addTextRun([ "alignment" => Jc::CENTER, "lineHeight" => 1, ]);
$fuente = [ "color" => "000000", "bold" => true ];
$textRun->addTextBreak(2);
$textRun->addText($_POST['empresa'], $fuente);
$textRun->addTextBreak(5);

$textRun = $seccion->addTextRun([ "alignment" => Jc::START, "lineHeight" => 1, ]);
$fuente = [ "color" => "000000", "bold" => true, "underline" => "single", ];
$textRun->addText("CERTIFICADO", $fuente);
$textRun->addTextBreak(3);

$fuentea = [ "color" => "ff0000", ];

$fuente =  [ "color" => "000000", ];
$textRun = $seccion->addTextRun([ "alignment" => Jc::LOW_KASHIDA, "lineHeight" => 1.5, ]);
$textRun->addText("SE CERTIFICA A ", $fuente);
$textRun->addText(strtoupper($_POST['nombres'])." ", $fuentea);
$textRun->addText(strtoupper($_POST['apellidos']), $fuentea);
$textRun->addText(", POR HABER TRABAJADO PARA ESTA EMPRESA, DURANTE EL PARÍODO ", $fuente);
$textRun->addText(strtoupper($_POST['f_a']), $fuentea);
$textRun->addText(" AL ", $fuente);
$textRun->addText(strtoupper($_POST['f_b']), $fuentea);
$textRun->addText(", COMO ", $fuente);
$textRun->addText(strtoupper($cargo), $fuentea);
$textRun->addText(".", $fuente);
$textRun->addTextBreak(2);

// $textRun = $seccion->addTextRun([ "alignment" => Jc::LOW_KASHIDA, "lineHeight" => 1.5,  ]);
$textRun->addText("EL PRESENTE CERTIFICADO SE EXPIDE A SOLICITUD DEL INTERESADO PARA LOS FINES QUE ESTIME CONVENIENTE.", $fuente);
$textRun->addTextBreak(3);

$textRun = $seccion->addTextRun([ "alignment" => Jc::CENTER, "lineHeight" => 1.5, ]);
$textRun->addText(isset($_POST['dpto']) ? strtoupper($_POST['dpto']).". " : "", $fuentea);
$textRun->addText($_POST['emision'].".", $fuentea);


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
    <title>SisPen - Certificados</title>
    <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="../css/estilos.min.css" media="all">
    <link rel="stylesheet" href="../css/impresion.min.css" media="print">
</head>
<body>
    <div class="pagina" >
        <div class="certificado7683">
            <div class="cer7683_empresa"><?php echo $_POST['empresa'] ?></div>
            <div class="cer7683_titulo"><strong>Certificado </strong></div>
            <div class="cer7683_cuerpo">SE CERTIFICA A <strong class="subrayar" style="color: red"><?php echo $_POST['nombres']." ".$_POST['apellidos'] ?></strong>, por haber trabajado para esta empresa, durante el paríodo <strong style="color: red"><?php echo $_POST['f_a'] ?></strong> al <strong style="color: red"><?php echo $_POST['f_b'] ?></strong>, como <strong style="color: red"><?php echo $cargo ?></strong>. </div>
            <div class="cer7683_cuerpo">EL PRESENTE CERTIFICADO SE EXPIDE A SOLICITUD DEL INTERESADO PARA LOS FINES QUE ESTIME CONVENIENTE.</div>
            <div class="cer7683_fecha"><strong><?php echo isset($_POST['dpto']) ? $_POST['dpto']."," : ""; ?> <?php echo $_POST['emision'] ?></strong> </div>
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