<?php
	session_start();
	if(!isset($_SESSION['pid'])){
		die("No ha iniciado sesion");
	}
	$opcionmenu= $_REQUEST['opcion'];
	switch($opcionmenu){
		case 1:
			include_once("./contabilidad/transaccionesDia.php");
			break;
		case 2:
			include_once("./contabilidad/transaccionesMes.php");
			break;
		case 3:
			include_once("./contabilidad/.php");
			break;
		default:
			die("No se ha especificado ninguna opcion");
			break;
	}
?>
