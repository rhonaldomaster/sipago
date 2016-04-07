<?php
	include_once("../modelos/productoModelo.php");
	$objmodelo = new ProductoModelo();
	$txt = $objmodelo->verEntradasMes($_REQUEST['anio'],$_REQUEST['mes']);
	echo utf8_encode($txt);
?>
