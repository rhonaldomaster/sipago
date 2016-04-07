<?php
	session_start();
	if(!isset($_SESSION['pid'])){
		header( 'Location: http://'.$_SERVER['SERVER_NAME'].'/sipago/index.php' ) ;
	}
?>
<script>
	function listaClientes(idsel){
		$.post("./scripts/clienteControl.php",{opcion:1},function(resp){
			$("#"+idsel).html("<option value='0'>...</option>"+resp);
		});
	}
	function verFactura(idf,iddiv){
		$.post("./scripts/facturaControl.php",{opcion:4,id:idf},function(resp){
			$("#"+iddiv).html(resp);
		});
	}
	function buscarFacturasCliente(accion){
		var idcliente = $("#clientes option:selected").val();
		$.getJSON("./scripts/facturaControl.php",{opcion:2,idcliente:idcliente},function(data){
			if(data.facturas[0]!=null){
				var html1 = "<table id='tblfact' class='tablesorter' cellspacing='0'>";
				html1 += "<thead><tr><th class='header'>Valor</th><th class='header'>Fecha</th><th class='header'>Fecha venc.</th><th class='header'>Activo</th>";
				//if(accion==2){
					html1 += "<th class='header'>Acci&oacute;n</th>";
				//}
				html1 += "</tr><thead><tbody></tbody><tfoot></tfoot></table>";
				$("#resultados").html(html1);
				$.each(data.facturas, function(i,factura){
					var html2 = "";
					html2 = "<tr>";
					if(factura.id==""){
						var cspan = 5;
						if(accion==2){
							cspan=6;
						}
						html2 += "<td colspan='"+cspan+"' style='text-align: center;'>No se encontraron resultados</td>";
					}
					else{
						html2 += "<td style='text-align:right;'>$ "+factura.valor+"</td>";
						html2 += "<td style='text-align:right;'>"+factura.fechap+"</td>";
						html2 += "<td style='text-align:right;'>"+factura.fechav+"</td>";
						html2 += "<td>"+( (factura.activo==1) ? "S&iacute;":"No")+"</td>";
						html2 += "<td><input type='image' title='Ver' src='./img/icn_search.png' onclick='verFactura("+factura.id+",\"resultados\");' alt='Editar'>";
						if(accion==2){
							html2 += "<td><input type='image' title='Editar' src='./img/icn_edit.png' onclick='editarFactura("+factura.id+");' alt='Editar'>";
							html2 += " <input type='image' title='Desactivar' src='./img/icn_trash.png' onclick='desactivarFactura("+factura.id+");' alt='Borrar'></td>";
						}
					}
					html2 += "</tr>";
					$("#tblfact tbody").append(html2);
					$(".tablesorter").tablesorter();
				});
			}
			else{
				jAlert("Ocurri\u00F3 un problema al obtener los datos","Error");
			}
		});
	}
	$(document).ready(function(){
		listaClientes("clientes");
	});
</script>
<div>
	Seleccione un cliente <select id="clientes"></select>
	<input type="button" value="Ver facturas" onclick="buscarFacturasCliente(1);">
	<p>&nbsp;</p>
	<div id="resultados"></div>
</div>
