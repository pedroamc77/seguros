<?php

include_once "./_db/nomina.php";

$valido = false;
do {
    $aniosa = rand(8, 12);
    $aniosb = rand(8, 12);
    $daysint = rand(8, 25);
    $monthsint = rand(1, 3);
    $aniosint = rand(0, 2);
    if ( ( $aniosa + $aniosb ) >= 20 ) $valido = true;
} while (!$valido);

$fnacimiento = "1940/06/24";

for ($numemp = 1; $numemp < 3; $numemp++ ) {

    $datos = generar_fechas_trabajo(array($fnacimiento, $aniosa, $aniosb, $daysint, $monthsint, $aniosint), $numemp === 2, $numemp === 2 ? $fecha_anterior : null );
    $fecha_anterior = $datos['fb3'];
    var_dump($datos);

}
