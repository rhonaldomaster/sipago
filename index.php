<?php
	session_start();
	//error_reporting(E_ALL);
	//$_SESSION['pid']=1;
	$server = "http";
	if(isset($_SERVER['HTTPS'])) {
    		$server.="s";
	}
	$server .= "://".$_SERVER['SERVER_NAME']."/sipago/";
?>
<!--
	
	Copyright (C) 2013<?php if(date("Y")-2013>0) echo "-".date("Y"); ?> Rhonalf Martinez Villa (rhonaldomaster@gmail.com)

	Este programa es software libre: usted puede redistribuirlo y/o modificarlo 
    bajo los términos de la Licencia Pública General GNU publicada 
    por la Fundación para el Software Libre, ya sea la versión 3 
    de la Licencia, o (a su elección) cualquier versión posterior.

    Este programa se distribuye con la esperanza de que sea útil, pero 
    SIN GARANTÍA ALGUNA; ni siquiera la garantía implícita 
    MERCANTIL o de APTITUD PARA UN PROPÓSITO DETERMINADO. 
    Consulte los detalles de la Licencia Pública General GNU para obtener 
    una información más detallada. 

    Debería haber recibido una copia de la Licencia Pública General GNU 
    junto a este programa. 
    En caso contrario, consulte <http://www.gnu.org/licenses/>.
-->
<!DOCTYPE html>
<html lang="es">
	<head>
		<title>Sipago - Principal</title>
		<meta charset="utf-8"/>
		<meta name="Author" content="Rhonalf Martinez Villa"/>
		<meta name="robots" content="index,nofollow"/>
		<meta name="description" content="Sipago - aplicacion de control - permite gestion de pagos y cobros en la misma aplicacion"/>
		<link rel="shortcut icon" href="./favicon.png">
		<!-- css -->
		<link rel="stylesheet" href="./css/reset.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,700" type="text/css" media="screen">
		<link rel="stylesheet" href="./css/layouts.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="./css/menu.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="./css/dhtmlgoodies_calendar.css?random=20051112" type="text/css" media="screen" />
		<link rel="stylesheet" href="./css/visualize.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="./css/visualize-light.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="./css/ultabs.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="./css/jquery.alerts.css" type="text/css" media="screen" />
	</head>
	<body>
		<header>
			<div id="mainbar"></div>
			<div class="clear"><br/></div>
			<div class="logo" onclick="window.location='./index.php';" style="cursor:pointer;">
				<h1>Sipago</h1>
				<h4>Colocar lema aqu&iacute;</h4>
			</div>
		</header>
		<nav id="mainnav"></nav>
		<!--[if lte IE 8]><div style='clear: both; height: 112px; padding:0; text-align: center; position: relative;'><a href="http://www.theie9countdown.com/ie-users-info"><img src="http://www.theie9countdown.com/assets/badge_iecountdown.png" border="0" height="112" width="348" alt="" /></a></div><![endif]-->
		<section id="main"></section>
		<footer>
			<!--[if lte IE 8]><span style="filter: FlipH; -ms-filter: "FlipH"; display: inline-block;"><![endif]-->
			<span style="-moz-transform: scaleX(-1); -o-transform: scaleX(-1); -webkit-transform: scaleX(-1); transform: scaleX(-1); display: inline-block;">
				&copy; 
			</span>
			<!--[if lte IE 8]></span><![endif]-->
			Rhonalf Martinez Villa 2013<?php if(date("Y")-2013>0) echo "-".date("Y"); ?>
			
		</footer>
		<!-- js -->
		<script src="./js/jquery.js"></script>
		<!--[if lte IE 8]>
		<script src="./js/html5.js"></script>
		<script src="./js/unitpngfix.js"></script>
		<![endif] -->
		<script src="./js/menu.js"></script>
		<script src="./js/numberFormat154.js"></script>
		<script src="./js/drag.js"></script>
		<script src="./js/jquery.alerts.js"></script>
		<script src="./js/ultabs.js"></script>
		<script src="./js/logactions.js"></script>
		<script src="./js/jquery.tablesorter.min.js"></script>
		<script src="./js/dhtmlgoodies_calendar.js"></script>
		<script>
			$(document).ready(
				function(){
					<?php if(!isset($_SESSION['pid'])){ ?>
					
					cargarMenu("./scripts/loginform.php","section#main");
					$("body").css({"background-color":"black","color":"white"});
					$("header").css({"opacity":"0.75","filter":"alpha(opacity=75)"});
					$("div#logindiv").css({"opacity":"1","filter":"alpha(opacity=100)"});
					<?php }else{ ?>
					
					cargarMenu("./scripts/mainbar.php","div#mainbar");
					cargarMenu("./scripts/menu.php","nav#mainnav");
					var mstt = setTimeout(function(){cargarMenu("./scripts/mensajebienvenida.php","section#main");},200);
					<?php } ?>
					
				}
			);
		</script>
	</body>
</html> 
