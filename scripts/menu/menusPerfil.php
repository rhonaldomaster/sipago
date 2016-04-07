<?php
	include_once("../modelos/menuModelo.php");
	$idUsuario = $_SESSION['pid'];
	$objmodelo = new MenuModelo();
	$menutext = $objmodelo->buscarMenusPerfil($_REQUEST['id']);
	echo $menutext;
?>
