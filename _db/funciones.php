<?php

require_once('data_base.php');

$salt = '$6$4dm1n1str4d0r3s';

function encriptar_clave($clave) {
    $hash = crypt($clave, $GLOBALS['salt']);
    $hash = crypt($hash , $hash);
    return $hash;
}

function autenticar_usuario( $alias, $clave ) {
    try {
        $hash = explode($GLOBALS['salt'] , encriptar_clave($clave))[1];
        $sql  = "SELECT * FROM usuarios WHERE alias = '$alias'";
        $db = new db();
        $db = $db->connectionDB();
        $resultado = $db->query($sql);
        if ($resultado->rowCount() > 0) {
            $datos = $resultado->fetchAll()[0];
            if ($datos['clave'] === $hash) {
                // echo $datos['nombres']." ".$datos['apellidos']." / Clave: ".$datos['clave'];
                $_SESSION['usuario_id'] = $datos['id'];
                $_SESSION['nombre'] = $datos['nombres']." ".$datos['apellidos'];
            } else {
                unset($_SESSION['usuario_id']);
                unset($_SESSION['nombre']);
            }
            return $datos;
        } else {
            unset($_SESSION['usuario_id']);
            unset($_SESSION['nombre']);
            return "No existen registros";
        }
    } catch (\Throwable $th) {
        return "Error al consultar información.";
    }
}

function obtener_usuarios() {
    $sql = "SELECT id, nombres, apellidos, alias FROM usuarios";
    try {
        $db = new db();
        $db = $db->connectionDB();
        $resultado = $db->query($sql);
        if ($resultado->rowCount() > 0) {
            $datos = $resultado->fetchAll();
            return $datos;
            // return $res->withStatus(200)
            //     ->withHeader('Content-Type', 'application/json')
            //     ->write(json_encode($datos));
        } else {
            echo json_encode("No existen registros");
        }
    } catch (\Throwable $th) {
        $datos = array([ "Error" => 401, "mensaje" => "Error al obtener registros."]);
        return $datos;
        // return $res->withStatus(401)
        //     ->withHeader('Content-Type', 'application/json')
        //     ->write(json_encode($datos[0]));
    }
}

function cargar_csv_bd( $csv, $encabezado, string $delimitador = ',' ) {
    $campos = 'ind, ruc, empleador, direccion, dpto, prov, dist, f_inic_act, f_baja_act, rep_legal, dni_a, f_inicio_a, otro_representante, dni_b, f_inicio_b, imprimir';
    $valores = '';
    try {
        $db = new db();

        // var_dump($csv);
        // exit;
        $file = fopen( $csv['tmp_name'], "r");
        $data = array();
        $numFila = 0;
        
        if ( isset($encabezado) ) {
            $data = fgetcsv($file,null,$delimitador);
        }
        $db = $db->connectionDB();
        while (!feof($file)) {
            $valores = '';
            $data = fgetcsv($file,null,$delimitador);
            if ( $data !== false ) {
                // foreach($data as $dato) {
                for ( $i=0; $i< count($data); $i++ ) {
                    if ( $i === 7 || $i === 8 || $i === 11 || $i === 14 ) {
                        if ( trim($data[$i]) !== "" && trim($data[$i]) !== "NO REGISTRA"  ) {
                            $fecha = explode("/", trim($data[$i]));
                            $f = $fecha[2]."-".$fecha[1]."-".$fecha[0];
                            // echo $f,"<br>";
                            $dato = $f;
                        } else {
                            $dato = "0000-00-00";
                        }
                    } else {
                        $dato = trim($data[$i]);
                    }
                    $valores .= '"'.$dato.'", ';
                }
                $valores = substr($valores, 0, -2);
                $sql = "INSERT INTO empresas($campos) VALUES($valores)";
                // echo $sql,"<br>";
                $resultado = $db->query($sql);
            }
            
        }
        fclose($file);
        
        $datos = array(["mensaje" => "Registros agregados."]);
        return $datos;

    } catch (\Throwable $th) {
        $datos = array([ "Error" => 401, "mensaje" => "El registro no pudo ser agregado."]);
        return $datos;
    }
}

