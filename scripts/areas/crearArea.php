<?php
	session_start();
	if(!isset($_SESSION['pid'])){
		die("No ha iniciado sesion");
	}
	include_once("../modelos/areaModelo.php");
	$objmodelo = new AreaModelo();
	$texto = $objmodelo->crearArea(utf8_decode($_REQUEST['nomarea']));
	echo $texto;
?>
