<?php
	include_once("../modelos/contabilidadModelo.php");
	$idUsuario = $_SESSION['pid'];
	$objmodelo = new ContabilidadModelo();
	$texto = utf8_decode($objmodelo->verTransaccionesDia($_REQUEST['fecha']));
	echo utf8_encode($texto);
?>
