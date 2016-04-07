<?php
	require_once("../objetos/conexion.php");
	
	class AreaModelo{
		
		public function __construct() {
			
		}
		
		public function crearArea($nom){
			$cad = "";
			$sql = "INSERT INTO area(nombre,activo) 
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
				echo "areaModelo.php - Ews04: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			return $cad;
		}
		
		public function buscarAreas(){
			$json = '{"areas":[';
			$sql = 
			"SELECT a.*
			FROM area a";
			$con = new Conexion();
			$cnt=0;
			try{
				$con->conectar();
				$result = mysql_query($sql) or die("Epos04: ".mysql_error());
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
				echo "areaModelo.php - Er0s7q: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			$json.=']}';
			return $json;
		}
		
		public function desactivarArea($id){
			$cad = "";
			$sql = "UPDATE area SET activo=0 WHERE id=$id";
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
				echo "areaModelo.php - E7kd0: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			return $cad;
		}
		
		public function modificarArea($id,$nom,$act){
			$cad = "";
			$sql = "UPDATE area SET nombre='$nom', activo=$act WHERE id=$id ";
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
				echo "areaModelo.php - EsRa0: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			return $cad;
		}
		
		public function buscarAreaPorId($id){
			$cad = "";
			$sql = "SELECT nombre,activo FROM area WHERE id=$id";
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
				echo "areaModelo.php - E0F4g: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			return $cad;
		}
		
		public function listadoArea_Option(){
			$cad = "";
			$sql = "SELECT * FROM area WHERE activo=1";
			$con = new Conexion();
			try{
				$con->conectar();
				$result = mysql_query($sql) or die("E6Rd0: ".mysql_error());
				$con->desconectar();
				if(mysql_num_rows($result)>0){
					while($row = mysql_fetch_array($result)){
						$cad .=  "<option value='".$row['id']."'>".utf8_encode($row['nombre'])."</option>";
					}
				}
				else{
					$cad = "";
				}
			}
			catch (Exception $exc) {
				echo "areaModelo.php - EU04s: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			return $cad;
		}
		
		public function asignarAreaPerfil($ida,$idp){
			$cad = "";
			$sql = "INSERT INTO areaperfil(idarea,idperfil,activo) 
			VALUES ( $ida,$idp,1 )";
			$con = new Conexion();
			try{
				$con->conectar();
				mysql_query($sql) or die("Eq70sdh: ".mysql_error());
				$filas = mysql_affected_rows();
				$con->desconectar();
				if ($filas>0) $cad = "Informacion actualizada";
				else $cad = "No fue posible actualizar la informacion";
			}
			catch (Exception $exc) {
				echo "areaModelo.php - Enf0we: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			return $cad;
		}
	}
?>
