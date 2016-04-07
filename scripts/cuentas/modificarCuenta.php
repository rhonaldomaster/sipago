<?php
	include_once("../modelos/cuentasModelo.php");
	$objmodelo = new CuentasModelo();
	$texto = $objmodelo->modificarCuenta($_REQUEST['idcuentamod'],$_REQUEST['codcuentamod'],$_REQUEST['nomcuentamod']);
	echo $texto;
?>
