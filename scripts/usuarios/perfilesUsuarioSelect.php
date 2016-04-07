<?php
	include_once("../modelos/usuarioModelo.php");
	$idUsuario = $_SESSION['pid'];
	$objmodelo = new UsuarioModelo();
	$menutext = $objmodelo->listadoPerfilesUsuario_Option($_REQUEST['id']);
	echo $menutext;
?>
