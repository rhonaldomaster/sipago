<?php
	session_start();
	if(!isset($_SESSION['pid'])){
		header( 'Location: http://'.$_SERVER['SERVER_NAME'].'/sipago/index.php' ) ;
	}
	if(!isset($_REQUEST['id'])){
		die("Proporcione la informacion necesaria para continuar");
	}
	$id = $_REQUEST['id'];
	include_once("../modelos/usuarioModelo.php");
	$objmodelo = new UsuarioModelo();
	$texto = utf8_encode($objmodelo->buscarUsuarioPorId($id));
	$aspl = explode("|",$texto);
	$tipoid = $aspl[0];
	$identif = $aspl[1];
	$nombre = $aspl[2];
	$apellido = $aspl[3];
	$telefono = $aspl[4];
	$direccion = $aspl[5];
	$email = $aspl[6];
	$username = $aspl[7];
?>
<script>
	function tipoIdentificacion2(idsel){
		$.post("./scripts/usuarioControl.php",{opcion:2},function(resp){
			$("#"+idsel).html(resp);
			var v = setTimeout(function(){$("#"+idsel+" option[value=<?php echo $tipoid; ?>]").prop("selected","selected");},200);
		});
	}
	$(document).ready(function(){
		tipoIdentificacion2("tipoididentumod");
	});
</script>
<div>
	<form id="fmodusuario" method="POST" action="">
		<input type="hidden" id="idumod" name="idumod" value="<?php echo $id; ?>">
		<table>
			<tr>
				<th colspan="4" style="text-align: center;">
					Modificar usuario
				</th>
			</tr>
			<tr>
				<td>Tipo Identificacion</td>
				<td><select id="tipoididentumod" name="tipoididentumod"></select></td>
				<td>Identificacion</td>
				<td><input type="text" id="identumod" name="identumod" value="<?php echo $identif; ?>"></td>
			</tr>
			<tr>
				<td>Nombres</td>
				<td><input type="text" id="nomumod" name="nomumod" value="<?php echo $nombre; ?>"></td>
				<td>Apellidos</td>
				<td><input type="text" id="apeumod" name="apeumod" value="<?php echo $apellido; ?>"></td>
			</tr>
			<tr>
				<td>Telefono</td>
				<td><input type="text" id="telumod" name="telumod" value="<?php echo $telefono; ?>"></td>
				<td>Direccion</td>
				<td><input type="text" id="dirumod" name="dirumod" value="<?php echo $direccion; ?>"></td>
			</tr>
			<tr>
				<td>Email</td>
				<td><input type="text" id="emailumod" name="emailumod" value="<?php echo $email; ?>"></td>
				<td>Username</td>
				<td><input type="text" id="usernameumod" name="usernameumod" value="<?php echo $username; ?>"></td>
			</tr>
			<tr>
				<td colspan="4" style="text-align: center;">
					<input type="button" value="Enviar" onclick="modificarUsuario('fmodusuario');">
				</td>
			</tr>
		</table>
	</form>
</div>
