<?php
	session_start();
	if(!isset($_SESSION['pid'])){
		die("No ha iniciado sesion");
	}
	include_once("../modelos/usuarioModelo.php");
	$objmodelo = new UsuarioModelo();
	$texto = $objmodelo->crearUsuario(
		$_REQUEST['tipoidusuario'],$_REQUEST['identifusuario'],utf8_decode($_REQUEST['nomusuario'])
		,utf8_decode($_REQUEST['apusuario']),utf8_decode($_REQUEST['telusuario'])
		,utf8_decode($_REQUEST['dirusuario']),utf8_decode($_REQUEST['emailusuario'])
		,utf8_decode($_REQUEST['usrusuario']),md5(utf8_decode($_REQUEST['clausuario']))
	);
	echo $texto;
?>
