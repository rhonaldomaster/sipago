<?php
	include_once("../modelos/cuentasModelo.php");
	$idUsuario = $_SESSION['pid'];
	$objmodelo = new CuentasModelo();
	$menutext = $objmodelo->subgruposPUC_Option($_REQUEST['idarea']);
	echo $menutext;
?>
