<?php
	include_once("../modelos/productoModelo.php");
	$objmodelo = new ProductoModelo();
	$txt = $objmodelo->buscarProductosInv();
	echo utf8_encode($txt);
?>
