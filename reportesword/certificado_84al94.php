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

$textRun = $seccion->addTextRun([ "alignment" => Jc::START, "lineHeight" => 1, ]);
$fuente = [ "color" => "000000", "bold" => true ];
$textRun->addTextBreak(2);
$textRun->addText($_POST['empresa'], $fuente);
$textRun->addTextBreak(4);

$fuentea = [ "color" => "ff0000", ];

$textRun = $seccion->addTextRun([ "alignment" => Jc::END, "lineHeight" => 1.5, ]);
$textRun->addText(isset($_POST['dpto']) ? strtoupper($_POST['dpto']).". " : "", $fuentea);
$textRun->addText($_POST['emision'].".", $fuentea);
$textRun->addTextBreak(1);

$textRun = $seccion->addTextRun([ "alignment" => Jc::CENTER, "lineHeight" => 1, ]);
$fuente = [ "color" => "000000", "bold" => true, "underline" => "single", ];
$textRun->addText("CONSTANCIA DE TRABAJO", $fuente);
$textRun->addTextBreak(2);

$fuente =  [ "color" => "000000", ];
$textRun = $seccion->addTextRun([ "alignment" => Jc::LOW_KASHIDA, "lineHeight" => 1.5, ]);
$textRun->addText("SE DEJA CONSTANCIA QUE EL SEÑOR(A) ", $fuente);
$textRun->addText(strtoupper($_POST['nombres'])." ", $fuentea);
$textRun->addText(strtoupper($_POST['apellidos']), $fuentea);
$textRun->addText(" HA LABORADO PARA NUESTRA EMPRESA COMO ", $fuente);
$textRun->addText(strtoupper($cargo), $fuentea);
$textRun->addText(" A PARTIR DEL ", $fuente);
$textRun->addText(strtoupper($_POST['f_a']), $fuentea);
$textRun->addText(" AL ", $fuente);
$textRun->addText(strtoupper($_POST['f_b']), $fuentea);
$textRun->addText(".", $fuente);
$textRun->addTextBreak(2);

// $textRun = $seccion->addTextRun([ "alignment" => Jc::LOW_KASHIDA, "lineHeight" => 1.5,  ]);
$textRun->addText("DURANTE SU TIEMPO DE SERVICIOS EL MENCIONADO SEÑOR, DEMOSTRO EN TODO MOMENTO UN ALTO GRADO DE RESPONSABILIDAD EN LAS TAREAS ENCOMENDADAS POR LA EMPRESA.", $fuente);
$textRun->addTextBreak(2);

// $textRun = $seccion->addTextRun([ "alignment" => Jc::LOW_KASHIDA, "lineHeight" => 1.5,  ]);
$textRun->addText("A SOLICITUD DEL INTERESADO, SE EXTIENDE LA CONSTANCIA PARA EL USO QUE EL, LE PUEDA DAR.", $fuente);


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
        <div class="certificado8494">
            <div class="cer8494_empresa"><?php echo $_POST['empresa'] ?></div>
            <div class="cer8494_fecha"><strong><?php echo isset($_POST['dpto']) ? $_POST['dpto']."," : ""; ?> <?php echo $_POST['fecha_emision'] ?></strong> </div>
            <div class="cer8494_titulo"><strong>Constancia de Trabjao </strong></div>
            <div class="cer8494_cuerpo">SE DEJA CONSTANCIA QUE EL SEÑOR(A) <strong class="resaltar"><?php echo $_POST['nombres']." ".$_POST['apellidos'] ?></strong>, HA LABORADO PARA NUESTRA EMPRESA COMO <strong style="color: red"><?php echo $cargo ?></strong> A PARTIR DEL <strong class="resaltar"><?php echo $_POST['f_a_b'] ?></strong> AL <strong style="color: red"><?php echo $_POST['f_b_b'] ?></strong>. </div>
            <div class="cer8494_cuerpo">DURANTE SU TIEMPO DE SERVICIOS EL MENCIONADO SEÑOR, DEMOSTRO EN TODO MOMENTO UN ALTO GRADO DE RESPONSABILIDAD EN LAS TAREAS ENCOMENDADAS POR LA EMPRESA.</div>
            <div class="cer8494_cuerpo">A SOLICITUD DEL INTERESADO, SE EXTIENDE LA CONSTANCIA PARA EL USO QUE EL, LE PUEDA DAR.</div>
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