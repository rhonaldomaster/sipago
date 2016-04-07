<?php
	session_start();
	if(!isset($_SESSION['pid'])){
		die("No ha iniciado sesion");
	}
	include_once("../modelos/usuarioModelo.php");
	$objmodelo = new UsuarioModelo();
	$texto = $objmodelo->asignarPerfil($_REQUEST['usuarioasig'],$_REQUEST['perfasig']);
	echo $texto;
?>
