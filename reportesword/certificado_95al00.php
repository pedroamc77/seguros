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
$propiedades->setTitle("Certificado_95_00");

$seccion = $documento->addSection();
# Títulos. Solo modificando depth (el número)
$fuenteTitulo = [ "color" => "ff0000", ];
$documento->addTitleStyle(1, $fuenteTitulo);
$seccion->addTextBreak(3);
$seccion->addTitle($_POST['empresa'], 1);
$seccion->addTextBreak(3);

$fuentea = [ "color" => "ff0000", ];

$textRun = $seccion->addTextRun([ "alignment" => Jc::CENTER, "lineHeight" => 1, ]);
$fuente = [ "size" => 20, "color" => "000000", "bold" => true, ];
$textRun->addText("Constancia de Trabajo", $fuente);
$textRun->addTextBreak(4);

$textRun = $seccion->addTextRun([ "alignment" => Jc::LOW_KASHIDA, "lineHeight" => 1, ]);

$fuente =  [ "color" => "000000", ];
$textRun->addText("SE DEJA CONSTANCIA QUE EL SEÑOR(A) ", $fuente);
$textRun->addText(strtoupper($_POST['nombres'])." ", $fuentea);
$textRun->addText(strtoupper($_POST['apellidos']), $fuentea);
$textRun->addText(" HA LABORADO PARA NUESTRA EMPRESA COMO ", $fuente);
$textRun->addText(strtoupper($cargo), $fuentea);
$textRun->addText(" A PARTIR DEL ", $fuente);
$textRun->addText(strtoupper($_POST['f_a_b']), $fuentea);
$textRun->addText(" AL ", $fuente);
$textRun->addText(strtoupper($_POST['f_b_b']), $fuentea);
$textRun->addText(".", $fuente);
$textRun->addTextBreak(2);

// $textRun = $seccion->addTextRun([ "alignment" => Jc::LOW_KASHIDA, "lineHeight" => 1, ]);
$textRun->addText("DURANTE SU TIEMPO DE SERVICIOS EL MENCIONADO SEÑOR, DEMOSTRO EN TODO MOMENTO UN ALTO GRADO DE RESPONSABILIDAD EN LAS TAREAS ENCOMENDADAS POR LA EMPRESA.", $fuente);
$textRun->addTextBreak(2);

// $textRun = $seccion->addTextRun([ "alignment" => Jc::LOW_KASHIDA, "lineHeight" => 1, ]);
$textRun->addText("A SOLICITUD DEL INTERESADO, SE EXTIENDE LA CONSTANCIA PARA EL USO QUE ÉL, LE PUEDA DAR.", $fuente);
$textRun->addTextBreak(2);
$textRun->addText(" ", $fuente);
$textRun->addTextBreak(1);

$textRun = $seccion->addTextRun([ "alignment" => Jc::END, "lineHeight" => 1, ]);
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
        <div class="certificado9500">
            <div class="cer9500_empresa resaltar"><?php echo $_POST['empresa'] ?></div>
            <div class="cer9500_titulo"><center><strong>Constancia de Trabajo </strong></center></div>
            <div class="cer9500_cuerpo">SE DEJA CONSTANCIA QUE EL SEÑOR(A) <strong class="resaltar"><?php echo $_POST['nombres']." ".$_POST['apellidos'] ?></strong>, HA LABORADO PARA NUESTRA EMPRESA COMO <strong style="color: red"><?php echo $cargo ?></strong> A PARTIR DEL <strong class="resaltar"><?php echo $_POST['f_a_b'] ?></strong> AL <strong style="color: red"><?php echo $_POST['f_b_b'] ?></strong>. </div>
            <div class="cer9500_cuerpo">DURANTE SU TIEMPO DE SERVICIOS EL MENCIONADO SEÑOR, DEMOSTRO EN TODO MOMENTO UN ALTO GRADO DE RESPONSABILIDAD EN LAS TAREAS ENCOMENDADAS POR LA EMPRESA.</div>
            <div class="cer9500_cuerpo">A SOLICITUD DEL INTERESADO, SE EXTIENDE LA CONSTANCIA PARA EL USO QUE EL, LE PUEDA DAR.</div>
            <div class="cer9500_fecha"><strong><?php echo isset($_POST['dpto']) ? $_POST['dpto']."," : ""; ?> <?php echo $_POST['emision'] ?></strong> </div>
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