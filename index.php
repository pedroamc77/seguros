<?php 



require_once('./_db/funciones.php');

// $informacion = consultar_bd();
// if ( isset($_FILES['archivo']) ) {
//     cargar_csv_bd($_FILES['archivo'], $_POST['encabezado'], $_POST['separador']);
// }

if ( isset($_POST['fnacimiento']) && $_POST['fnacimiento'] !== "" ) {
    // echo "Fecha de Nacimiento: ".$_POST['nacimiento'];
    // exit;
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
    <link rel="stylesheet" href="css/impresion.min.css" media="print">
    <link rel="stylesheet" href="./datatables/datatables.min.css">
    <link href="fa5130/css/all.min.css" rel="stylesheet" >

</head>
<body>
  <div class="contenedor">
    <div class="app">
      <div class="app_horizontal_barra">
          <div class="app_horizontal_barra_logo"><div>Sis</div><div>Pen</div></div>
          <div class="app_horizontal_barra_menu">
            <button href="#" class="custom-btn btn-13">Tablero</button>
            <button href="#" class="custom-btn btn-13">Empleados</button>
            <button href="#" class="custom-btn btn-13">Reportes</button>
            <button href="#" class="custom-btn btn-13">Empresas</button>
          </div>
      </div>
      <div class="app_horizontal_contenido">
        <div class="app_contenido_formulario p-2" >
          <div class="container-fluid">
            <div class="row justify-content-center">
              <div class="col-xl-7 col-lg-9 col-md-12 col-sm-12">
                <form action="index.php" id="frmPersona" method="POST" >
                  <fieldset>
                      <div class="row">
                        <div class="col-6">
                          <div class="row mb-1">
                              <label for="nombre" class="col-sm-3 col-form-label">Nombre:</label>
                              <div class="col-sm-9">
                                <input type="text" id="nombres" name="nombres" class="form-control form-control-sm" placeholder="Nombres" value="<?php echo $_POST['nombres'] ?>">
                              </div>
                          </div>
                          <div class="row mr-1">
                              <label for="apellidos" class="col-sm-3 col-form-label">Apellidos:</label>
                              <div class="col-sm-9">
                                <input type="text" id="apellidos" name="apellidos" class=" form-control form-control-sm" placeholder="Apellidos" value="<?php echo $_POST['apellidos'] ?>">
                              </div>
                          </div>
                          <div class="row mb-1">
                              <label for="dni" class="col-sm-3 col-form-label">DNI:</label>
                              <div class="col-sm-9">
                                <input type="text" id="dni" name="dni" class="form-control form-control-sm" placeholder="DNI">
                              </div>
                          </div>
                          <div class="row mb-1">
                              <label for="fnacimiento" class="col-sm-3 col-form-label">Nacimiento:</label>
                              <div class="col-sm-9">
                               <!--onchange="calcularEdad()"-->
                                <input type="date" id="fnacimiento" name="fnacimiento" value="<?php echo $_POST['fnacimiento'] ?>" class="form-control form-control-sm" onchange="calcularEdad()">
                                <input type="hidden" id="edad" name="edad" value="<?php echo $_POST['edad'] ?>" >
                                <input type="hidden" id="fecleglab" name="fecleglab" value="<?php echo $_POST['iniactlab'] ?>" >
                              </div>
                          </div>
                          <div class="row mb-1">
                              <!-- onchange="calcularTiemLabo()" -->
                              <label for="iniactlab" class="col-sm-5 col-form-label">Inicio de Act. Laboral:</label>
                              <div class="col-sm-7">
                                <input type="text" readonly id="iniactlab" name="iniactlab" value="<?php echo $_POST['iniactlab'] ?>" class="form-control form-control-sm" >
                              </div>
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="row mb-1">
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
                          </div>
                          <div class="row mb-3">
                            <label for="cargo_o" class="col-sm-3 col-form-label">Cargo:</label>
                            <div class="col-sm-9">
                              <input type="text" id="cargo_o" name="cargo_o" class="form-control form-control-sm" placeholder="Cargo" value="<?php echo $_POST['cargo_o'] ?>">
                            </div>
                          </div>
                          <div class="row mb-3">
                            <label for="sueldo" class="col-sm-3 col-form-label">Sueldo:</label>
                            <div class="col-sm-9">
                              <input type="text" id="sueldo" name="sueldo" class="form-control form-control-sm" placeholder="Sueldo" value="<?php echo $_POST['sueldo'] ?>">
                            </div>
                          </div>
                        </div>

                        <!-- Acordeon -->
                        <!-- <div class="col-6">
                          <div id="pensionado" style="display:none;">
                              <div class="accordion" id="accordion">
                                <div class="accordion-item">
                                  <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                      Reporte "O"
                                    </button>
                                  </h2>
                                  <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordion" >
                                    <div class="accordion-body">
                                        <div class="row ">
                                          <label for="empleador" class="col-sm-3 col-form-label">Empresa:</label>
                                          <div class="col-sm-9">
                                            <input type="text" id="empresa" name="empresa" class="form-control form-control-sm" placeholder="Empresa">
                                          </div>
                                        </div>
                                        <div class="row ">
                                          <label for="cargo_o" class="col-sm-3 col-form-label">Cargo:</label>
                                          <div class="col-sm-9">
                                            <input type="text" id="cargo_o" name="cargo_o" class="form-control form-control-sm" placeholder="Cargo">
                                          </div>
                                        </div>
                                        <hr style="margin: 5px 0;"/>
                                        <div class="row">
                                          <div class="col-6 ">
                                            <label for="inicio_act" class="form-label">Inicio Actividades:</label>
                                              <input type="date" id="ini_act_O" name="nacimiento" class="form-control form-control-sm" placeholder="Fecha de Inicio en la empresa" >
                                          </div>
                                          <div class="col-6 ">
                                            <label for="fin_act" class="form-label">Fin Actividades:</label>
                                            <input type="date" id="fin_act_O" name="nacimiento" class="form-control form-control-sm" placeholder="Fecha de finalizacion" >
                                          </div>
                                        </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="accordion-item">
                                  <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                      Reporte "H"
                                    </button>
                                  </h2>
                                  <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordion">
                                    <div class="accordion-body">
                                        <div class="row ">
                                          <label for="empleador" class="col-sm-3 col-form-label">Empresa:</label>
                                          <div class="col-sm-9">
                                            <input type="text" id="empresa" name="empresa" class="form-control form-control-sm" placeholder="Empresa">
                                          </div>
                                        </div>
                                        <div class="row ">
                                          <label for="cargo" class="col-sm-3 col-form-label">Cargo:</label>
                                          <div class="col-sm-9">
                                            <input type="text" id="cargo" name="cargo" class="form-control form-control-sm" placeholder="Cargo">
                                          </div>
                                        </div>
                                        <hr style="margin: 5px 0;"/>
                                        <div class="row">
                                          <div class="col-6 ">
                                            <label for="inicio_act" class="form-label">Inicio Actividades:</label>
                                              <input type="date" id="ini_act_O" name="nacimiento" class="form-control form-control-sm" placeholder="Fecha de Inicio en la empresa" >
                                          </div>
                                          <div class="col-6 ">
                                            <label for="fin_act" class="form-label">Fin Actividades:</label>
                                            <input type="date" id="fin_act_O" name="nacimiento" class="form-control form-control-sm" placeholder="Fecha de finalizacion" >
                                          </div>
                                        </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="accordion-item">
                                  <h2 class="accordion-header" id="headingThree">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                      Reporte "R"
                                    </button>
                                  </h2>
                                  <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordion">
                                    <div class="accordion-body">
                                      <div class="row ">
                                        <label for="empleador" class="col-sm-3 col-form-label">Empresa:</label>
                                        <div class="col-sm-9">
                                          <input type="text" id="empresa" name="empresa" class="form-control form-control-sm" placeholder="Empresa">
                                        </div>
                                      </div>
                                      <div class="row ">
                                        <label for="cargo" class="col-sm-3 col-form-label">Cargo:</label>
                                        <div class="col-sm-9">
                                          <input type="text" id="cargo" name="cargo" class="form-control form-control-sm" placeholder="Cargo">
                                        </div>
                                      </div>
                                      <hr style="margin: 5px 0;"/>
                                      <div class="row">
                                        <div class="col-6 ">
                                          <label for="inicio_act" class="form-label">Inicio Actividades:</label>
                                            <input type="date" id="ini_act_O" name="nacimiento" class="form-control form-control-sm" placeholder="Fecha de Inicio en la empresa" >
                                        </div>
                                        <div class="col-6 ">
                                          <label for="fin_act" class="form-label">Fin Actividades:</label>
                                          <input type="date" id="fin_act_O" name="nacimiento" class="form-control form-control-sm" placeholder="Fecha de finalizacion" >
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                          </div>
                        </div> -->
                      </div>

                      <!-- Opciones de reporte -->
                      <hr style="margin: 5px 0;" />
                      <div class="row">
                        <!-- <div class="col-6">
                          <div class="mb-1 px-3 row">
                              <div class="col-4 form-check">
                                  <input class="form-check-input" type="radio" value="boleta" name="opcion" id="optboleta" onchange="mostrar(this.value);">
                                  <label class="form-check-label" for="optboleta">
                                      Boleta
                                  </label>
                              </div>
                              <div class="col-4 form-check">
                                  <input class="form-check-input" type="radio" value="pensionado" name="opcion" id="optpensionado" onchange="mostrar(this.value);">
                                  <label class="form-check-label" for="optpensionado">
                                      Pensionado
                                  </label>
                              </div>
                              <div class="col-4 form-check">
                                  <input class="form-check-input" type="radio" value="noreporte" name="opcion" id="optnoreporte" onchange="mostrar(this.value);">
                                  <label class="form-check-label" for="optnoreporte">
                                      Sin reporte
                                  </label>
                              </div>
                          </div>
                        </div> -->
                        <div class="col-12">
                          <div class="mb-3 row justify-content-end " >
                              <button type="submit" class="col-xl-2 col-lg-2 col-md-3 col-sm-3 btn btn-primary btn-sm me-3 ">Cargar</button>
                              <button type="reset" class="col-xl-2 col-lg-2 col-md-3 col-sm-3 btn btn-primary btn-sm me-3 ">Cancelar</button>
                          </div>
                        </div>
                      </div>
                  </fieldset>
                </form>
              </div>
            </div>
          </div>
        </div>
        <div class="app_contenido_tabla p-2" >
          <div class="title" >Listado</div>
          <table id="tabladatos" class="display hover compact stripe" >
            <thead>
                <tr>
                    <th>Id</th>
                    <!-- <th>IND</th> -->
                    <th>Empleador</th>
                    <th>Dpto</th>
                    <th>Inic Act.</th>
                    <th>Baja Act.</th>
                    <!-- <th>Años</th> -->
                    <th style='text-align: center;'>Acciones</th>
                </tr>
            </thead>
            <tbody class="text-dark">
                <?php // var_dump($empresas); ?>
                <?php
                  $numemp = 0;
                  if ( isset($_POST['fnacimiento']) ) {
                    foreach ($empresas as $empresa) {
                      $numemp++;
                      echo "<tr>";
                      echo "<td>".$empresa['id']."</td>";
                      // echo "<td>".$empresa['ind']."</td>";
                      echo "<td>".$empresa['empleador']."</td>";
                      echo "<td>".$empresa['dpto']."</td>";
                      echo "<td>".$empresa['f_inic_act']."</td>";
                      echo "<td>".$empresa['f_baja_act']."</td>";
                      // echo "<td>".$empresa['anios_transcurridos']."</td>";
                      ?>
                      <td style="display: flex; flex-direction: row; flex-wrap: nowrap; justify-content: center; text-align: center; padding: 0 15px;">
                        <?php
                          // echo "Fecha de Nacimiento: ",$_POST['fnacimiento'];
                          $control[0] = '<input type="hidden" name="empresa" value="'.$empresa['empleador'].'">'; 
                          $control[1] = '<input type="hidden" name="nombres" value="'.$_POST['nombres'].'">'; 
                          $control[2] = '<input type="hidden" name="apellidos" value="'.$_POST['apellidos'].'">'; 
                          
                          
                          $valido = false;
                          do {
                            $aniosa = rand(8, 12);
                            $aniosb = rand(8, 12);
                            $daysint = rand(8, 25);
                            $monthsint = rand(1, 5);
                            $aniosint = rand(0, 2);
                            if ( ( $aniosa + $aniosb ) >= 20 ) $valido = true;
                          } while (!$valido);

                          $date = new DateTime();
                          // echo "Fecha Nacimiento: ",$_POST['fnacimiento'],"<br>";
                          // $datea_a = date_create($_POST['fnacimiento']);
                          $datea_a = date_create($_POST['fnacimiento']);
                          //$datea_a = date_create($empresa['f_inic_act']);
                          $datea_a = date_add($datea_a, date_interval_create_from_date_string("18 year"));
                          //echo "Fecha Legal Laboral: ",date_format($datea_a, "Y-m-d"),"<br><br>";

                          $datea_a = date_add($datea_a, date_interval_create_from_date_string($monthsint." months"));
                          $datea_a = date_add($datea_a, date_interval_create_from_date_string($daysint." days"));
                          $control[3] = '<input type="hidden" name="f_a" value="'.date_format($datea_a, "j").' de '.$meses[date_format($datea_a , "n")].' de '.date_format($datea_a , "Y").'">'; 
                          if ( $numemp === 1 ) echo "Fecha I A: ",date_format($datea_a, "Y-m-d"),"<br>";
                          
                          $datea_b = date_add($datea_a, date_interval_create_from_date_string(($monthsint + 1)." months"));
                          $datea_b = date_add($datea_b, date_interval_create_from_date_string($aniosa." years"));
                          $datea_b = date_create(date_format($datea_b, "Y-m-d"));
                          $control[4] = '<input type="hidden" name="f_b" value="'.date_format($datea_b, 'j').' de '.$meses[date_format($datea_b , "n")].' de '.date_format($datea_b , "Y").'">'; 
                          if ( $numemp === 1 ) echo "Fecha B A: ",date_format($datea_b, "Y-m-d"),"<br>";
                          
                          $dateb_a = date_add($datea_b, date_interval_create_from_date_string(($monthsint - 1)." months"));
                          $dateb_a = date_add($dateb_a, date_interval_create_from_date_string($aniosint." years"));
                          $dateb_a = date_create(date_format($dateb_a, "Y-m-d"));
                          $control[5] = '<input type="hidden" name="f_a" value="'.date_format($dateb_a, "j").' de '.$meses[date_format($dateb_a , "n")].' de '.date_format($dateb_a , "Y").'">'; 
                          if ( $numemp === 2 ) echo "Fecha I B: ",date_format($dateb_a, "Y-m-d"),"<br>";
                          
                          $dateb_b = date_add($dateb_a, date_interval_create_from_date_string($aniosb." years"));
                          $dateb_b = date_create(date_format($dateb_b, "Y-m-d"));
                          $control[6] = '<input type="hidden" name="f_b" value="'.date_format($dateb_b, 'j').' de '.$meses[date_format($dateb_b , "n")].' de '.date_format($dateb_b , "Y").'">'; 
                          if ( $numemp === 2 ) echo "Fecha B B: ",date_format($dateb_b, "Y-m-d"),"<br>";

                          $control[7] = '<input type="hidden" name="cargo_a" value="'.$_POST['cargo_o'].'">'; 
                          $control[8] = '<input type="hidden" name="dpto" value="'.$empresa['dpto'].'">'; 
                          $control[9] = '<input type="hidden" name="fecha_emision" value="'.date_format($date, 'j').' de '.$meses[date_format($date , 'n')].' de '.date_format($date ,'Y').'">';
                        ?>
                          <?php
                          for ( $p = 1 ; $p < 3 ; $p++ ) {
                            echo "<form action='reportes/reporte0$p.php' method='post'>";
                            // for ( $i = 0; $i < 10; $i++  ) {
                            //   echo $control[$i],"\n";
                            // }
                            echo $control[0],"\n";
                            echo $control[1],"\n";
                            echo $control[2],"\n";
                            if ( $numemp === 1 ) {
                              echo $control[3],"\n";
                              echo $control[4],"\n";
                            }
                            if ( $numemp === 2 ) {
                              echo $control[5],"\n";
                              echo $control[6],"\n";
                            }
                            echo $control[7],"\n";
                            echo $control[8],"\n";
                            echo $control[9],"\n";
                            echo "<button type='submit' data-title='Reporte A' > <i class='fa fa-file-alt' ></i> </button>";
                            echo "</form>";
                          }
                          ?>
                      </td>
                      <?php
                      echo "</tr>";
                    }
                    // var_dump($empresas);
                  }
                  // for ($i=1; $i < 51; $i++) {
                  //   echo "<tr>";
                  //   for ($o=1; $o < 11; $o++) {
                  //     echo "<td>","F: ",str_pad($i,2,"0",STR_PAD_LEFT)," / C: ",str_pad(strval($o),2,"0",STR_PAD_LEFT),"</td>";
                  //   }
                  //   echo "</tr>";
                  // }
                ?>
            </tbody>
          </table>
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
            });
        } );

        const mostrar = (dato) => { $('#pensionado').css("display", dato == "pensionado" ? "block" : "none" ) }

        // const calcularTiemLabo = () => {
        //   const fechaIniAct = moment($('#iniactlab').val())
        //   const fechaFinAct = moment($('#fecafiafp').val())
        //   const anios = fechaFinAct.diff(fechaIniAct, 'years')
        //   $("#anioslaborados").val(anios)
        //   console.info('Ini Actividad Laboral: ', fechaIniAct.format('L'))
        //   console.info('Fin Actividad Laboral: ', fechaFinAct.format('L'))
        //   console.info('Años que laboró: ', anios)
        // }

        const calcularEdad = () => {
          const fechaAct = moment()
          const fechaNac = moment($('#nacimiento').val())
          const edad = fechaAct.diff(fechaNac, 'years')
          const fecleglab = fechaNac.add(18, 'years').format('Y/M/D')
          $('#edad').val(edad)
          $('#iniactlab').val(fecleglab)
          //console.info('Fecha de Nacimiento: ', $('#nacimiento').val())
          //console.info('Edad: ', edad)
          //console.info('Fecha de edad legal para laborar: ', fecleglab)
        }
    </script>
</body>
</html>