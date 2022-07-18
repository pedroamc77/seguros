<?php
require_once 'funciones.php';

$meses = array("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
$mes = array("", "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic");

function obtener_sueldo($fecha) {
    // echo $fecha,"<br>";
    $sql  = "SELECT * FROM sueldos WHERE desde <= '$fecha' and hasta >= '$fecha' LIMIT 1";
    // echo $sql,"<br>";
    // SELECT * FROM sueldos WHERE desde <= '1974-12-25' and hasta >= '1974-12-25' LIMIT 1
    // echo $sql;
    // exit;
    try {
        $db = new db();
        $db = $db->connectionDB();
        $resultado = $db->query($sql);
        if ($resultado->rowCount() > 0) {
            $datos = $resultado->fetchAll();
            return $datos[0];
        } else {
            return "No existen registros";
        }
    } catch (\Throwable $th) {
        return "Error al consultar información.";
    }
}

// function generar_fechas_trabajo($fnac, $aniosa, $aniosb, $daysint, $monthsint, $ultimafecha, $fecha_anterior) {
function generar_fechas_trabajo($dF, $ultimafecha = false, $fecha_anterior =  "0000-00-00") {
    $meses = array("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
    $mes = array("", "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic");

    var_dump($dF);

    $fechas = array();
    
    if (!$ultimafecha) {
        $datea_a = date_create($dF[0]);
        $datea_a = date_add($datea_a, date_interval_create_from_date_string("18 year"));
    } else {
        $datea_a = date_create($fecha_anterior);
        $datea_a = date_add($datea_a, date_interval_create_from_date_string($dF[4]." months"));
    }

    $datecomp = date_create("1999-06-30");
    
    $datea_a = date_add($datea_a, date_interval_create_from_date_string($dF[4]." months"));
    $datea_a = date_add($datea_a, date_interval_create_from_date_string($dF[3]." days"));

    $dateDA = date_diff($datea_a , $datecomp);

    var_dump($dateDA);

    if ($dateDA->invert === 0) {

        $fechas['fa1'] = date_format($datea_a, "j").' de '.$meses[date_format($datea_a , "n")].' de '.date_format($datea_a , "Y"); 
        $fechas['fa2'] = date_format($datea_a, "d.m.Y"); 
        $fechas['fa3'] = date_format($datea_a, "Y-m-d");
        $fechas['fa4'] = date_format($datea_a, "j").'.'.$mes[date_format($datea_a , "n")].'.'.date_format($datea_a , "Y"); 
        
        $datea_b = date_add($datea_a, date_interval_create_from_date_string(($dF[4] + 1)." months"));
        $datea_b = date_add($datea_b, date_interval_create_from_date_string($dF[5]." days"));
        if (!$ultimafecha) $datea_b = date_add($datea_b, date_interval_create_from_date_string($dF[1]." years"));
        if ($ultimafecha) $datea_b = date_add($datea_b, date_interval_create_from_date_string($dF[2]." years"));
    } else {
        return array();
    }
    
    $datea_b = date_create(date_format($datea_b, "Y-m-d"));
    $dateDB = date_diff($datea_b , $datecomp);

    if ($dateDB->invert === 0) {
        $fechas['fb1'] = date_format($datea_b, 'j').' de '.$meses[date_format($datea_b , "n")].' de '.date_format($datea_b , "Y"); 
        $fechas['fb2'] = date_format($datea_b, "d.m.Y"); 
        $fechas['fb3'] = date_format($datea_b, "Y-m-d");
        $fechas['fb4'] = date_format($datea_b, 'j').'.'.$mes[date_format($datea_b , "n")].'.'.date_format($datea_b , "Y"); 
        
        $emisiona_b = date_create(date_format($datea_b, "d.m.Y"));
        $emisiona_b = date_add($emisiona_b, date_interval_create_from_date_string("7 days"));
        
        $fechas['emision'] = date_format($emisiona_b, "d.m.Y"); 
        $fechas['anniorep'] = date_format($datea_b, "Y");
    } else {
        $fechas['fb1'] = date_format($datecomp, 'j').' de '.$meses[date_format($datecomp , "n")].' de '.date_format($datecomp , "Y"); 
        $fechas['fb2'] = date_format($datecomp, "d.m.Y"); 
        $fechas['fb3'] = date_format($datecomp, "Y-m-d");
        $fechas['fb4'] = date_format($datecomp, 'j').'.'.$mes[date_format($datecomp , "n")].'.'.date_format($datecomp , "Y"); 
        
        $emisiona_b = date_create(date_format($datecomp, "d.m.Y"));
        $emisiona_b = date_add($emisiona_b, date_interval_create_from_date_string("7 days"));
        
        $fechas['emision'] = date_format($emisiona_b, "d.m.Y"); 
        $fechas['anniorep'] = date_format($datecomp, "Y");
    }

    return $fechas;
}

// function generar_fechas_trabajo($fnac, $aniosa, $aniosb, $daysint, $monthsint, $ultimafecha, $fecha_anterior) {
function generar_fechas_trabajo_bonoA($dF, $fnac) {
    $meses = array("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
    $mes = array("", "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic");

    $fechas = array();
    $empresas = array();

    $fn = date_create($fnac);
    $fl = date_add($fn, date_interval_create_from_date_string("18 years"));
    // echo $fl->format('d-m-Y'),"<br>";

    // $añobono = rand(1992, 1994);
    $d2 = 1984 - $fl->format('Y');
    // echo $d2,"<br>";
    // $añoinicio = 1984 - $fl->y;
    $añobono = 1994;
    $mesbono = rand(1, 12);
    $f_bb = date_create("$añobono-$mesbono-15");
    $diabono = rand(1, nf(date_format($f_bb,"t"),0));

    // Fechas para empresa 2
    if ( $d2 < 0 ) {
        // echo "Menos de 10 años en Fecha2","<br>";
        // echo 10 + $d2,"<br>";
        $añosrestar = 10 + $d2;
        $dateb_b = date_create("$añobono-$mesbono-$diabono");
        $f_ba = date_create("$añobono-$mesbono-$diabono");
        $dateb_a = date_sub($f_ba, date_interval_create_from_date_string($añosrestar." years"));
        $dateb_a = date_sub($dateb_a, date_interval_create_from_date_string($dF[3]." months"));
        $dateb_a = date_sub($dateb_a, date_interval_create_from_date_string($dF[2]." days"));
    } else {
        $dateb_b = date_create("$añobono-$mesbono-$diabono");
        $f_ba = date_create("$añobono-$mesbono-$diabono");
        $dateb_a = date_sub($f_ba, date_interval_create_from_date_string("10 years"));
        $dateb_a = date_sub($dateb_a, date_interval_create_from_date_string($dF[3]." months"));
        $dateb_a = date_sub($dateb_a, date_interval_create_from_date_string($dF[2]." days"));
    }

    $d1 =  $dateb_a->format("Y") - $fl->format('Y');
    $d1 = 1984 - $fl->format('Y');
    // echo "Fa: ",$fl->format('Y'),"<br>";
    // echo "Fb: ",$dateb_a->format("Y"),"<br>";
    // echo "D1: ",$d1,"<br>";

    // Fechas para empresa 1
    if ( $d1 > 0 && $d1 <= 10 ) {
        $f_ab = date_create($dateb_a->format("Y-m-d"));
        // $datea_b = date_sub($f_ab, date_interval_create_from_date_string($d1." years"));
        $datea_b = date_sub($f_ab, date_interval_create_from_date_string($dF[3]." months"));
        $datea_b = date_sub($datea_b, date_interval_create_from_date_string($dF[2]." days"));
    
        $f_aa = date_create($datea_b->format("Y-m-d"));
        $datea_a = date_sub($f_aa, date_interval_create_from_date_string($d1." years"));
        $datea_a = date_sub($datea_a, date_interval_create_from_date_string($dF[3]." months"));
        $datea_a = date_sub($datea_a, date_interval_create_from_date_string($dF[2]." days"));
    } else {
        $f_ab = date_create($dateb_a->format("Y-m-d"));
        // $datea_b = date_sub($f_ab, date_interval_create_from_date_string($dF[4]." years"));
        $datea_b = date_sub($f_ab, date_interval_create_from_date_string($dF[3]." months"));
        $datea_b = date_sub($datea_b, date_interval_create_from_date_string($dF[2]." days"));
    
        $f_aa = date_create($datea_b->format("Y-m-d"));
        $datea_a = date_sub($f_aa, date_interval_create_from_date_string($dF[0]." years"));
        $datea_a = date_sub($datea_a, date_interval_create_from_date_string($dF[3]." months"));
        $datea_a = date_sub($datea_a, date_interval_create_from_date_string($dF[2]." days"));
    }

    
    $difa = date_diff($fn,$datea_a);
    $difb = date_diff($fn,$dateb_a);
    // $difa = date_diff($datea_a,$fn);
    // $difb = date_diff($dateb_a,$fn);

    $num = 1;
    if ( $difa->invert === 0 || ($d1 > 0 && $d1 <= 10) ) {
        // echo "El primer bloque esta en positivo.","<br>";
        $maa = date_format($datea_a , "n");
        $fechas[$num]['fechas']['fa1'] = date_format($datea_a, "j").' de '.$meses[$maa].' de '.date_format($datea_a , "Y"); 
        $fechas[$num]['fechas']['fa2'] = date_format($datea_a, "d.m.Y"); 
        $fechas[$num]['fechas']['fa3'] = date_format($datea_a, "Y-m-d");
        $fechas[$num]['fechas']['fa4'] = date_format($datea_a, "j").'.'.$mes[$maa].'.'.date_format($datea_a , "Y"); 
    
        $fechas[$num]['fechas']['fb1'] = date_format($datea_b, 'j').' de '.$meses[date_format($datea_b , "n")].' de '.date_format($datea_b , "Y"); 
        $fechas[$num]['fechas']['fb2'] = date_format($datea_b, "d.m.Y"); 
        $fechas[$num]['fechas']['fb3'] = date_format($datea_b, "Y-m-d");
        $fechas[$num]['fechas']['fb4'] = date_format($datea_b, 'j').'.'.$mes[date_format($datea_b , "n")].'.'.date_format($datea_b , "Y"); 
        
        $emisiona_b = date_create(date_format($datea_b, "d.m.Y"));
        $emisiona_b = date_add($emisiona_b, date_interval_create_from_date_string("7 days"));
        
        $fechas[$num]['fechas']['emision'] = date_format($emisiona_b, "d.m.Y"); 
        $fechas[$num]['fechas']['anniorep'] = date_format($datea_b, "Y");

        $fechas['empresas'][$num] = empresa_cotizada(date_format($dateb_a, "Y-m-d"), date_format($dateb_b, "Y-m-d"))[0];

        // $empresas[$num] = empresa_cotizada(date_format($datea_a, "Y-m-d"), date_format($datea_b, "Y-m-d"));

        $num++;
    } else {

    }

    if ( $difb->invert === 0 || $d2 < 0 ) {
        // echo "El segundo bloque esta en positivo.","<br>";
        $fechas[$num]['fechas']['fa1'] = date_format($dateb_a, "j").' de '.$meses[date_format($dateb_a , "n")].' de '.date_format($dateb_a , "Y"); 
        $fechas[$num]['fechas']['fa2'] = date_format($dateb_a, "d.m.Y"); 
        $fechas[$num]['fechas']['fa3'] = date_format($dateb_a, "Y-m-d");
        $fechas[$num]['fechas']['fa4'] = date_format($dateb_a, "j").'.'.$mes[date_format($dateb_a , "n")].'.'.date_format($dateb_a , "Y"); 
    
        $fechas[$num]['fechas']['fb1'] = date_format($dateb_b, 'j').' de '.$meses[date_format($dateb_b , "n")].' de '.date_format($dateb_b , "Y"); 
        $fechas[$num]['fechas']['fb2'] = date_format($dateb_b, "d.m.Y"); 
        $fechas[$num]['fechas']['fb3'] = date_format($dateb_b, "Y-m-d");
        $fechas[$num]['fechas']['fb4'] = date_format($dateb_b, 'j').'.'.$mes[date_format($dateb_b , "n")].'.'.date_format($dateb_b , "Y"); 
        
        $emisionb_b = date_create(date_format($dateb_b, "d.m.Y"));
        $emisionb_b = date_add($emisionb_b, date_interval_create_from_date_string("7 days"));
        
        $fechas[$num]['fechas']['emision'] = date_format($emisionb_b, "d.m.Y"); 
        $fechas[$num]['fechas']['anniorep'] = date_format($dateb_b, "Y");

        $fechas['empresas'][$num] = empresa_cotizada(date_format($dateb_a, "Y-m-d"), date_format($dateb_b, "Y-m-d"))[0];

        // $empresas[$num] = empresa_cotizada(date_format($dateb_a, "Y-m-d"), date_format($dateb_b, "Y-m-d"));
    }

    // echo $fnac,"<br>";
    // echo date_format($fn, "d/m/Y"),"<br>";
    // echo date_format($datea_b, "d/m/Y"),"<br>";
    // echo date_format($dateb_b, "d/m/Y"),"<br>";
    // echo "<div class='row'>";
    // echo "<div class='col-6'>";
    // var_dump($difa);
    // echo "</div>";
    // echo "<div class='col-6'>";
    // var_dump($difb);
    // echo "</div>";
    // echo "</div>";    

    // var_dump($fechas);

    return $fechas;
}

// function generar_fechas_trabajo($fnac, $aniosa, $aniosb, $daysint, $monthsint, $ultimafecha, $fecha_anterior) {
function generar_fechas_trabajo_bono($dF) {
    $meses = array("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
    $mes = array("", "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic");

    $fechas = array();

    // $añobono = rand(1992, 1994);
    $añobono = 1994;
    $mesbono = rand(1, 12);
    $f_bb = date_create("$añobono-$mesbono-15");
    $diabono = rand(1, nf(date_format($f_bb,"t"),0));

    // Fechas para empresa 2
    $dateb_b = date_create("$añobono-$mesbono-$diabono");
    $f_ba = date_create("$añobono-$mesbono-$diabono");
    $dateb_a = date_sub($f_ba, date_interval_create_from_date_string($dF[1]." years"));
    $dateb_a = date_sub($dateb_a, date_interval_create_from_date_string($dF[3]." months"));
    $dateb_a = date_sub($dateb_a, date_interval_create_from_date_string($dF[2]." days"));

    // Fechas para empresa 1
    $f_ab = date_create($dateb_a->format("Y-m-d"));
    // $datea_b = date_sub($f_ab, date_interval_create_from_date_string($dF[4]." years"));
    $datea_b = date_sub($f_ab, date_interval_create_from_date_string($dF[3]." months"));
    $datea_b = date_sub($datea_b, date_interval_create_from_date_string($dF[2]." days"));

    $f_aa = date_create($datea_b->format("Y-m-d"));
    $datea_a = date_sub($f_aa, date_interval_create_from_date_string($dF[0]." years"));
    $datea_a = date_sub($datea_a, date_interval_create_from_date_string($dF[3]." months"));
    $datea_a = date_sub($datea_a, date_interval_create_from_date_string($dF[2]." days"));

    $maa = date_format($datea_a , "n");
    $fechas[1]['fechas']['fa1'] = date_format($datea_a, "j").' de '.$meses[$maa].' de '.date_format($datea_a , "Y"); 
    $fechas[1]['fechas']['fa2'] = date_format($datea_a, "d.m.Y"); 
    $fechas[1]['fechas']['fa3'] = date_format($datea_a, "Y-m-d");
    $fechas[1]['fechas']['fa4'] = date_format($datea_a, "j").'.'.$mes[$maa].'.'.date_format($datea_a , "Y"); 

    $fechas[1]['fechas']['fb1'] = date_format($datea_b, 'j').' de '.$meses[date_format($datea_b , "n")].' de '.date_format($datea_b , "Y"); 
    $fechas[1]['fechas']['fb2'] = date_format($datea_b, "d.m.Y"); 
    $fechas[1]['fechas']['fb3'] = date_format($datea_b, "Y-m-d");
    $fechas[1]['fechas']['fb4'] = date_format($datea_b, 'j').'.'.$mes[date_format($datea_b , "n")].'.'.date_format($datea_b , "Y"); 
    
    $emisiona_b = date_create(date_format($datea_b, "d.m.Y"));
    $emisiona_b = date_add($emisiona_b, date_interval_create_from_date_string("7 days"));
    
    $fechas[1]['fechas']['emision'] = date_format($emisiona_b, "d.m.Y"); 
    $fechas[1]['fechas']['anniorep'] = date_format($datea_b, "Y");

    $fechas[2]['fechas']['fa1'] = date_format($dateb_a, "j").' de '.$meses[date_format($dateb_a , "n")].' de '.date_format($dateb_a , "Y"); 
    $fechas[2]['fechas']['fa2'] = date_format($dateb_a, "d.m.Y"); 
    $fechas[2]['fechas']['fa3'] = date_format($dateb_a, "Y-m-d");
    $fechas[2]['fechas']['fa4'] = date_format($dateb_a, "j").'.'.$mes[date_format($dateb_a , "n")].'.'.date_format($dateb_a , "Y"); 

    $fechas[2]['fechas']['fb1'] = date_format($dateb_b, 'j').' de '.$meses[date_format($dateb_b , "n")].' de '.date_format($dateb_b , "Y"); 
    $fechas[2]['fechas']['fb2'] = date_format($dateb_b, "d.m.Y"); 
    $fechas[2]['fechas']['fb3'] = date_format($dateb_b, "Y-m-d");
    $fechas[2]['fechas']['fb4'] = date_format($dateb_b, 'j').'.'.$mes[date_format($dateb_b , "n")].'.'.date_format($dateb_b , "Y"); 
    
    $emisionb_b = date_create(date_format($dateb_b, "d.m.Y"));
    $emisionb_b = date_add($emisionb_b, date_interval_create_from_date_string("7 days"));
    
    $fechas[2]['fechas']['emision'] = date_format($emisionb_b, "d.m.Y"); 
    $fechas[2]['fechas']['anniorep'] = date_format($dateb_b, "Y");

    return $fechas;
}

function datos_empresa($empresa, $datosFechas, $ultimafecha = false, $fecha_anterior) {
    $datos = array();
    $datos['fechas'] = generar_fechas_trabajo($datosFechas, $ultimafecha, $fecha_anterior);
    return $datos;
}

function nf($valor, $dec = 2) {
    if ($dec) {
        $monto = number_format($valor,$dec,".",",");
    } else {
        $monto = number_format($valor,$dec,"","");
    }
    return $monto;
}

function declaempleador($fechafinal) {
    $fechas[] = $fechafinal->format('Y-m-t');
    $f = date_sub($fechafinal, date_interval_create_from_date_string("1 months"));
    $fechas[] = $f->format('Y-m-t');
    $f = date_sub($fechafinal, date_interval_create_from_date_string("1 months"));
    $fechas[] = $f->format('Y-m-t');
    $f = date_sub($fechafinal, date_interval_create_from_date_string("1 months"));
    $fechas[] = $f->format('Y-m-t');
    $f = date_sub($fechafinal, date_interval_create_from_date_string("1 months"));
    $fechas[] = $f->format('Y-m-t');
    $f = date_sub($fechafinal, date_interval_create_from_date_string("1 months"));
    $fechas[] = $f->format('Y-m-t');
    $f = date_sub($fechafinal, date_interval_create_from_date_string("1 months"));
    $fechas[] = $f->format('Y-m-t');
    $f = date_sub($fechafinal, date_interval_create_from_date_string("1 months"));
    $fechas[] = $f->format('Y-m-t');
    $f = date_sub($fechafinal, date_interval_create_from_date_string("1 months"));
    $fechas[] = $f->format('Y-m-t');
    $f = date_sub($fechafinal, date_interval_create_from_date_string("1 months"));
    $fechas[] = $f->format('Y-m-t');
    $f = date_sub($fechafinal, date_interval_create_from_date_string("1 months"));
    $fechas[] = $f->format('Y-m-t');
    $f = date_sub($fechafinal, date_interval_create_from_date_string("1 months"));
    $fechas[] = $f->format('Y-m-t');
    $fechas = array_reverse($fechas);

    $num = 0;
    foreach ($fechas as $key => $fecha) {
        $sueldo = obtener_sueldo($fecha);
        $datos[$num]['mes'] = substr($fecha,0,4);
        $datos[$num]['anio'] = substr($fecha,5,2);
        $datos[$num]['remuneracion'] = nf($sueldo['sueldo_minimo']);
        // $datos[$num]['retencion'] = nf($sueldo['sueldo_minimo']*($sueldo['at_ss']/100));
        $datos[$num]['retencion'] = nf($sueldo['sueldo_minimo']*(3/100));
        $num++;
    }

    return $datos;
}