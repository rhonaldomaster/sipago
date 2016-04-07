<?php
	include_once("../modelos/cuentasModelo.php");
	$objmodelo = new CuentasModelo();
	$menutext = $objmodelo->desactivarCuenta($_REQUEST['id']);
	echo $menutext;
?>
