<?php
	session_start();
	if(!isset($_SESSION['pid'])){
		die("No ha iniciado sesion");
	}
	if(!isset($opcionusuario)) $opcionusuario= $_REQUEST['opcion'];
	switch($opcionusuario){
		case 1:
			include_once("./usuarios/datosUsuario.php");
			break;
		case 2:
			include_once("./usuarios/tipoIdentificacion.php");
			break;
		case 3:
			include_once("./usuarios/buscarUsuarios.php");
			break;
		case 4:
			include_once("./usuarios/buscarUsuarioPorId.php");
			break;
		case 5:
			include_once("./usuarios/desactivarUsuario.php");
			break;
		case 6:
			include_once("./usuarios/modificarUsuario.php");
			break;
		case 7:
			include_once("./usuarios/crearUsuario.php");
			break;
		case 8:
			include_once("./usuarios/modificarClave.php");
			break;
		case 9:
			include_once("./usuarios/buscarPerfiles.php");
			break;
		case 10:
			include_once("./usuarios/desactivarPerfil.php");
			break;
		case 11:
			include_once("./usuarios/actualizarPerfil.php");
			break;
		case 12:
			include_once("./usuarios/crearPerfil.php");
			break;
		case 13:
			include_once("./usuarios/perfilSelect.php");
			break;
		case 14:
			include_once("./usuarios/asignarPerfil.php");
			break;
		case 15:
			include_once("./usuarios/perfilesUsuarioSelect.php");
			break;
		case 16:
			include_once("./usuarios/quitarPerfil.php");
			break;
		case 17:
			include_once("./usuarios/usuarioSelect.php");
			break;
		default:
			die("No se ha especificado ninguna opcion");
			break;
	}
?>
