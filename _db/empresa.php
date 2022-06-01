<?php
require_once 'nomina.php';
$empresa = buscar_empresa_ruc($_GET['dni']);
echo json_encode($empresa);