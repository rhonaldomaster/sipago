<?php
	include_once("../modelos/clienteModelo.php");
	$idUsuario = $_SESSION['pid'];
	$objmodelo = new ClienteModelo();
	$menutext = $objmodelo->modificarCliente(
		$_REQUEST['idcli'],$_REQUEST['tipoid'],$_REQUEST['identificacion']
		,$_REQUEST['nombrecli'],$_REQUEST['apellidocli'],$_REQUEST['dircli']
		,$_REQUEST['telcli'],$_REQUEST['pob']
	);
	echo $menutext;
?>