function cargar_sueldos_bd( $csv, $encabezado, string $delimitador = ',' ) {
    $campos = 'desde, hasta, unidad_moneda, sueldo_minimo, at_ss, at_pro_desocup, at_fondo_juvi, ap_ss, ap_fondo_juvi, ap_fonavi';
    $valores = '';
    try {
        $db = new db();

        // var_dump($csv);
        // exit;
        $file = fopen( $csv['tmp_name'], "r");
        $data = array();
        $numFila = 0;
        
        if ( isset($encabezado) ) {
            $data = fgetcsv($file,null,$delimitador);
        }
        $db = $db->connectionDB();
        while (!feof($file)) {
            $valores = '';
            $data = fgetcsv($file,null,$delimitador);
            if ( $data !== false ) {
                // foreach($data as $dato) {
                for ( $i=0; $i< count($data); $i++ ) {
                    // if ( $i == 7 || $i == 8 || $i == 11 || $i == 14 ){
                    //     if ( $data[$i] !== "" && $data[$i] !== "NO REGISTRA"  ) {
                    //         $fecha = explode("/", $data[$i]);
                    //         $f = $fecha[2]."-".$fecha[1]."-".$fecha[0];
                    //         $dato = $f;
                    //     } else {
                    //         $dato = "0000-00-00";
                    //     }
                    // } else {
                    //     $dato = $data[$i];
                    // }
                    // $valores .= '"'.$dato.'", ';
                    $valores .= '"'.$data[$i].'", ';
                }
                $valores = substr($valores, 0, -2);
                $sql = "INSERT INTO sueldos($campos) VALUES($valores)";
                echo $sql,"<br>";
                $resultado = $db->query($sql);
            }
            
        }
        fclose($file);
        
        $datos = array(["mensaje" => "Registros agregados."]);
        return $datos;

    } catch (\Throwable $th) {
        $datos = array([ "Error" => 401, "mensaje" => "El registro no pudo ser agregado."]);
        return $datos;
    }
}

function consultar_seguros( $idempresa ) {
    $sql = "SELECT * FROM empresas WHERE id = ".$idempresa;
    try {
        $db = new db();
        $db = $db->connectionDB();
        $resultado = $db->query($sql);
        if ($resultado->rowCount() > 0) {
            $datos = $resultado->fetchAll();
            return $datos;
            // return $res->withStatus(200)
            //     ->withHeader('Content-Type', 'application/json')
            //     ->write(json_encode($datos));
        } else {
            echo json_encode("No existen registros");
        }
    } catch (\Throwable $th) {
        $datos = array([ "Error" => 401, "mensaje" => "Error al obtener registros."]);
        return $datos;
        // return $res->withStatus(401)
        //     ->withHeader('Content-Type', 'application/json')
        //     ->write(json_encode($datos[0]));
    }
}

