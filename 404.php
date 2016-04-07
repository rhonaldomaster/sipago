<?php
	session_start();
	//error_reporting(E_ALL);
	$server = "http";
	if(isset($_SERVER['HTTPS'])) {
    		$server.="s";
	}
	$server .= "://".$_SERVER['SERVER_NAME']."/copg/";
?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<title>Sipago - 404</title>
		<meta charset="utf-8"/>
		<meta name="Author" content="Rhonalf Martinez Villa"/>
		<meta name="robots" content="index,nofollow"/>
		<meta name="description" content="Sipago - aplicacion de control - permite gestion de pagos y cobros en la misma aplicacion"/>
		<link rel="shortcut icon" href="./favicon.png">
		<!-- estilos -->
		<link rel="stylesheet" href="./css/reset.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,700' type='text/css">
		<link rel="stylesheet" href="./css/layouts.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="./css/menu.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="./css/dhtmlgoodies_calendar.css?random=20051112" type="text/css" media="screen" />
		<link rel="stylesheet" href="./css/visualize.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="./css/visualize-light.css" type="text/css" media="screen" />
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
		<nav id="mainnav">
			
		</nav>
		<section id="main">
			<div style="width:90%; margin:0 auto; border-radius:0.8em;text-align:center;">
				<h3>No s&eacute; donde quieres ir ...</h3><br>
				<h3>Mejor comamos unas galletas :3</h3><br>
				<img src="./img/chibikat.png" alt="chibikat">
			</div>
		</section>
		<footer>
			<!--[if lte IE 8]><span style="filter: FlipH; -ms-filter: "FlipH"; display: inline-block;"><![endif]-->
			<span style="-moz-transform: scaleX(-1); -o-transform: scaleX(-1); -webkit-transform: scaleX(-1); transform: scaleX(-1); display: inline-block;">
				&copy; 
			</span>
			<!--[if lte IE 8]></span><![endif]-->
			Rhonalf Martinez Villa 2013<?php if(date("Y")-2013>0) echo "-".date("Y"); ?>
			
		</footer>
	</body>
	<!-- js -->
	<script src="./js/jquery.js"></script>
	<script src="./js/menu.js"></script>
	<script src="./js/numberFormat154.js"></script>
	<script src="./js/drag.js"></script>
	<script src="./js/jquery.alerts.js"></script>
	<script>
		$(document).ready(
			function(){
				<?php
					if(isset($_SESSION['pid'])){
				?>
				cargarMenu("./scripts/mainbar.php","div#mainbar");
				cargarMenu("./scripts/menu.php","nav#mainnav");
				<?php
					}
				?>
			}
		);
	</script>
</html> 
