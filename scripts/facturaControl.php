<?php
	session_start();
	if(!isset($_SESSION['pid'])){
		die("No ha iniciado sesion");
	}
	$opcionusuario = $_REQUEST['opcion'];
	switch($opcionusuario){
		case 1:
			include_once("./factura/ingresarFactura.php");
			break;
		case 2:
			include_once("./factura/verFacturasCliente.php");
			break;
		case 3:
			include_once("./factura/verFacturasPorPagar.php");
			break;
		case 4:
			include_once("./factura/verDetallesFactura.php");
			break;
		case 5:
			include_once("./factura/facturasClienteAcreedorOption.php");
			break;
		case 6:
			include_once("./factura/ingresarPago.php");
			break;
		case 7:
			include_once("./factura/tipoComprobanteSelect.php");
			break;
		case 8:
			include_once("./factura/tipoSoporteSelect.php");
			break;
		default:
			die("No se ha especificado ninguna opcion");
			break;
	}
?>
