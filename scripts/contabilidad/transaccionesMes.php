<?php
	include_once("../modelos/contabilidadModelo.php");
	$idUsuario = $_SESSION['pid'];
	$objmodelo = new ContabilidadModelo();
	$mesd = ($_REQUEST['mes']*1 < 10) ? "0".$_REQUEST['mes'] : $_REQUEST['mes'];
	$texto = utf8_decode($objmodelo->verTransaccionesMes($_REQUEST['anio'],$mesd));
	echo utf8_encode($texto);
?>
