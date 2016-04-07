<?php
	$opcionusuario = 1;
	require_once("./usuarioControl.php");
?>
<div id="container1">
	<div id="sysadvices">
		<!--<p>adv1 ... sdsd</p>
		<p>avd2 xxx ooo</p>-->
	</div>
</div>
<div class="nomuser">
	<?php echo $nombres." ".$apellidos;//variables estan en usuariocontrol.php ?>
	<!--<div id="msgdiv">0</div>-->
	<div class="logout" onclick="logout();" title="Cerrar sesion">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	</div>
</div>
