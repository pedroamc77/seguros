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

$textRun = $seccion->addTextRun([ "alignment" => Jc::RIGHT, "lineHeight" => 1, ]);
$fuente = [ "size" => 18, "color" => "000000", "bold" => true, "underline" => "single", ];
$textRun->addTextBreak(2);
$textRun->addText($_POST['empresa'], $fuente);
$textRun->addTextBreak(7);

$textRun = $seccion->addTextRun([ "alignment" => Jc::CENTER, "lineHeight" => 1, ]);
$fuente = [ "color" => "000000", "bold" => true, "underline" => "single", ];
$textRun->addText("CERTIFICADO DE TRABAJO", $fuente);
$textRun->addTextBreak(3);

$fuentea = [ "color" => "ff0000", ];

$fuente =  [ "color" => "000000", ];
$textRun = $seccion->addTextRun([ "alignment" => Jc::LOW_KASHIDA, "lineHeight" => 1.5, ]);
$textRun->addText("Certificamos que ", $fuente);
$textRun->addText($_POST['nombres']." ", $fuentea);
$textRun->addText($_POST['apellidos'], $fuentea);
$textRun->addText(" ha trabajado en nuestra empresa desde el ", $fuente);
$textRun->addText($_POST['f_a_b'], $fuentea);
$textRun->addText(" y siendo su cese el ", $fuente);
$textRun->addText($_POST['f_b_b'].".", $fuentea);
$textRun->addText(" desempeñándose como ", $fuente);
$textRun->addText($cargo, $fuentea);
$textRun->addText(".", $fuente);
$textRun->addTextBreak(2);

// $textRun = $seccion->addTextRun([ "alignment" => Jc::LOW_KASHIDA, "lineHeight" => 1.5,  ]);
$textRun->addText("Durante el tiempo de su permanencia, ha demostrado honradez, buena conducta en la empresa, extendiéndose el presente certificado para los fines que estime conveniente.", $fuente);
$textRun->addTextBreak(3);

$textRun = $seccion->addTextRun([ "alignment" => Jc::END, "lineHeight" => 1.5, ]);
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
        <div class="certificado7375">
            <div class="cer7375_empresa"><?php echo $_POST['empresa'] ?></div>
            <div class="cer7375_titulo">certificado de trabajo</div>
            <div class="cer7375_cuerpo">Certificamos que <strong class="subrayar" style="color: red"><?php echo $_POST['nombres']." ".$_POST['apellidos'] ?></strong> ha trabajado en nuestra empresa desde el <strong style="color: red"><?php echo $_POST['f_a_b'] ?></strong> y siendo su cese el <strong style="color: red"><?php echo $_POST['f_b_b'] ?></strong> desempeñandose como <strong style="color: red"><?php echo $cargo; ?> </strong>. </div>
            <div class="cer7375_cuerpo">Durante el tiempo de su permanencia, ha demostrado honradez, buena conducta en la empresa, extendiéndose el presente certificado para los fines que estime conveniente.</div>
            <div class="cer7375_fecha"><strong><?php echo isset($_POST['dpto']) ? $_POST['dpto']."," : ""; ?> <?php echo $_POST['emision'] ?></strong> </div>
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