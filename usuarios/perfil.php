<?php
	session_start();
	if(!isset($_SESSION['pid'])){
		header( 'Location: http://'.$_SERVER['SERVER_NAME'].'/sipago/index.php' ) ;
	}
?>
<script>
	function buscarPerfil(accion){
		$.getJSON("./scripts/usuarioControl.php",{opcion:9},function(data){
			if(data.perfiles[0]!=null){
				var html1 = "<table id='tblcuentas' class='tablesorter' cellspacing='0'>";
				html1 += "<thead><tr><th class='header'>Nombre</th><th class='header'>Activo</th>";
				if(accion==2){
					html1 += "<th class='header'>Acci&oacute;n</th>";
				}
				html1 += "</tr><thead><tbody></tbody><tfoot></tfoot></table>";
				$("#datos").html(html1);
				$.each(data.perfiles, function(i,perfil){
					var html2 = "";
					html2 = "<tr>";
					if(perfil.id==""){
						var cspan = 2;
						if(accion==2){
							cspan=3;
						}
						html2 += "<td colspan='"+cspan+"' style='text-align: center;'>No se encontraron resultados</td>";
					}
					else{
						html2 += "<td>"+perfil.nombre+"</td>";
						html2 += "<td>"+( (perfil.activo==1) ? "S&iacute;":"No")+"</td>";
						if(accion==2){
							html2 += "<td><input type='image' title='Editar' src='./img/icn_edit.png' onclick='editarPerfil("+perfil.id+");' alt='Editar'>";
							html2 += " <input type='image' title='Desactivar' src='./img/icn_trash.png' onclick='desactivarPerfil("+perfil.id+");' alt='Borrar'></td>";
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
	function editarPerfil(idu){
		$("#datos").load("./usuarios/modFormPerf.php?id="+idu);
	}
	function desactivarPerfil(idu){
		var ir = jConfirm("Seguro que desea desactivar este perfil?","Advertencia");
		if(ir==true){
			$.post("./scripts/usuarioControl.php",{id:idu,opcion:10},function(resp){
				jAlert(resp,"Informacion");
				buscarPerfil(2);
			});
		}
	}
	function modificarPerfil(idform){
		var data = $("#"+idform).serialize();
		$.post("./scripts/usuarioControl.php?opcion=11",data,function(resp){
			jAlert(resp,"Informacion");
			buscarPerfil(2);
		});
	}
	function registrarPerfil(idform){
		var data = $("#"+idform).serialize();
		$.post("./scripts/usuarioControl.php?opcion=12",data,function(resp){
			jAlert(resp,"Informacion");
			document.getElementById(idform).reset();
		});
	}
	function listaClientes(idsel){
		$.post("./scripts/usuarioControl.php",{opcion:17},function(resp){
			$("#"+idsel).html(resp);
		});
	}
	function listaClientesDel(idsel,idperf){
		$.post("./scripts/usuarioControl.php",{opcion:17},function(resp){
			$("#"+idsel).html(resp);
			listaPerfilesUsuario(idsel,idperf);
		});
	}
	function listaPerfiles(idsel){
		$.post("./scripts/usuarioControl.php",{opcion:13},function(resp){
			$("#"+idsel).html(resp);
		});
	}
	function asignarPerfil(idform){
		var data = $("#"+idform).serialize();
		$.post("./scripts/usuarioControl.php?opcion=14",data,function(resp){
			jAlert(resp,"Informacion");
			document.getElementById(idform).reset();
		});
	}
	function listaPerfilesUsuario(idselu,idsel){
		$("#"+idsel).html("<option>Buscando</option>");
		var idu = $("#"+idselu+" option:selected").val();
		$.post("./scripts/usuarioControl.php",{opcion:15,id:idu},function(resp){
			$("#"+idsel).html(resp);
		});
	}
	function quitarPerfil(idform){
		var data = $("#"+idform).serialize();
		$.post("./scripts/usuarioControl.php?opcion=16",data,function(resp){
			jAlert(resp,"Informacion");
			document.getElementById(idform).reset();
			listaClientesDel("usuariodel","perfdel");
		});
	}
	$(document).ready(function(){
		activar_tabs();
		buscarPerfil(2);
		listaClientes("usuarioasig");
		listaClientesDel("usuariodel","perfdel");
		listaPerfiles("perfasig");
	});
</script>
<div style="width: 96%">
	<ul class='tabs'>
		<li><a href='#tab1'>Modificar perfil</a></li>
		<li><a href='#tab2'>Crear perfil</a></li>
		<li><a href='#tab3'>Asignar perfil</a></li>
		<li><a href='#tab4'>Quitar perfil</a></li>
	</ul>
	<div class='tab_container'>
		<div id="tab1" class='tab_content'>
			<table>
				<tr>
					<td>
						<input type="button" value="Buscar" onclick="buscarPerfil(2);">
					</td>
				</tr>
			</table>
			<br><br>
			<div id="datos"></div>
		</div><!--tab1-->
		<div id="tab2" class='tab_content'>
			<form id="frminsertp" method="POST" action="">
				<table>
					<tr>
						<td colspan="2">Creaci&oacute;n de perfil</td>
					</tr>
					<tr>
						<td>Nombre(s)</td>
						<td><input type="text" id="nomperfil" name="nomperfil" required></td>
					</tr>
					<tr>
						<td colspan="2" style="text-align: center;">
							<input type="button" value="Enviar" onclick="registrarPerfil('frminsertp');">
							<input type="reset" value="Borrar">
						</td>
					</tr>
				</table>
			</form>
		</div><!--tab2-->
		<div id="tab3" class='tab_content'>
			<form id="frmasigp" method="POST" action="">
				<table>
					<tr>
						<td colspan="2">Asignaci&oacute;n de perfil</td>
					</tr>
					<tr>
						<td>Usuario</td>
						<td><select id="usuarioasig"></select></td>
					</tr>
					<tr>
						<td>Perfil</td>
						<td><select id="perfasig"></select></td>
					</tr>
					<tr>
						<td colspan="2" style="text-align: center;">
							<input type="button" value="Enviar" onclick="asignarPerfil('frmasigp');">
							<input type="reset" value="Borrar">
						</td>
					</tr>
				</table>
			</form>
		</div><!--tab3-->
		<div id="tab4" class='tab_content'>
			<form id="frmasigp" method="POST" action="">
				<table>
					<tr>
						<td colspan="2">Quitar perfil</td>
					</tr>
					<tr>
						<td>Usuario</td>
						<td><select id="usuariodel" onchange="listaPerfilesUsuario(this.id,'perfdel');"></select></td>
					</tr>
					<tr>
						<td>Perfil</td>
						<td><select id="perfdel"></select></td>
					</tr>
					<tr>
						<td colspan="2" style="text-align: center;">
							<input type="button" value="Enviar" onclick="quitarPerfil('frmasigp');">
							<input type="reset" value="Borrar">
						</td>
					</tr>
				</table>
		</div><!--tab4-->
	</div><!--tabcontainer-->
	<div style="clear:both;"></div>
</div>
