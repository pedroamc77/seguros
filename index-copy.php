<?php 

require_once('./_db/nomina.php');

if ( isset($_POST['fnacimiento']) && $_POST['fnacimiento'] !== "" ) {
    $empresas = empresas_cotizadas($_POST['fnacimiento']);
}

$meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SisPen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="css/estilos.min.css" media="all">
    <!-- <link rel="stylesheet" href="css/impresion.min.css" media="print"> -->
    <link rel="stylesheet" href="./datatables/datatables.min.css">
    <link href="fa5130/css/all.min.css" rel="stylesheet" >

</head>
<body>
  <div class="contenedor">
    <div class="app">
      <div class="app_horizontal_barra">
          <div class="app_horizontal_barra_logo"><div>Sis</div><div>Pen</div></div>
          <div class="app_horizontal_barra_menu">
            <button href="#" class="custom-btn btn-13">Automático</button>
            <button href="#" class="custom-btn btn-13">Manual</button>
            <!-- <button href="#" class="custom-btn btn-13">Reportes</button> -->
            <!-- <button href="#" class="custom-btn btn-13">Empresas</button> -->
          </div>
      </div>
      <div class="app_horizontal_contenido">
        <div class="app_contenido_formulario p-2" >
          <div class="container-fluid">
            <!-- <div class="row justify-content-center"> -->
            <div class="row justify-content-between">
              <!-- <div class="col-xl-7 col-lg-9 col-md-12 col-sm-12"> -->
              <div class="col-3">
                <form action="index.php" id="frmPersona" method="POST" >
                  <fieldset>
                      <div class="row">
                        <div class="col-12">
                          <div class="row mb-1">
                              <label for="nombre" class="col-sm-3 col-form-label">Nombre:</label>
                              <div class="col-sm-9">
                                <input type="text" id="nombres" name="nombres" class="form-control form-control-sm" placeholder="Nombres" value="<?php echo isset($_POST['nombres']) ?  $_POST['nombres'] : '' ?>">
                              </div>
                          </div>
                          <div class="row mr-1">
                              <label for="apellidos" class="col-sm-3 col-form-label">Apellidos:</label>
                              <div class="col-sm-9">
                                <input type="text" id="apellidos" name="apellidos" class=" form-control form-control-sm" placeholder="Apellidos" value="<?php echo isset($_POST['apellidos']) ? $_POST['apellidos'] : '' ?>">
                              </div>
                          </div>
                          <div class="row mb-1">
                              <label for="dni" class="col-sm-3 col-form-label">DNI:</label>
                              <div class="col-sm-9">
                                <input type="text" id="dni" name="dni" class="form-control form-control-sm" placeholder="DNI" value="<?php echo isset($_POST['dni']) ? $_POST['dni'] : '' ?>">
                              </div>
                          </div>
                          <div class="row mb-1">
                              <label for="fnacimiento" class="col-sm-3 col-form-label">Nacimiento:</label>
                              <div class="col-sm-9">
                                <input type="date" id="fnacimiento" name="fnacimiento" value="<?php echo isset($_POST['fnacimiento']) ? $_POST['fnacimiento'] : '' ?>" class="form-control form-control-sm" >
                                <input type="hidden" id="edad" name="edad" value="<? echo isset($_POST['edad']) ? $_POST['edad'] : '' ?>" >
                                <input type="hidden" id="fecleglab" name="fecleglab" value="<? echo isset($_POST['iniactlab']) ? $_POST['iniactlab'] : '' ?>" >
                              </div>
                          </div>
                          <!-- <div class="row mb-1">
                              <label for="iniactlab" class="col-sm-5 col-form-label">Inicio de Act. Laboral:</label>
                              <div class="col-sm-7">
                                <input type="text" readonly id="iniactlab" name="iniactlab" value="<?php //echo isset($_POST['iniactlab']) ? $_POST['iniactlab'] : '' ?>" class="form-control form-control-sm" >
                              </div>
                          </div> -->
                          <!-- <div class="row mb-1">
                              <label for="fecafiafp" class="col-sm-5 col-form-label">Fecha de Afil. AFP:</label>
                              <div class="col-sm-7">
                                <input type="date" id="fecafiafp" name="fecafiafp" class="form-control form-control-sm" onchange="calcularTiemLabo()">
                                <input type="hidden" id="anioslaborados" value="" >
                              </div>
                          </div>
                          <div class="row mb-3">
                              <label for="numautog" class="col-sm-5 col-form-label">Número Autogenerado:</label>
                              <div class="col-sm-7">
                                <input type="text" id="numautog" name="numautog" class="form-control form-control-sm" placeholder="Núm. Autogenerado">
                              </div>
                          </div> -->

                        </div>
                      </div>

                      <!-- Opciones de reporte -->
                      <hr style="margin: 5px 0;" />
                      <div class="row">
                        <div class="col-12">
                          <div class="mb-3 row justify-content-end " >
                              <button type="submit" class="col-xl-3 col-lg-3 col-md-4 col-sm-4 btn btn-primary btn-sm me-3 ">Cargar</button>
                              <button type="reset"  class="col-xl-3 col-lg-3 col-md-4 col-sm-4 btn btn-primary btn-sm me-3 ">Cancelar</button>
                          </div>
                        </div>
                      </div>
                  </fieldset>
                </form>
              </div>
              <?php
                  if ( isset($_POST['fnacimiento']) ) {
                    $numemp = 0;
                    $anniorepa = "";
                    $anniorepb = "";
                    $fnacimiento = $_POST['fnacimiento'];
                    $fecha_anterior = null;
                    $valido = false;
                    do {
                      $aniosa = rand(8, 12);
                      $aniosb = rand(8, 12);
                      $daysint = rand(8, 25);
                      $monthsint = rand(1, 5);
                      $aniosint = rand(0, 2);
                      if ( ( $aniosa + $aniosb ) >= 20 ) $valido = true;
                    } while (!$valido);
                    foreach ($empresas as $empresa) {
                      $numemp++;
                      $datos = datos_empresa($empresa, array($fnacimiento, $aniosa, $aniosb, $daysint, $monthsint, $aniosint), $numemp === 2, $numemp === 2 ? $fecha_anterior : null );
                      $fecha_anterior = $datos['fechas']['fb3'];
                      ?>
                      <div class="col-xl-3 col-4">
                      <?php
                      ?>
                      <!-- <td style="display: flex; flex-direction: row; flex-wrap: nowrap; justify-content: center; text-align: center; padding: 0 15px;"> -->
                        <?php
                          echo "<div class=' border-bottom border-info text-center mb-2 pb-2 ' >Empresa $numemp</div>";
                          
                          echo "<div class='text-center fw-bolder text-info ' style='font-size: 13px;'>",$empresa['id']," - ",$empresa['empleador'],"</div>";
                          // echo $empresa['dpto'],"\n";
                          echo "<div class=' text-center fw-lighter fst-italic pb-2 border-bottom border-info ' style='font-size: 11px;' >","Desde el: ", $empresa['f_inic_act']," / Hasta el: ",$empresa['f_baja_act'],"</div>";
                          // echo "Fecha I A: ",$datos['fechas']['fa1'],"<br>";
                          // echo "Fecha B A: ",$datos['fechas']['fb1'],"<br>";

                          $control[0] = '<input type="hidden" name="empresa" value="'.$empresa['empleador'].'">'; 
                          $control[1] = '<input type="hidden" name="nombres" value="'.$_POST['nombres'].'">'; 
                          $control[2] = '<input type="hidden" name="apellidos" value="'.$_POST['apellidos'].'">'; 
                          
                          $control[3]  = '<input type="hidden" name="f_a" value="'.$datos['fechas']['fa2'].'">'; 
                          $control[12] = '<input type="hidden" name="f_a_b" value="'.$datos['fechas']['fa1'].'">'; 
                          $control[4]  = '<input type="hidden" name="f_b" value="'.$datos['fechas']['fb2'].'">'; 
                          $control[13] = '<input type="hidden" name="f_b_b" value="'.$datos['fechas']['fb1'].'">'; 
                          $control[10] = '<input type="hidden" name="emision" value="'.$datos['fechas']['emision'].'">'; 
                          
                          $control[14] = '<input type="hidden" name="f_a_b" value="'.$datos['fechas']['fa1'].'">'; 
                          $control[5]  = '<input type="hidden" name="f_a" value="'.$datos['fechas']['fa2'].'">'; 
                          $control[15] = '<input type="hidden" name="f_b_b" value="'.$datos['fechas']['fb1'].'">'; 
                          $control[6]  = '<input type="hidden" name="f_b" value="'.$datos['fechas']['fb2'].'">'; 
                          $control[9]  = '<input type="hidden" name="fecha_emision" value="'.$datos['fechas']['fb1'].'">';
                          
                          $control[11] = '<input type="hidden" name="emision" value="'.$datos['fechas']['emision'].'">'; 

                          $control[16] = '<input type="hidden" name="fsueldo" value="'.$datos['fechas']['fb3'].'">'; 
                          
                          // $control[7] = '<input type="hidden" name="cargo_a" value="'.$_POST['cargo_o'].'">'; 
                          // $control[16] = '<input type="hidden" name="sueldo" value="'.$_POST['sueldo'].'">'; 
                          $control[8] = '<input type="hidden" name="dpto" value="'.$empresa['dpto'].'">'; 

                          $rp = "";
                          $anniorp = $datos['fechas']['anniorep'];
                            
                          if ( $anniorp >= 1962 && $anniorp <= 1972) {
                            $rp = "_62al72";
                          }
                          
                          if ( $anniorp >= 1973 && $anniorp <= 1975) {
                            $rp = "_73al75";
                          }
                          
                          if ( $anniorp >= 1976 && $anniorp <= 1983) {
                            $rp = "_76al83";
                          }
                          
                          if ( $anniorp >= 1984 && $anniorp <= 1994) {
                            $rp = "_84al94";
                          }

                          if ( $anniorp >= 1995 ) {
                            $rp = "_95al00";
                          }

                          if ($numemp === 1) {
                        ?>
                              <div class="row mb-3 mt-2 ">
                                <label for="cargo" class="col-sm-3 col-form-label">Cargo:</label>
                                <div class="col-sm-9">
                                  <select required id="cargoc" name="cargoc" placeholder="Cargo"  class="form-control form-control-sm" placeholder="Cargo" onchange="asignar_cargo_c(this.value)" >
                                    <option value=""></option>
                                    <option value="SUPERVISOR">SUPERVISOR</option>
                                    <option value="ADMINISTRADOR">ADMINISTRADOR</option>
                                    <option value="CONTADOR">CONTADOR</option>
                                    <option value="GERENTE">GERENTE</option>
                                    <option value="GERENTE GENERAL">GERENTE GENERAL</option>
                                    <option value="JEFE DE PERSONAL">JEFE DE PERSONAL</option>
                                    <option value="JEFE DE PLANTA">JEFE DE PLANTA</option>
                                    <option value="JEFE DE VENTAS">JEFE DE VENTAS</option>
                                    <option value="JEFE DE ALMACEN">JEFE DE ALMACEN</option>
                                    <option value="AYUDANTE DE ALMACEN">AYUDANTE DE ALMACEN</option>
                                    <option value="ASISTENTE DE CONTABILIDAD">ASISTENTE DE CONTABILIDAD</option>
                                    <option value="INGENIERO DE PLANTA">INGENIERO DE PLANTA</option>
                                    <option value="SECRETARIO">SECRETARIO</option>
                                    <option value="SUPERVISOR DE VENTAS">SUPERVISOR DE VENTAS</option>
                                    <option value="MAESTRO DE OBRA">MAESTRO DE OBRA</option>
                                    <option value="AYUDANTE ">AYUDANTE </option>
                                    <option value="AUXILIAR DE OFICINA">AUXILIAR DE OFICINA</option>
                                    <option value="ASISTENTE DE OFICINA">ASISTENTE DE OFICINA</option>
                                    <option value="ASISTENTE ADMINISTRATIVO">ASISTENTE ADMINISTRATIVO</option>
                                    <option value="DIRECTOR">DIRECTOR</option>
                                    <option value="FARMACEUTICO">FARMACEUTICO</option>
                                    <option value="CAJERO">CAJERO</option>
                                    <option value="JEFE DE COBRANZAS">JEFE DE COBRANZAS</option>
                                    <option value="AUXILIAR DE CONTABILIDAD">AUXILIAR DE CONTABILIDAD</option>
                                    <option value="LIMPIEZA">LIMPIEZA</option>
                                    <option value="MECANICO">MECANICO</option>
                                    <option value="OPERARIO">OPERARIO</option>
                                    <option value="JEFE DE OPERACIONES">JEFE DE OPERACIONES</option>
                                    <option value="JEFE ZONAL">JEFE ZONAL</option>
                                    <option value="GERENTE COMERCIAL">GERENTE COMERCIAL</option>
                                    <option value="GERENTE FINANCIERO">GERENTE FINANCIERO</option>
                                    <option value="JEFE DE PRODUCCION">JEFE DE PRODUCCION</option>
                                    <option value="OPERADOR DE MAQUINA">OPERADOR DE MAQUINA</option>
                                    <option value="JEFE DE CALIDAD">JEFE DE CALIDAD</option>
                                    <option value="JEFE DE LOGISTICA">JEFE DE LOGISTICA</option>
                                    <option value="ASISTENTE GERENCIAL">ASISTENTE GERENCIAL</option>
                                    <option value="GERENTE DE SERVICIO AL CLIENTE">GERENTE DE SERVICIO AL CLIENTE</option>
                                    <option value="ENCARGADO DE TIENDA">ENCARGADO DE TIENDA</option>
                                    <option value="ALMACENERO">ALMACENERO</option>
                                    <option value="PROMOTOR DE VENTAS">PROMOTOR DE VENTAS</option>
                                    <option value="SUPERVISOR DE SERVICIOS GENERALES">SUPERVISOR DE SERVICIOS GENERALES</option>
                                    <option value="OPERARIO DE MONTAJE">OPERARIO DE MONTAJE</option>
                                    <option value="EJECUTIVO COMERCIAL">EJECUTIVO COMERCIAL</option>
                                    <option value="REPRESENTANTE TECNICO">REPRESENTANTE TECNICO</option>
                                    <option value="JEFE COMERCIAL">JEFE COMERCIAL</option>
                                    <option value="ANALISTA">ANALISTA</option>
                                    <option value="JEFE ZONAL">JEFE ZONAL</option>
                                  </select>
                                </div>
                              </div>
                        <?php
                          } else {
                        ?>
                              <div class="row mb-3 mt-2 ">
                                <label for="cargo" class="col-sm-3 col-form-label">Cargo:</label>
                                <div class="col-sm-9">
                                  <select required id="cargol" name="cargol" placeholder="Cargo"  class="form-control form-control-sm" placeholder="Cargo" onchange="asignar_cargo_l(this.value)" >
                                    <option value=""></option>
                                    <option value="SUPERVISOR">SUPERVISOR</option>
                                    <option value="ADMINISTRADOR">ADMINISTRADOR</option>
                                    <option value="CONTADOR">CONTADOR</option>
                                    <option value="GERENTE">GERENTE</option>
                                    <option value="GERENTE GENERAL">GERENTE GENERAL</option>
                                    <option value="JEFE DE PERSONAL">JEFE DE PERSONAL</option>
                                    <option value="JEFE DE PLANTA">JEFE DE PLANTA</option>
                                    <option value="JEFE DE VENTAS">JEFE DE VENTAS</option>
                                    <option value="JEFE DE ALMACEN">JEFE DE ALMACEN</option>
                                    <option value="AYUDANTE DE ALMACEN">AYUDANTE DE ALMACEN</option>
                                    <option value="ASISTENTE DE CONTABILIDAD">ASISTENTE DE CONTABILIDAD</option>
                                    <option value="INGENIERO DE PLANTA">INGENIERO DE PLANTA</option>
                                    <option value="SECRETARIO">SECRETARIO</option>
                                    <option value="SUPERVISOR DE VENTAS">SUPERVISOR DE VENTAS</option>
                                    <option value="MAESTRO DE OBRA">MAESTRO DE OBRA</option>
                                    <option value="AYUDANTE ">AYUDANTE </option>
                                    <option value="AUXILIAR DE OFICINA">AUXILIAR DE OFICINA</option>
                                    <option value="ASISTENTE DE OFICINA">ASISTENTE DE OFICINA</option>
                                    <option value="ASISTENTE ADMINISTRATIVO">ASISTENTE ADMINISTRATIVO</option>
                                    <option value="DIRECTOR">DIRECTOR</option>
                                    <option value="FARMACEUTICO">FARMACEUTICO</option>
                                    <option value="CAJERO">CAJERO</option>
                                    <option value="JEFE DE COBRANZAS">JEFE DE COBRANZAS</option>
                                    <option value="AUXILIAR DE CONTABILIDAD">AUXILIAR DE CONTABILIDAD</option>
                                    <option value="LIMPIEZA">LIMPIEZA</option>
                                    <option value="MECANICO">MECANICO</option>
                                    <option value="OPERARIO">OPERARIO</option>
                                    <option value="JEFE DE OPERACIONES">JEFE DE OPERACIONES</option>
                                    <option value="JEFE ZONAL">JEFE ZONAL</option>
                                    <option value="GERENTE COMERCIAL">GERENTE COMERCIAL</option>
                                    <option value="GERENTE FINANCIERO">GERENTE FINANCIERO</option>
                                    <option value="JEFE DE PRODUCCION">JEFE DE PRODUCCION</option>
                                    <option value="OPERADOR DE MAQUINA">OPERADOR DE MAQUINA</option>
                                    <option value="JEFE DE CALIDAD">JEFE DE CALIDAD</option>
                                    <option value="JEFE DE LOGISTICA">JEFE DE LOGISTICA</option>
                                    <option value="ASISTENTE GERENCIAL">ASISTENTE GERENCIAL</option>
                                    <option value="GERENTE DE SERVICIO AL CLIENTE">GERENTE DE SERVICIO AL CLIENTE</option>
                                    <option value="ENCARGADO DE TIENDA">ENCARGADO DE TIENDA</option>
                                    <option value="ALMACENERO">ALMACENERO</option>
                                    <option value="PROMOTOR DE VENTAS">PROMOTOR DE VENTAS</option>
                                    <option value="SUPERVISOR DE SERVICIOS GENERALES">SUPERVISOR DE SERVICIOS GENERALES</option>
                                    <option value="OPERARIO DE MONTAJE">OPERARIO DE MONTAJE</option>
                                    <option value="EJECUTIVO COMERCIAL">EJECUTIVO COMERCIAL</option>
                                    <option value="REPRESENTANTE TECNICO">REPRESENTANTE TECNICO</option>
                                    <option value="JEFE COMERCIAL">JEFE COMERCIAL</option>
                                    <option value="ANALISTA">ANALISTA</option>
                                    <option value="JEFE ZONAL">JEFE ZONAL</option>
                                  </select>
                                </div>
                              </div>
                              
                              <?php
                          }
                          ?>
                          <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                              <button class="nav-link active" id="certificado_<?php echo $numemp ?>-tab" data-bs-toggle="pill" data-bs-target="#certificado_<?php echo $numemp ?>" type="button" role="tab"   aria-controls="certificado_<?php echo $numemp ?>" aria-selected="true">Certificado</button>
                            </li>
                            <li class="nav-item" role="presentation">
                              <button class="nav-link"        id="liquidacion_<?php echo $numemp ?>-tab" data-bs-toggle="pill" data-bs-target="#liquidacion_<?php echo $numemp ?>" type="button" role="tab"   aria-controls="liquidacion_<?php echo $numemp ?>" aria-selected="false">Liquidación</button>
                            </li>
                            <li class="nav-item" role="presentation">
                              <button class="nav-link"        id="boletadepago_<?php echo $numemp ?>-tab" data-bs-toggle="pill" data-bs-target="#boletadepago_<?php echo $numemp ?>" type="button" role="tab" aria-controls="boletadepago_<?php echo $numemp ?>" aria-selected="false">Boleta</button>
                            </li>
                          </ul>
                          <div class="tab-content" id="pills-tabContent">
                            <!-- <div class="tab-pane fade capitalizar show active" id="certificado" role="tabpanel" aria-labelledby="certificado-tab">
                              Constancia
                            </div> -->
                          <!-- </div> -->
                          <?php
                          for ( $p = 1 ; $p < 4 ; $p++ ) {
                            if ( $anniorp >= 1978 ) {
                              if ($p === 1) $rep = "certificado";
                              if ($p === 2) $rep = "liquidacion";
                              if ($p === 3) $rep = "boletadepago";
                              if ($p === 1 || $p === 2) {
                                echo "<div class='tab-pane fade capitalizar ", ($p === 1 ? 'show active' : '') ,"' id='".$rep."_".$numemp."' role='tabpanel' aria-labelledby='".$rep."_".$numemp."-tab'>";
                                echo "<form action='reportes/".$rep.$rp.".php' method='post' target='_blank'>","\n";
                              }
                              if ($p === 3) {
                                echo "<div class='tab-pane fade capitalizar ", ($p === 1 ? 'show active' : '') ,"' id='".$rep."_".$numemp."' role='tabpanel' aria-labelledby='".$rep."_".$numemp."-tab'>";
                                echo "<form action='reportes/".$rep.".php' method='post' target='_blank'>","\n";
                                ?>
                                  <div class="row mb-1">
                                    <label for="sueldo" class="col-sm-7 col-form-label">Fecha:</label>
                                    <div class="col-sm-5">
                                      <input required type="date" id="fechaboleta" name="fechaboleta" min="1962-08-22" class="form-control form-control-sm" value="<?php echo isset($_POST['fechaboleta']) ? $_POST['fechaboleta'] : '0' ?>">
                                    </div>
                                  </div>
                                  <div class="row mb-1">
                                    <label for="sueldo" class="col-sm-7 col-form-label">REM. VACACIONAL:</label>
                                    <div class="col-sm-5">
                                      <input onkeypress="return filterFloat(event,this);" type="text" id="remvacacionales" name="remvacacionales" class="form-control form-control-sm" value="<?php echo isset($_POST['remvacacionales']) ? $_POST['remvacacionales'] : '0' ?>">
                                    </div>
                                  </div>
                                  <div class="row mb-1">
                                    <label for="sueldo" class="col-sm-7 col-form-label">Reintegro:</label>
                                    <div class="col-sm-5">
                                      <input onkeypress="return filterFloat(event,this);" type="text" id="reintegro" name="reintegro" class="form-control form-control-sm" value="<?php echo isset($_POST['reintegro']) ? $_POST['reintegro'] : '0' ?>">
                                    </div>
                                  </div>
                                  <div class="row mb-1">
                                    <label for="sueldo" class="col-sm-7 col-form-label">H. EXTRAS:</label>
                                    <div class="col-sm-5">
                                      <input onkeypress="return filterFloat(event,this);" type="text" id="hextras" name="hextras" class="form-control form-control-sm" value="<?php echo isset($_POST['hextras']) ? $_POST['hextras'] : '0' ?>">
                                    </div>
                                  </div>
                                  <div class="row mb-1">
                                    <label for="sueldo" class="col-sm-7 col-form-label">Bonificacion:</label>
                                    <div class="col-sm-5">
                                      <input onkeypress="return filterFloat(event,this);" type="text" id="bonificacion" name="bonificacion" class="form-control form-control-sm" value="<?php echo isset($_POST['bonificacion']) ? $_POST['bonificacion'] : '0' ?>">
                                    </div>
                                  </div>
                                  <div class="row mb-1 border-bottom border-info">
                                    <label for="sueldo" class="col-sm-7 col-form-label">OTROS:</label>
                                    <div class="col-sm-5">
                                      <input onkeypress="return filterFloat(event,this);" type="text" id="otros_deven" name="otros_deven" class="form-control form-control-sm" value="<?php echo isset($_POST['otros_deven']) ? $_POST['otros_deven'] : '0' ?>">
                                    </div>
                                  </div>


                                  <!-- <div class="row mb-1">
                                    <label for="sueldo" class="col-sm-6 col-form-label"></label>
                                    <div class="col-sm-3 text-center">
                                      Trabajador
                                    </div>
                                    <div class="col-sm-3 text-center">
                                      Empleador
                                    </div>
                                  </div>
                                  <div class="row mb-1">
                                    <label for="sueldo" class="col-sm-6 col-form-label">SNP:</label>
                                    <div class="col-sm-3">
                                      <input onkeypress="return filterFloat(event,this);" type="text" id="snp_tra" name="snp_tra" class="form-control form-control-sm bg-danger bg-gradient bg-opacity-50 text-white" value="<?php echo isset($_POST['snp_tra']) ? $_POST['snp_tra'] : '0' ?>">
                                    </div>
                                    <div class="col-sm-3">
                                      <input onkeypress="return filterFloat(event,this);" type="text" id="snp_emp" name="snp_emp" class="form-control form-control-sm bg-danger bg-gradient bg-opacity-50 text-white" value="<?php echo isset($_POST['snp_emp']) ? $_POST['snp_emp'] : '0' ?>">
                                    </div>
                                  </div>
                                  <div class="row mb-1">
                                    <label for="sueldo" class="col-sm-6 col-form-label">IPSS:</label>
                                    <div class="col-sm-3">
                                      <input onkeypress="return filterFloat(event,this);"  type="text" id="ipss_tra" name="ipss_tra" class="form-control form-control-sm bg-danger bg-gradient bg-opacity-50 text-white" value="<?php echo isset($_POST['ipss_tra']) ? $_POST['ipss_tra'] : '0' ?>">
                                    </div>
                                    <div class="col-sm-3">
                                      <input onkeypress="return filterFloat(event,this);"  type="text" id="ipss_emp" name="ipss_emp" class="form-control form-control-sm bg-danger bg-gradient bg-opacity-50 text-white" value="<?php echo isset($_POST['ipss_emp']) ? $_POST['ipss_emp'] : '0' ?>">
                                    </div>
                                  </div>
                                  <div class="row mb-1">
                                    <label for="sueldo" class="col-sm-6 col-form-label">FONAVI:</label>
                                    <div class="col-sm-3">
                                      <input onkeypress="return filterFloat(event,this);" type="text" id="fonavi_tra" name="fonavi_tra" class="form-control form-control-sm bg-danger bg-gradient bg-opacity-50 text-white" value="<?php echo isset($_POST['fonavi_tra']) ? $_POST['fonavi_tra'] : '0' ?>">
                                    </div>
                                    <div class="col-sm-3">
                                      <input onkeypress="return filterFloat(event,this);" type="text" id="fonavi_emp" name="fonavi_emp" class="form-control form-control-sm bg-danger bg-gradient bg-opacity-50 text-white" value="<?php echo isset($_POST['fonavi_emp']) ? $_POST['fonavi_emp'] : '0' ?>">
                                    </div>
                                  </div>
                                  <div class="row mb-1">
                                    <label for="sueldo" class="col-sm-6 col-form-label">QUINCENA:</label>
                                    <div class="col-sm-3">
                                      <input onkeypress="return filterFloat(event,this);" type="text" id="quincena_tra" name="quincena_tra" class="form-control form-control-sm bg-danger bg-gradient bg-opacity-50 text-white" value="<?php echo isset($_POST['quincena_tra']) ? $_POST['quincena_tra'] : '0' ?>">
                                    </div>
                                    <div class="col-sm-3">
                                      <input onkeypress="return filterFloat(event,this);" type="text" id="quincena_emp" name="quincena_emp" class="form-control form-control-sm bg-danger bg-gradient bg-opacity-50 text-white" value="<?php echo isset($_POST['quincena_emp']) ? $_POST['quincena_emp'] : '0' ?>">
                                    </div>
                                  </div>
                                  <div class="row mb-1">
                                    <label for="sueldo" class="col-sm-6 col-form-label">ADELANTO:</label>
                                    <div class="col-sm-3">
                                      <input onkeypress="return filterFloat(event,this);"  type="text" id="adelanto_tra" name="adelanto_tra" class="form-control form-control-sm bg-danger bg-gradient bg-opacity-50 text-white" value="<?php echo isset($_POST['adelanto_tra']) ? $_POST['adelanto_tra'] : '0' ?>">
                                    </div>
                                    <div class="col-sm-3">
                                      <input onkeypress="return filterFloat(event,this);"  type="text" id="adelanto_emp" name="adelanto_emp" class="form-control form-control-sm bg-danger bg-gradient bg-opacity-50 text-white" value="<?php echo isset($_POST['adelanto_emp']) ? $_POST['adelanto_emp'] : '0' ?>">
                                    </div>
                                  </div>
                                  <div class="row mb-1">
                                    <label for="sueldo" class="col-sm-6 col-form-label">OTROS:</label>
                                    <div class="col-sm-3">
                                      <input onkeypress="return filterFloat(event,this);" type="text" id="otros_deduc_tra" name="otros_deduc_tra" class="form-control form-control-sm bg-danger bg-gradient bg-opacity-50 text-white" xtraordinaria" value="<?php echo isset($_POST['otros_deduc_tra']) ? $_POST['otros_deduc_tra'] : '0' ?>">
                                    </div>
                                    <div class="col-sm-3">
                                      <input onkeypress="return filterFloat(event,this);" type="text" id="otros_deduc_emp" name="otros_deduc_emp" class="form-control form-control-sm bg-danger bg-gradient bg-opacity-50 text-white" xtraordinaria" value="<?php echo isset($_POST['otros_deduc_emp']) ? $_POST['otros_deduc_emp'] : '0' ?>">
                                    </div>
                                  </div> -->
                                  </div>
                                <?php
                                echo $control[0],"\n";
                                echo $control[1],"\n";
                                echo $control[2],"\n";
                              // if ( $numemp === 1 ) {
                                echo $control[3],"\n";
                                echo $control[4],"\n";
                                echo $control[10],"\n";
                                echo $control[12],"\n";
                                echo $control[13],"\n";
                              // }
                              // if ( $numemp === 2 ) {
                              //   echo $control[5],"\n";
                              //   echo $control[6],"\n";
                              //   echo $control[11],"\n";
                              //   echo $control[14],"\n";
                              //   echo $control[15],"\n";
                              // }
                                echo $control[8],"\n";
                                echo $control[9],"\n";
                                echo $control[16],"\n";
                                echo "<div style='display: flex; flex-direction: row; justify-content: end; align-items: center;' > <button class='btn btn-outline-info mb-4' type='submit' style=' text-transform: capitalize; ' > imprimir $rep <i class='fa fa-file-alt fa-sm ' ></i> </button></div>";
                                echo "</form>";
                                echo "</div>";
                              }
                              if( $numemp === 1 ) {
                                if( $p === 1 ) echo '<input required type="hidden" name="cargo_ac" id="cargo_ac" value="" />',"\n";
                                if( $p === 2 ) echo '<input required type="hidden" name="cargo_al" id="cargo_al" value="" />',"\n";
                                if( $p === 3 ) echo '<input required type="hidden" name="cargo_ab" id="cargo_ab" value="" />',"\n";
                              }
                              if( $numemp === 2 ) {
                                if( $p === 1 ) echo '<input required type="hidden" name="cargo_bc" id="cargo_bc" value="" />',"\n";
                                if( $p === 2 ) echo '<input required type="hidden" name="cargo_bl" id="cargo_bl" value="" />',"\n";
                                if( $p === 3 ) echo '<input required type="hidden" name="cargo_bb" id="cargo_bb" value="" />',"\n";
                              }
                              if( $p === 2 ) {
                              ?>
                                <div class="row mb-1">
                                  <label for="sueldo" class="col-sm-7 col-form-label">Adelanto:</label>
                                  <div class="col-sm-5">
                                    <input onkeypress="return filterFloat(event,this);" type="text" id="adelanto" name="adelanto" class="form-control form-control-sm bg-danger bg-gradient bg-opacity-50 text-white" placeholder="Adelanto" value="<?php echo isset($_POST['adelanto']) ? $_POST['adelanto'] : '0' ?>">
                                  </div>
                                </div>
                                <div class="row mb-1 border-bottom border-info">
                                  <label for="sueldo" class="col-sm-7 col-form-label">Retencion:</label>
                                  <div class="col-sm-5">
                                    <input onkeypress="return filterFloat(event,this);"  type="text" id="retencion" name="retencion" class="form-control form-control-sm bg-danger bg-gradient bg-opacity-50 text-white" placeholder="Retencion" value="<?php echo isset($_POST['retencion']) ? $_POST['retencion'] : '0' ?>">
                                  </div>
                                </div>
                                <div class="row mb-1">
                                  <label for="sueldo" class="col-sm-7 col-form-label">Vacaciones:</label>
                                  <div class="col-sm-5">
                                    <input onkeypress="return filterFloat(event,this);" type="text" id="vacaciones" name="vacaciones" class="form-control form-control-sm" placeholder="Vacaciones" value="<?php echo isset($_POST['vacaciones']) ? $_POST['vacaciones'] : '0' ?>">
                                  </div>
                                </div>
                                <div class="row mb-1">
                                  <label for="sueldo" class="col-sm-7 col-form-label">Gratificaciones:</label>
                                  <div class="col-sm-5">
                                    <input onkeypress="return filterFloat(event,this);" type="text" id="gratificaciones" name="gratificaciones" class="form-control form-control-sm" placeholder="Gratificaciones" value="<?php echo isset($_POST['gratificaciones']) ? $_POST['gratificaciones'] : '0' ?>">
                                  </div>
                                </div>
                                <div class="row mb-1">
                                  <label for="sueldo" class="col-sm-7 col-form-label">Reintegro:</label>
                                  <div class="col-sm-5">
                                    <input onkeypress="return filterFloat(event,this);" type="text" id="reintegro" name="reintegro" class="form-control form-control-sm" placeholder="Reintegro" value="<?php echo isset($_POST['reintegro']) ? $_POST['reintegro'] : '0' ?>">
                                  </div>
                                </div>
                                <div class="row mb-1">
                                  <label for="sueldo" class="col-sm-7 col-form-label">Incentivo:</label>
                                  <div class="col-sm-5">
                                    <input onkeypress="return filterFloat(event,this);"  type="text" id="incentivo" name="incentivo" class="form-control form-control-sm" placeholder="Incentivo" value="<?php echo isset($_POST['incentivo']) ? $_POST['incentivo'] : '0' ?>">
                                  </div>
                                </div>
                                <div class="row mb-1">
                                  <label for="sueldo" class="col-sm-7 col-form-label">Bonificacion:</label>
                                  <div class="col-sm-5">
                                    <input onkeypress="return filterFloat(event,this);" type="text" id="bonificacion" name="bonificacion" class="form-control form-control-sm" placeholder="Bonificacion" value="<?php echo isset($_POST['bonificacion']) ? $_POST['bonificacion'] : '0' ?>">
                                  </div>
                                </div>
                                <div class="row mb-1">
                                  <label for="sueldo" class="col-sm-7 col-form-label">Bonificacion Graciosa:</label>
                                  <div class="col-sm-5">
                                    <input onkeypress="return filterFloat(event,this);" type="text" id="bonificacion_graciosa" name="bonificacion_graciosa" class="form-control form-control-sm" placeholder="Bonificacion Graciosa" value="<?php echo isset($_POST['bonificacion_graciosa']) ? $_POST['bonificacion_graciosa'] : '0' ?>">
                                  </div>
                                </div>
                                <div class="row mb-1">
                                  <label for="sueldo" class="col-sm-7 col-form-label">Bonificacion Extraordinaria:</label>
                                  <div class="col-sm-5">
                                    <input onkeypress="return filterFloat(event,this);" type="text" id="bonificacion_extraordinaria" name="bonificacion_extraordinaria" class="form-control form-control-sm" placeholder="Bonificacion Extraordinaria" value="<?php echo isset($_POST['bonificacion_extraordinaria']) ? $_POST['bonificacion_extraordinaria'] : '0' ?>">
                                  </div>
                                </div>
                              <?php
                              }
                                echo $control[0],"\n";
                                echo $control[1],"\n";
                                echo $control[2],"\n";
                              // if ( $numemp === 1 ) {
                                echo $control[3],"\n";
                                echo $control[4],"\n";
                                echo $control[10],"\n";
                                echo $control[12],"\n";
                                echo $control[13],"\n";
                              // }
                              // if ( $numemp === 2 ) {
                              //   echo $control[5],"\n";
                              //   echo $control[6],"\n";
                              //   echo $control[11],"\n";
                              //   echo $control[14],"\n";
                              //   echo $control[15],"\n";
                              // }
                                echo $control[8],"\n";
                                echo $control[9],"\n";
                                echo $control[16],"\n";
                                echo "<div style='display: flex; flex-direction: row; justify-content: end; align-items: center;' > <button class='btn btn-outline-info mb-4' type='submit' style=' text-transform: capitalize; ' > imprimir $rep <i class='fa fa-file-alt fa-sm ' ></i> </button></div>";
                                echo "</form>";
                                echo "</div>";
                          }
                          ?>
                        </div>
                      </div>
                    <?php
                    }
                  }
                ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

  <script src="js/moment-with-locales.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>

  <script src="./datatables/datatables.min.js"></script>
	
	<script>
        // moment.locale('es-mx')
        
        $(document).ready( function () {
            $('#tabladatos').DataTable({
              "ordering": false,
              "searching": false,
              "paging": false,
              "info": false
            });
        } );

        const mostrar = (dato) => { $('#pensionado').css("display", dato == "pensionado" ? "block" : "none" ) }

        const calcularEdad = () => {
          const fechaAct = h()
          const fechaNac = moment($('#nacimiento').val())
          const edad = fechaAct.diff(fechaNac, 'years')
          const fecleglab = fechaNac.add(18, 'years').format('Y/M/D')
          $('#edad').val(edad)
          $('#iniactlab').val(fecleglab)
        }

        const asignar_cargo_c = (valor) => {
          // alert("El cargo es: "+valor)
          $('#cargo_ac').val(valor)
          $('#cargo_al').val(valor)
          $('#cargo_ab').val(valor)
        }

        const asignar_cargo_l = (valor) => {
          // alert("El cargo es: "+valor)
          $('#cargo_bc').val(valor)
          $('#cargo_bl').val(valor)
          $('#cargo_bb').val(valor)
        }

        function filterFloat(evt,input){
          // Backspace = 8, Enter = 13, ‘0′ = 48, ‘9′ = 57, ‘.’ = 46, ‘-’ = 43
          var key = window.Event ? evt.which : evt.keyCode;   
          var chark = String.fromCharCode(key);
          var tempValue = input.value+chark;
          var isNumber = (key >= 48 && key <= 57);
          var isSpecial = (key == 8 || key == 13 || key == 0 ||  key == 46);
          if(isNumber || isSpecial){
              return filter(tempValue);
          }        
          
          return false;    
            
        }
        function filter(__val__){
          var preg = /^([0-9]+\.?[0-9]{0,2})$/; 
          return (preg.test(__val__) === true);
        }

    </script>
</body>
</html>