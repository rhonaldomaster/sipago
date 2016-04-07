<?php
	include_once("../modelos/usuarioModelo.php");
	$idUsuario = $_SESSION['pid'];
	$nombres = "";
	$apellidos = "";
	$objmodelo = new UsuarioModelo();
	$usuarioObj = $objmodelo->buscarPorId($idUsuario);
	$nombres = $usuarioObj->getNombres();
	$apellidos = $usuarioObj->getApellidos();
	$_SESSION['nombreusuario'] = $nombres." ".$apellidos;
	//echo $nombres." ".$apellidos;
?>
