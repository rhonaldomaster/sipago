<?php
	session_start();
	require_once('../modelos/usuarioModelo.php');
	if(isset($_SESSION['pid'])){
		echo "ok";
	}
	else{
		$username = utf8_decode($_POST['usuario']);
		$passwd = utf8_decode($_POST['clave']);
		if(strcasecmp($username,"")==0){
			echo "Escriba nombre de usuario ...";
		}
		else{
			$usuario = new UsuarioModelo();
			echo $usuario->verificarLogin($username,$passwd);
		}
	}
?>
