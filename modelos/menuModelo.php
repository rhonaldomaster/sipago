<?php

	require_once("../objetos/conexion.php");
	require_once("../objetos/menu.php");

	class MenuModelo{

		public function __construct() {

		}

		public function cargarMenuUsuario($idu){
			$cadenamenu = "";
			$sql =
			"SELECT ar.*, pusu.idperfil
			FROM areaperfil aperf
			INNER JOIN area ar ON ar.id = aperf.idarea
			INNER JOIN perfilusuario pusu ON pusu.idperfil = aperf.idperfil
			WHERE pusu.idusuario = $idu AND pusu.activo=1";
			$con = new Conexion();
			try{
				$con->conectar();
				$result = mysql_query($sql) or die("Ek4df: ".mysql_error());
				$con->desconectar();
				if(mysql_num_rows($result)>0){
					while($row = mysql_fetch_array($result)){
						$sqlmenus ="SELECT mdin.* ";
						$sqlmenus .="FROM menu mdin ";
						$sqlmenus .="INNER JOIN menuperfil mperf ON mdin.id=mperf.idmenu ";
						$sqlmenus .="INNER JOIN areaperfil AS ap ON ap.idperfil=mperf.idperfil ";
						$sqlmenus .="WHERE mperf.idperfil= ".$row['idperfil']." AND mdin.idarea=".$row['id']." AND mperf.activo=1 ";
						$sqlmenus .="GROUP BY mdin.id ";
						$cadenamenu .= "<li><div>".$row['nombre']."</div>";
						$cadenamenu .=  "<ul>";
						$con->conectar();
						$rst = mysql_query($sqlmenus) or die(mysql_error());
						$con->desconectar();
						while($rx2 = mysql_fetch_array($rst)){
						    $cadenamenu .=  "<li><a onclick='cargarMenu(\"./".$rx2['link']."\",\"section#main\");'>".$rx2['texto']."</a></li>";
						}
						$cadenamenu .=  "</ul>";
						$cadenamenu .=  "</li>";
					}
				}
				else{
					$cadenamenu = "";
				}
			}
			catch (Exception $exc) {
				echo "menuModelo.php - E1bpd: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			return $cadenamenu;
		}

		public function buscarMenu(){
			$json = '{"menus":[';
			$sql =
			"SELECT a.nombre AS nomarea,m.id,m.texto,m.link,m.activo
			FROM area a
			INNER JOIN menu m ON m.idarea=a.id";
			$con = new Conexion();
			$cnt=0;
			try{
				$con->conectar();
				$result = mysql_query($sql) or die("E4d77q: ".mysql_error());
				$con->desconectar();
				if(mysql_num_rows($result)>0){
					while($row = mysql_fetch_array($result)){
						if($cnt!=0){
							$json .= ",";
						}
						else{
							$cnt=1;
						}
						$json .= '{"id":"'.$row['id'].'","nombrea":"'.$row['nomarea'].'","nombre":"'.$row['texto'].'","link":"'.$row['link'].'","activo":"'.$row['activo'].'"}';
					}
				}
				else{
					$json .= '{"id":"","nombrea":"","nombre":"","link":"","activo":"0"}';
				}
			}
			catch (Exception $exc) {
				echo "menuModelo.php - Ew7y21f: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			$json.=']}';
			return $json;
		}

		public function registrarMenu($ida,$nom,$lnk){
			$cad = "";
			$sql = "INSERT INTO menu(idarea,texto,link,activo)
			VALUES ( $ida,'$nom','$lnk',1 )";
			$con = new Conexion();
			try{
				$con->conectar();
				mysql_query($sql) or die("Ea0dse: ".mysql_error());
				$filas = mysql_affected_rows();
				$con->desconectar();
				if ($filas>0) $cad = "Informacion actualizada";
				else $cad = "No fue posible actualizar la informacion";
			}
			catch (Exception $exc) {
				echo "menuModelo.php - E0a8c1: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			return $cad;
		}

		public function desactivarMenu($id){
			$cad = "";
			$sql = "UPDATE menu SET activo=0 WHERE id=$id";
			$con = new Conexion();
			try{
				$con->conectar();
				mysql_query($sql) or die("ET0za1: ".mysql_error());
				$filas = mysql_affected_rows();
				$con->desconectar();
				if ($filas>0) $cad = "Informacion actualizada";
				else $cad = "No fue posible actualizar la informacion";
			}
			catch (Exception $exc) {
				echo "menuModelo.php - E7Ydc: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			return $cad;
		}

		public function actualizarMenu($id,$ida,$nom,$lnk){
			$cad = "";
			$sql = "UPDATE menu SET idarea=$ida,texto='$nom',link='$lnk' WHERE id=$id";
			$con = new Conexion();
			try{
				$con->conectar();
				mysql_query($sql) or die("EU0yd: ".mysql_error());
				$filas = mysql_affected_rows();
				$con->desconectar();
				if ($filas>0) $cad = "Informacion actualizada";
				else $cad = "No fue posible actualizar la informacion";
			}
			catch (Exception $exc) {
				echo "menuModelo.php - E8xT0: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			return $cad;
		}
		
		public function buscarMenusArea($ida){
			$cad = "";
			$sql = "SELECT m.* 
			FROM menu m 
			WHERE m.activo=1 AND m.idarea=$ida";
			$con = new Conexion();
			try{
				$con->conectar();
				$result = mysql_query($sql) or die("EQ054s: ".mysql_error());
				$con->desconectar();
				if(mysql_num_rows($result)>0){
					while($row = mysql_fetch_array($result)){
						$cad .=  "<option value='".$row['id']."'>".utf8_encode($row['texto'])."</option>";
					}
				}
				else{
					$cad = "";
				}
			}
			catch (Exception $exc) {
				echo "menuModelo.php - E7Gs0: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			return $cad;
		}
		
		public function buscarMenusPerfil($idp){
			$cad = "";
			$sql = "SELECT m.* 
			FROM menu m 
			INNER JOIN menuperfil mp ON mp.idmenu=m.id
			WHERE m.activo=1 AND mp.idperfil=$idp";
			$con = new Conexion();
			try{
				$con->conectar();
				$result = mysql_query($sql) or die("EV04s: ".mysql_error());
				$con->desconectar();
				if(mysql_num_rows($result)>0){
					while($row = mysql_fetch_array($result)){
						$cad .=  "<option value='".$row['id']."'>".utf8_encode($row['texto'])."</option>";
					}
				}
				else{
					$cad = "";
				}
			}
			catch (Exception $exc) {
				echo "menuModelo.php - E3j8C: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			return $cad;
		}
		
		public function buscarMenusPerfilDiv($idp){
			$cad = "";
			$sql = "SELECT m.*, a.nombre AS nomarea 
			FROM menu m 
			INNER JOIN menuperfil mp ON mp.idmenu=m.id
			INNER JOIN area a ON a.id = m.idarea
			WHERE m.activo=1 AND mp.idperfil=$idp";
			$con = new Conexion();
			try{
				$con->conectar();
				$result = mysql_query($sql) or die("EL40s: ".mysql_error());
				$con->desconectar();
				$cad = "<table class='tablesorter'>";
				$cad .="<thead><tr>"
				."<th>Area</th><th>Nombre menu</th><th>Link</th>"
				."</tr></thead>"
				."<tbody>";
				if(mysql_num_rows($result)>0){
					while($row = mysql_fetch_array($result)){
						$cad .=  "<tr>"
						."<td>".utf8_encode($row['nomarea'])."</td>"
						."<td>".utf8_encode($row['texto'])."</td>"
						."<td>".utf8_encode($row['link'])."</td>"
						."</tr>";
					}
				}
				else{
					$cad .= "<tr><td colspan='3' style='text-align:center;'>No se encontraron resultados</td></tr>";
				}
				$cad .= "</tbody></table>";
			}
			catch (Exception $exc) {
				echo "menuModelo.php - E1Ax2s: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			return $cad;
		}
		
		public function datosMenu($id){
			$cad = "";
			$sql = "SELECT m.* 
			FROM menu m 
			WHERE m.id=$id";
			$con = new Conexion();
			try{
				$con->conectar();
				$result = mysql_query($sql) or die("EV04s: ".mysql_error());
				$con->desconectar();
				if(mysql_num_rows($result)>0){
					while($row = mysql_fetch_array($result)){
						$cad =  "".$row['idarea']."|".utf8_encode($row['texto'])."|".utf8_encode($row['link'])."";
					}
				}
				else{
					$cad = "";
				}
			}
			catch (Exception $exc) {
				echo "menuModelo.php - E3j8C: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			return $cad;
		}
		
		function quitarMenuPerfil($idm,$idp){
			$cad = "";
			$sql = "DELETE FROM menuperfil WHERE idmenu=$idm AND idperfil=$idp";
			$con = new Conexion();
			try{
				$con->conectar();
				mysql_query($sql) or die("EG7s0: ".mysql_error());
				$filas = mysql_affected_rows();
				$con->desconectar();
				if ($filas>0) $cad = "Informacion actualizada";
				else $cad = "No fue posible actualizar la informacion";
			}
			catch (Exception $exc) {
				echo "menuModelo.php - E5J0u: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			return $cad;
		}
		
		public function asignarMenuPerfil($idm,$idp){
			$cad = "";
			$sql = "INSERT INTO menuperfil(idmenu,idperfil,activo) VALUES($idm,$idp,1)";
			$con = new Conexion();
			try{
				$con->conectar();
				mysql_query($sql) or die("EN67w: ".mysql_error());
				$filas = mysql_affected_rows();
				$con->desconectar();
				if ($filas>0) $cad = "Informacion actualizada";
				else $cad = "No fue posible actualizar la informacion";
			}
			catch (Exception $exc) {
				echo "menuModelo.php - E9Q1d: ".$exc->getTraceAsString();
				$con->desconectar();
			}
			return $cad;
		}
	}
?>
