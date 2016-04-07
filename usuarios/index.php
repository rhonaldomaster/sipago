<?php
	session_start();
	if(!isset($_SESSION['pid'])){
		header( 'Location: http://'.$_SERVER['SERVER_NAME'].'/sipago/index.php' ) ;
	}
?>
<script>
	function tipoIdentificacion(idsel){
		$.post("./scripts/usuarioControl.php",{opcion:2},function(resp){
			$("#"+idsel).html(resp);
		});
	}
	function buscarUsuarios(accion){
		$.getJSON("./scripts/usuarioControl.php",{opcion:3},function(data){
			if(data.usuarios[0]!=null){
				var html1 = "<table id='tblcuentas' class='tablesorter' cellspacing='0'>";
				html1 += "<thead><tr><th class='header'>Identificacion</th><th class='header'>Nombres</th><th class='header'>Apellidos</th><th class='header'>Activo</th>";
				if(accion==2){
					html1 += "<th class='header'>Acci&oacute;n</th>";
				}
				html1 += "</tr><thead><tbody></tbody><tfoot></tfoot></table>";
				$("#datos").html(html1);
				$.each(data.usuarios, function(i,usuario){
					var html2 = "";
					html2 = "<tr>";
					if(usuario.id==""){
						var cspan = 4;
						if(accion==2){
							cspan=5;
						}
						html2 += "<td colspan='"+cspan+"' style='text-align: center;'>No se encontraron resultados</td>";
					}
					else{
						html2 += "<td>"+usuario.identificacion+"</td>";
						html2 += "<td>"+usuario.nombres+"</td>";
						html2 += "<td>"+usuario.apellidos+"</td>";
						html2 += "<td>"+( (usuario.activo==1) ? "S&iacute;":"No")+"</td>";
						if(accion==2){
							html2 += "<td><input type='image' title='Editar' src='./img/icn_edit.png' onclick='editarUsuario("+usuario.id+");' alt='Editar'>";
							html2 += " <input type='image' title='Desactivar' src='./img/icn_trash.png' onclick='desactivarUsuario("+usuario.id+");' alt='Borrar'></td>";
						}
					}
					html2 += "</tr>";
					$("#tblcuentas tbody").append(html2);
					$(".tablesorter").tablesorter();
				});
			}
			else{
				jAlert("Ocurri\u00F3 un problema al obtener los datos","Error");
			}
		});
	}
	function editarUsuario(idu){
		$("#datos").load("./usuarios/modForm.php?id="+idu);
	}
	function desactivarUsuario(idu){
		var ir = jConfirm("Seguro que desea desactivar este usuario?","Advertencia");
		if(ir==true){
			$.post("./scripts/usuarioControl.php",{id:idu,opcion:5},function(resp){
				jAlert(resp,"Informacion");
				buscarUsuarios(2);
			});
		}
	}
	function modificarUsuario(idform){
		var data = $("#"+idform).serialize();
		$.post("./scripts/usuarioControl.php?opcion=6",data,function(resp){
			jAlert(resp,"Informacion");
			buscarUsuarios(2);
		});
	}
	function registrarUsuario(idform){
		var data = $("#"+idform).serialize();
		$.post("./scripts/usuarioControl.php?opcion=7",data,function(resp){
			jAlert(resp,"Informacion");
			document.getElementById(idform).reset();
		});
	}
	$(document).ready(function(){
		activar_tabs();
		tipoIdentificacion("tipoidusuario");
		buscarUsuarios(2);
	});
</script>
<div style="width: 96%">
	<ul class='tabs'>
		<li><a href='#tab1'>Modificar usuario</a></li>
		<li><a href='#tab2'>Crear usuario</a></li>
	</ul>
	<div class='tab_container'>
		<div id="tab1" class='tab_content'>
			<table>
				<tr>
					<td>
						<input type="button" value="Buscar" onclick="buscarUsuarios(2);">
					</td>
				</tr>
			</table>
			<br><br>
			<div id="datos"></div>
		</div><!--tab1-->
		<div id="tab2" class='tab_content'>
			<form id="frminsertu" method="POST" action="">
				<table>
					<tr>
						<td colspan="2">Creaci&oacute;n de usuario</td>
					</tr>
					<tr>
						<td>Tipo Identificacion</td>
						<td><select id="tipoidusuario" name="tipoidusuario"></select></td>
					</tr>
					<tr>
						<td>Identificacion</td>
						<td><input type="text" id="identifusuario" name="identifusuario" required></td>
					</tr>
					<tr>
						<td>Nombre(s)</td>
						<td><input type="text" id="nomusuario" name="nomusuario" required></td>
					</tr>
					<tr>
						<td>Apellido(s)</td>
						<td><input type="text" id="apusuario" name="apusuario" required></td>
					</tr>
					<tr>
						<td>Telefono</td>
						<td><input type="text" id="telusuario" name="telusuario"></td>
					</tr>
					<tr>
						<td>Email</td>
						<td><input type="text" id="emailusuario" name="emailusuario"></td>
					</tr>
					<tr>
						<td>Username</td>
						<td><input type="text" id="usrusuario" name="usrusuario" required></td>
					</tr>
					<tr>
						<td>Contrase&ntilde;a</td>
						<td><input type="password" id="clausuario" name="clausuario"></td>
					</tr>
					<tr>
						<td colspan="2" style="text-align: center;">
							<input type="button" value="Enviar" onclick="registrarUsuario('frminsertu');">
							<input type="reset" value="Borrar">
						</td>
					</tr>
				</table>
			</form>
		</div><!--tab2-->
	</div><!--tabcontainer-->
	<div style="clear:both;"></div>
</div>
