<?php
	include_once("../modelos/menuModelo.php");
	$idUsuario = $_SESSION['pid'];
	$objmodelo = new MenuModelo();
	$menutext = $objmodelo->actualizarMenu($_REQUEST['idmenumod'],$_REQUEST['idaream'],$_REQUEST['nomenum'],$_REQUEST['linkmenum']);
	echo $menutext;
?>
