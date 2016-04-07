<?php
	session_start();
	if(!isset($_SESSION['pid'])){
		die("No ha iniciado sesion");
	}
	include_once("../modelos/productoModelo.php");
	$objmodelo = new ProductoModelo();
	$texto = $objmodelo->crearProdcuto(utf8_decode($_REQUEST['nomamod']));
	echo $texto;
?>
