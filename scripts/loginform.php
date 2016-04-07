<script>
	$(document).ready(function() {
		$("#usuario").focus();
	});
</script>
<div class="spacer"></div>
<div id="logindiv">
	<form id="formlogin" method="post" action="">
		<fieldset>
			<legend>Acceso al sistema</legend>
			<table style="text-align: center; width: 100%;">
				<tbody>
					<tr>
						<td>
							Usuario:
						</td>
						<td>
							<input type="text" id="usuario" name="usuario" placeholder="Usuario" required>
						</td>
					</tr>
					<tr>
						<td>
							Contrase&ntilde;a:
						</td>
						<td>
							<input type="password" id="clave" name="clave" placeholder="Contrase&ntilde;a">
						</td>
					</tr>
					<tr>
						<td colspan="2" style="text-align: center;">
							<br>
							<input type="button" value="Acceder" onclick="login();">
							&nbsp;
							<input type="reset" value="Borrar">
						</td>
					</tr>
				</tbody>
			</table>
		</fieldset>
	</form>
</div>
