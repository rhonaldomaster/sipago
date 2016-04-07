<?php
	include_once("../modelos/productoModelo.php");
	$objmodelo = new ProductoModelo();
	$txt = $objmodelo->verSalidasMes($_REQUEST['anio'],$_REQUEST['mes']);
	echo utf8_encode($txt);
?>
