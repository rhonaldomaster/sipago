function login(){
	var usuarionom = $.trim($('#usuario').val());
	if(usuarionom != ""){
		$.ajax({
			type: "POST",
			url: "./scripts/loginAction.php",
			data: $('#formlogin').serialize(),
			success: function(response){
				if(response.toLowerCase() == "ok"){
					location.href = "index.php";
				}
				else{
					alert("No es posible acceder: "+response);
				}
			},
			error: function(response){
				jAlert(response,"Error");
			}
		});
	}
	else{
		jAlert("Escriba un nombre de usuario ...","Aviso");
	}
}

function logout(){
	$.get('./scripts/logoutAction.php','',function(resp){
		if(resp.toLowerCase()=="ok") location.href="./index.php";
	});
}
