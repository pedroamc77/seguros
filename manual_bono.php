<?php 

require_once('./_db/nomina.php');

// if ( isset($_POST['finicio']) && $_POST['finicio'] !== "" ) {
//     $empresas = empresas_cotizadas($_POST['finicio']);
// }

$bonoactivo = true;

// $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");

$anniorp = [];
$rp = [];
$bo = [];

$dif_orci = [];
$dif_host = [];
$dif_refl = [];

$pageorci = isset($_POST['orci_fechaf']); 
$pagehost = isset($_POST['host_fechaf']); 
$pagerefl = isset($_POST['refl_fechaf']); 

$empresa = [];
$datosfechas = [];

$tab = isset($_POST['tab']) && $_POST['tab'] !== '' ? $_POST['tab'] : '';

// if (isset($_POST['orci_fechaf'])) echo $_POST['orci_fechaf'],"<br>";
// if (isset($_POST['host_fechaf'])) echo $_POST['host_fechaf'],"<br>";
// if (isset($_POST['refl_fechaf'])) echo $_POST['refl_fechaf'],"<br>";

if ( isset($_POST['orci_fechai']) && $_POST['orci_fechai'] !== '' ) { 
  $datea_a = date_create($_POST['orci_fechai']); 
  $datea_b = date_create($_POST['orci_fechaf']); 

  $dif_orci = date_diff($datea_b, $datea_a);

  $fechas['orci']['fa1'] = date_format($datea_a, "j").' de '.$meses[date_format($datea_a , "n")].' de '.date_format($datea_a , "Y"); 
  $fechas['orci']['fa2'] = date_format($datea_a, "d.m.Y"); 
  $fechas['orci']['fa3'] = date_format($datea_a, "Y-m-d");
  $fechas['orci']['fa4'] = date_format($datea_a, "j").'.'.$mes[date_format($datea_a , "n")].'.'.date_format($datea_a , "Y"); 

  $anniorp['orci'] = date_format($datea_b,"Y");
  $fechas['orci']['fb1'] = date_format($datea_b, 'j').' de '.$meses[date_format($datea_b , "n")].' de '.date_format($datea_b , "Y"); 
  $fechas['orci']['fb2'] = date_format($datea_b, "d.m.Y"); 
  $fechas['orci']['fb3'] = date_format($datea_b, "Y-m-d");
  $fechas['orci']['fb4'] = date_format($datea_b, 'j').'.'.$mes[date_format($datea_b , "n")].'.'.date_format($datea_b , "Y"); 

  $emisiona_b = date_create(date_format($datea_b, "d.m.Y"));
  $emisiona_b = date_add($emisiona_b, date_interval_create_from_date_string("7 days"));
  
  $fechas['orci']['emision'] = date_format($emisiona_b, "d.m.Y"); 
  $fechas['orci']['anniorep'] = date_format($datea_b, "Y");
  
  if ( $anniorp['orci'] >= 1962 && $anniorp['orci'] <= 1972 ) { $rp['orci'] = "_62al72"; }
  if ( $anniorp['orci'] >= 1973 && $anniorp['orci'] <= 1975 ) { $rp['orci'] = "_73al75"; }
  if ( $anniorp['orci'] >= 1976 && $anniorp['orci'] <= 1983 ) { $rp['orci'] = "_76al83"; }
  if ( $anniorp['orci'] >= 1984 && $anniorp['orci'] <= 1994 ) { $rp['orci'] = "_84al94"; }
  if ( $anniorp['orci'] >= 1995 ) { $rp['orci'] = "_95al00"; }
  
  if ( $anniorp['orci'] >= 1978 && $anniorp['orci'] <= 1980 ) { $bo['orci'] = "_78al80"; }
  if ( $anniorp['orci'] >= 1981 && $anniorp['orci'] <= 1987 ) { $bo['orci'] = "_81al87"; }
  if ( $anniorp['orci'] >= 1988 && $anniorp['orci'] <= 1992 ) { $bo['orci'] = "_88al92"; }
  if ( $anniorp['orci'] >= 1993 ) { $bo['orci'] = "_93al00"; }

  $empresa['orci'] = empresa_cotizada(date_format($datea_a, "Y-m-d"), date_format($datea_b, "Y-m-d"))[0];

}

if (isset($_POST['host_fechai']) && $_POST['host_fechai'] !== '' ) { 
  $datea_a = date_create($_POST['host_fechai']); 
  $datea_b = date_create($_POST['host_fechaf']); 

  $dif_host = date_diff($datea_b, $datea_a);

  $fechas['host']['fa1'] = date_format($datea_a, "j").' de '.$meses[date_format($datea_a , "n")].' de '.date_format($datea_a , "Y"); 
  $fechas['host']['fa2'] = date_format($datea_a, "d.m.Y"); 
  $fechas['host']['fa3'] = date_format($datea_a, "Y-m-d");
  $fechas['host']['fa4'] = date_format($datea_a, "j").'.'.$mes[date_format($datea_a , "n")].'.'.date_format($datea_a , "Y"); 

  $anniorp['host'] = date_format($datea_b,"Y");
  $fechas['host']['fb1'] = date_format($datea_b, 'j').' de '.$meses[date_format($datea_b , "n")].' de '.date_format($datea_b , "Y"); 
  $fechas['host']['fb2'] = date_format($datea_b, "d.m.Y"); 
  $fechas['host']['fb3'] = date_format($datea_b, "Y-m-d");
  $fechas['host']['fb4'] = date_format($datea_b, 'j').'.'.$mes[date_format($datea_b , "n")].'.'.date_format($datea_b , "Y"); 

  $emisiona_b = date_create(date_format($datea_b, "d.m.Y"));
  $emisiona_b = date_add($emisiona_b, date_interval_create_from_date_string("7 days"));
  
  $fechas['host']['emision'] = date_format($emisiona_b, "d.m.Y"); 
  $fechas['host']['anniorep'] = date_format($datea_b, "Y");
  
  if ( $anniorp['host'] >= 1962 && $anniorp['host'] <= 1972 ) { $rp['host'] = "_62al72"; }
  if ( $anniorp['host'] >= 1973 && $anniorp['host'] <= 1975 ) { $rp['host'] = "_73al75"; }
  if ( $anniorp['host'] >= 1976 && $anniorp['host'] <= 1983 ) { $rp['host'] = "_76al83"; }
  if ( $anniorp['host'] >= 1984 && $anniorp['host'] <= 1994 ) { $rp['host'] = "_84al94"; }
  if ( $anniorp['host'] >= 1995 ) { $rp['host'] = "_95al00"; }
  
  if ( $anniorp['host'] >= 1978 && $anniorp['host'] <= 1980 ) { $bo['host'] = "_78al80"; }
  if ( $anniorp['host'] >= 1981 && $anniorp['host'] <= 1987 ) { $bo['host'] = "_81al87"; }
  if ( $anniorp['host'] >= 1988 && $anniorp['host'] <= 1992 ) { $bo['host'] = "_88al92"; }
  if ( $anniorp['host'] >= 1993 ) { $bo['host'] = "_93al00"; }

  $empresa['host'] = empresa_cotizada(date_format($datea_a, "Y-m-d"), date_format($datea_b, "Y-m-d"))[0];

}

