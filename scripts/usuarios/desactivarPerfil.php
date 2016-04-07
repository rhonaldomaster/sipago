<?php
	include_once("../modelos/usuarioModelo.php");
	$objmodelo = new UsuarioModelo();
	$txt = $objmodelo->desactivarPerfil($_REQUEST['id']);
	echo utf8_encode($txt);
?>
