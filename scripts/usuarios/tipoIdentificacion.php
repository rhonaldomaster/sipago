<?php
	include_once("../modelos/usuarioModelo.php");
	$nombres = "";
	$apellidos = "";
	$objmodelo = new UsuarioModelo();
	$txt = $objmodelo->tipoIdentificacion_Option();
	echo $txt;
?>
