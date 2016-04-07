<?php
	include_once("../modelos/facturaModelo.php");
	$objmodelo = new FacturaModelo();
	$rstext = $objmodelo->verDetallesFactura($_REQUEST['id']);
	$arr1 = explode("|",$rstext);
	$idf = $arr1[0];
	if($idf!=0){
		$val = $arr1[1];
		$fecha = $arr1[2];
		$fechalim = $arr1[3];
		$nombrecl = $arr1[4];
		$desc = $arr1[5];
		$act = $arr1[6];
		$numcomp = $arr1[7];
	}
	else{
		$val = "";
		$fecha = "";
		$fechalim = date("Y-m-d");
		$nombrecl = $arr1[1];
		$desc = "";
		$act = "";
		$numcomp = 0;
	}
	$tipof = $objmodelo->tipoFactura($_REQUEST['id']);
	$arr2 = explode("|",$tipof);
	$vpagado = $objmodelo->valorPagadoFactura($_REQUEST['id']);
	if($val - $vpagado>0) $stl1 = ($fechalim<date("Y-m-d")?";color:#EE2C2C;font-weight:bold;":"");
	else $stl1 = "";
?>
<table style="width:100%;" class="tablesorter">
	<thead>
		<tr>
			<th colspan="4">Factura no. <?php echo $idf; ?></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<th>Nombre del <?php echo ($arr2[0]==1?"cliente":"acreedor"); ?></th>
			<td colspan="3" style="text-align:center;"><?php echo $nombrecl; ?></td>
		</tr>
		<tr>
			<th>Tipo de factura</th><td style="text-align:right;"><?php echo $arr2[1]; ?></td>
			<th>Valor factura</th><td style="text-align:right;">$ <?php echo number_format($val,2,'.',','); ?></td>
		</tr>
		<tr>	
			<th>Fecha factura</th><td style="text-align:right;"><?php echo $fecha; ?></td>
			<th>Fecha vencimiento factura</th><td style="text-align:right;<?php echo $stl1; ?>"><?php echo $fechalim; ?></td>
		</tr>
		<tr>
			<th>Valor pagado</th><td style="text-align:right;">$ <?php echo number_format($vpagado,2,'.',','); ?></td>
			<th>Valor en deuda</th><td style="text-align:right;<?php echo $stl1; ?>">$ <?php echo number_format($val - $vpagado,2,'.',','); ?></td>
		</tr>
		<tr>
			<td colspan="4">Detalles:</td>
		</tr>
		<tr>
			<td colspan="4"><textarea rows="7" style="width:100%;" readonly><?php echo $desc; ?></textarea></td>
		</tr>
	</tbody>
</table>
<?php
	$detpagos = $objmodelo->comprobantesFactura($_REQUEST['id']);
	$arr4 = explode(";_;",$detpagos);
?>
<br/>
<table style="width:100%;" class="tablesorter">
	<thead>
		<tr>
			<th colspan="6">Detalles de pagos</th>
		</tr>
		<tr>
			<th>Tipo comprobante</th>
			<th>Valor</th>
			<th>Fecha</th>
			<th>Cuenta</th>
			<th>Tipo soporte</th>
			<th>No. soporte</th>
		</tr>
	</thead>
	<tbody>
<?php
	if(strcasecmp($detpagos,"")!=0){
		foreach($arr4 as $k=>$v){
			$ai4 = explode("|",$v);
			echo "<tr>";
			echo "<td>".$ai4[0]."</td>";
			echo "<td style='text-align:right;'>$ ".number_format($ai4[1],2,'.',',')."</td>";
			echo "<td style='text-align:right;'>".$ai4[2]."</td>";
			echo "<td>".$ai4[3]."</td>";
			echo "<td>".$ai4[4]."</td>";
			echo "<td>".$ai4[5]."</td>";
			echo "</tr>";
		}
	}
	else{
		echo "<tr><td colspan='6' style='text-align:center;'>No existen comprobantes de pagos para esta factura</td></tr>";
	}
?>
	</tbody>
</table>
<br/>
