<?php
	session_start();
	if(!isset($_SESSION['pid'])){
		die("Debe iniciar sesion");
	}
	$opcionmenu=1;
	require_once("./menuControl.php");
?>
