<?php
	session_start();
	if(!isset($_SESSION['pid'])){
		die("No ha iniciado sesion");
	}
	$opcionusuario = $_REQUEST['opcion'];
	switch($opcionusuario){
		case 1:
			include_once("./cuentas/areasSelect.php");
			break;
		case 2:
			include_once("./cuentas/subgruposSelect.php");
			break;
		case 3:
			include_once("./cuentas/insertarCuenta.php");
			break;
		case 4:
			include_once("./cuentas/buscarCuentaAreaGrupo.php");
			break;
		case 5:
			include_once("./cuentas/desactivarCuenta.php");
			break;
		case 6:
			include_once("./cuentas/modificarCuenta.php");
			break;
		case 7:
			include_once("./cuentas/cuentasAreaGrupoSelect.php");
			break;
		default:
			die("No se ha especificado ninguna opcion");
			break;
	}
?>
