<?php
	include_once("../modelos/facturaModelo.php");
	$objmodelo = new FacturaModelo();
	$rstext = $objmodelo->facturasClienteAcreedorOption($_REQUEST['tipo'],$_REQUEST['idcl']);
	echo utf8_decode($rstext);
?>
