<?php
	include_once("../modelos/cuentasModelo.php");
	$idUsuario = $_SESSION['pid'];
	$objmodelo = new CuentasModelo();
	$menutext = $objmodelo->ingresarCuenta($_REQUEST['idarea'],$_REQUEST['idgrupo'],$_REQUEST['codigo'],$_REQUEST['nombre']);
	echo $menutext;
?>
