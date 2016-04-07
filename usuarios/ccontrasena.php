<?php
	session_start();
	if(!isset($_SESSION['pid'])){
		header( 'Location: http://'.$_SERVER['SERVER_NAME'].'/sipago/index.php' ) ;
	}
?>
<script>
	function modificarClave(){
		var cl1 = $.trim($("#clave1").val());
		var cl2 = $.trim($("#clave2").val());
		if(cl1!=cl2){
			jAlert("Las contrase\u00F1as no son iguales","Advertencia");
		}
		else{
			$.post("./scripts/usuarioControl.php",{clave:cl1,opcion:8},function(resp){
				jAlert(resp,"Informacion");
			});
		}
	}
</script>
<div>
	<table>
		<tr>
			<td>Escriba nueva contrase&ntilde;a:</td>
			<td><input type="text" id="clave1" required></td>
		</tr>
		<tr>
			<td>Repita nueva contrase&ntilde;a:</td>
			<td><input type="text" id="clave2" required></td>
		</tr>
		<tr>
			<td>
				<input type="button" value="Cambiar" onclick="modificarClave();">
			</td>
		</tr>
	</table>
</div>
