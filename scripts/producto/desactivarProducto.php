<?php
	include_once("../modelos/productoModelo.php");
	$objmodelo = new ProductoModelo();
	$txt = $objmodelo->desactivarProducto($_REQUEST['id']);
	echo utf8_encode($txt);
?>
