<?php
	session_start();
	if(!isset($_SESSION['pid'])){
		header( 'Location: http://'.$_SERVER['SERVER_NAME'].'/sipago/index.php' ) ;
	}
?>
<script>
	function buscarAreas(accion){
		$.getJSON("./scripts/areaControl.php",{opcion:3},function(data){
			if(data.areas[0]!=null){
				var html1 = "<table id='tblcuentas' class='tablesorter' cellspacing='0'>";
				html1 += "<thead><tr><th class='header'>Nombres</th><th class='header'>Activo</th>";
				if(accion==2){
					html1 += "<th class='header'>Acci&oacute;n</th>";
				}
				html1 += "</tr><thead><tbody></tbody><tfoot></tfoot></table>";
				$("#datos").html(html1);
				$.each(data.areas, function(i,area){
					var html2 = "";
					html2 = "<tr>";
					if(area.id==""){
						var cspan = 2;
						if(accion==2){
							cspan=3;
						}
						html2 += "<td colspan='"+cspan+"' style='text-align: center;'>No se encontraron resultados</td>";
					}
					else{
						html2 += "<td>"+area.nombre+"</td>";
						html2 += "<td>"+( (area.activo==1) ? "S&iacute;":"No")+"</td>";
						if(accion==2){
							html2 += "<td><input type='image' title='Editar' src='./img/icn_edit.png' onclick='editarArea("+area.id+");' alt='Editar'>";
							html2 += " <input type='image' title='Desactivar' src='./img/icn_trash.png' onclick='desactivarArea("+area.id+");' alt='Borrar'></td>";
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
	function editarArea(idu){
		$("#datos").load("./sistema/modFormArea.php?id="+idu);
	}
	function desactivarArea(idu){
		var ir = jConfirm("Seguro que desea desactivar este area?","Advertencia");
		if(ir==true){
			$.post("./scripts/areaControl.php",{id:idu,opcion:5},function(resp){
				jAlert(resp,"Informacion");
				buscarAreas(2);
			});
		}
	}
	function modificarArea(idform){
		var data = $("#"+idform).serialize();
		$.post("./scripts/areaControl.php?opcion=6",data,function(resp){
			jAlert(resp,"Informacion");
			buscarAreas(2);
		});
	}
	function registrarArea(idform){
		var data = $("#"+idform).serialize();
		$.post("./scripts/areaControl.php?opcion=7",data,function(resp){
			jAlert(resp,"Informacion");
			document.getElementById(idform).reset();
		});
	}
	function listaPerfiles(idsel){
		$.post("./scripts/usuarioControl.php",{opcion:13},function(resp){
			$("#"+idsel).html(resp);
		});
	}
	function listaAreas(idsel){
		$.post("./scripts/areaControl.php",{opcion:2},function(resp){
			$("#"+idsel).html(resp);
		});
	}
	function asignarAreaPerfil(idform){
		var data = $("#"+idform).serialize();
		$.post("./scripts/areaControl.php?opcion=8",data,function(resp){
			jAlert(resp,"Informacion");
			document.getElementById(idform).reset();
		});
	}
	$(document).ready(function(){
		activar_tabs();
		buscarAreas(2);
		listaPerfiles("idperf");
		listaAreas("idarea");//07010885
	});
</script>
<div style="width: 96%">
	<ul class='tabs'>
		<li><a href='#tab1'>Modificar area</a></li>
		<li><a href='#tab2'>Crear area</a></li>
		<li><a href='#tab3'>Asignar area - perfil</a></li>
	</ul>
	<div class='tab_container'>
		<div id="tab1" class='tab_content'>
			<table>
				<tr>
					<td>
						<input type="button" value="Buscar" onclick="buscarAreas(2);">
					</td>
				</tr>
			</table>
			<br><br>
			<div id="datos"></div>
		</div><!--tab1-->
		<div id="tab2" class='tab_content'>
			<form id="frminserta" method="POST" action="">
				<table>
					<tr>
						<td colspan="2">Creaci&oacute;n de area</td>
					</tr>
					<tr>
						<td>Nombre</td>
						<td><input type="text" id="nomarea" name="nomarea" required></td>
					</tr>
					<tr>
						<td colspan="2" style="text-align: center;">
							<input type="button" value="Enviar" onclick="registrarArea('frminserta');">
							<input type="reset" value="Borrar">
						</td>
					</tr>
				</table>
			</form>
		</div><!--tab2-->
		<div id="tab3" class='tab_content'>
			<form id="frmareaperf" method="POST" action="">
				<table>
					<tr>
						<td colspan="2">Asignaci&oacute;n de area - perfil</td>
					</tr>
					<tr>
						<td>Area</td>
						<td><select id="idarea" name="idarea"></select></td>
					</tr>
					<tr>
						<td>Perfil</td>
						<td><select id="idperf" name="idperf"></select></td>
					</tr>
					<tr>
						<td colspan="2" style="text-align: center;">
							<input type="button" value="Enviar" onclick="asignarAreaPerfil('frmareaperf');">
							<input type="reset" value="Borrar">
						</td>
					</tr>
				</table>
			</form>
		</div><!--tab3-->
	</div><!--tabcontainer-->
	<div style="clear:both;"></div>
</div>
