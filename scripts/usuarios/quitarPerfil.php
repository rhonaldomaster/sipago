<?php
	session_start();
	if(!isset($_SESSION['pid'])){
		die("No ha iniciado sesion");
	}
	include_once("../modelos/usuarioModelo.php");
	$objmodelo = new UsuarioModelo();
	$texto = $objmodelo->quitarPerfil($_REQUEST['usuariodel'],$_REQUEST['perfdel']);
	echo $texto;
?>
