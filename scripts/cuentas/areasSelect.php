<?php
	include_once("../modelos/cuentasModelo.php");
	$idUsuario = $_SESSION['pid'];
	$objmodelo = new CuentasModelo();
	$menutext = $objmodelo->areasPUC_Option();
	echo $menutext;
?>
