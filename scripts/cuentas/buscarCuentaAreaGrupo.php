<?php
	include_once("../modelos/cuentasModelo.php");
	$idUsuario = $_SESSION['pid'];
	$objmodelo = new CuentasModelo();
	$texto = $objmodelo->buscarCuentasPorAreaYGrupo($_REQUEST['idarea'],$_REQUEST['idsub']);
	echo utf8_encode($texto);
?>
