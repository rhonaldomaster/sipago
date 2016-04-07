<?php
	include_once("../modelos/usuarioModelo.php");
	$idUsuario = $_SESSION['pid'];
	$objmodelo = new UsuarioModelo();
	$menutext = $objmodelo->listadoPerfiles_Option();
	echo $menutext;
?>
