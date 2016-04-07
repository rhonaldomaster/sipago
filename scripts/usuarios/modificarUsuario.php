<?php
	session_start();
	if(!isset($_SESSION['pid'])){
		die("No ha iniciado sesion");
	}
	include_once("../modelos/usuarioModelo.php");
	$objmodelo = new UsuarioModelo();
	$texto = $objmodelo->modificarUsuario(
		$_REQUEST['idumod'],$_REQUEST['tipoididentumod']
		,$_REQUEST['identumod'],utf8_decode($_REQUEST['nomumod']),utf8_decode($_REQUEST['apeumod']),utf8_decode($_REQUEST['telumod'])
		,utf8_decode($_REQUEST['dirumod']),utf8_decode($_REQUEST['emailumod']),utf8_decode($_REQUEST['usernameumod'])
	);
	echo $texto;
?>
