<?php
	include_once("../modelos/menuModelo.php");
	$idUsuario = $_SESSION['pid'];
	$objmodelo = new MenuModelo();
	$menutext = $objmodelo->quitarMenuPerfil($_REQUEST['perfmdel'],$_REQUEST['menumdel']);
	echo $menutext;
?>
