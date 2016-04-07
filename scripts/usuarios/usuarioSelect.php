<?php
	include_once("../modelos/usuarioModelo.php");
	$idUsuario = $_SESSION['pid'];
	$objmodelo = new UsuarioModelo();
	$menutext = $objmodelo->listadoUsuario_Option();
	echo $menutext;
?>
