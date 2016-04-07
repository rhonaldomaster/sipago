<?php
	require_once("../objetos/conexion.php");
	
	class ProductoModelo{
		
		public function __construct() {
			
		}
		
		public function buscarProductos(){
			$json = '{"productos":[';
			$sql = 
			"SELECT a.*
			FROM producto a";
			$con = new Conexion();
			$cnt=0;
			try{
				$con->conectar();
				$result = mysql_query($sql) or die("E6dS0x: ".mysql_error());
				$con->desconectar();
				if(mysql_num_rows($result)>0){
					while($row = mysql_fetch_array($result)){
						if($cnt!=0){
							$json .= ",";
						}
						else{
							$cnt=1;
						}
						$json .= '{"id":"'.$row['id'].'","nombre":"'.$row['nombre'].'","activo":"'.$row['activo'].'"}';
					}
				}
				else{
					$json .= '{"id":"","nombre":"","activo":"0"}';
				}
			}
			catch (Exception $exc) {
				echo "productoModelo.php - Er0s7q: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			$json.=']}';
			return $json;
		}
		
		public function desactivarProducto($id){
			$cad = "";
			$sql = "UPDATE producto SET activo=0 WHERE id=$id";
			$con = new Conexion();
			try{
				$con->conectar();
				mysql_query($sql) or die("Etd04: ".mysql_error());
				$filas = mysql_affected_rows();
				$con->desconectar();
				if ($filas>0) $cad = "Informacion actualizada";
				else $cad = "No fue posible actualizar la informacion";
			}
			catch (Exception $exc) {
				echo "productoModelo.php - E7kd0: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			return $cad;
		}
		
		public function modificarProducto($id,$nom,$act){
			$cad = "";
			$sql = "UPDATE producto SET nombre='$nom', activo=$act WHERE id=$id ";
			$con = new Conexion();
			try{
				$con->conectar();
				mysql_query($sql) or die("E10sad: ".mysql_error());
				$filas = mysql_affected_rows();
				$con->desconectar();
				if ($filas>0) $cad = "Informacion actualizada";
				else $cad = "No fue posible actualizar la informacion";
			}
			catch (Exception $exc) {
				echo "productoModelo.php - EsRa0: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			return $cad;
		}
		
		public function buscarProductoPorId($id){
			$cad = "";
			$sql = "SELECT nombre,activo FROM producto WHERE id=$id";
			$con = new Conexion();
			try{
				$con->conectar();
				$result = mysql_query($sql) or die("EU4s0: ".mysql_error());
				$con->desconectar();
				while($row = mysql_fetch_array($result)){
					$cad = $row['nombre']."|".$row['activo'];
				}
			}
			catch (Exception $exc) {
				echo "productoModelo.php - E0F4g: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			return $cad;
		}
		
		public function crearProdcuto($nom){
			$cad = "";
			$sql = "INSERT INTO producto(nombre,activo) 
			VALUES ( '$nom',1 )";
			$con = new Conexion();
			try{
				$con->conectar();
				mysql_query($sql) or die("Egd40: ".mysql_error());
				$filas = mysql_affected_rows();
				$con->desconectar();
				if ($filas>0) $cad = "Informacion actualizada";
				else $cad = "No fue posible actualizar la informacion";
			}
			catch (Exception $exc) {
				echo "productoModelo.php - Ews04: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			return $cad;
		}
		
		public function buscarProductosInv(){
			$json = '{"productos":[';
			$sql = 
			"SELECT a.*,i.cantidad
			FROM producto a
			INNER JOIN inventario i ON i.idproducto=a.id
			WHERE i.activo=1 AND a.activo=1";
			$con = new Conexion();
			$cnt=0;
			try{
				$con->conectar();
				$result = mysql_query($sql) or die("E6dS0x: ".mysql_error());
				$con->desconectar();
				if(mysql_num_rows($result)>0){
					while($row = mysql_fetch_array($result)){
						if($cnt!=0){
							$json .= ",";
						}
						else{
							$cnt=1;
						}
						$json .= '{"id":"'.$row['id'].'","nombre":"'.$row['nombre'].'","cantidad":"'.$row['cantidad'].'"}';
					}
				}
				else{
					$json .= '{"id":"","nombre":"","cantidad":"0"}';
				}
			}
			catch (Exception $exc) {
				echo "productoModelo.php - Er0s7q: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			$json.=']}';
			return $json;
		}
		
		public function verSalidasMes($a,$m){
			$json = '{"productos":[';
			$sql = "SELECT vd.cantidadproducto, p.nombre
			FROM ventadetalle vd 
			INNER JOIN producto p ON p.id=vd.idproducto
			WHERE vd.activo=1";
			$con = new Conexion();
			$cnt=0;
			try{
				$con->conectar();
				$result = mysql_query($sql) or die("Et50Sd: ".mysql_error());
				$con->desconectar();
				if(mysql_num_rows($result)>0){
					while($row = mysql_fetch_array($result)){
						if($cnt!=0){
							$json .= ",";
						}
						else{
							$cnt=1;
						}
						$json .= '{"id":"'.$row['id'].'","nombre":"'.$row['nombre'].'","cantidad":"'.$row['cantidadproducto'].'"}';
					}
				}
				else{
					$json .= '{"id":"","nombre":"","cantidad":"0"}';
				}
			}
			catch (Exception $exc) {
				echo "productoModelo.php - Evs48X: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			$json.=']}';
			return $json;
		}
		
		public function verEntradasMes($a,$m){
			$json = '{"productos":[';
			$sql = "SELECT vd.cantidadproducto, p.nombre
			FROM compradetalle vd 
			INNER JOIN producto p ON p.id=vd.idproducto
			WHERE vd.activo=1";
			$con = new Conexion();
			$cnt=0;
			try{
				$con->conectar();
				$result = mysql_query($sql) or die("Et30Sf: ".mysql_error());
				$con->desconectar();
				if(mysql_num_rows($result)>0){
					while($row = mysql_fetch_array($result)){
						if($cnt!=0){
							$json .= ",";
						}
						else{
							$cnt=1;
						}
						$json .= '{"id":"'.$row['id'].'","nombre":"'.$row['nombre'].'","cantidad":"'.$row['cantidadproducto'].'"}';
					}
				}
				else{
					$json .= '{"id":"","nombre":"","cantidad":"0"}';
				}
			}
			catch (Exception $exc) {
				echo "productoModelo.php - Eqs4aX: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			$json.=']}';
			return $json;
		}
		
		public function productosSelect(){
			$cad = "";
			$sql = "SELECT id,nombre FROM producto WHERE activo=1";
			$con = new Conexion();
			try{
				$con->conectar();
				$result = mysql_query($sql) or die("E1aAq: ".mysql_error());
				$con->desconectar();
				while($row = mysql_fetch_array($result)){
					$cad .= "<option value='".$row['id']."'>".$row['nombre']."</option>";
				}
			}
			catch (Exception $exc) {
				echo "productoModelo.php - E40lJh: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			return $cad;
		}
	}
?>
