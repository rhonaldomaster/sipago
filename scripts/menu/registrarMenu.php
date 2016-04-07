<?php
	include_once("../modelos/menuModelo.php");
	$idUsuario = $_SESSION['pid'];
	$objmodelo = new MenuModelo();
	$menutext = $objmodelo->registrarMenu($_REQUEST['idarea'],$_REQUEST['nomenu'],$_REQUEST['linkmenu']);
	echo $menutext;
?>
