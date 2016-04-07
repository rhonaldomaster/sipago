<?php
	include_once("../modelos/facturaModelo.php");
	$objmodelo = new FacturaModelo();
	$rstext = $objmodelo->verFacturasPorPagar();
	echo utf8_decode($rstext);
?>
