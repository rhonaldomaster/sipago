<?php
	session_start();
	if(!isset($_SESSION['pid'])){
		die("No ha iniciado sesion");
	}
	if(!isset($opcionmenu)) $opcionmenu= $_REQUEST['opcion'];
	switch($opcionmenu){
		case 1:
			include_once("./menu/verMenu.php");
			break;
		case 2:
			include_once("./menu/asignarMenuPerfil.php");
			break;
		case 3:
			include_once("./menu/buscarMenu.php");
			break;
		case 4:
			include_once("./menu/registrarMenu.php");
			break;
		case 5:
			include_once("./menu/desactivarMenu.php");
			break;
		case 6:
			include_once("./menu/actualizarMenu.php");
			break;
		case 7:
			include_once("./menu/menusArea.php");
			break;
		case 8:
			include_once("./menu/menusPerfil.php");
			break;
		case 9:
			include_once("./menu/menusPerfilDiv.php");
			break;
		case 10:
			include_once("./menu/quitarMenuPerfil.php");
			break;
		default:
			die("No se ha especificado ninguna opcion");
			break;
	}
?>
