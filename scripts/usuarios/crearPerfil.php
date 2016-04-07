<?php
	include_once("../modelos/usuarioModelo.php");
	$objmodelo = new UsuarioModelo();
	$txt = $objmodelo->crearPerfil($_REQUEST['nomperfil']]);
	echo utf8_encode($txt);
?>
