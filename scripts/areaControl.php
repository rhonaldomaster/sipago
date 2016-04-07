<?php
	session_start();
	if(!isset($_SESSION['pid'])){
		die("No ha iniciado sesion");
	}
	if(!isset($opcionarea)) $opcionarea= $_REQUEST['opcion'];
	switch($opcionarea){
		case 1:
			//include_once("./areas/datosArea.php");
			break;
		case 2:
			include_once("./areas/areaSelect.php");
			break;
		case 3:
			include_once("./areas/buscarAreas.php");
			break;
		case 4:
			//include_once("./areas/buscarAreaPorId.php");
			break;
		case 5:
			include_once("./areas/desactivarArea.php");
			break;
		case 6:
			include_once("./areas/modificarArea.php");
			break;
		case 7:
			include_once("./areas/crearArea.php");
			break;
		case 8:
			include_once("./areas/asignarAreaPerfil.php");
			break;
		default:
			die("No se ha especificado ninguna opcion");
			break;
	}
?>
