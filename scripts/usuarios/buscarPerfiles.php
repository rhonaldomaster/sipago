<?php
	include_once("../modelos/usuarioModelo.php");
	$objmodelo = new UsuarioModelo();
	$txt = $objmodelo->buscarPerfiles();
	echo utf8_encode($txt);
?>
