<?php
	session_start();
	if(!isset($_SESSION['pid'])){
		header( 'Location: http://'.$_SERVER['SERVER_NAME'].'/sipago/index.php' ) ;
	}
?>
<script>
	function buscarMenu(accion){
		$.getJSON("./scripts/menuControl.php",{opcion:3},function(data){
			if(data.menus[0]!=null){
				var html1 = "<table id='tblcuentas' class='tablesorter' cellspacing='0'>";
				html1 += "<thead><tr><th class='header'>Nombre</th><th class='header'>Area</th><th class='header'>Activo</th>";
				if(accion==2){
					html1 += "<th class='header'>Acci&oacute;n</th>";
				}
				html1 += "</tr><thead><tbody></tbody><tfoot></tfoot></table>";
				$("#datos").html(html1);
				$.each(data.menus, function(i,menu){
					var html2 = "";
					html2 = "<tr>";
					if(menu.id==""){
						var cspan = 3;
						if(accion==2){
							cspan=4;
						}
						html2 += "<td colspan='"+cspan+"' style='text-align: center;'>No se encontraron resultados</td>";
					}
					else{
						html2 += "<td>"+menu.nombre+"</td>";
						html2 += "<td>"+menu.nombrea+"</td>";
						html2 += "<td>"+( (menu.activo==1) ? "S&iacute;":"No")+"</td>";
						if(accion==2){
							html2 += "<td><input type='image' title='Editar' src='./img/icn_edit.png' onclick='editarMenu("+menu.id+");' alt='Editar'>";
							html2 += " <input type='image' title='Desactivar' src='./img/icn_trash.png' onclick='desactivarMenu("+menu.id+");' alt='Borrar'></td>";
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
	function registrarMenu(idform){
		var data = $("#"+idform).serialize();
		$.post("./scripts/menuControl.php?opcion=4",data,function(resp){
			jAlert(resp,"Informacion");
			document.getElementById(idform).reset();
		});
	}
	function editarMenu(idu){
		$("#datos").load("./sistema/modFormMenu.php?id="+idu);
	}
	function desactivarMenu(idu){
		var ir = jConfirm("Seguro que desea desactivar este area?","Advertencia");
		if(ir==true){
			$.post("./scripts/menuControl.php",{id:idu,opcion:5},function(resp){
				jAlert(resp,"Informacion");
				buscarAreas(2);
			});
		}
	}
	function modificarMenu(idform){
		var data = $("#"+idform).serialize();
		$.post("./scripts/menuControl.php?opcion=6",data,function(resp){
			jAlert(resp,"Informacion");
			buscarMenu(2);
		});
	}
	function listaAreas(idsel){
		$.post("./scripts/areaControl.php",{opcion:2},function(resp){
			$("#"+idsel).html(resp);
		});
	}
	function listaPerfiles(idsel){
		$.post("./scripts/usuarioControl.php",{opcion:13},function(resp){
			$("#"+idsel).html(resp);
		});
	}
	function listaAreas2(idsel,idmen){
		$.post("./scripts/areaControl.php",{opcion:2},function(resp){
			$("#"+idsel).html(resp);
			cargarMenusArea(idsel,idmen);
		});
	}
	function listaPerfiles2(idsel,idmen){
		$.post("./scripts/usuarioControl.php",{opcion:13},function(resp){
			$("#"+idsel).html(resp);
			listaMenusPerfil(idsel,idmen);
		});
	}
	function listaPerfiles3(idsel,iddiv){
		$.post("./scripts/usuarioControl.php",{opcion:13},function(resp){
			$("#"+idsel).html(resp);
			listaMenusPerfilDiv(idsel,iddiv);
		});
	}
	function cargarMenusArea(idsel,idselm){
		var idarea = $("#"+idsel+" option:selected").val();
		$.post("./scripts/menuControl.php",{opcion:7,id:idarea},function(resp){
			$("#"+idselm).html(resp);
		});
	}
	function listaMenusPerfil(idsel,idselmen){
		var idperf = $("#"+idsel+" option:selected").val();
		$.post("./scripts/menuControl.php",{opcion:8,id:idperf},function(resp){
			$("#"+idselmen).html(resp);
		});
	}
	function listaMenusPerfilDiv(idsel,iddiv){
		var idperf = $("#"+idsel+" option:selected").val();
		$.post("./scripts/menuControl.php",{opcion:9,id:idperf},function(resp){
			$("#"+iddiv).html(resp);
		});
	}
	function listaAreasSel(idsel,val){
		$.post("./scripts/areaControl.php",{opcion:2},function(resp){
			$("#"+idsel).html(resp);
			var v = setTimeout(function(){$("#"+idsel+" option").eq(val).prop('selected', true);},200);
		});
	}
	function quitarMenuPerfil(idform){
		var data = $("#"+idform).serialize();
		$.post("./scripts/menuControl.php?opcion=10",data,function(resp){
			jAlert(resp,"Informacion");
			listaPerfiles2("perfmdel","menumdel");
		});
	}
	function asignarMenuPerfil(idform){
		var data = $("#"+idform).serialize();
		$.post("./scripts/menuControl.php?opcion=2",data,function(resp){
			jAlert(resp,"Informacion");
			listaAreas2("areaasig","menuasig");
		});
	}
	$(document).ready(function(){
		activar_tabs();
		buscarMenu(2);
		listaPerfiles("perfasig");
		listaPerfiles3("perfmver","vermenusperf");
		listaPerfiles2("perfmdel","menumdel");
		listaAreas("idarea");
		listaAreas2("areaasig","menuasig");
	});
</script>
<div style="width: 96%">
	<ul class='tabs'>
		<li><a href='#tab1'>Modificar menu</a></li>
		<li><a href='#tab2'>Crear menu</a></li>
		<li><a href='#tab3'>Asignar menu-perfil</a></li>
		<li><a href='#tab4'>Quitar menu-perfil</a></li>
		<li><a href='#tab5'>Ver menu por perfil</a></li>
	</ul>
	<div class='tab_container'>
		<div id="tab1" class='tab_content'>
			<table>
				<tr>
					<td>
						<input type="button" value="Buscar" onclick="buscarMenu(2);">
					</td>
				</tr>
			</table>
			<br><br>
			<div id="datos"></div>
		</div><!--tab1-->
		<div id="tab2" class='tab_content'>
			<form id="frminsertm" method="POST" action="">
				<table>
					<tr>
						<td colspan="2">Creaci&oacute;n de menu</td>
					</tr>
					<tr>
						<td>Area</td>
						<td><select id="idarea" name="idarea"></select></td>
					</tr>
					<tr>
						<td>Nombre</td>
						<td><input type="text" id="nomenu" name="nomenu" required></td>
					</tr>
					<tr>
						<td>Link</td>
						<td><input type="text" id="linkmenu" name="linkmenu" required></td>
					</tr>
					<tr>
						<td colspan="2" style="text-align: center;">
							<input type="button" value="Enviar" onclick="registrarMenu('frminsertm');">
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
						<td colspan="2">Asignaci&oacute;n de menu-perfil</td>
					</tr>
					<tr>
						<td>Area</td>
						<td><select id="areaasig" name="areaasig" onchange="cargarMenusArea(this.id,'menuasig');"></select></td>
					</tr>
					<tr>
						<td>Menu</td>
						<td><select id="menuasig" name="menuasig"></select></td>
					</tr>
					<tr>
						<td>Perfil</td>
						<td><select id="perfasig" name="perfasig"></select></td>
					</tr>
					<tr>
						<td colspan="2" style="text-align: center;">
							<input type="button" value="Enviar" onclick="asignarMenuPerfil('frmasigp');">
							<input type="reset" value="Borrar">
						</td>
					</tr>
				</table>
			</form>
		</div><!--tab3-->
		<div id="tab4" class='tab_content'>
			<form id="frmasigpm" method="POST" action="">
				<table>
					<tr>
						<td colspan="2">Quitar menu-perfil</td>
					</tr>
						<td>Perfil</td>
						<td><select id="perfmdel" name="perfmdel" onchange="listaMenusPerfil(this.id,'menumdel');"></select></td>
					</tr>
					<tr>
						<td>Menu</td>
						<td><select id="menumdel" name="menumdel"></select></td>
					</tr>
					<tr>
					<tr>
						<td colspan="2" style="text-align: center;">
							<input type="button" value="Enviar" onclick="quitarMenuPerfil('frmasigpm');">
							<input type="reset" value="Borrar">
						</td>
					</tr>
				</table>
		</div><!--tab4-->
		<div id="tab5" class='tab_content'>
				<select id="perfmver" onchange="listaMenusPerfilDiv(this.id,'vermenusperf');"></select>
				<input type="button" value="Actualizar" onclick="listaMenusPerfilDiv('perfmver','vermenusperf');">
				<br/><br/>
				<div id="vermenusperf"></div>
		</div><!--tab5-->
	</div><!--tabcontainer-->
	<div style="clear:both;"></div>
</div>
