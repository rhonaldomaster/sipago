<?php
	include_once("../modelos/facturaModelo.php");
	$objmodelo = new FacturaModelo();
	$rstext = $objmodelo->tipoSoporteSelect();
	echo $rstext;
?>
