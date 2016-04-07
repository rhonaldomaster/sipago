<?php
	session_start();
	if(!isset($_SESSION['pid'])){
		die("No ha iniciado sesion");
	}
	$id = $_SESSION['pid'];
	$ncl = utf8_decode($_REQUEST['clave']);
	include_once("../modelos/usuarioModelo.php");
	$objmodelo = new UsuarioModelo();
	$txt = $objmodelo->modificarClave($id,$ncl);
	echo $txt;
?>
