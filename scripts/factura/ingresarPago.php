<?php
	include_once("../modelos/facturaModelo.php");
	$objmodelo = new FacturaModelo();
	$rstext = $objmodelo->ingresarPago($_REQUEST['idfact'],$_REQUEST['tipo'],$_REQUEST['valor'],$_REQUEST['idcuenta'],$_REQUEST['numsoporte'],$_REQUEST['fechapago'],$_REQUEST['tiposoporte']);
	echo $rstext;
?>
