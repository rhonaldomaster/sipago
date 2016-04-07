<?php
	session_start();
	if(!isset($_SESSION['pid'])){
		die("No ha iniciado sesion");
	}
	include_once("../modelos/areaModelo.php");
	$objmodelo = new AreaModelo();
	$texto = $objmodelo->modificarArea($_REQUEST['idamod'],utf8_decode($_REQUEST['nomamod']),$_REQUEST['actmod'] );
	echo $texto;
?>
