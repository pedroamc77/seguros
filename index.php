<?php 

require_once('./_db/funciones.php');

// $informacion = consultar_bd();

// if ( isset($_FILES['archivo']) ) {
//     cargar_csv_bd($_FILES['archivo'], $_POST['encabezado'], $_POST['separador']);
// }

if ( isset($_POST['fnacimiento']) && $_POST['fnacimiento'] != '' ) {
  // var_dump($_POST);
  // exit;
  $empresas = empresas_cotizadas($_POST['fnacimiento']);
}

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
                                <input type="text" id="nombres" name="nombre" class="form-control form-control-sm" placeholder="Nombres">
                              </div>
                          </div>
                          <div class="row mr-1">
                              <label for="apellidos" class="col-sm-3 col-form-label">Apellidos:</label>
                              <div class="col-sm-9">
                                <input type="text" id="apellidos" name="apellidos" class=" form-control form-control-sm" placeholder="Apellidos">
                              </div>
                          </div>
                          <div class="row mb-1">
                              <label for="dni" class="col-sm-3 col-form-label">DNI:</label>
                              <div class="col-sm-9">
                                <input type="text" id="dni" name="dni" class="form-control form-control-sm" placeholder="DNI">
                              </div>
                          </div>
                          <div class="row mb-1">
                              <label for="nacimiento" class="col-sm-3 col-form-label">Nacimiento:</label>
                              <div class="col-sm-9">
                                <input type="date" id="fnacimiento" name="fnacimiento" class="form-control form-control-sm" onchange="calcularEdad()">
                                <input type="hidden" id="edad" name="edad" value="" >
                                <input type="hidden" id="fecleglab" name="fecleglab" value="" >
                                <input type="hidden" id="nacimiento" name="nacimiento" value="" >
                              </div>
                          </div>
                          <div class="row mb-1">
                              <label for="iniactlab" class="col-sm-5 col-form-label">Inicio de Act. Laboral:</label>
                              <div class="col-sm-7">
                                <input type="date" id="iniactlab" name="iniactlab" class="form-control form-control-sm" onchange="calcularTiemLabo()">
                              </div>
                          </div>
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
                        </div>
                        <div class="col-6">
                          <div id="pensionado" style="display:none;">
                              <!-- <hr class="divisor_h" /> -->
                              <div class="accordion" id="accordion">
                                <div class="accordion-item">
                                  <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                      Reporte "O"
                                    </button>
                                  </h2>
                                  <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordion" >
                                    <div class="accordion-body">
                                      <!-- <div class="row"> -->
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
                                      <!-- </div> -->
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
                        </div>
                      </div>
                      <hr style="margin: 5px 0;" />
                      <div class="row">
                        <div class="col-6">
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
                        </div>
                        <div class="col-6">
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
                    <th>IND</th>
                    <th>Empleador</th>
                    <th>Dpto</th>
                    <th>Inic Act.</th>
                    <th>Baja Act.</th>
                    <th>Años</th>
                    <th style='text-align: center;'>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                  if ( isset($_POST['fecleglab']) ) {
                    foreach ($empresas as $empresa) {
                      echo "<tr>";
                      echo "<td>".$empresa['id']."</td>";
                      echo "<td>".$empresa['ind']."</td>";
                      echo "<td>".$empresa['empleador']."</td>";
                      echo "<td>".$empresa['dpto']."</td>";
                      echo "<td>".$empresa['f_inic_act']."</td>";
                      echo "<td>".$empresa['f_baja_act']."</td>";
                      echo "<td>".$empresa['anios_transcurridos']."</td>";
                      ?>
                      <td style="text-align: center; padding: 0 15px;">
                        <a href="#" class="px-2" style="text-decoration: none;"> <i class="fas fa-pen text-warning" ></i> </a>
                        <a href="#" class="px-2" style="text-decoration: none;"> <i class="fas fa-times text-danger" ></i> </a>
                        <a href="#" class="px-2" style="text-decoration: none;"> <i class="fas fa-eye text-success" ></i> </a>
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
        moment.locale('es-mx')
        
        $(document).ready( function () {
            $('#tabladatos').DataTable({
            });
        } );

        const mostrar = (dato) => { $('#pensionado').css("display", dato == "pensionado" ? "block" : "none" ) }

        const calcularTiemLabo = () => {
          const fechaIniAct = moment($('#iniactlab').val())
          const fechaFinAct = moment($('#fecafiafp').val())
          const anios = fechaFinAct.diff(fechaIniAct, 'years')
          $("#anioslaborados").val(anios)
          console.info('Ini Actividad Laboral: ', fechaIniAct.format('L'))
          console.info('Fin Actividad Laboral: ', fechaFinAct.format('L'))
          console.info('Años que laboró: ', anios)
        }

        const calcularEdad = () => {
          const fechaAct = moment()
          const fechaNac = moment($('#fnacimiento').val())
          $('#nacimiento').val($('#fnacimiento').val())
          console.info('Fecha de Nacimiento: ', fechaNac.format('Y/M/D'))

          const edad = fechaAct.diff(fechaNac, 'years')
          $('#edad').val(edad)
          console.info('Edad: ', edad)

          const fecleglab = fechaNac.add(18, 'years').format('Y/M/D')
          $('#fecleglab').val(fecleglab)
          console.info('Fecha de edad legal para laborar: ', fecleglab)
        }
    </script>
</body>
</html>