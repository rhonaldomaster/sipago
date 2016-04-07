<?php
	include_once("../modelos/menuModelo.php");
	$idUsuario = $_SESSION['pid'];
	$objmodelo = new MenuModelo();
	$menutext = $objmodelo->cargarMenuUsuario($idUsuario);
	echo $menutext;
?>