if (isset($_POST['refl_fechai']) && $_POST['refl_fechai'] !== '' ) { 
  $datea_a = date_create($_POST['refl_fechai']); 
  $datea_b = date_create($_POST['refl_fechaf']);  

  $dif_refl = date_diff($datea_b, $datea_a);

  $fechas['refl']['fa1'] = date_format($datea_a, "j").' de '.$meses[date_format($datea_a , "n")].' de '.date_format($datea_a , "Y"); 
  $fechas['refl']['fa2'] = date_format($datea_a, "d.m.Y"); 
  $fechas['refl']['fa3'] = date_format($datea_a, "Y-m-d");
  $fechas['refl']['fa4'] = date_format($datea_a, "j").'.'.$mes[date_format($datea_a , "n")].'.'.date_format($datea_a , "Y"); 

  $anniorp['refl'] = date_format($datea_b,"Y");
  $fechas['refl']['fb1'] = date_format($datea_b, 'j').' de '.$meses[date_format($datea_b , "n")].' de '.date_format($datea_b , "Y"); 
  $fechas['refl']['fb2'] = date_format($datea_b, "d.m.Y"); 
  $fechas['refl']['fb3'] = date_format($datea_b, "Y-m-d");
  $fechas['refl']['fb4'] = date_format($datea_b, 'j').'.'.$mes[date_format($datea_b , "n")].'.'.date_format($datea_b , "Y"); 

  $emisiona_b = date_create(date_format($datea_b, "d.m.Y"));
  $emisiona_b = date_add($emisiona_b, date_interval_create_from_date_string("7 days"));
  
  $fechas['refl']['emision'] = date_format($emisiona_b, "d.m.Y"); 
  $fechas['refl']['anniorep'] = date_format($datea_b, "Y");
  
  if ( $anniorp['refl'] >= 1962 && $anniorp['refl'] <= 1972 ) { $rp['refl'] = "_62al72"; }
  if ( $anniorp['refl'] >= 1973 && $anniorp['refl'] <= 1975 ) { $rp['refl'] = "_73al75"; }
  if ( $anniorp['refl'] >= 1976 && $anniorp['refl'] <= 1983 ) { $rp['refl'] = "_76al83"; }
  if ( $anniorp['refl'] >= 1984 && $anniorp['refl'] <= 1994 ) { $rp['refl'] = "_84al94"; }
  if ( $anniorp['refl'] >= 1995 ) { $rp['refl'] = "_95al00"; }
  
  if ( $anniorp['refl'] >= 1978 && $anniorp['refl'] <= 1980 ) { $bo['refl'] = "_78al80"; }
  if ( $anniorp['refl'] >= 1981 && $anniorp['refl'] <= 1987 ) { $bo['refl'] = "_81al87"; }
  if ( $anniorp['refl'] >= 1988 && $anniorp['refl'] <= 1992 ) { $bo['refl'] = "_88al92"; }
  if ( $anniorp['refl'] >= 1993 ) { $bo['refl'] = "_93al00"; }

  $empresa['refl'] = empresa_cotizada(date_format($datea_a, "Y-m-d"), date_format($datea_b, "Y-m-d"))[0];
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
    <link rel="stylesheet" href="./datatables/datatables.min.css">
    <link href="fa5130/css/all.min.css" rel="stylesheet" >

</head>
<body>
  	<div class="contenedor">
    	<div class="app">
			<div class="app_horizontal_barra">
				<div class="app_horizontal_barra_logo"><div>Sis</div><div>Pen</div></div>
				<div class="app_horizontal_barra_menu">
					<a href="index.php" class="custom-btn btn-13 text-center">Pensiones</a>
					<a href="bono.php"  class="custom-btn btn-13 text-center">Bono</a>
					<a href="manual.php"  class="custom-btn btn-13  text-center">Pensiones Manual</a>
					<a href="manual_bono.php"  class="custom-btn btn-13  text-center">Bono Manual</a>
				</div>
			</div>
			<div class="app_horizontal_contenido">
				<div class="app_contenido_formulario p-2" >
					<div class="row justify-content-center">
						<!-- inicio tabs -->
						<div class="col-6">
							<div class="row">
								<div class="col-5">
									<h2>Bono</h2>
								</div>
								<div class="col-7">
									<div class="row justify-content-end">
										<div class="col-4 text-end">
											Orcinea:&nbsp;
										</div>
										<div class="col-8 text-start">
											<?php 
											$ao = 0;
											$mo = 0;
											$do = 0;
											if ($dif_orci) {
												echo str_pad($dif_orci->y,2,"0",STR_PAD_LEFT)," Años, ",str_pad($dif_orci->m,2,"0",STR_PAD_LEFT)," Meses, ",str_pad($dif_orci->d,2,"0",STR_PAD_LEFT)," Días.";
												$ao = $dif_orci->y;
												$mo = $dif_orci->m;
												$do = $dif_orci->d;
											} else {
												echo "-------------------------";
											}
											?>
										</div>
										<div class="col-4 text-end">
											Host:&nbsp;
										</div>
										<div class="col-8 text-start">
											<?php
											$ah = 0;
											$mh = 0;
											$dh = 0;
											if ($dif_host) {
												echo str_pad($dif_host->y,2,"0",STR_PAD_LEFT)," Años, ",str_pad($dif_host->m,2,"0",STR_PAD_LEFT)," Meses, ",str_pad($dif_host->d,2,"0",STR_PAD_LEFT)," Días.";
												$ah = $dif_host->y;
												$mh = $dif_host->m;
												$dh = $dif_host->d;
											} else {
												echo "-------------------------";
											}
											?>
										</div>
										<div class="col-4 text-end">
											Reflex:&nbsp;
										</div>
										<div class="col-8 text-start">
											<?php
											$ar = 0;
											$mr = 0;
											$dr = 0;
											if ($dif_refl) {
												echo str_pad($dif_refl->y,2,"0",STR_PAD_LEFT)," Años, ",str_pad($dif_refl->m,2,"0",STR_PAD_LEFT)," Meses, ",str_pad($dif_refl->d,2,"0",STR_PAD_LEFT)," Días.";
												$ar = $dif_refl->y;
												$mr = $dif_refl->m;
												$dr = $dif_refl->d;
											} else {
												echo "-------------------------";
											}
											?>
										</div>
										<div class="col-4 text-end">
											Total:&nbsp;
										</div>
										<div class="col-8 text-start">
											<?php
											if ( $dif_orci || $dif_host || $dif_refl) { 
												$at = $ao + $ah + $ar; 
												$mt = $mo + $mh + $mr; 
												$dt = $do + $dh + $dr; 
												
												$at = $at + intdiv($mt, 12);
												$mt = intdiv($mt, 12) ? ($mt - (intdiv($mt, 12)*12)) + intdiv($dt, 30) : $mt + intdiv($dt, 30);
												$dt = intdiv($dt, 30) ? ($dt - (intdiv($dt, 30)*30)) : $dt;

												echo str_pad($at,2,"0",STR_PAD_LEFT)," Años, ",str_pad($mt,2,"0",STR_PAD_LEFT)," Meses, ",str_pad($dt,2,"0",STR_PAD_LEFT)," Días."; 
											} else { 
												echo "-------------------------"; 
											} 
											?>
										</div>
									</div>
								</div>
							</div>
							<ul class="nav nav-tabs mb-3" id="pills-tab" role="tablist">
								<li class="nav-item" role="presentation">
								<button class="nav-link <?php echo $tab === '' || $tab === 'orci' ? 'active' : '' ?>"  id="orcinea-tab"  data-bs-toggle="pill" data-bs-target="#orcinea" type="button" role="tab" aria-controls="orcinea"  aria-selected="true">ORCINEA  </button>
								</li>
								<li class="nav-item" role="presentation">
								<button class="nav-link <?php echo $tab === 'host' ? 'active' : '' ?>"                 id="host-tab"     data-bs-toggle="pill" data-bs-target="#host"    type="button" role="tab" aria-controls="host"     aria-selected="false">HOST    </button>
								</li>
								<li class="nav-item" role="presentation">
								<button class="nav-link <?php echo $tab === 'refl' ? 'active' : '' ?>"                 id="refelx-tab"   data-bs-toggle="pill" data-bs-target="#reflex"  type="button" role="tab" aria-controls="reflex"   aria-selected="false">REFLEX  </button>
								</li>
							</ul>
							<?php //echo $tab; ?>
							<div class="tab-content">
								<!-- ORCINEA -->
								<div id="orcinea" class="tab-pane fadein <?php echo $tab === '' || $tab === 'orci' ? ' show active' : '' ?>">
									<!-- <div class="col border border-light rounded"> -->
									<form id="form_orci" action="manual_bono.php" method="post">
										<div class="text-center fs-4 fw-semibold text-white">ORCINEA</div>
										<div class="row align-items-center mb-1"><label for="orci_emprdni"    class="col-sm-2 col-form-label">R.U.C.:   </label><div class="col-sm-7"> <input type="text" id="orci_emprdni"   name="orci_emprdni"   class="form-control form-control-sm" placeholder="" value="<?php echo isset($_POST['orci_emprdni'])   ? $_POST['orci_emprdni']    : '' ?>"></div><div class="col-sm-3"><button class="btn btn-primary btn-sm" type="button" onclick="obtenerEmpresa('orci')">Buscar</button></div></div>
										<div class="row align-items-center mb-1"><label for="orci_empresa"    class="col-sm-2 col-form-label">Empresa:  </label><div class="col-sm-10"><input type="text" id="orci_empresa"   name="orci_empresa"   class="form-control form-control-sm" placeholder="" value="<?php echo isset($_POST['orci_empresa'])   ? $_POST['orci_empresa']    : '' ?>"></div></div>
										<div class="row align-items-center mb-1"><label for="orci_nombres"    class="col-sm-2 col-form-label">Nombres:  </label><div class="col-sm-10"><input type="text" id="orci_nombres"   name="orci_nombres"   class="form-control form-control-sm" placeholder="" value="<?php echo isset($_POST['orci_nombres'])   ? $_POST['orci_nombres']    : '' ?>"></div></div>
										<div class="row align-items-center mb-1"><label for="orci_apellidos"  class="col-sm-2 col-form-label">Apellidos:</label><div class="col-sm-10"><input type="text" id="orci_apellidos" name="orci_apellidos" class="form-control form-control-sm" placeholder="" value="<?php echo isset($_POST['orci_apellidos']) ? $_POST['orci_apellidos']  : '' ?>"></div></div>
										<div class="row align-items-center mb-1"><label for="orci_dni"        class="col-sm-2 col-form-label">D.N.I.:   </label><div class="col-sm-10"><input type="text" id="orci_dni"       name="orci_dni"       class="form-control form-control-sm" placeholder="" value="<?php echo isset($_POST['orci_dni'])       ? $_POST['orci_dni']        : '' ?>"></div></div>
										<div class="row justify-content-start align-items-center mb-1">
											<label for="orci_fechai" class="col-sm-2 col-form-label ">Inicio: </label><div class="col-sm-4"><input required type="date" id="orci_fechai" name="orci_fechai" class="form-control form-control-sm" value="<?php echo isset($_POST['orci_fechai'])   ? $_POST['orci_fechai']    : '' ?>"></div>
											<label for="orci_fechaf" class="col-sm-2 col-form-label ">Final:  </label><div class="col-sm-4"><input required type="date" id="orci_fechaf" name="orci_fechaf" class="form-control form-control-sm" value="<?php echo isset($_POST['orci_fechaf'])   ? $_POST['orci_fechaf']    : '' ?>" max="1994-12-31"></div>
										</div>
										<div class="row justify-content-start align-items-center mb-1 me-1">
											<label for="orci_cargo"      class="col-sm-2 col-form-label">Cargo:    </label>
											<div class="col-sm-8"><input type="text" id="orci_cargo"     name="orci_cargo"     class="form-control form-control-sm" placeholder="" value="<?php echo isset($_POST['orci_cargo'])   ? $_POST['orci_cargo']    : '' ?>"></div>
											<button type="submit" class="col-2 btn btn-light btn-sm">Cargar</button>
										</div>
						
										<input type="hidden"  name="host_emprdni"   value="<?php echo isset($_POST['host_emprdni'])   ? $_POST['host_emprdni']    : '' ?>">
										<input type="hidden"  name="host_empresa"   value="<?php echo isset($_POST['host_empresa'])   ? $_POST['host_empresa']    : '' ?>">
										<input type="hidden"  name="host_nombres"   value="<?php echo isset($_POST['host_nombres'])   ? $_POST['host_nombres']    : '' ?>">
										<input type="hidden"  name="host_apellidos" value="<?php echo isset($_POST['host_apellidos']) ? $_POST['host_apellidos']  : '' ?>">
										<input type="hidden"  name="host_dni"       value="<?php echo isset($_POST['host_dni'])       ? $_POST['host_dni']        : '' ?>">
										<input type="hidden"  name="host_fechai"    value="<?php echo isset($_POST['host_fechai'])    ? $_POST['host_fechai']     : '' ?>">
										<input type="hidden"  name="host_fechaf"    value="<?php echo isset($_POST['host_fechaf'])    ? $_POST['host_fechaf']     : '' ?>">
										<input type="hidden"  name="host_cargo"     value="<?php echo isset($_POST['host_cargo'])     ? $_POST['host_cargo']      : '' ?>">
										
										<input type="hidden"  name="refl_emprdni"   value="<?php echo isset($_POST['refl_emprdni'])   ? $_POST['refl_emprdni']    : '' ?>">
										<input type="hidden"  name="refl_empresa"   value="<?php echo isset($_POST['refl_empresa'])   ? $_POST['refl_empresa']    : '' ?>">
										<input type="hidden"  name="refl_nombres"   value="<?php echo isset($_POST['refl_nombres'])   ? $_POST['refl_nombres']    : '' ?>">
										<input type="hidden"  name="refl_apellidos" value="<?php echo isset($_POST['refl_apellidos']) ? $_POST['refl_apellidos']  : '' ?>">
										<input type="hidden"  name="refl_dni"       value="<?php echo isset($_POST['refl_dni'])       ? $_POST['refl_dni']        : '' ?>">
										<input type="hidden"  name="refl_fechai"    value="<?php echo isset($_POST['refl_fechai'])    ? $_POST['refl_fechai']     : '' ?>">
										<input type="hidden"  name="refl_fechaf"    value="<?php echo isset($_POST['refl_fechaf'])    ? $_POST['refl_fechaf']     : '' ?>">
										<input type="hidden"  name="refl_cargo"     value="<?php echo isset($_POST['refl_cargo'])     ? $_POST['refl_cargo']      : '' ?>">

										<input type="hidden" name="tab" value="orci">
										
									</form>
									<?php if ($anniorp['orci'] && $pageorci) { ?>
									<div class="row justify-content-end px-3">
										<div class="col-3">
											<form id="form_orci_cer" action="reportes/certificado<?php echo $rp['orci'] ?>.php" method="post" target="_blank" >
												<input type="hidden" name="empresa" value="<?php echo isset($_POST['orci_empresa']) ? $_POST['orci_empresa'] : '' ?>" />
												<input type="hidden" name="nombres" value="<?php echo isset($_POST['orci_nombres']) ? $_POST['orci_nombres'] : '' ?>" />
												<input type="hidden" name="apellidos" value="<?php echo isset($_POST['orci_apellidos']) ? $_POST['orci_apellidos'] : '' ?>" />
												<input type="hidden" name="dni" value="<?php echo isset($_POST['orci_dni']) ? $_POST['orci_dni'] : '' ?>" />
					
												<input type="hidden" name="f_a"           value="<?php echo $fechas['orci']['fa2'];      ?>">
												<input type="hidden" name="f_a_b"         value="<?php echo $fechas['orci']['fa1'];      ?>">
												<input type="hidden" name="f_b"           value="<?php echo $fechas['orci']['fb2'];      ?>">
												<input type="hidden" name="f_b_b"         value="<?php echo $fechas['orci']['fb1'];      ?>">
												<input type="hidden" name="fecha_emision" value="<?php echo $fechas['orci']['fb1'];      ?>">
												<input type="hidden" name="emision"       value="<?php echo $fechas['orci']['emision'];  ?>">
					
												<input type="hidden" name="cargo_ac" value="<?php echo isset($_POST['orci_cargo']) ? $_POST['orci_cargo'] : '' ?>" />
												<input type="hidden" name="cargo_al" value="<?php echo isset($_POST['orci_cargo']) ? $_POST['orci_cargo'] : '' ?>" />
												<input type="hidden" name="cargo_ab" value="<?php echo isset($_POST['orci_cargo']) ? $_POST['orci_cargo'] : '' ?>" />
												<button type="submit" class="btn btn-light btn-sm">Certificado</button>
											</form>
										</div>
										<div class="col-3">
											<form action="manual_bono.php" id="frmPersona" method="POST" >
												<input type="hidden" name="nombres"         value="<?php echo isset($_POST['orci_nombres'])     ? $_POST['orci_nombres']   : '' ?>">
												<input type="hidden" name="apellidos"       value="<?php echo isset($_POST['orci_apellidos'])   ? $_POST['orci_apellidos'] : '' ?>">
												<input type="hidden" name="dni"             value="<?php echo isset($_POST['orci_dni'])         ? $_POST['orci_dni']       : '' ?>">
												<input type="hidden" name="finicio"         value="<?php echo isset($_POST['orci_fechai'])      ? $_POST['orci_fechai']    : '' ?>">
												<input type="hidden" name="ffinal"          value="<?php echo isset($_POST['orci_fechaf'])      ? $_POST['orci_fechaf']    : '' ?>">
						
												<input type="hidden"  name="orci_emprdni"   value="<?php echo isset($_POST['orci_emprdni'])   ? $_POST['orci_emprdni']    : '' ?>">
												<input type="hidden"  name="orci_empresa"   value="<?php echo isset($_POST['orci_empresa'])   ? $_POST['orci_empresa']    : '' ?>">
												<input type="hidden"  name="orci_nombres"   value="<?php echo isset($_POST['orci_nombres'])   ? $_POST['orci_nombres']    : '' ?>">
												<input type="hidden"  name="orci_apellidos" value="<?php echo isset($_POST['orci_apellidos']) ? $_POST['orci_apellidos']  : '' ?>">
												<input type="hidden"  name="orci_dni"       value="<?php echo isset($_POST['orci_dni'])       ? $_POST['orci_dni']        : '' ?>">
												<input type="hidden"  name="orci_fechai"    value="<?php echo isset($_POST['orci_fechai'])    ? $_POST['orci_fechai']     : '' ?>">
												<input type="hidden"  name="orci_fechaf"    value="<?php echo isset($_POST['orci_fechaf'])    ? $_POST['orci_fechaf']     : '' ?>">
												<input type="hidden"  name="orci_cargo"     value="<?php echo isset($_POST['orci_cargo'])     ? $_POST['orci_cargo']      : '' ?>">
											
												<input type="hidden"  name="host_emprdni"   value="<?php echo isset($_POST['host_emprdni'])   ? $_POST['host_emprdni']    : '' ?>">
												<input type="hidden"  name="host_empresa"   value="<?php echo isset($_POST['host_empresa'])   ? $_POST['host_empresa']    : '' ?>">
												<input type="hidden"  name="host_nombres"   value="<?php echo isset($_POST['host_nombres'])   ? $_POST['host_nombres']    : '' ?>">
												<input type="hidden"  name="host_apellidos" value="<?php echo isset($_POST['host_apellidos']) ? $_POST['host_apellidos']  : '' ?>">
												<input type="hidden"  name="host_dni"       value="<?php echo isset($_POST['host_dni'])       ? $_POST['host_dni']        : '' ?>">
												<input type="hidden"  name="host_fechai"    value="<?php echo isset($_POST['host_fechai'])    ? $_POST['host_fechai']     : '' ?>">
												<input type="hidden"  name="host_fechaf"    value="<?php echo isset($_POST['host_fechaf'])    ? $_POST['host_fechaf']     : '' ?>">
												<input type="hidden"  name="host_cargo"     value="<?php echo isset($_POST['host_cargo'])     ? $_POST['host_cargo']      : '' ?>">
												
												<input type="hidden"  name="refl_emprdni"   value="<?php echo isset($_POST['refl_emprdni'])   ? $_POST['refl_emprdni']    : '' ?>">
												<input type="hidden"  name="refl_empresa"   value="<?php echo isset($_POST['refl_empresa'])   ? $_POST['refl_empresa']    : '' ?>">
												<input type="hidden"  name="refl_nombres"   value="<?php echo isset($_POST['refl_nombres'])   ? $_POST['refl_nombres']    : '' ?>">
												<input type="hidden"  name="refl_apellidos" value="<?php echo isset($_POST['refl_apellidos']) ? $_POST['refl_apellidos']  : '' ?>">
												<input type="hidden"  name="refl_dni"       value="<?php echo isset($_POST['refl_dni'])       ? $_POST['refl_dni']        : '' ?>">
												<input type="hidden"  name="refl_fechai"    value="<?php echo isset($_POST['refl_fechai'])    ? $_POST['refl_fechai']     : '' ?>">
												<input type="hidden"  name="refl_fechaf"    value="<?php echo isset($_POST['refl_fechaf'])    ? $_POST['refl_fechaf']     : '' ?>">
												<input type="hidden"  name="refl_cargo"     value="<?php echo isset($_POST['refl_cargo'])     ? $_POST['refl_cargo']      : '' ?>">

												<input type="hidden" name="tab" value="orci">


												<button type="submit" class="btn btn-light btn-sm">Empresa</button>
											</form>
										</div>
									</div>
									<!-- Liquidacion -->
									<div class="row border-white border-top pt-3 mt-2">
										<div class="col">
											<form id="form_orci_liq" action="reportes/liquidacion<?php echo $rp['orci'] ?>.php" method="post" target="_blank" >
												<input type="hidden" name="empresa" value="<?php echo isset($_POST['orci_empresa']) ? $_POST['orci_empresa'] : '' ?>" />
												<input type="hidden" name="nombres" value="<?php echo isset($_POST['orci_nombres']) ? $_POST['orci_nombres'] : '' ?>" />
												<input type="hidden" name="apellidos" value="<?php echo isset($_POST['orci_apellidos']) ? $_POST['orci_apellidos'] : '' ?>" />
												<input type="hidden" name="dni" value="<?php echo isset($_POST['orci_dni']) ? $_POST['orci_dni'] : '' ?>" />
					
												<input type="hidden" name="f_a"           value="<?php echo $fechas['orci']['fa2'];      ?>">
												<input type="hidden" name="f_a_b"         value="<?php echo $fechas['orci']['fa1'];      ?>">
												<input type="hidden" name="f_b"           value="<?php echo $fechas['orci']['fb2'];      ?>">
												<input type="hidden" name="f_b_b"         value="<?php echo $fechas['orci']['fb1'];      ?>">
												<input type="hidden" name="fecha_emision" value="<?php echo $fechas['orci']['fb1'];      ?>">
												<input type="hidden" name="emision"       value="<?php echo $fechas['orci']['emision'];  ?>">
												<input type="hidden" name="fsueldo"       value="<?php echo $fechas['orci']['fb3'];      ?>">
												
												<input type="hidden" name="cargo_ac" value="<?php echo isset($_POST['orci_cargo']) ? $_POST['orci_cargo'] : '' ?>" />
												<input type="hidden" name="cargo_al" value="<?php echo isset($_POST['orci_cargo']) ? $_POST['orci_cargo'] : '' ?>" />
												<input type="hidden" name="cargo_ab" value="<?php echo isset($_POST['orci_cargo']) ? $_POST['orci_cargo'] : '' ?>" />

												<div class="row mb-1 border-bottom border-info">
													<label for="sueldo" class="col-sm-7 col-form-label">Adelanto:</label>
													<div class="col-sm-5">
													<input onkeypress="return filterFloat(event,this);" type="text" id="adelanto" name="adelanto" class="form-control form-control-sm bg-danger bg-gradient bg-opacity-50 text-white" placeholder="Adelanto" value="<?php echo isset($_POST['adelanto']) ? $_POST['adelanto'] : '0' ?>">
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

												<div class="row justify-content-end ">
													<button type="submit" class="col-3 btn btn-light btn-sm">Liquidación</button>
												</div>
											</form>
										</div>
									</div>
									<!-- fin Liquidación -->
									<!-- BONO -->
									<?php if ( $anniorp['orci'] >= 1978 ) { ?>
									<div class="row border-white border-top pt-3 mt-2">
										<div class="col">
											<form id="form_orci_bol" action="reportes/boletadepago<?php echo $bo['orci'] ?>.php" method="post" target="_blank" >
												<input type="hidden" name="empresa" value="<?php echo isset($_POST['orci_empresa']) ? $_POST['orci_empresa'] : '' ?>" />
												<input type="hidden" name="nombres" value="<?php echo isset($_POST['orci_nombres']) ? $_POST['orci_nombres'] : '' ?>" />
												<input type="hidden" name="apellidos" value="<?php echo isset($_POST['orci_apellidos']) ? $_POST['orci_apellidos'] : '' ?>" />
												<input type="hidden" name="dni" value="<?php echo isset($_POST['orci_dni']) ? $_POST['orci_dni'] : '' ?>" />
					
												<input type="hidden" name="f_a"           value="<?php echo $fechas['orci']['fa2'];      ?>">
												<input type="hidden" name="f_a_b"         value="<?php echo $fechas['orci']['fa1'];      ?>">
												<input type="hidden" name="f_b"           value="<?php echo $fechas['orci']['fb2'];      ?>">
												<input type="hidden" name="f_b_b"         value="<?php echo $fechas['orci']['fb1'];      ?>">
												<input type="hidden" name="fecha_emision" value="<?php echo $fechas['orci']['fb1'];      ?>">
												<input type="hidden" name="emision"       value="<?php echo $fechas['orci']['emision'];  ?>">
												<input type="hidden" name="fsueldo"       value="<?php echo $fechas['orci']['fb3'];      ?>">
												
												<input type="hidden" name="cargo_ac" value="<?php echo isset($_POST['orci_cargo']) ? $_POST['orci_cargo'] : '' ?>" />
												<input type="hidden" name="cargo_al" value="<?php echo isset($_POST['orci_cargo']) ? $_POST['orci_cargo'] : '' ?>" />
												<input type="hidden" name="cargo_ab" value="<?php echo isset($_POST['orci_cargo']) ? $_POST['orci_cargo'] : '' ?>" />

												<div class="row">
													<div class="col-6">
														<div class="row mb-1">
															<label for="sueldo" class="col-5 col-form-label">Fecha:</label>
															<div class="col-7">
																<input required type="date" id="fechaboleta" name="fechaboleta" min="1978-08-22" class="form-control form-control-sm" value="<?php echo isset($_POST['fechaboleta']) ? $_POST['fechaboleta'] : '0' ?>">
															</div>
														</div>
														<div class="row mb-1">
															<label for="sueldo" class="col-5 col-form-label">R. VACACIONAL:</label>
															<div class="col-7">
																<input onkeypress="return filterFloat(event,this);" type="text" id="remvacacionales" name="remvacacionales" class="form-control form-control-sm" value="<?php echo isset($_POST['remvacacionales']) ? $_POST['remvacacionales'] : '0' ?>">
															</div>
														</div>
														<div class="row mb-1">
															<label for="sueldo" class="col-5 col-form-label">Reintegro:</label>
															<div class="col-7">
																<input onkeypress="return filterFloat(event,this);" type="text" id="reintegro" name="reintegro" class="form-control form-control-sm" value="<?php echo isset($_POST['reintegro']) ? $_POST['reintegro'] : '0' ?>">
															</div>
														</div>
													</div>
													<div class="col-6">
														<div class="row mb-1">
															<label for="sueldo" class="col-5 col-form-label">H. EXTRAS:</label>
															<div class="col-7">
																<input onkeypress="return filterFloat(event,this);" type="text" id="hextras" name="hextras" class="form-control form-control-sm" value="<?php echo isset($_POST['hextras']) ? $_POST['hextras'] : '0' ?>">
															</div>
														</div>
														<div class="row mb-1">
															<label for="sueldo" class="col-5 col-form-label">Bonificacion:</label>
															<div class="col-7">
																<input onkeypress="return filterFloat(event,this);" type="text" id="bonificacion" name="bonificacion" class="form-control form-control-sm" value="<?php echo isset($_POST['bonificacion']) ? $_POST['bonificacion'] : '0' ?>">
															</div>
														</div>
														<div class="row mb-1">
															<label for="sueldo" class="col-5 col-form-label">OTROS:</label>
															<div class="col-7">
																<input onkeypress="return filterFloat(event,this);" type="text" id="otros_deven" name="otros_deven" class="form-control form-control-sm" value="<?php echo isset($_POST['otros_deven']) ? $_POST['otros_deven'] : '0' ?>">
															</div>
														</div>
													</div>
												</div>
												
												<div class="row justify-content-end ">
													<button type="submit" class="col-3 btn btn-light btn-sm me-3">Boleta</button>
												</div>
											</form>
										</div>
									</div>
									<?php } ?>
									<!-- fin BONO -->

									<!-- inicio Declaracion Jurada -->
									<div class="row border-white border-top pt-3 mt-2">
										<div class="col">
											<?php $dec = rand(1, 3); ?>
											<form id="form_orci_bol" action="reportes/declaracionempleador0<?php echo $dec ?>.php" method="post" target="_blank" >
												<input type="hidden" name="empresa" value="<?php echo isset($_POST['orci_empresa']) ? $_POST['orci_empresa'] : '' ?>" />
												<input type="hidden" name="nombres" value="<?php echo isset($_POST['orci_nombres']) ? $_POST['orci_nombres'] : '' ?>" />
												<input type="hidden" name="apellidos" value="<?php echo isset($_POST['orci_apellidos']) ? $_POST['orci_apellidos'] : '' ?>" />
												<input type="hidden" name="dni" value="<?php echo isset($_POST['orci_dni']) ? $_POST['orci_dni'] : '' ?>" />
					
												<input type="hidden" name="f_a"           value="<?php echo $fechas['orci']['fa2'];      ?>">
												<input type="hidden" name="f_a_b"         value="<?php echo $fechas['orci']['fa1'];      ?>">
												<input type="hidden" name="f_b"           value="<?php echo $fechas['orci']['fb2'];      ?>">
												<input type="hidden" name="f_b_b"         value="<?php echo $fechas['orci']['fb1'];      ?>">
												<input type="hidden" name="fecha_emision" value="<?php echo $fechas['orci']['fb1'];      ?>">
												<input type="hidden" name="emision"       value="<?php echo $fechas['orci']['emision'];  ?>">
												<input type="hidden" name="fsueldo"       value="<?php echo $fechas['orci']['fb3'];      ?>">
												
												<input type="hidden" name="rep_legal" value="<?php echo $empresa['orci']['id']; ?>">
												<input type="hidden" name="rep_legal" value="<?php echo $empresa['orci']['rep_legal']; ?>">
												<input type="hidden" name="dni_a"     value="<?php echo $empresa['orci']['dni_a']; ?>">
												<input type="hidden" name="ruc"       value="<?php echo $empresa['orci']['ruc']; ?>">
												
												<input type="hidden" name="cargo_abo" value="<?php echo isset($_POST['orci_cargo']) ? $_POST['orci_cargo'] : '' ?>" />
												<input type="hidden" name="cargo_bbo" value="<?php echo isset($_POST['orci_cargo']) ? $_POST['orci_cargo'] : '' ?>" />

												<div class="row mb-3">
												<label for="numautog" class="col-7 col-form-label text-end">Número Autogenerado:</label>
												<div class="col-5">
													<input type="text" id="numautog" name="numautog" class="form-control form-control-sm" placeholder="Núm. Autogenerado" value="<?php echo isset($_POST['numautog']) ? $_POST['numautog']  : '' ?>" >
												</div>
												</div>

												<div class="row">
													<div class="col-6">
														<div class="row mb-1">
															<label for="sueldo" class="col-sm-7 col-form-label text-end">Diciembre '91:</label>
															<div class="col-sm-5">
																<input onkeypress="return filterFloat(event,this);" type="text" id="orci_mes12" name="mes12" class="form-control form-control-sm" value="" class="text-end" onchange="return calcularBono('orci', 'orci')">
															</div>
														</div>
														<div class="row mb-1">
															<label for="sueldo" class="col-sm-7 col-form-label text-end">Enero '92:</label>
															<div class="col-sm-5">
																<input onkeypress="return filterFloat(event,this);" type="text" id="orci_mes01" name="mes01" class="form-control form-control-sm" value="" class="text-end" onchange="return calcularBono('orci', 'orci')">
															</div>
														</div>
														<div class="row mb-1">
															<label for="sueldo" class="col-sm-7 col-form-label text-end">Febrero '92:</label>
															<div class="col-sm-5">
																<input onkeypress="return filterFloat(event,this);" type="text" id="orci_mes02" name="mes02" class="form-control form-control-sm" value="" class="text-end" onchange="return calcularBono('orci', 'orci')">
															</div>
														</div>
														<div class="row mb-1">
															<label for="sueldo" class="col-sm-7 col-form-label text-end">Marzo '92:</label>
															<div class="col-sm-5">
																<input onkeypress="return filterFloat(event,this);" type="text" id="orci_mes03" name="mes03" class="form-control form-control-sm" value="" class="text-end" onchange="return calcularBono('orci', 'orci')">
															</div>
														</div>
														<div class="row mb-1">
															<label for="sueldo" class="col-sm-7 col-form-label text-end">Abril '92:</label>
															<div class="col-sm-5">
																<input onkeypress="return filterFloat(event,this);" type="text" id="orci_mes04" name="mes04" class="form-control form-control-sm" value="" class="text-end" onchange="return calcularBono('orci', 'orci')">
															</div>
														</div>
														<div class="row mb-1">
															<label for="sueldo" class="col-sm-7 col-form-label text-end">Mayo '92:</label>
															<div class="col-sm-5">
																<input onkeypress="return filterFloat(event,this);" type="text" id="orci_mes05" name="mes05" class="form-control form-control-sm" value="" class="text-end" onchange="return calcularBono('orci', 'orci')">
															</div>
														</div>
													</div>
													<div class="col-6">
														<div class="row mb-1">
															<label for="sueldo" class="col-sm-7 col-form-label text-end">Junio '92:</label>
															<div class="col-sm-5">
																<input onkeypress="return filterFloat(event,this);" type="text" id="orci_mes06" name="mes06" class="form-control form-control-sm" value="" class="text-end" onchange="return calcularBono('orci', 'orci')">
															</div>
														</div>
														<div class="row mb-1">
															<label for="sueldo" class="col-sm-7 col-form-label text-end">Julio '92:</label>
															<div class="col-sm-5">
																<input onkeypress="return filterFloat(event,this);" type="text" id="orci_mes07" name="mes07" class="form-control form-control-sm" value="" class="text-end" onchange="return calcularBono('orci', 'orci')">
															</div>
														</div>
														<div class="row mb-1">
															<label for="sueldo" class="col-sm-7 col-form-label text-end">Agosto '92:</label>
															<div class="col-sm-5">
																<input onkeypress="return filterFloat(event,this);" type="text" id="orci_mes08" name="mes08" class="form-control form-control-sm" value="" class="text-end" onchange="return calcularBono('orci', 'orci')">
															</div>
														</div>
														<div class="row mb-1">
															<label for="sueldo" class="col-sm-7 col-form-label text-end">Septiembre '92:</label>
															<div class="col-sm-5">
																<input onkeypress="return filterFloat(event,this);" type="text" id="orci_mes09" name="mes09" class="form-control form-control-sm" value="" class="text-end" onchange="return calcularBono('orci', 'orci')">
															</div>
														</div>
														<div class="row mb-1">
															<label for="sueldo" class="col-sm-7 col-form-label text-end">Octubre '92:</label>
															<div class="col-sm-5">
																<input onkeypress="return filterFloat(event,this);" type="text" id="orci_mes10" name="mes10" class="form-control form-control-sm" value="" class="text-end" onchange="return calcularBono('orci', 'orci')">
															</div>
														</div>
														<div class="row mb-1">
															<label for="sueldo" class="col-sm-7 col-form-label text-end">Noviembre '92:</label>
															<div class="col-sm-5">
																<input onkeypress="return filterFloat(event,this);" type="text" id="orci_mes11" name="mes11" class="form-control form-control-sm" value="" class="text-end" onchange="return calcularBono('orci', 'orci')">
															</div>
														</div>
													</div>
												</div>

												<div class="row border-top border-bottom border-warning py-1 mb-1">
												<div class="col text-end">
													Cálculo de Bono: <input id="orci_totalbono" value="" />
												</div>
												</div>

												<?php
												$sueldo = obtener_sueldo($fechas['orci']['fb3'])['sueldo_minimo'];
												$difea  = date_diff(date_create($fechas['orci']['fb3']), date_create($fechas['orci']['fa3']));
												$mesest  = ($difea->y * 12 )+$difea->m;
												?>
												<input type="hidden" id="orci_sueldo" name="sueldo" value="<?php echo nf($sueldo,0); ?>"/>
												<input type="hidden" id="orci_mesest" name="mesest" value="<?php echo $mesest; ?>"/>
												
												<div class="row justify-content-end ">
													<button type="submit" class="col-3 btn btn-light btn-sm me-3">Declaración</button>
												</div>
											</form>
										</div>
									</div>
									<!-- fin Declaracion Jurada -->
									<?php } ?>
								</div>
								<!-- fin ORCINEA -->
								<!-- HOST -->
								<div id="host" 	 class="tab-pane fade <?php echo $tab === 'host' ? ' show active' : '' ?>">
									<!-- <div class="col border border-light rounded mx-3"> -->
									<form id="form_host" action="manual_bono.php" method="post">
										<div class="text-center fs-4 fw-semibold text-white">HOST</div>
										<div class="row align-items-center mb-1"><label for="host_emprdni"    class="col-sm-2 col-form-label">R.U.C.:   </label><div class="col-sm-7"> <input type="text" id="host_emprdni"   name="host_emprdni"   class="form-control form-control-sm" placeholder="" value="<?php echo isset($_POST['host_emprdni'])   ? $_POST['host_emprdni']    : '' ?>"></div><div class="col-sm-3"><button class="btn btn-primary btn-sm" type="button" onclick="obtenerEmpresa('host')">Buscar</button></div></div>
										<div class="row align-items-center mb-1"><label for="host_empresa"    class="col-sm-2 col-form-label">Empresa:  </label><div class="col-sm-10"><input type="text" id="host_empresa"   name="host_empresa"   class="form-control form-control-sm" placeholder="" value="<?php echo isset($_POST['host_empresa'])   ? $_POST['host_empresa']    : '' ?>"></div></div>
										<div class="row align-items-center mb-1"><label for="host_nombres"    class="col-sm-2 col-form-label">Nombres:  </label><div class="col-sm-10"><input type="text" id="host_nombres"   name="host_nombres"   class="form-control form-control-sm" placeholder="" value="<?php echo isset($_POST['host_nombres'])   ? $_POST['host_nombres']    : '' ?>"></div></div>
										<div class="row align-items-center mb-1"><label for="host_apellidos"  class="col-sm-2 col-form-label">Apellidos:</label><div class="col-sm-10"><input type="text" id="host_apellidos" name="host_apellidos" class="form-control form-control-sm" placeholder="" value="<?php echo isset($_POST['host_apellidos']) ? $_POST['host_apellidos']  : '' ?>"></div></div>
										<div class="row align-items-center mb-1"><label for="host_dni"        class="col-sm-2 col-form-label">D.N.I.:   </label><div class="col-sm-10"><input type="text" id="host_dni"       name="host_dni"       class="form-control form-control-sm" placeholder="" value="<?php echo isset($_POST['host_dni'])       ? $_POST['host_dni']        : '' ?>"></div></div>
										<div class="row align-items-center mb-1">
											<label for="host_fechai" class="col-sm-2 col-form-label">Inicio: </label><div class="col-sm-4"><input required type="date" id="host_fechai" name="host_fechai" class="form-control form-control-sm" placeholder="" value="<?php echo isset($_POST['host_fechai'])   ? $_POST['host_fechai']    : '' ?>"></div>
											<label for="host_fechaf" class="col-sm-2 col-form-label">Final:  </label><div class="col-sm-4"><input required type="date" id="host_fechaf" name="host_fechaf" class="form-control form-control-sm" placeholder="" value="<?php echo isset($_POST['host_fechaf'])   ? $_POST['host_fechaf']    : '' ?>" max="1994-12-31"></div>
										</div>
										<div class="row justify-content-start align-items-center mb-1 me-1">
											<label for="host_cargo"      class="col-sm-2 col-form-label">Cargo:    </label>
											<div class="col-sm-8"><input type="text" id="host_cargo"     name="host_cargo"     class="form-control form-control-sm" placeholder="" value="<?php echo isset($_POST['host_cargo'])   ? $_POST['host_cargo']    : '' ?>"></div>
											<button type="submit" class="col-2 btn btn-light btn-sm">Cargar</button>
										</div>
						
										<input type="hidden"  name="orci_emprdni"   value="<?php echo isset($_POST['orci_emprdni'])   ? $_POST['orci_emprdni']    : '' ?>">
										<input type="hidden"  name="orci_empresa"   value="<?php echo isset($_POST['orci_empresa'])   ? $_POST['orci_empresa']    : '' ?>">
										<input type="hidden"  name="orci_nombres"   value="<?php echo isset($_POST['orci_nombres'])   ? $_POST['orci_nombres']    : '' ?>">
										<input type="hidden"  name="orci_apellidos" value="<?php echo isset($_POST['orci_apellidos']) ? $_POST['orci_apellidos']  : '' ?>">
										<input type="hidden"  name="orci_dni"       value="<?php echo isset($_POST['orci_dni'])       ? $_POST['orci_dni']        : '' ?>">
										<input type="hidden"  name="orci_fechai"    value="<?php echo isset($_POST['orci_fechai'])    ? $_POST['orci_fechai']     : '' ?>">
										<input type="hidden"  name="orci_fechaf"    value="<?php echo isset($_POST['orci_fechaf'])    ? $_POST['orci_fechaf']     : '' ?>">
										<input type="hidden"  name="orci_cargo"     value="<?php echo isset($_POST['orci_cargo'])     ? $_POST['orci_cargo']      : '' ?>">
										
										<input type="hidden"  name="refl_emprdni"   value="<?php echo isset($_POST['refl_emprdni'])   ? $_POST['refl_emprdni']    : '' ?>">
										<input type="hidden"  name="refl_empresa"   value="<?php echo isset($_POST['refl_empresa'])   ? $_POST['refl_empresa']    : '' ?>">
										<input type="hidden"  name="refl_nombres"   value="<?php echo isset($_POST['refl_nombres'])   ? $_POST['refl_nombres']    : '' ?>">
										<input type="hidden"  name="refl_apellidos" value="<?php echo isset($_POST['refl_apellidos']) ? $_POST['refl_apellidos']  : '' ?>">
										<input type="hidden"  name="refl_dni"       value="<?php echo isset($_POST['refl_dni'])       ? $_POST['refl_dni']        : '' ?>">
										<input type="hidden"  name="refl_fechai"    value="<?php echo isset($_POST['refl_fechai'])    ? $_POST['refl_fechai']     : '' ?>">
										<input type="hidden"  name="refl_fechaf"    value="<?php echo isset($_POST['refl_fechaf'])    ? $_POST['refl_fechaf']     : '' ?>">
										<input type="hidden"  name="refl_cargo"     value="<?php echo isset($_POST['refl_cargo'])     ? $_POST['refl_cargo']      : '' ?>">

										<input type="hidden" name="tab" value="host">

									</form>
									<?php if ($anniorp['host'] && $pagehost) { ?>
									<div class="row justify-content-end px-3">
										<div class="col-3">
											<form id="form_host_cer" action="reportes/certificado<?php echo $rp['host'] ?>.php" method="post" target="_blank" >
												<input type="hidden" name="empresa" value="<?php echo isset($_POST['host_empresa']) ? $_POST['host_empresa'] : '' ?>" />
												<input type="hidden" name="nombres" value="<?php echo isset($_POST['host_nombres']) ? $_POST['host_nombres'] : '' ?>" />
												<input type="hidden" name="apellidos" value="<?php echo isset($_POST['host_apellidos']) ? $_POST['host_apellidos'] : '' ?>" />
												<input type="hidden" name="dni" value="<?php echo isset($_POST['host_dni']) ? $_POST['host_dni'] : '' ?>" />

												<input type="hidden" name="f_a"           value="<?php echo $fechas['host']['fa2'];      ?>">
												<input type="hidden" name="f_a_b"         value="<?php echo $fechas['host']['fa1'];      ?>">
												<input type="hidden" name="f_b"           value="<?php echo $fechas['host']['fb2'];      ?>">
												<input type="hidden" name="f_b_b"         value="<?php echo $fechas['host']['fb1'];      ?>">
												<input type="hidden" name="fecha_emision" value="<?php echo $fechas['host']['fb1'];      ?>">
												<input type="hidden" name="emision"       value="<?php echo $fechas['host']['emision'];  ?>">

												<input type="hidden" name="cargo_ac" value="<?php echo isset($_POST['host_cargo']) ? $_POST['host_cargo'] : '' ?>" />
												<input type="hidden" name="cargo_al" value="<?php echo isset($_POST['host_cargo']) ? $_POST['host_cargo'] : '' ?>" />
												<input type="hidden" name="cargo_ab" value="<?php echo isset($_POST['host_cargo']) ? $_POST['host_cargo'] : '' ?>" />
												<button type="submit" class="btn btn-light btn-sm">Certificado</button>
											</form>
										</div>
										<div class="col-3">
											<form id="form_host_liq" action="reportes/liquidacion<?php echo $rp['host'] ?>.php" method="post" target="_blank" >
												<input type="hidden" name="empresa" value="<?php echo isset($_POST['host_empresa']) ? $_POST['host_empresa'] : '' ?>" />
												<input type="hidden" name="nombres" value="<?php echo isset($_POST['host_nombres']) ? $_POST['host_nombres'] : '' ?>" />
												<input type="hidden" name="apellidos" value="<?php echo isset($_POST['host_apellidos']) ? $_POST['host_apellidos'] : '' ?>" />
												<input type="hidden" name="dni" value="<?php echo isset($_POST['host_dni']) ? $_POST['host_dni'] : '' ?>" />

												<input type="hidden" name="f_a"           value="<?php echo $fechas['host']['fa2'];      ?>">
												<input type="hidden" name="f_a_b"         value="<?php echo $fechas['host']['fa1'];      ?>">
												<input type="hidden" name="f_b"           value="<?php echo $fechas['host']['fb2'];      ?>">
												<input type="hidden" name="f_b_b"         value="<?php echo $fechas['host']['fb1'];      ?>">
												<input type="hidden" name="fecha_emision" value="<?php echo $fechas['host']['fb1'];      ?>">
												<input type="hidden" name="emision"       value="<?php echo $fechas['host']['emision'];  ?>">
												<input type="hidden" name="fsueldo"       value="<?php echo $fechas['host']['fb3'];      ?>">
												
												<input type="hidden" name="cargo_ac" value="<?php echo isset($_POST['host_cargo']) ? $_POST['host_cargo'] : '' ?>" />
												<input type="hidden" name="cargo_al" value="<?php echo isset($_POST['host_cargo']) ? $_POST['host_cargo'] : '' ?>" />
												<input type="hidden" name="cargo_ab" value="<?php echo isset($_POST['host_cargo']) ? $_POST['host_cargo'] : '' ?>" />
												<button type="submit" class="btn btn-light btn-sm">Liquidación</button>
											</form>
										</div>
										<div class="col-3">
											<form action="manual_bono.php" id="frmPersona" method="POST" >
												<input type="hidden" name="nombres"    value="<?php echo isset($_POST['host_nombres'])     ? $_POST['host_nombres']   : '' ?>">
												<input type="hidden" name="apellidos"  value="<?php echo isset($_POST['host_apellidos'])   ? $_POST['host_apellidos'] : '' ?>">
												<input type="hidden" name="dni"        value="<?php echo isset($_POST['host_dni'])         ? $_POST['host_dni']       : '' ?>">
												<input type="hidden" name="finicio"    value="<?php echo isset($_POST['host_fechai'])      ? $_POST['host_fechai']    : '' ?>">
												<input type="hidden" name="ffinal"     value="<?php echo isset($_POST['host_fechaf'])      ? $_POST['host_fechaf']    : '' ?>">
						
												<input type="hidden"  name="orci_emprdni"   value="<?php echo isset($_POST['orci_emprdni'])   ? $_POST['orci_emprdni']    : '' ?>">
												<input type="hidden"  name="orci_empresa"   value="<?php echo isset($_POST['orci_empresa'])   ? $_POST['orci_empresa']    : '' ?>">
												<input type="hidden"  name="orci_nombres"   value="<?php echo isset($_POST['orci_nombres'])   ? $_POST['orci_nombres']    : '' ?>">
												<input type="hidden"  name="orci_apellidos" value="<?php echo isset($_POST['orci_apellidos']) ? $_POST['orci_apellidos']  : '' ?>">
												<input type="hidden"  name="orci_dni"       value="<?php echo isset($_POST['orci_dni'])       ? $_POST['orci_dni']        : '' ?>">
												<input type="hidden"  name="orci_fechai"    value="<?php echo isset($_POST['orci_fechai'])    ? $_POST['orci_fechai']     : '' ?>">
												<input type="hidden"  name="orci_fechaf"    value="<?php echo isset($_POST['orci_fechaf'])    ? $_POST['orci_fechaf']     : '' ?>">
												<input type="hidden"  name="orci_cargo"     value="<?php echo isset($_POST['orci_cargo'])     ? $_POST['orci_cargo']      : '' ?>">
											
												<input type="hidden"  name="host_emprdni"   value="<?php echo isset($_POST['host_emprdni'])   ? $_POST['host_emprdni']    : '' ?>">
												<input type="hidden"  name="host_empresa"   value="<?php echo isset($_POST['host_empresa'])   ? $_POST['host_empresa']    : '' ?>">
												<input type="hidden"  name="host_nombres"   value="<?php echo isset($_POST['host_nombres'])   ? $_POST['host_nombres']    : '' ?>">
												<input type="hidden"  name="host_apellidos" value="<?php echo isset($_POST['host_apellidos']) ? $_POST['host_apellidos']  : '' ?>">
												<input type="hidden"  name="host_dni"       value="<?php echo isset($_POST['host_dni'])       ? $_POST['host_dni']        : '' ?>">
												<input type="hidden"  name="host_fechai"    value="<?php echo isset($_POST['host_fechai'])    ? $_POST['host_fechai']     : '' ?>">
												<input type="hidden"  name="host_fechaf"    value="<?php echo isset($_POST['host_fechaf'])    ? $_POST['host_fechaf']     : '' ?>">
												<input type="hidden"  name="host_cargo"     value="<?php echo isset($_POST['host_cargo'])     ? $_POST['host_cargo']      : '' ?>">
												
												<input type="hidden"  name="refl_emprdni"   value="<?php echo isset($_POST['refl_emprdni'])   ? $_POST['refl_emprdni']    : '' ?>">
												<input type="hidden"  name="refl_empresa"   value="<?php echo isset($_POST['refl_empresa'])   ? $_POST['refl_empresa']    : '' ?>">
												<input type="hidden"  name="refl_nombres"   value="<?php echo isset($_POST['refl_nombres'])   ? $_POST['refl_nombres']    : '' ?>">
												<input type="hidden"  name="refl_apellidos" value="<?php echo isset($_POST['refl_apellidos']) ? $_POST['refl_apellidos']  : '' ?>">
												<input type="hidden"  name="refl_dni"       value="<?php echo isset($_POST['refl_dni'])       ? $_POST['refl_dni']        : '' ?>">
												<input type="hidden"  name="refl_fechai"    value="<?php echo isset($_POST['refl_fechai'])    ? $_POST['refl_fechai']     : '' ?>">
												<input type="hidden"  name="refl_fechaf"    value="<?php echo isset($_POST['refl_fechaf'])    ? $_POST['refl_fechaf']     : '' ?>">
												<input type="hidden"  name="refl_cargo"     value="<?php echo isset($_POST['refl_cargo'])     ? $_POST['refl_cargo']      : '' ?>">

												<input type="hidden" name="tab" value="host">

												<button type="submit" class="btn btn-light btn-sm">Empresa</button>
											</form>
										</div>
									</div>
									<!-- inicio BONO -->
									<?php if ( $anniorp['host'] >= 1978 ) { ?>
									<div class="row border-white border-top pt-3 mt-2">
										<div class="col">
										<form id="form_host_bol" action="reportes/boletadepago<?php echo $bo['host'] ?>.php" method="post" target="_blank" >
											<input type="hidden" name="empresa" value="<?php echo isset($_POST['host_empresa']) ? $_POST['host_empresa'] : '' ?>" />
											<input type="hidden" name="nombres" value="<?php echo isset($_POST['host_nombres']) ? $_POST['host_nombres'] : '' ?>" />
											<input type="hidden" name="apellidos" value="<?php echo isset($_POST['host_apellidos']) ? $_POST['host_apellidos'] : '' ?>" />
											<input type="hidden" name="dni" value="<?php echo isset($_POST['host_dni']) ? $_POST['host_dni'] : '' ?>" />
				
											<input type="hidden" name="f_a"           value="<?php echo $fechas['host']['fa2'];      ?>">
											<input type="hidden" name="f_a_b"         value="<?php echo $fechas['host']['fa1'];      ?>">
											<input type="hidden" name="f_b"           value="<?php echo $fechas['host']['fb2'];      ?>">
											<input type="hidden" name="f_b_b"         value="<?php echo $fechas['host']['fb1'];      ?>">
											<input type="hidden" name="fecha_emision" value="<?php echo $fechas['host']['fb1'];      ?>">
											<input type="hidden" name="emision"       value="<?php echo $fechas['host']['emision'];  ?>">
											<input type="hidden" name="fsueldo"       value="<?php echo $fechas['host']['fb3'];      ?>">
											
											<input type="hidden" name="cargo_ac" value="<?php echo isset($_POST['host_cargo']) ? $_POST['host_cargo'] : '' ?>" />
											<input type="hidden" name="cargo_al" value="<?php echo isset($_POST['host_cargo']) ? $_POST['host_cargo'] : '' ?>" />
											<input type="hidden" name="cargo_ab" value="<?php echo isset($_POST['host_cargo']) ? $_POST['host_cargo'] : '' ?>" />

											<div class="row">
												<div class="col-6">
													<div class="row mb-1">
														<label for="sueldo" class="col-5 col-form-label">Fecha:</label>
														<div class="col-7">
															<input required type="date" id="fechaboleta" name="fechaboleta" min="1978-08-22" class="form-control form-control-sm" value="<?php echo isset($_POST['fechaboleta']) ? $_POST['fechaboleta'] : '0' ?>">
														</div>
													</div>
													<div class="row mb-1">
														<label for="sueldo" class="col-5 col-form-label">R. VACACIONAL:</label>
														<div class="col-7">
															<input onkeypress="return filterFloat(event,this);" type="text" id="remvacacionales" name="remvacacionales" class="form-control form-control-sm" value="<?php echo isset($_POST['remvacacionales']) ? $_POST['remvacacionales'] : '0' ?>">
														</div>
													</div>
													<div class="row mb-1">
														<label for="sueldo" class="col-5 col-form-label">Reintegro:</label>
														<div class="col-7">
															<input onkeypress="return filterFloat(event,this);" type="text" id="reintegro" name="reintegro" class="form-control form-control-sm" value="<?php echo isset($_POST['reintegro']) ? $_POST['reintegro'] : '0' ?>">
														</div>
													</div>
												</div>
												<div class="col-6">
													<div class="row mb-1">
														<label for="sueldo" class="col-5 col-form-label">H. EXTRAS:</label>
														<div class="col-7">
															<input onkeypress="return filterFloat(event,this);" type="text" id="hextras" name="hextras" class="form-control form-control-sm" value="<?php echo isset($_POST['hextras']) ? $_POST['hextras'] : '0' ?>">
														</div>
													</div>
													<div class="row mb-1">
														<label for="sueldo" class="col-5 col-form-label">Bonificacion:</label>
														<div class="col-7">
															<input onkeypress="return filterFloat(event,this);" type="text" id="bonificacion" name="bonificacion" class="form-control form-control-sm" value="<?php echo isset($_POST['bonificacion']) ? $_POST['bonificacion'] : '0' ?>">
														</div>
													</div>
													<div class="row mb-1">
														<label for="sueldo" class="col-5 col-form-label">OTROS:</label>
														<div class="col-7">
															<input onkeypress="return filterFloat(event,this);" type="text" id="otros_deven" name="otros_deven" class="form-control form-control-sm" value="<?php echo isset($_POST['otros_deven']) ? $_POST['otros_deven'] : '0' ?>">
														</div>
													</div>
												</div>
											</div>
											
											<div class="row justify-content-end ">
												<button type="submit" class="col-3 btn btn-light btn-sm me-3">Boleta</button>
											</div>
										</form>
										</div>
									</div>
									<?php } ?>
									<!-- fin BONO -->

									<!-- inicio Declaracion Jurada -->
									<div class="row border-white border-top pt-3 mt-2">
										<div class="col">
										<?php $dec = rand(1, 3); ?>
										<form id="form_orci_bol" action="reportes/declaracionempleador0<?php echo $dec ?>.php" method="post" target="_blank" >
											<input type="hidden" name="empresa"   value="<?php echo isset($_POST['host_empresa'])   ? $_POST['host_empresa'] : '' ?>" />
											<input type="hidden" name="nombres"   value="<?php echo isset($_POST['host_nombres'])   ? $_POST['host_nombres'] : '' ?>" />
											<input type="hidden" name="apellidos" value="<?php echo isset($_POST['host_apellidos']) ? $_POST['host_apellidos'] : '' ?>" />
											<input type="hidden" name="dni"       value="<?php echo isset($_POST['host_dni'])       ? $_POST['host_dni'] : '' ?>" />
				
											<input type="hidden" name="f_a"           value="<?php echo $fechas['host']['fa2'];      ?>">
											<input type="hidden" name="f_a_b"         value="<?php echo $fechas['host']['fa1'];      ?>">
											<input type="hidden" name="f_b"           value="<?php echo $fechas['host']['fb2'];      ?>">
											<input type="hidden" name="f_b_b"         value="<?php echo $fechas['host']['fb1'];      ?>">
											<input type="hidden" name="fecha_emision" value="<?php echo $fechas['host']['fb1'];      ?>">
											<input type="hidden" name="emision"       value="<?php echo $fechas['host']['emision'];  ?>">
											<input type="hidden" name="fsueldo"       value="<?php echo $fechas['host']['fb3'];      ?>">

											<input type="hidden" name="rep_legal" value="<?php echo $empresa['host']['id']; ?>">
											<input type="hidden" name="rep_legal" value="<?php echo $empresa['host']['rep_legal']; ?>">
											<input type="hidden" name="dni_a"     value="<?php echo $empresa['host']['dni_a']; ?>">
											<input type="hidden" name="ruc"       value="<?php echo $empresa['host']['ruc']; ?>">
											
											<input type="hidden" name="cargo_abo" value="<?php echo isset($_POST['host_cargo']) ? $_POST['host_cargo'] : '' ?>" />
											<input type="hidden" name="cargo_bbo" value="<?php echo isset($_POST['host_cargo']) ? $_POST['host_cargo'] : '' ?>" />

											<div class="row mb-3">
												<label for="numautog" class="col-7 col-form-label text-end">Número Autogenerado:</label>
												<div class="col-5">
													<input type="text" id="numautog" name="numautog" class="form-control form-control-sm" placeholder="Núm. Autogenerado" value="<?php echo isset($_POST['numautog']) ? $_POST['numautog']  : '' ?>" >
												</div>
											</div>

											<div class="row">
												<div class="col-6">
													<div class="row mb-1">
														<label for="sueldo" class="col-sm-7 col-form-label text-end">Diciembre '91:</label>
														<div class="col-sm-5">
															<input onkeypress="return filterFloat(event,this);" type="text" id="host_mes12" name="mes12" class="form-control form-control-sm" value="" class="text-end" onchange="return calcularBono('host', 'host')">
														</div>
													</div>
													<div class="row mb-1">
														<label for="sueldo" class="col-sm-7 col-form-label text-end">Enero '92:</label>
														<div class="col-sm-5">
															<input onkeypress="return filterFloat(event,this);" type="text" id="host_mes01" name="mes01" class="form-control form-control-sm" value="" class="text-end" onchange="return calcularBono('host', 'host')">
														</div>
													</div>
													<div class="row mb-1">
														<label for="sueldo" class="col-sm-7 col-form-label text-end">Febrero '92:</label>
														<div class="col-sm-5">
															<input onkeypress="return filterFloat(event,this);" type="text" id="host_mes02" name="mes02" class="form-control form-control-sm" value="" class="text-end" onchange="return calcularBono('host', 'host')">
														</div>
													</div>
													<div class="row mb-1">
														<label for="sueldo" class="col-sm-7 col-form-label text-end">Marzo '92:</label>
														<div class="col-sm-5">
															<input onkeypress="return filterFloat(event,this);" type="text" id="host_mes03" name="mes03" class="form-control form-control-sm" value="" class="text-end" onchange="return calcularBono('host', 'host')">
														</div>
													</div>
													<div class="row mb-1">
														<label for="sueldo" class="col-sm-7 col-form-label text-end">Abril '92:</label>
														<div class="col-sm-5">
															<input onkeypress="return filterFloat(event,this);" type="text" id="host_mes04" name="mes04" class="form-control form-control-sm" value="" class="text-end" onchange="return calcularBono('host', 'host')">
														</div>
													</div>
													<div class="row mb-1">
														<label for="sueldo" class="col-sm-7 col-form-label text-end">Mayo '92:</label>
														<div class="col-sm-5">
															<input onkeypress="return filterFloat(event,this);" type="text" id="host_mes05" name="mes05" class="form-control form-control-sm" value="" class="text-end" onchange="return calcularBono('host', 'host')">
														</div>
													</div>
												</div>
												<div class="col-6">
													<div class="row mb-1">
														<label for="sueldo" class="col-sm-7 col-form-label text-end">Junio '92:</label>
														<div class="col-sm-5">
															<input onkeypress="return filterFloat(event,this);" type="text" id="host_mes06" name="mes06" class="form-control form-control-sm" value="" class="text-end" onchange="return calcularBono('host', 'host')">
														</div>
													</div>
													<div class="row mb-1">
														<label for="sueldo" class="col-sm-7 col-form-label text-end">Julio '92:</label>
														<div class="col-sm-5">
															<input onkeypress="return filterFloat(event,this);" type="text" id="host_mes07" name="mes07" class="form-control form-control-sm" value="" class="text-end" onchange="return calcularBono('host', 'host')">
														</div>
													</div>
													<div class="row mb-1">
														<label for="sueldo" class="col-sm-7 col-form-label text-end">Agosto '92:</label>
														<div class="col-sm-5">
															<input onkeypress="return filterFloat(event,this);" type="text" id="host_mes08" name="mes08" class="form-control form-control-sm" value="" class="text-end" onchange="return calcularBono('host', 'host')">
														</div>
													</div>
													<div class="row mb-1">
														<label for="sueldo" class="col-sm-7 col-form-label text-end">Septiembre '92:</label>
														<div class="col-sm-5">
															<input onkeypress="return filterFloat(event,this);" type="text" id="host_mes09" name="mes09" class="form-control form-control-sm" value="" class="text-end" onchange="return calcularBono('host', 'host')">
														</div>
													</div>
													<div class="row mb-1">
														<label for="sueldo" class="col-sm-7 col-form-label text-end">Octubre '92:</label>
														<div class="col-sm-5">
															<input onkeypress="return filterFloat(event,this);" type="text" id="host_mes10" name="mes10" class="form-control form-control-sm" value="" class="text-end" onchange="return calcularBono('host', 'host')">
														</div>
													</div>
													<div class="row mb-1">
														<label for="sueldo" class="col-sm-7 col-form-label text-end">Noviembre '92:</label>
														<div class="col-sm-5">
															<input onkeypress="return filterFloat(event,this);" type="text" id="host_mes11" name="mes11" class="form-control form-control-sm" value="" class="text-end" onchange="return calcularBono('host', 'host')">
														</div>
													</div>
												</div>
											</div>

											<div class="row border-top border-bottom border-warning py-1 mb-1">
											<div class="col text-end">
												Cálculo de Bono: <input id="host_totalbono" value="" />
											</div>
											</div>

											<?php
											$sueldo = obtener_sueldo($fechas['host']['fb3'])['sueldo_minimo'];
											$difea  = date_diff(date_create($fechas['host']['fb3']), date_create($fechas['host']['fa3']));
											$mesest  = ($difea->y * 12 )+$difea->m;
											?>
											<input type="hidden" id="host_sueldo" name="sueldo" value="<?php echo nf($sueldo,0); ?>"/>
											<input type="hidden" id="host_mesest" name="mesest" value="<?php echo $mesest; ?>"/>
											
											
											<div class="row justify-content-end ">
											<button type="submit" class="col-3 btn btn-light btn-sm me-3">Declaración</button>
											</div>
										</form>
										</div>
									</div>
									<!-- fin Declaracion Jurada -->
									<?php } ?>
									<!-- </div> -->
								</div>
								<!-- fin HOST -->
								<!-- REFLEX -->
								<div id="reflex" class="tab-pane fade <?php echo $tab === 'refl' ? ' show active' : '' ?>">
									<!-- <div class="col border border-light rounded"> -->
									<form id="form_host" action="manual_bono.php" method="post">
										<div class="text-center fs-4 fw-semibold text-white">REFLEX</div>
										<div class="row align-items-center mb-1"><label for="refl_emprdni"    class="col-sm-2 col-form-label">R.U.C.:   </label><div class="col-sm-7"><input type="text" id="refl_emprdni"   name="refl_emprdni"   class="form-control form-control-sm" placeholder="" value="<?php echo isset($_POST['refl_emprdni'])   ? $_POST['refl_emprdni']    : '' ?>"></div><div class="col-sm-3"><button class="btn btn-primary btn-sm" type="button" onclick="obtenerEmpresa('refl')">Buscar</button></div></div>
										<div class="row align-items-center mb-1"><label for="refl_empresa"    class="col-sm-2 col-form-label">Empresa:  </label><div class="col-sm-10"><input type="text" id="refl_empresa"   name="refl_empresa"   class="form-control form-control-sm" placeholder="" value="<?php echo isset($_POST['refl_empresa'])   ? $_POST['refl_empresa']    : '' ?>"></div></div>
										<div class="row align-items-center mb-1"><label for="refl_nombres"    class="col-sm-2 col-form-label">Nombres:  </label><div class="col-sm-10"><input type="text" id="refl_nombres"   name="refl_nombres"   class="form-control form-control-sm" placeholder="" value="<?php echo isset($_POST['refl_nombres'])   ? $_POST['refl_nombres']    : '' ?>"></div></div>
										<div class="row align-items-center mb-1"><label for="refl_apellidos"  class="col-sm-2 col-form-label">Apellidos:</label><div class="col-sm-10"><input type="text" id="refl_apellidos" name="refl_apellidos" class="form-control form-control-sm" placeholder="" value="<?php echo isset($_POST['refl_apellidos']) ? $_POST['refl_apellidos']  : '' ?>"></div></div>
										<div class="row align-items-center mb-1"><label for="refl_dni"        class="col-sm-2 col-form-label">D.N.I.:   </label><div class="col-sm-10"><input type="text" id="refl_dni"       name="refl_dni"       class="form-control form-control-sm" placeholder="" value="<?php echo isset($_POST['refl_dni'])       ? $_POST['refl_dni']        : '' ?>"></div></div>
										<div class="row align-items-center mb-1">
											<label for="refl_fechai" class="col-sm-2 col-form-label">Inicio: </label><div class="col-sm-4"><input required type="date" id="refl_fechai" name="refl_fechai" class="form-control form-control-sm" placeholder="" value="<?php echo isset($_POST['refl_fechai'])   ? $_POST['refl_fechai']    : '' ?>"></div>
											<label for="refl_fechaf" class="col-sm-2 col-form-label">Final:  </label><div class="col-sm-4"><input required type="date" id="refl_fechaf" name="refl_fechaf" class="form-control form-control-sm" placeholder="" value="<?php echo isset($_POST['refl_fechaf'])   ? $_POST['refl_fechaf']    : '' ?>" max="1994-12-31"></div>
										</div>
										<div class="row justify-content-start align-items-center mb-1 me-1">
											<label for="refl_cargo"      class="col-sm-2 col-form-label">Cargo:    </label>
											<div class="col-sm-8"><input type="text" id="refl_cargo"     name="refl_cargo"     class="form-control form-control-sm" placeholder="" value="<?php echo isset($_POST['refl_cargo'])   ? $_POST['refl_cargo']    : '' ?>"></div>
											<button type="submit" class="col-2 btn btn-light btn-sm">Cargar</button>
										</div>
						
										<input type="hidden"  name="orci_emprdni"   value="<?php echo isset($_POST['orci_emprdni'])   ? $_POST['orci_emprdni']    : '' ?>">
										<input type="hidden"  name="orci_empresa"   value="<?php echo isset($_POST['orci_empresa'])   ? $_POST['orci_empresa']    : '' ?>">
										<input type="hidden"  name="orci_nombres"   value="<?php echo isset($_POST['orci_nombres'])   ? $_POST['orci_nombres']    : '' ?>">
										<input type="hidden"  name="orci_apellidos" value="<?php echo isset($_POST['orci_apellidos']) ? $_POST['orci_apellidos']  : '' ?>">
										<input type="hidden"  name="orci_dni"       value="<?php echo isset($_POST['orci_dni'])       ? $_POST['orci_dni']        : '' ?>">
										<input type="hidden"  name="orci_fechai"    value="<?php echo isset($_POST['orci_fechai'])    ? $_POST['orci_fechai']     : '' ?>">
										<input type="hidden"  name="orci_fechaf"    value="<?php echo isset($_POST['orci_fechaf'])    ? $_POST['orci_fechaf']     : '' ?>">
										<input type="hidden"  name="orci_cargo"     value="<?php echo isset($_POST['orci_cargo'])     ? $_POST['orci_cargo']      : '' ?>">
										
										<input type="hidden"  name="host_emprdni"   value="<?php echo isset($_POST['host_emprdni'])   ? $_POST['host_emprdni']    : '' ?>">
										<input type="hidden"  name="host_empresa"   value="<?php echo isset($_POST['host_empresa'])   ? $_POST['host_empresa']    : '' ?>">
										<input type="hidden"  name="host_nombres"   value="<?php echo isset($_POST['host_nombres'])   ? $_POST['host_nombres']    : '' ?>">
										<input type="hidden"  name="host_apellidos" value="<?php echo isset($_POST['host_apellidos']) ? $_POST['host_apellidos']  : '' ?>">
										<input type="hidden"  name="host_dni"       value="<?php echo isset($_POST['host_dni'])       ? $_POST['host_dni']        : '' ?>">
										<input type="hidden"  name="host_fechai"    value="<?php echo isset($_POST['host_fechai'])    ? $_POST['host_fechai']     : '' ?>">
										<input type="hidden"  name="host_fechaf"    value="<?php echo isset($_POST['host_fechaf'])    ? $_POST['host_fechaf']     : '' ?>">
										<input type="hidden"  name="host_cargo"     value="<?php echo isset($_POST['host_cargo'])     ? $_POST['host_cargo']      : '' ?>">

										<input type="hidden" name="tab" value="refl">

									</form>
									<?php if ($anniorp['refl'] && $pagerefl) { ?>
									<div class="row justify-content-center px-3">
										<div class="col-3">
											<form id="form_refl_cer" action="reportes/certificado<?php echo $rp['refl'] ?>.php" method="post" target="_blank" >
												<input type="hidden" name="empresa" value="<?php echo isset($_POST['refl_empresa']) ? $_POST['refl_empresa'] : '' ?>" />
												<input type="hidden" name="nombres" value="<?php echo isset($_POST['refl_nombres']) ? $_POST['refl_nombres'] : '' ?>" />
												<input type="hidden" name="apellidos" value="<?php echo isset($_POST['refl_apellidos']) ? $_POST['refl_apellidos'] : '' ?>" />
												<input type="hidden" name="dni" value="<?php echo isset($_POST['refl_dni']) ? $_POST['refl_dni'] : '' ?>" />

												<input type="hidden" name="f_a"           value="<?php echo $fechas['refl']['fa2'];      ?>">
												<input type="hidden" name="f_a_b"         value="<?php echo $fechas['refl']['fa1'];      ?>">
												<input type="hidden" name="f_b"           value="<?php echo $fechas['refl']['fb2'];      ?>">
												<input type="hidden" name="f_b_b"         value="<?php echo $fechas['refl']['fb1'];      ?>">
												<input type="hidden" name="fecha_emision" value="<?php echo $fechas['refl']['fb1'];      ?>">
												<input type="hidden" name="emision"       value="<?php echo $fechas['refl']['emision'];  ?>">

												<input type="hidden" name="cargo_ac" value="<?php echo isset($_POST['refl_cargo']) ? $_POST['refl_cargo'] : '' ?>" />
												<input type="hidden" name="cargo_al" value="<?php echo isset($_POST['refl_cargo']) ? $_POST['refl_cargo'] : '' ?>" />
												<input type="hidden" name="cargo_ab" value="<?php echo isset($_POST['refl_cargo']) ? $_POST['refl_cargo'] : '' ?>" />
												<button type="submit" class="btn btn-light btn-sm">Certificado</button>
											</form>
										</div>
										<div class="col-3">
											<form id="form_refl_liq" action="reportes/liquidacion<?php echo $rp['refl'] ?>.php" method="post" target="_blank" >
												<input type="hidden" name="empresa" value="<?php echo isset($_POST['refl_empresa']) ? $_POST['refl_empresa'] : '' ?>" />
												<input type="hidden" name="nombres" value="<?php echo isset($_POST['refl_nombres']) ? $_POST['refl_nombres'] : '' ?>" />
												<input type="hidden" name="apellidos" value="<?php echo isset($_POST['refl_apellidos']) ? $_POST['refl_apellidos'] : '' ?>" />
												<input type="hidden" name="dni" value="<?php echo isset($_POST['refl_dni']) ? $_POST['refl_dni'] : '' ?>" />

												<input type="hidden" name="f_a"           value="<?php echo $fechas['refl']['fa2'];      ?>">
												<input type="hidden" name="f_a_b"         value="<?php echo $fechas['refl']['fa1'];      ?>">
												<input type="hidden" name="f_b"           value="<?php echo $fechas['refl']['fb2'];      ?>">
												<input type="hidden" name="f_b_b"         value="<?php echo $fechas['refl']['fb1'];      ?>">
												<input type="hidden" name="fecha_emision" value="<?php echo $fechas['refl']['fb1'];      ?>">
												<input type="hidden" name="emision"       value="<?php echo $fechas['refl']['emision'];  ?>">
												<input type="hidden" name="fsueldo"       value="<?php echo $fechas['refl']['fb3'];      ?>">
												
												<input type="hidden" name="cargo_ac" value="<?php echo isset($_POST['refl_cargo']) ? $_POST['refl_cargo'] : '' ?>" />
												<input type="hidden" name="cargo_al" value="<?php echo isset($_POST['refl_cargo']) ? $_POST['refl_cargo'] : '' ?>" />
												<input type="hidden" name="cargo_ab" value="<?php echo isset($_POST['refl_cargo']) ? $_POST['refl_cargo'] : '' ?>" />
												<button type="submit" class="btn btn-light btn-sm">Liquidación</button>
											</form>
										</div>
										<div class="col-3">
											<form action="manual_bono.php" id="frmPersona" method="POST" >
												<input type="hidden" name="nombres"    value="<?php echo isset($_POST['refl_nombres'])     ? $_POST['refl_nombres']   : '' ?>">
												<input type="hidden" name="apellidos"  value="<?php echo isset($_POST['refl_apellidos'])   ? $_POST['refl_apellidos'] : '' ?>">
												<input type="hidden" name="dni"        value="<?php echo isset($_POST['refl_dni'])         ? $_POST['refl_dni']       : '' ?>">
												<input type="hidden" name="finicio"    value="<?php echo isset($_POST['refl_fechai'])      ? $_POST['refl_fechai']    : '' ?>">
												<input type="hidden" name="ffinal"     value="<?php echo isset($_POST['refl_fechaf'])      ? $_POST['refl_fechaf']    : '' ?>">
						
												<input type="hidden"  name="orci_emprdni"   value="<?php echo isset($_POST['orci_emprdni'])   ? $_POST['orci_emprdni']    : '' ?>">
												<input type="hidden"  name="orci_empresa"   value="<?php echo isset($_POST['orci_empresa'])   ? $_POST['orci_empresa']    : '' ?>">
												<input type="hidden"  name="orci_nombres"   value="<?php echo isset($_POST['orci_nombres'])   ? $_POST['orci_nombres']    : '' ?>">
												<input type="hidden"  name="orci_apellidos" value="<?php echo isset($_POST['orci_apellidos']) ? $_POST['orci_apellidos']  : '' ?>">
												<input type="hidden"  name="orci_dni"       value="<?php echo isset($_POST['orci_dni'])       ? $_POST['orci_dni']        : '' ?>">
												<input type="hidden"  name="orci_fechai"    value="<?php echo isset($_POST['orci_fechai'])    ? $_POST['orci_fechai']     : '' ?>">
												<input type="hidden"  name="orci_fechaf"    value="<?php echo isset($_POST['orci_fechaf'])    ? $_POST['orci_fechaf']     : '' ?>">
												<input type="hidden"  name="orci_cargo"     value="<?php echo isset($_POST['orci_cargo'])     ? $_POST['orci_cargo']      : '' ?>">
											
												<input type="hidden"  name="host_emprdni"   value="<?php echo isset($_POST['host_emprdni'])   ? $_POST['host_emprdni']    : '' ?>">
												<input type="hidden"  name="host_empresa"   value="<?php echo isset($_POST['host_empresa'])   ? $_POST['host_empresa']    : '' ?>">
												<input type="hidden"  name="host_nombres"   value="<?php echo isset($_POST['host_nombres'])   ? $_POST['host_nombres']    : '' ?>">
												<input type="hidden"  name="host_apellidos" value="<?php echo isset($_POST['host_apellidos']) ? $_POST['host_apellidos']  : '' ?>">
												<input type="hidden"  name="host_dni"       value="<?php echo isset($_POST['host_dni'])       ? $_POST['host_dni']        : '' ?>">
												<input type="hidden"  name="host_fechai"    value="<?php echo isset($_POST['host_fechai'])    ? $_POST['host_fechai']     : '' ?>">
												<input type="hidden"  name="host_fechaf"    value="<?php echo isset($_POST['host_fechaf'])    ? $_POST['host_fechaf']     : '' ?>">
												<input type="hidden"  name="host_cargo"     value="<?php echo isset($_POST['host_cargo'])     ? $_POST['host_cargo']      : '' ?>">
												
												<input type="hidden"  name="refl_emprdni"   value="<?php echo isset($_POST['refl_emprdni'])   ? $_POST['refl_emprdni']    : '' ?>">
												<input type="hidden"  name="refl_empresa"   value="<?php echo isset($_POST['refl_empresa'])   ? $_POST['refl_empresa']    : '' ?>">
												<input type="hidden"  name="refl_nombres"   value="<?php echo isset($_POST['refl_nombres'])   ? $_POST['refl_nombres']    : '' ?>">
												<input type="hidden"  name="refl_apellidos" value="<?php echo isset($_POST['refl_apellidos']) ? $_POST['refl_apellidos']  : '' ?>">
												<input type="hidden"  name="refl_dni"       value="<?php echo isset($_POST['refl_dni'])       ? $_POST['refl_dni']        : '' ?>">
												<input type="hidden"  name="refl_fechai"    value="<?php echo isset($_POST['refl_fechai'])    ? $_POST['refl_fechai']     : '' ?>">
												<input type="hidden"  name="refl_fechaf"    value="<?php echo isset($_POST['refl_fechaf'])    ? $_POST['refl_fechaf']     : '' ?>">
												<input type="hidden"  name="refl_cargo"     value="<?php echo isset($_POST['refl_cargo'])     ? $_POST['refl_cargo']      : '' ?>">

												<input type="hidden" name="tab" value="refl">
												
												<button type="submit" class="btn btn-light btn-sm">Empresa</button>
											</form>
										</div>
									</div>
									<!-- inicio BONO -->
									<?php if ( $anniorp['refl'] >= 1978 ) { ?>
									<div class="row border-white border-top pt-3 mt-2">
										<div class="col">
											<form id="form_refl_bol" action="reportes/boletadepago<?php echo $bo['refl'] ?>.php" method="post" target="_blank" >
												<input type="hidden" name="empresa" value="<?php echo isset($_POST['refl_empresa']) ? $_POST['refl_empresa'] : '' ?>" />
												<input type="hidden" name="nombres" value="<?php echo isset($_POST['refl_nombres']) ? $_POST['refl_nombres'] : '' ?>" />
												<input type="hidden" name="apellidos" value="<?php echo isset($_POST['refl_apellidos']) ? $_POST['refl_apellidos'] : '' ?>" />
												<input type="hidden" name="dni" value="<?php echo isset($_POST['refl_dni']) ? $_POST['refl_dni'] : '' ?>" />
					
												<input type="hidden" name="f_a"           value="<?php echo $fechas['refl']['fa2'];      ?>">
												<input type="hidden" name="f_a_b"         value="<?php echo $fechas['refl']['fa1'];      ?>">
												<input type="hidden" name="f_b"           value="<?php echo $fechas['refl']['fb2'];      ?>">
												<input type="hidden" name="f_b_b"         value="<?php echo $fechas['refl']['fb1'];      ?>">
												<input type="hidden" name="fecha_emision" value="<?php echo $fechas['refl']['fb1'];      ?>">
												<input type="hidden" name="emision"       value="<?php echo $fechas['refl']['emision'];  ?>">
												<input type="hidden" name="fsueldo"       value="<?php echo $fechas['refl']['fb3'];      ?>">
												
												<input type="hidden" name="cargo_ac" value="<?php echo isset($_POST['refl_cargo']) ? $_POST['refl_cargo'] : '' ?>" />
												<input type="hidden" name="cargo_al" value="<?php echo isset($_POST['refl_cargo']) ? $_POST['refl_cargo'] : '' ?>" />
												<input type="hidden" name="cargo_ab" value="<?php echo isset($_POST['refl_cargo']) ? $_POST['refl_cargo'] : '' ?>" />
					
												<div class="row">
												<div class="col-6">
													<div class="row mb-1">
														<label for="sueldo" class="col-5 col-form-label">Fecha:</label>
														<div class="col-7">
															<input required type="date" id="fechaboleta" name="fechaboleta" min="1978-08-22" class="form-control form-control-sm" value="<?php echo isset($_POST['fechaboleta']) ? $_POST['fechaboleta'] : '0' ?>">
														</div>
													</div>
													<div class="row mb-1">
														<label for="sueldo" class="col-5 col-form-label">R. VACACIONAL:</label>
														<div class="col-7">
															<input onkeypress="return filterFloat(event,this);" type="text" id="remvacacionales" name="remvacacionales" class="form-control form-control-sm" value="<?php echo isset($_POST['remvacacionales']) ? $_POST['remvacacionales'] : '0' ?>">
														</div>
													</div>
													<div class="row mb-1">
														<label for="sueldo" class="col-5 col-form-label">Reintegro:</label>
														<div class="col-7">
															<input onkeypress="return filterFloat(event,this);" type="text" id="reintegro" name="reintegro" class="form-control form-control-sm" value="<?php echo isset($_POST['reintegro']) ? $_POST['reintegro'] : '0' ?>">
														</div>
													</div>
												</div>
												<div class="col-6">
													<div class="row mb-1">
														<label for="sueldo" class="col-5 col-form-label">H. EXTRAS:</label>
														<div class="col-7">
															<input onkeypress="return filterFloat(event,this);" type="text" id="hextras" name="hextras" class="form-control form-control-sm" value="<?php echo isset($_POST['hextras']) ? $_POST['hextras'] : '0' ?>">
														</div>
													</div>
													<div class="row mb-1">
														<label for="sueldo" class="col-5 col-form-label">Bonificacion:</label>
														<div class="col-7">
															<input onkeypress="return filterFloat(event,this);" type="text" id="bonificacion" name="bonificacion" class="form-control form-control-sm" value="<?php echo isset($_POST['bonificacion']) ? $_POST['bonificacion'] : '0' ?>">
														</div>
													</div>
													<div class="row mb-1">
															<label for="sueldo" class="col-5 col-form-label">OTROS:</label>
															<div class="col-7">
																<input onkeypress="return filterFloat(event,this);" type="text" id="otros_deven" name="otros_deven" class="form-control form-control-sm" value="<?php echo isset($_POST['otros_deven']) ? $_POST['otros_deven'] : '0' ?>">
															</div>
													</div>
												</div>
												</div>
					
												<div class="row justify-content-end ">
													<button type="submit" class="col-3 btn btn-light btn-sm me-3">Boleta</button>
												</div>
											</form>
										</div>
									</div>
									<?php } ?>
									<!-- fin BONO -->

									<!-- inicio Declaracion Jurada -->
									<div class="row border-white border-top pt-3 mt-2">
										<div class="col">
										<?php $dec = rand(1, 3); ?>
										<form id="form_orci_bol" action="reportes/declaracionempleador0<?php echo $dec ?>.php" method="post" target="_blank" >
											<input type="hidden" name="empresa"   value="<?php echo isset($_POST['refl_empresa']) ? $_POST['refl_empresa'] : '' ?>" />
											<input type="hidden" name="nombres"   value="<?php echo isset($_POST['refl_nombres']) ? $_POST['refl_nombres'] : '' ?>" />
											<input type="hidden" name="apellidos" value="<?php echo isset($_POST['refl_apellidos']) ? $_POST['refl_apellidos'] : '' ?>" />
											<input type="hidden" name="dni"       value="<?php echo isset($_POST['refl_dni']) ? $_POST['refl_dni'] : '' ?>" />
				
											<input type="hidden" name="f_a"           value="<?php echo $fechas['refl']['fa2'];      ?>">
											<input type="hidden" name="f_a_b"         value="<?php echo $fechas['refl']['fa1'];      ?>">
											<input type="hidden" name="f_b"           value="<?php echo $fechas['refl']['fb2'];      ?>">
											<input type="hidden" name="f_b_b"         value="<?php echo $fechas['refl']['fb1'];      ?>">
											<input type="hidden" name="fecha_emision" value="<?php echo $fechas['refl']['fb1'];      ?>">
											<input type="hidden" name="emision"       value="<?php echo $fechas['refl']['emision'];  ?>">
											<input type="hidden" name="fsueldo"       value="<?php echo $fechas['refl']['fb3'];      ?>">

											<input type="hidden" name="rep_legal" value="<?php echo $empresa['refl']['id']; ?>">
											<input type="hidden" name="rep_legal" value="<?php echo $empresa['refl']['rep_legal']; ?>">
											<input type="hidden" name="dni_a"     value="<?php echo $empresa['refl']['dni_a']; ?>">
											<input type="hidden" name="ruc"       value="<?php echo $empresa['refl']['ruc']; ?>">
											
											<input type="hidden" name="cargo_abo" value="<?php echo isset($_POST['refl_cargo']) ? $_POST['refl_cargo'] : '' ?>" />
											<input type="hidden" name="cargo_bbo" value="<?php echo isset($_POST['refl_cargo']) ? $_POST['refl_cargo'] : '' ?>" />

											<div class="row mb-3">
											<label for="numautog" class="col-7 col-form-label text-end">Número Autogenerado:</label>
											<div class="col-5">
												<input type="text" id="numautog" name="numautog" class="form-control form-control-sm" placeholder="Núm. Autogenerado" value="<?php echo isset($_POST['numautog']) ? $_POST['numautog']  : '' ?>" >
											</div>
											</div>

											<div class="row">
												<div class="col-6">
													<div class="row mb-1">
														<label for="sueldo" class="col-sm-7 col-form-label text-end">Diciembre '91:</label>
														<div class="col-sm-5">
															<input onkeypress="return filterFloat(event,this);" type="text" id="refl_mes12" name="mes12" class="form-control form-control-sm" value="" class="text-end" onchange="return calcularBono('refl', 'refl')">
														</div>
													</div>
													<div class="row mb-1">
														<label for="sueldo" class="col-sm-7 col-form-label text-end">Enero '92:</label>
														<div class="col-sm-5">
															<input onkeypress="return filterFloat(event,this);" type="text" id="refl_mes01" name="mes01" class="form-control form-control-sm" value="" class="text-end" onchange="return calcularBono('refl', 'refl')">
														</div>
													</div>
													<div class="row mb-1">
														<label for="sueldo" class="col-sm-7 col-form-label text-end">Febrero '92:</label>
														<div class="col-sm-5">
															<input onkeypress="return filterFloat(event,this);" type="text" id="refl_mes02" name="mes02" class="form-control form-control-sm" value="" class="text-end" onchange="return calcularBono('refl', 'refl')">
														</div>
													</div>
													<div class="row mb-1">
														<label for="sueldo" class="col-sm-7 col-form-label text-end">Marzo '92:</label>
														<div class="col-sm-5">
															<input onkeypress="return filterFloat(event,this);" type="text" id="refl_mes03" name="mes03" class="form-control form-control-sm" value="" class="text-end" onchange="return calcularBono('refl', 'refl')">
														</div>
													</div>
													<div class="row mb-1">
														<label for="sueldo" class="col-sm-7 col-form-label text-end">Abril '92:</label>
														<div class="col-sm-5">
															<input onkeypress="return filterFloat(event,this);" type="text" id="refl_mes04" name="mes04" class="form-control form-control-sm" value="" class="text-end" onchange="return calcularBono('refl', 'refl')">
														</div>
													</div>
													<div class="row mb-1">
														<label for="sueldo" class="col-sm-7 col-form-label text-end">Mayo '92:</label>
														<div class="col-sm-5">
															<input onkeypress="return filterFloat(event,this);" type="text" id="refl_mes05" name="mes05" class="form-control form-control-sm" value="" class="text-end" onchange="return calcularBono('refl', 'refl')">
														</div>
													</div>
												</div>
												<div class="col-6">
													<div class="row mb-1">
														<label for="sueldo" class="col-sm-7 col-form-label text-end">Junio '92:</label>
														<div class="col-sm-5">
															<input onkeypress="return filterFloat(event,this);" type="text" id="refl_mes06" name="mes06" class="form-control form-control-sm" value="" class="text-end" onchange="return calcularBono('refl', 'refl')">
														</div>
													</div>
													<div class="row mb-1">
														<label for="sueldo" class="col-sm-7 col-form-label text-end">Julio '92:</label>
														<div class="col-sm-5">
															<input onkeypress="return filterFloat(event,this);" type="text" id="refl_mes07" name="mes07" class="form-control form-control-sm" value="" class="text-end" onchange="return calcularBono('refl', 'refl')">
														</div>
													</div>
													<div class="row mb-1">
														<label for="sueldo" class="col-sm-7 col-form-label text-end">Agosto '92:</label>
														<div class="col-sm-5">
															<input onkeypress="return filterFloat(event,this);" type="text" id="refl_mes08" name="mes08" class="form-control form-control-sm" value="" class="text-end" onchange="return calcularBono('refl', 'refl')">
														</div>
													</div>
													<div class="row mb-1">
														<label for="sueldo" class="col-sm-7 col-form-label text-end">Septiembre '92:</label>
														<div class="col-sm-5">
															<input onkeypress="return filterFloat(event,this);" type="text" id="refl_mes09" name="mes09" class="form-control form-control-sm" value="" class="text-end" onchange="return calcularBono('refl', 'refl')">
														</div>
													</div>
													<div class="row mb-1">
														<label for="sueldo" class="col-sm-7 col-form-label text-end">Octubre '92:</label>
														<div class="col-sm-5">
															<input onkeypress="return filterFloat(event,this);" type="text" id="refl_mes10" name="mes10" class="form-control form-control-sm" value="" class="text-end" onchange="return calcularBono('refl', 'refl')">
														</div>
													</div>
													<div class="row mb-1">
														<label for="sueldo" class="col-sm-7 col-form-label text-end">Noviembre '92:</label>
														<div class="col-sm-5">
															<input onkeypress="return filterFloat(event,this);" type="text" id="refl_mes11" name="mes11" class="form-control form-control-sm" value="" class="text-end" onchange="return calcularBono('refl', 'refl')">
														</div>
													</div>
												</div>
											</div>

											<div class="row border-top border-bottom border-warning py-1 mb-1">
											<div class="col text-end">
												Cálculo de Bono: <input id="refl_totalbono" value="" />
											</div>
											</div>

											<?php
											$sueldo = obtener_sueldo($fechas['refl']['fb3'])['sueldo_minimo'];
											$difea  = date_diff(date_create($fechas['refl']['fb3']), date_create($fechas['refl']['fa3']));
											$mesest  = ($difea->y * 12 )+$difea->m;
											?>
											<input type="hidden" id="refl_sueldo" name="sueldo" value="<?php echo nf($sueldo,0); ?>"/>
											<input type="hidden" id="refl_mesest" name="mesest" value="<?php echo $mesest; ?>"/>
											
											<div class="row justify-content-end ">
												<button type="submit" class="col-3 btn btn-light btn-sm me-3">Declaración</button>
											</div>
										</form>
										</div>
									</div>
									<!-- fin Declaracion Jurada -->
									<?php } ?>
									<!-- </div> -->
								</div>
								<!-- fin REFLEX -->
							</div>
						</div>
						<!-- fin tabs -->

						<!-- empresa automatica -->
						<!-- <div class="col-4"> -->
						<?php
						if ( isset($_POST['finicio']) && isset($_POST['ffinal']) ) {

							$numemp = 0;
							$anniorepa = "";
							$anniorepb = "";
							$fecha_anterior = null;
							$valido = false;
							do {
								$aniosa = 10;
								$aniosb = 10;
								// $aniosa = rand(8, 12);
								// $aniosb = rand(8, 12);
								$daysint = rand(8, 25);
								$monthsint = rand(1, 3);
								$aniosint = rand(0, 2);
								if ( ( $aniosa + $aniosb ) >= 20 ) $valido = true;
							} while (!$valido);
							$datosfechas = $bonoactivo ? generar_fechas_trabajo_bono(array($aniosa, $aniosb, $daysint, $monthsint, $aniosint)) : array();

							$datos = $datosfechas[2];
							
							$empresas = empresa_cotizada($datos['fechas']['fa3'], $datos['fechas']['fb3']);
							foreach ($empresas as $empresa) {
								$numemp++;
								?>
								<div class="col-6 border-start border-warning">
									<div class="column-reverse">
										<div class="col">
											<?php
												// echo "fa1: ",$datos['fechas']['fa1'],"<br>";
												// echo "fa2: ",$datos['fechas']['fa2'],"<br>";
												// echo "fa3: ",$datos['fechas']['fa3'],"<br>";
												// echo "fa4: ",$datos['fechas']['fa4'],"<br>";
												// echo "fb1: ",$datos['fechas']['fb1'],"<br>";
												// echo "fb2: ",$datos['fechas']['fb2'],"<br>";
												// echo "fb3: ",$datos['fechas']['fb3'],"<br>";
												// echo "fb4: ",$datos['fechas']['fb4'],"<br>";
												// var_dump($datosfechas);


												$sueldo = nf(obtener_sueldo($datos['fechas']['fb3'])['sueldo_minimo']);

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
												
												$control[8] = '<input type="hidden" name="dpto" value="'.$empresa['dpto'].'">'; 

												$rp = "";
												$bo = "";
												$anniorp = $datos['fechas']['anniorep'];
												
												if ( $anniorp >= 1962 && $anniorp <= 1972 ) { $rp = "_62al72"; }
												if ( $anniorp >= 1973 && $anniorp <= 1975 ) { $rp = "_73al75"; }
												if ( $anniorp >= 1976 && $anniorp <= 1983 ) { $rp = "_76al83"; }
												if ( $anniorp >= 1984 && $anniorp <= 1994 ) { $rp = "_84al94"; }
												if ( $anniorp >= 1995 ) { $rp = "_95al00"; }

												if ( $anniorp >= 1978 && $anniorp <= 1980 ) { $bo = "_78al80"; }
												if ( $anniorp >= 1981 && $anniorp <= 1987 ) { $bo = "_81al87"; }
												if ( $anniorp >= 1988 && $anniorp <= 1992 ) { $bo = "_88al92"; }
												if ( $anniorp >= 1993 ) { $bo = "_93al00"; }

												// echo "<div class=' border-bottom border-info text-center mb-2 pb-2 ' >Empresa $numemp</div>";
												
												echo "<div class='text-center fw-bolder text-info ' style='font-size: 13px;'>",$empresa['id']," - ",$empresa['empleador'],"</div>";
												
												echo "<div class=' text-center fw-lighter fst-italic pb-2' style='font-size: 11px;' >","Desde el: ", $datos['fechas']['fa2']," / Hasta el: ",$datos['fechas']['fb2'],"</div>";
												echo "<div class=' text-center fw-lighter fst-italic pb-2 border-bottom border-info ' style='font-size: 11px;' >","Último sueldo: ", $sueldo,"</div>";

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
														<button class="nav-link" id="liquidacion_<?php echo $numemp ?>-tab" data-bs-toggle="pill" data-bs-target="#liquidacion_<?php echo $numemp ?>" type="button" role="tab"   aria-controls="liquidacion_<?php echo $numemp ?>" aria-selected="false">Liquidación</button>
													</li>
													<?php if ( $anniorp >= 1978 ) { ?>
														<li class="nav-item" role="presentation">
															<button class="nav-link" id="boletadepago_<?php echo $numemp ?>-tab" data-bs-toggle="pill" data-bs-target="#boletadepago_<?php echo $numemp ?>" type="button" role="tab" aria-controls="boletadepago_<?php echo $numemp ?>" aria-selected="false">Boleta</button>
														</li>
													<?php } ?>
													<?php if ( $bonoactivo && $anniorp >= 1992 && $anniorp <= 1994 ) { ?>
														<li class="nav-item" role="presentation">
															<button class="nav-link" id="bono_<?php echo $numemp ?>-tab" data-bs-toggle="pill" data-bs-target="#bono_<?php echo $numemp ?>" type="button" role="tab" aria-controls="bono_<?php echo $numemp ?>" aria-selected="false">Bono</button>
														</li>
													<?php } ?>
												</ul>
												<div class="tab-content" id="pills-tabContent">
												<?php
												for ( $p = 1 ; $p < 4 ; $p++ ) {
													if ($p === 1) {
														$rep = "certificado";
														echo "<div class='tab-pane fade capitalizar show active' id='".$rep."_".$numemp."' role='tabpanel' aria-labelledby='".$rep."_".$numemp."-tab'>";
															echo "<form action='reportes/".$rep.$rp.".php' method='post' target='_blank'>","\n";
																if( $numemp === 1 ) echo '<input required type="hidden" name="cargo_ac" id="cargo_ac" value="" />',"\n";
																if( $numemp === 2 ) echo '<input required type="hidden" name="cargo_al" id="cargo_al" value="" />',"\n";
																echo $control[0],"\n";
																echo $control[1],"\n";
																echo $control[2],"\n";
																
																echo $control[3],"\n";
																echo $control[4],"\n";
																echo $control[10],"\n";
																echo $control[12],"\n";
																echo $control[13],"\n";
																
																echo $control[8],"\n";
																echo $control[9],"\n";
																echo $control[16],"\n";
																echo "<div style='display: flex; flex-direction: row; justify-content: end; align-items: center;' > <button class='btn btn-outline-info mb-4' type='submit' style=' text-transform: capitalize; ' > imprimir $rep <i class='fa fa-file-alt fa-sm ' ></i> </button></div>";
															echo "</form>";
														echo "</div>";
													}
													if ($p === 2) {
														$rep = "liquidacion";
														echo "<div class='tab-pane fade capitalizar' id='".$rep."_".$numemp."' role='tabpanel' aria-labelledby='".$rep."_".$numemp."-tab'>";
															echo "<form action='reportes/".$rep.$rp.".php' method='post' target='_blank'>","\n";
																if( $numemp === 1 ) echo '<input required type="hidden" name="cargo_al" id="cargo_al" value="" />',"\n";
																if( $numemp === 2 ) echo '<input required type="hidden" name="cargo_bl" id="cargo_bl" value="" />',"\n";
																?>
																<div class="row mb-1 border-bottom border-info">
																	<label for="sueldo" class="col-sm-7 col-form-label">Adelanto:</label>
																	<div class="col-sm-5">
																		<input onkeypress="return filterFloat(event,this);" type="text" id="adelanto" name="adelanto" class="form-control form-control-sm bg-danger bg-gradient bg-opacity-50 text-white" placeholder="Adelanto" value="<?php echo isset($_POST['adelanto']) ? $_POST['adelanto'] : '0' ?>">
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
																echo $control[0],"\n";
																echo $control[1],"\n";
																echo $control[2],"\n";
																
																echo $control[3],"\n";
																echo $control[4],"\n";
																echo $control[10],"\n";
																echo $control[12],"\n";
																echo $control[13],"\n";
																
																echo $control[8],"\n";
																echo $control[9],"\n";
																echo $control[16],"\n";
																echo "<div style='display: flex; flex-direction: row; justify-content: end; align-items: center;' > <button class='btn btn-outline-info mb-4' type='submit' style=' text-transform: capitalize; ' > imprimir $rep <i class='fa fa-file-alt fa-sm ' ></i> </button></div>";
															echo "</form>";
														echo "</div>";
													}
													if ($p === 3 ) {
														$rep = "boletadepago";
														echo "<div class='tab-pane fade capitalizar' id='".$rep."_".$numemp."' role='tabpanel' aria-labelledby='".$rep."_".$numemp."-tab'>";
															echo "<form action='reportes/".$rep.$bo.".php' method='post' target='_blank'>","\n";
																if( $numemp === 1 ) echo '<input required type="hidden" name="cargo_ab" id="cargo_ab" value="" />',"\n";
																if( $numemp === 2 ) echo '<input required type="hidden" name="cargo_bb" id="cargo_bb" value="" />',"\n";
																?>
																<div class="row mb-1">
																	<label for="sueldo" class="col-sm-7 col-form-label">Fecha:</label>
																	<div class="col-sm-5">
																		<input required type="date" id="fechaboleta" name="fechaboleta" min="1978-08-22" class="form-control form-control-sm" value="<?php echo isset($_POST['fechaboleta']) ? $_POST['fechaboleta'] : '0' ?>">
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
																<?php
																echo $control[0],"\n";
																echo $control[1],"\n";
																echo $control[2],"\n";
																
																echo $control[3],"\n";
																echo $control[4],"\n";
																echo $control[10],"\n";
																echo $control[12],"\n";
																echo $control[13],"\n";
																
																echo $control[8],"\n";
																echo $control[9],"\n";
																echo $control[16],"\n";
																echo "<div style='display: flex; flex-direction: row; justify-content: end; align-items: center;' > <button class='btn btn-outline-info mb-4' type='submit' style=' text-transform: capitalize; ' > imprimir $rep <i class='fa fa-file-alt fa-sm ' ></i> </button></div>";
															echo "</form>";
														echo "</div>";
													}
													// if ( $bonoactivo && $numemp === 2 && $anniorp >= 1992 && $anniorp <= 1994 ) {
													if ( $bonoactivo && $p === 3 && $anniorp >= 1992 && $anniorp <= 1994 ) {

														$rep = "bono";
														$dec = rand(1, 3);

														echo "<div class='tab-pane fade capitalizar' id='".$rep."_".$numemp."' role='tabpanel' aria-labelledby='".$rep."_".$numemp."-tab'>";
														
															echo "<form action='reportes/declaracionempleador0$dec.php' method='post' target='_blank'>","\n";
															
																if( $numemp === 1 ) echo '<input required type="hidden" name="cargo_abo" id="cargo_ab" value="" />',"\n";
																if( $numemp === 2 ) echo '<input required type="hidden" name="cargo_bbo" id="cargo_bb" value="" />',"\n";
																
																echo '<input type="hidden" name="rep_legal" value="'.$empresa['id'].'">';
																echo '<input type="hidden" name="rep_legal" value="'.$empresa['rep_legal'].'">';
																echo '<input type="hidden" name="dni_a" value="'.$empresa['dni_a'].'">';
																echo '<input type="hidden" name="ruc" value="'.$empresa['ruc'].'">';
																echo '<input type="hidden" name="dni" value="'.$_POST['dni'].'">';
																
																?>
																<div class="row mb-3">
																	<label for="numautog" class="col-sm-7 col-form-label">Número Autogenerado:</label>
																	<div class="col-sm-5">
																		<input type="text" id="numautog" name="numautog" class="form-control form-control-sm" placeholder="Núm. Autogenerado" value="<?php echo isset($_POST['numautog']) ? $_POST['numautog']  : '' ?>" >
																	</div>
																</div>

																<div class="row">
																	<div class="col-6">
																	<div class="row mb-1">
																		<label for="sueldo" class="col-sm-7 col-form-label text-end">Diciembre '91:</label>
																		<div class="col-sm-5">
																		<input onkeypress="return filterFloat(event,this);" type="text" id="auto_mes12" name="mes12" class="form-control form-control-sm" value="" class="text-end" onchange="return calcularBono('auto', 'auto')">
																		</div>
																	</div>
																	<div class="row mb-1">
																		<label for="sueldo" class="col-sm-7 col-form-label text-end">Enero '92:</label>
																		<div class="col-sm-5">
																		<input onkeypress="return filterFloat(event,this);" type="text" id="auto_mes01" name="mes01" class="form-control form-control-sm" value="" class="text-end" onchange="return calcularBono('auto', 'auto')">
																		</div>
																	</div>
																	<div class="row mb-1">
																		<label for="sueldo" class="col-sm-7 col-form-label text-end">Febrero '92:</label>
																		<div class="col-sm-5">
																		<input onkeypress="return filterFloat(event,this);" type="text" id="auto_mes02" name="mes02" class="form-control form-control-sm" value="" class="text-end" onchange="return calcularBono('auto', 'auto')">
																		</div>
																	</div>
																	<div class="row mb-1">
																		<label for="sueldo" class="col-sm-7 col-form-label text-end">Marzo '92:</label>
																		<div class="col-sm-5">
																		<input onkeypress="return filterFloat(event,this);" type="text" id="auto_mes03" name="mes03" class="form-control form-control-sm" value="" class="text-end" onchange="return calcularBono('auto', 'auto')">
																		</div>
																	</div>
																	<div class="row mb-1">
																		<label for="sueldo" class="col-sm-7 col-form-label text-end">Abril '92:</label>
																		<div class="col-sm-5">
																		<input onkeypress="return filterFloat(event,this);" type="text" id="auto_mes04" name="mes04" class="form-control form-control-sm" value="" class="text-end" onchange="return calcularBono('auto', 'auto')">
																		</div>
																	</div>
																	<div class="row mb-1">
																		<label for="sueldo" class="col-sm-7 col-form-label text-end">Mayo '92:</label>
																		<div class="col-sm-5">
																		<input onkeypress="return filterFloat(event,this);" type="text" id="auto_mes05" name="mes05" class="form-control form-control-sm" value="" class="text-end" onchange="return calcularBono('auto', 'auto')">
																		</div>
																	</div>
																	</div>
																	<div class="col-6">
																	<div class="row mb-1">
																		<label for="sueldo" class="col-sm-7 col-form-label text-end">Junio '92:</label>
																		<div class="col-sm-5">
																		<input onkeypress="return filterFloat(event,this);" type="text" id="auto_mes06" name="mes06" class="form-control form-control-sm" value="" class="text-end" onchange="return calcularBono('auto', 'auto')">
																		</div>
																	</div>
																	<div class="row mb-1">
																		<label for="sueldo" class="col-sm-7 col-form-label text-end">Julio '92:</label>
																		<div class="col-sm-5">
																		<input onkeypress="return filterFloat(event,this);" type="text" id="auto_mes07" name="mes07" class="form-control form-control-sm" value="" class="text-end" onchange="return calcularBono('auto', 'auto')">
																		</div>
																	</div>
																	<div class="row mb-1">
																		<label for="sueldo" class="col-sm-7 col-form-label text-end">Agosto '92:</label>
																		<div class="col-sm-5">
																		<input onkeypress="return filterFloat(event,this);" type="text" id="auto_mes08" name="mes08" class="form-control form-control-sm" value="" class="text-end" onchange="return calcularBono('auto', 'auto')">
																		</div>
																	</div>
																	<div class="row mb-1">
																		<label for="sueldo" class="col-sm-7 col-form-label text-end">Septiembre '92:</label>
																		<div class="col-sm-5">
																		<input onkeypress="return filterFloat(event,this);" type="text" id="auto_mes09" name="mes09" class="form-control form-control-sm" value="" class="text-end" onchange="return calcularBono('auto', 'auto')">
																		</div>
																	</div>
																	<div class="row mb-1">
																		<label for="sueldo" class="col-sm-7 col-form-label text-end">Octubre '92:</label>
																		<div class="col-sm-5">
																		<input onkeypress="return filterFloat(event,this);" type="text" id="auto_mes10" name="mes10" class="form-control form-control-sm" value="" class="text-end" onchange="return calcularBono('auto', 'auto')">
																		</div>
																	</div>
																	<div class="row mb-1">
																		<label for="sueldo" class="col-sm-7 col-form-label text-end">Noviembre '92:</label>
																		<div class="col-sm-5">
																		<input onkeypress="return filterFloat(event,this);" type="text" id="auto_mes11" name="mes11" class="form-control form-control-sm" value="" class="text-end" onchange="return calcularBono('auto', 'auto')">
																		</div>
																	</div>
																	</div>
																</div>

																<div class="row border-top border-bottom border-warning py-1 mb-1">
																	<div class="col text-end">
																	Cálculo de Bono: <input id="auto_totalbono" value="" />
																	</div>
																</div>
																
																<?php
																
																echo $control[0],"\n";
																echo $control[1],"\n";
																echo $control[2],"\n";
																
																echo $control[3],"\n";
																echo $control[4],"\n";
																echo $control[10],"\n";
																echo $control[12],"\n";
																echo $control[13],"\n";
																
																echo $control[8],"\n";
																echo $control[9],"\n";
																echo $control[16],"\n";
																echo "<div style='display: flex; flex-direction: row; justify-content: end; align-items: center;' > <button class='btn btn-outline-info mb-4' type='submit' style=' text-transform: capitalize; ' > imprimir $rep <i class='fa fa-file-alt fa-sm ' ></i> </button></div>";
															echo "</form>";
														echo "</div>";
													}
												}
												?>
												</div>
												<?php
											?>
										</div>
										<div class="col">
											<?php
											if ( count($datosfechas) ) {
												// var_dump($datosfechas);
												echo '<div class="row justify-content-center">';
												echo '<div class="col border-top border-bottom border-warning py-3 mb-3 text-center">';
												
												// $feai = date_create($datosfechas[1]['fechas']['fa3']);
												// $feaf = date_create($datosfechas[1]['fechas']['fb3']);
												$febi = date_create($datosfechas[2]['fechas']['fa3']);
												$febf = date_create($datosfechas[2]['fechas']['fb3']);
												
												// $difea = date_diff($feaf,$feai);
												$difeb = date_diff($febf,$febi);
												
												// $años = $difea->y + $difeb->y;
												// $meses = $difea->m + $difeb->m;
												// $dias = $difea->d + $difeb->d;
												
												$años = $difeb->y;
												$meses = $difeb->m;
												
												// echo "Tiempo de servicio total: ",$años," Años - ",$meses," Meses y ",$dias," Días.";
												echo "Tiempo de servicio total: ",$años," Años - ",$meses," Meses .";
												
												echo '<input type="hidden" id="auto_sueldo" name="sueldo" value="'.$sueldo.'"/>';
												echo '<input type="hidden" id="auto_mesest" name="mesest" value="'.(($años*12)+$meses).'"/>';

												// var_dump($difea);
												// var_dump($difeb);

												// echo $feai,"  -  ",$feaf,"  -  ",$febi,"  -  ",$febf;
												echo '</div>';
												echo '</div>';
											}
											?>
										</div>
									</div>
								</div>
								<?php
							}
						}
						?>
					</div>
					<!-- 
					<div class="column-reverse">
						<div class="col">
						</div>
						<div class="col">
							<?php
							if ( count($datosfechas) ) {
								// var_dump($datosfechas);
								echo '<div class="row justify-content-center">';
								echo '<div class="col border-top border-bottom border-warning py-3 mb-3 text-center">';
								
								// $feai = date_create($datosfechas[1]['fechas']['fa3']);
								// $feaf = date_create($datosfechas[1]['fechas']['fb3']);
								$febi = date_create($datosfechas[2]['fechas']['fa3']);
								$febf = date_create($datosfechas[2]['fechas']['fb3']);
								
								// $difea = date_diff($feaf,$feai);
								$difeb = date_diff($febf,$febi);
								
								// $años = $difea->y + $difeb->y;
								// $meses = $difea->m + $difeb->m;
								// $dias = $difea->d + $difeb->d;
								
								$años = $difeb->y;
								$meses = $difeb->m;
								
								// echo "Tiempo de servicio total: ",$años," Años - ",$meses," Meses y ",$dias," Días.";
								echo "Tiempo de servicio total: ",$años," Años - ",$meses," Meses .";
								
								echo '<input type="hidden" id="auto_sueldo" name="sueldo" value="'.$sueldo.'"/>';
								echo '<input type="hidden" id="auto_mesest" name="mesest" value="'.(($años*12)+$meses).'"/>';

								// var_dump($difea);
								// var_dump($difeb);

								// echo $feai,"  -  ",$feaf,"  -  ",$febi,"  -  ",$febf;
								echo '</div>';
								echo '</div>';
							}
							?>
						</div>
					</div>
					-->
          
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
          $('#cargo_ac').val(valor)
          $('#cargo_al').val(valor)
          $('#cargo_ab').val(valor)
        }

        const asignar_cargo_l = (valor) => {
          $('#cargo_bc').val(valor)
          $('#cargo_bl').val(valor)
          $('#cargo_bb').val(valor)
        }

        function filterFloat(evt,input){
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

        const obtenerEmpresa = (para) => {
          var dni = $('#'+para+'_emprdni').val()
          $.ajax({
              url : '_db/empresa.php',
              data : { dni : dni },
              type : 'GET',
              dataType : 'json',
              success : function(json) {
                  $('#'+para+'_empresa').val(json.empleador)
              },
              error : function(xhr, status) {
                  alert('Registro no encontrado.')
                  console.info("XHR: ", xhr.responseText)
                  console.info("Estatus: ", status)
              },
              complete : function(xhr, status) {
              }
          });
        }

        const calcularBono = (bloque, base) => {
          
          meses = parseInt($('#'+base+'_mesest').val())
          sueldo = parseFloat($('#'+base+'_sueldo').val())
          constante = 0.1831

          mes12 = parseFloat($('#'+bloque+'_mes12').val()) | 0
          mes01 = parseFloat($('#'+bloque+'_mes01').val()) | 0
          mes02 = parseFloat($('#'+bloque+'_mes02').val()) | 0
          mes03 = parseFloat($('#'+bloque+'_mes03').val()) | 0
          mes04 = parseFloat($('#'+bloque+'_mes04').val()) | 0
          mes05 = parseFloat($('#'+bloque+'_mes05').val()) | 0
          mes06 = parseFloat($('#'+bloque+'_mes06').val()) | 0
          mes07 = parseFloat($('#'+bloque+'_mes07').val()) | 0
          mes08 = parseFloat($('#'+bloque+'_mes08').val()) | 0
          mes09 = parseFloat($('#'+bloque+'_mes09').val()) | 0
          mes10 = parseFloat($('#'+bloque+'_mes10').val()) | 0
          mes11 = parseFloat($('#'+bloque+'_mes11').val()) | 0

          promedio = (mes12+mes01+mes02+mes03+mes04+mes05+mes06+mes07+mes08+mes09+mes10+mes11)/12
          
          total = new Intl.NumberFormat('en-EN', { maximumFractionDigits: 2 }).format((promedio*meses)*constante)

          $('#'+bloque+'_totalbono').val(total)

          console.info("Promedio: ",promedio )
          console.info("Meses: ",meses )
          console.info("Total: ",total )
          
        }

    </script>
</body>
</html>