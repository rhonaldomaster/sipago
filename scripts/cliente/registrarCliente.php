<?php
	include_once("../modelos/clienteModelo.php");
	$idUsuario = $_SESSION['pid'];
	$objmodelo = new ClienteModelo();
	$menutext = $objmodelo->ingresarCliente(
		$_REQUEST['nombrecli'],$_REQUEST['apellidocli'],$_REQUEST['identificacion'],$_REQUEST['tipoid']
		,$_REQUEST['dircli'],$_REQUEST['telcli'],$_REQUEST['pob']
	);
	echo $menutext;
?>
