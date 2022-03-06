<?php
require_once('data_base.php');

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
                    if ( $i == 7 || $i == 8 || $i == 11 || $i == 14 ){
                        if ( $data[$i] !== "" && $data[$i] !== "NO REGISTRA"  ) {
                            $fecha = explode("/", $data[$i]);
                            $f = $fecha[2]."-".$fecha[1]."-".$fecha[0];
                            $dato = $f;
                        } else {
                            $dato = "0000-00-00";
                        }
                    } else {
                        $dato = $data[$i];
                    }
                    $valores .= '"'.$dato.'", ';
                }
                $valores = substr($valores, 0, -2);
                $sql = "INSERT INTO empresas($campos) VALUES($valores)";
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

function empresas_cotizadas( $fecha ) {
    $sql  = "(SELECT DISTINCT id, ruc, empleador, dpto, f_inic_act, f_baja_act FROM vempresasfiltradas WHERE f_inic_act <= (DATE_ADD('".$fecha."',INTERVAL 17 YEAR)) and f_baja_act >= (DATE_ADD('".$fecha."',INTERVAL 28 YEAR)) ORDER BY rand() LIMIT 1)";
    $sql .= "UNION";
    $sql .= "(SELECT DISTINCT id, ruc, empleador, dpto, f_inic_act, f_baja_act FROM vempresasfiltradas WHERE f_inic_act <= (DATE_ADD('".$fecha."',INTERVAL 27 YEAR)) and f_baja_act >= (DATE_ADD('".$fecha."',INTERVAL 38 YEAR)) ORDER BY rand() LIMIT 1)";
    // $sql .= "ORDER BY f_inic_act";
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