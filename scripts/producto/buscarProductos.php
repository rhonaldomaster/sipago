<?php
	include_once("../modelos/productoModelo.php");
	$objmodelo = new ProductoModelo();
	$txt = $objmodelo->buscarProductos();
	echo utf8_encode($txt);
?>
