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
	$texto = utf8_encode($objmodelo->datosPerfil($id));
	$aspl = explode("|",$texto);
	
	$nombre = $aspl[0];
	$activo = $aspl[1];
?>
<div>
	<form id="fmodperfil" method="POST" action="">
		<input type="hidden" id="idumod" name="idumod" value="<?php echo $id; ?>">
		<table>
			<tr>
				<th colspan="4" style="text-align: center;">
					Modificar perfil
				</th>
			</tr>
			<tr>
				<td>Nombre</td>
				<td><input type="text" id="nomumod" name="nomumod" value="<?php echo $nombre; ?>"></td>
				<td>Activo</td>
				<td>
					<select id="activoumod" name="activoumod">
						<option value="0"<?php if($activo==0) echo " selected"; ?>>Inactivo</option>
						<option value="1"<?php if($activo==1) echo " selected"; ?>>Activo</option>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="4" style="text-align: center;">
					<input type="button" value="Enviar" onclick="modificarPerfil('fmodperfil');">
				</td>
			</tr>
		</table>
	</form>
</div>
