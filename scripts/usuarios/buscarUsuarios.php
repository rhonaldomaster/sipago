<?php
	include_once("../modelos/usuarioModelo.php");
	$objmodelo = new UsuarioModelo();
	$txt = $objmodelo->buscarUsuarios();
	echo utf8_encode($txt);
?>
