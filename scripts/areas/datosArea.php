<?php
	include_once("../modelos/areaModelo.php");
	$id = $_REQUEST['pid'];
	$nombre = "";
	$activo = "";
	$objmodelo = new AreaModelo();
	$usuarioObj = $objmodelo->buscarPorId($id);
	//echo $nombres." ".$apellidos;
?>
