<?php
	session_start();
	if(!isset($_SESSION['pid'])){
		header( 'Location: http://localhost/sipago/index.php' ) ;
	}
?>
<script>
	function buscarProductos(accion){
		$.getJSON("./scripts/productoControl.php",{opcion:3},function(data){
			if(data.productos[0]!=null){
				var html1 = "<table id='tblcuentas' class='tablesorter' cellspacing='0'>";
				html1 += "<thead><tr><th class='header'>Nombres</th><th class='header'>Activo</th>";
				if(accion==2){
					html1 += "<th class='header'>Acci&oacute;n</th>";
				}
				html1 += "</tr><thead><tbody></tbody><tfoot></tfoot></table>";
				$("#datos").html(html1);
				$.each(data.productos, function(i,producto){
					var html2 = "";
					html2 = "<tr>";
					if(producto.id==""){
						var cspan = 2;
						if(accion==2){
							cspan=3;
						}
						html2 += "<td colspan='"+cspan+"' style='text-align: center;'>No se encontraron resultados</td>";
					}
					else{
						html2 += "<td>"+producto.nombre+"</td>";
						html2 += "<td>"+( (producto.activo==1) ? "S&iacute;":"No")+"</td>";
						if(accion==2){
							html2 += "<td><input type='image' title='Editar' src='./img/icn_edit.png' onclick='editarProducto("+producto.id+");' alt='Editar'>";
							html2 += " <input type='image' title='Desactivar' src='./img/icn_trash.png' onclick='desactivarProducto("+producto.id+");' alt='Borrar'></td>";
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
	function editarProducto(idu){
		$("#datos").load("./productos/modFormproducto.php?id="+idu);
	}
	function desactivarProducto(idu){
		var ir = jConfirm("Seguro que desea desactivar este producto?","Advertencia");
		if(ir==true){
			$.post("./scripts/productoControl.php",{id:idu,opcion:5},function(resp){
				jAlert(resp,"Informacion");
				buscarProductos(2);
			});
		}
	}
	function modificarProducto(idform){
		var data = $("#"+idform).serialize();
		$.post("./scripts/productoControl.php?opcion=6",data,function(resp){
			jAlert(resp,"Informacion");
			buscarProductos(2);
		});
	}
	function registrarProducto(idform){
		var data = $("#"+idform).serialize();
		$.post("./scripts/productoControl.php?opcion=7",data,function(resp){
			jAlert(resp,"Informacion");
			document.getElementById(idform).reset();
		});
	}
	function listaProductos(idsel){
		$.post("./scripts/productoControl.php",{opcion:2},function(resp){
			$("#"+idsel).html(resp);
		});
	}
	$(document).ready(function(){
		activar_tabs();
		buscarProductos(2);
	});
</script>
<div style="width: 96%">
	<ul class='tabs'>
		<li><a href='#tab1'>Modificar producto</a></li>
		<li><a href='#tab2'>Crear producto</a></li>
	</ul>
	<div class='tab_container'>
		<div id="tab1" class='tab_content'>
			<table>
				<tr>
					<td>
						<input type="button" value="Buscar" onclick="buscarProductos(2);">
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
						<td colspan="2">Creaci&oacute;n de producto</td>
					</tr>
					<tr>
						<td>Nombre</td>
						<td><input type="text" id="nomproducto" name="nomproducto" required></td>
					</tr>
					<tr>
						<td colspan="2" style="text-align: center;">
							<input type="button" value="Enviar" onclick="registrarProducto('frminserta');">
							<input type="reset" value="Borrar">
						</td>
					</tr>
				</table>
			</form>
		</div><!--tab2-->
	</div><!--tabcontainer-->
	<div style="clear:both;"></div>
</div>
