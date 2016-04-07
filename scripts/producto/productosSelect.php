<?php
	include_once("../modelos/productoModelo.php");
	$objmodelo = new ProductoModelo();
	$txt = $objmodelo->productosSelect();
	echo utf8_encode($txt);
?>
