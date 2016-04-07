<?php
	session_start();
	if(!isset($_SESSION['pid'])){
		die("No ha iniciado sesion");
	}
	include_once("../modelos/productoModelo.php");
	$objmodelo = new ProductoModelo();
	$texto = $objmodelo->modificarProducto($_REQUEST['idamod'],utf8_decode($_REQUEST['nomamod']),$_REQUEST['actmod'] );
	echo $texto;
?>
