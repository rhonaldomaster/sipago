<?php
	session_start();
	if(!isset($_SESSION['pid'])){
		die("No ha iniciado sesion");
	}
	$opcionusuario = $_REQUEST['opcion'];
	switch($opcionusuario){
		case 1:
			include_once("./cliente/clienteSelect.php");
			break;
		case 2:
			include_once("./cliente/ingresarCliente.php");
			break;
		case 3:
			include_once("./cliente/clienteTipoSelect.php");
			break;
		case 4:
			include_once("./cliente/buscarClientes.php");
			break;
		case 5:
			include_once("./cliente/modificarCliente.php");
			break;
		case 6:
			include_once("./cliente/desactivarCliente.php");
			break;
		case 7:
			include_once("./cliente/registrarCliente.php");
			break;
		case 8:
			include_once("./cliente/tipoIdOption.php");
			break;
		case 9:
			include_once("./cliente/departamentosOption.php");
			break;
		case 10:
			include_once("./cliente/poblacionesOption.php");
			break;
		case 11:
			include_once("./cliente/departamentosOptionSel.php");
			break;
		case 12:
			include_once("./cliente/poblacionesOptionSel.php");
			break;
		default:
			die("No se ha especificado ninguna opcion");
			break;
	}
?>
