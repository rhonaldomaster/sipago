<?php
	session_start();
	if(!isset($_SESSION['pid'])){
		die("No ha iniciado sesion");
	}
	$opcionarea= $_REQUEST['opcion'];
	switch($opcionarea){
		case 1:
			//include_once("./producto/datosProducto.php");
			break;
		case 2:
			include_once("./producto/buscaProdInv.php");
			break;
		case 3:
			include_once("./producto/buscarProductos.php");
			break;
		case 4:
			//include_once("./producto/buscarProductoPorId.php");
			break;
		case 5:
			include_once("./producto/desactivarProducto.php");
			break;
		case 6:
			include_once("./producto/modificarProducto.php");
			break;
		case 7:
			include_once("./producto/crearProducto.php");
			break;
		case 8:
			include_once("./producto/salidasMes.php");
			break;
		case 9:
			include_once("./producto/entradasMes.php");
			break;
		case 10:
			include_once("./producto/productosSelect.php");
			break;
		default:
			die("No se ha especificado ninguna opcion");
			break;
	}
?>
