<?php
	session_start();
	if(!isset($_SESSION['pid'])){
		die("No ha iniciado sesion");
	}
	include_once("../modelos/usuarioModelo.php");
	$objmodelo = new UsuarioModelo();
	$texto = $objmodelo->actualizarPerfil($_REQUEST['idumod'],utf8_decode($_REQUEST['nomumod']),$_REQUEST['activoumod']);
	echo $texto;
?>
