<?php
	include_once("../modelos/areaModelo.php");
	$objmodelo = new AreaModelo();
	$txt = $objmodelo->buscarAreas();
	echo utf8_encode($txt);
?>
