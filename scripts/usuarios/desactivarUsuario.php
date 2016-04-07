<?php
	include_once("../modelos/usuarioModelo.php");
	$objmodelo = new UsuarioModelo();
	$menutext = $objmodelo->desactivarUsuario($_REQUEST['id']);
	echo $menutext;
?>