function buscar_empresa( $dni ) {
    $sql  = "SELECT DISTINCT id, ruc, empleador, dpto, f_inic_act, f_baja_act, rep_legal, dni_a FROM empresas WHERE dni_a = '$dni' LIMIT 1";
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

function buscar_empresa_ruc( $ruc ) {
    $sql  = "SELECT DISTINCT id, ruc, empleador, dpto, f_inic_act, f_baja_act, rep_legal, dni_a FROM empresas WHERE ruc = '$ruc' LIMIT 1";
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

function empresa_cotizada( $finicial, $ffinal, $manual = false ) {
    $sql  = "SELECT DISTINCT id, ruc, empleador, dpto, f_inic_act, f_baja_act, rep_legal, dni_a FROM vempresasfiltradas WHERE f_inic_act <= '$finicial' and f_baja_act >= '$ffinal' ORDER BY rand() LIMIT 1";
    // echo $sql;
    // exit;
    try {
        $db = new db();
        $db = $db->connectionDB();
        $resultado = $db->query($sql);
        if ($resultado->rowCount() > 0) {
            $datos = $resultado->fetchAll();
            return $datos;
        } else {
            return "No existen registros";
        }
    } catch (\Throwable $th) {
        return "Error al consultar información.";
    }
}

function empresas_cotizadas( $fecha ) {
    $sql  = "(SELECT DISTINCT id, ruc, empleador, dpto, f_inic_act, f_baja_act, rep_legal, dni_a FROM vempresasfiltradas WHERE f_inic_act <= (DATE_ADD('".$fecha."',INTERVAL 17 YEAR)) and f_baja_act >= (DATE_ADD('".$fecha."',INTERVAL 28 YEAR)) ORDER BY rand() LIMIT 1)";
    $sql .= "UNION";
    $sql .= "(SELECT DISTINCT id, ruc, empleador, dpto, f_inic_act, f_baja_act, rep_legal, dni_a FROM vempresasfiltradas WHERE f_inic_act <= (DATE_ADD('".$fecha."',INTERVAL 27 YEAR)) and f_baja_act >= (DATE_ADD('".$fecha."',INTERVAL 38 YEAR)) ORDER BY rand() LIMIT 1)";
    $sql .= "ORDER BY f_baja_act";
    // echo $sql;
    // exit;
    try {
        $db = new db();
        $db = $db->connectionDB();
        $resultado = $db->query($sql);
        if ($resultado->rowCount() > 0) {
            $datos = $resultado->fetchAll();
            return $datos;
        } else {
            return "No existen registros";
        }
    } catch (\Throwable $th) {
        return "Error al consultar información.";
    }
}

function basico($numero) {
    $valor = array ('uno','dos','tres','cuatro','cinco','seis','siete','ocho',
    'nueve','diez','once','doce','trece','catorce','quince','dieciseis','diecisiete','dieciocho','diecinueve','veinte','veintiuno ','veintidós ','veintitrés ', 'veinticuatro','veinticinco',
    'veintiséis','veintisiete','veintiocho','veintinueve');
    return $valor[$numero - 1];
}
    
function decenas($n) {
    $decenas = array (30=>'treinta',40=>'cuarenta',50=>'cincuenta',60=>'sesenta', 70=>'setenta',80=>'ochenta',90=>'noventa');
    if( $n <= 29) return basico($n);
    $x = $n % 10;
    if ( $x == 0 ) {
        return $decenas[$n];
    } else return $decenas[$n - $x].' y '. basico($x);
}
    
function centenas($n) {
    $cientos = array (100 =>'cien',200 =>'doscientos',300=>'trecientos', 400=>'cuatrocientos', 500=>'quinientos',600=>'seiscientos', 700=>'setecientos',800=>'ochocientos', 900 =>'novecientos');
    if( $n >= 100) {
        if ( $n % 100 == 0 ) {
            return $cientos[$n];
        } else {
            $u = (int) substr($n,0,1);
            $d = (int) substr($n,1,2);
            return (($u == 1)?'ciento':$cientos[$u*100]).' '.decenas($d);
        }
    } else return decenas($n);
}
    
function miles($n) {
    if($n > 999) {
        if( $n == 1000) {return 'mil';}
        else {
            $l = strlen($n);
            $c = (int)substr($n,0,$l-3);
            $x = (int)substr($n,-3);
            if($c == 1) {$cadena = 'mil '.centenas($x);}
            else if($x != 0) {$cadena = centenas($c).' mil '.centenas($x);}
            else $cadena = centenas($c). ' mil';
            return $cadena;
        }
    } else return centenas($n);
}
    
function millones($n) {
    if($n == 1000000) {return 'un millón';}
    else {
        $l = strlen($n);
        $c = (int)substr($n,0,$l-6);
        $x = (int)substr($n,-6);
        if($c == 1) {
            $cadena = ' millón ';
        } else {
            $cadena = ' millones ';
        }
        return miles($c).$cadena.(($x > 0)?miles($x):'');
    }
}

function convertir($n) {
    switch (true) {
        case ( $n >= 1 && $n <= 29) : return basico($n); break;
        case ( $n >= 30 && $n < 100) : return decenas($n); break;
        case ( $n >= 100 && $n < 1000) : return centenas($n); break;
        case ($n >= 1000 && $n <= 999999): return miles($n); break;
        case ($n >= 1000000): return millones($n);
    }
}