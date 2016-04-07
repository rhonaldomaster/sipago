<?php
	session_start();
	if(!isset($_SESSION['pid'])){
		die("");
	}
	$server = "http";
	if(isset($_SERVER['HTTPS'])) {
    		$server.="s";
	}
	$server .= "://".$_SERVER['SERVER_NAME']."/sipago/";
?>
<script>            
    $(document).ready(
        function(){
            $("#accordion > li > div").click(function(){
                if(false == $(this).next().is(':visible')) {
                    $('#accordion ul').slideUp(300);
                }
                $(this).next().slideToggle(300);
            });
            //$('#accordion ul:eq(0)').show();//mostrar el primer item
        }
    );
</script>
<div id="menunom" onclick="$('#menucont').slideToggle('slow');" title="Menu principal">
	<div id="figuramenu"></div>
</div>
<div id="divmenuac">
    <div id="menucont">
        <ul id="accordion">
            <li><div>Inicio</div>
                <ul>
                    <li><a href="./index.php">Inicio</a></li>
                </ul>
            </li>
            <?php
                include_once("./contenidomenu.php");
            ?>
            <li>
                <div>Opciones</div>
                <ul>
                    <li><a onclick="cargarMenu('./usuarios/ccontrasena.php','section#main');">Cambiar contrase&ntilde;a</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>
