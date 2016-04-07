function activar_tabs(){
	$(".tab_content").hide(); //Esconde todo el contenido
	$("ul.tabs li:first").addClass("active").show(); //Activa la primera tab
	$(".tab_content:first").show(); //Muestra el contenido de la primera tab
	//On Click Event
	$("ul.tabs li").click(function() {
		$("ul.tabs li").removeClass("active"); //Elimina las clases activas
		$(this).addClass("active"); //Agrega la clase activa a la tab seleccionada
		$(".tab_content").hide(); //Esconde todo el contenido de la tab
		var activeTab = $(this).find("a").attr("href"); //Encuentra el valor del atributo href para identificar la tab activa + el contenido
		$(activeTab).fadeIn(); //Agrega efecto de transicion (fade) en el contenido activo
		return false;
	});
}
