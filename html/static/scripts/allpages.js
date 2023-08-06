if(window.matchMedia && 
	window.matchMedia('(prefers-color-scheme: dark)').matches && 
	(location.href !== "https://www.quizza.org/" || 
		location.href !== "https://www.quizza.org")
	) {

	$("meta[name=theme-color]").attr("content","#085e4e");

}

function signout(){
	$.get("/docs/lib/login-endpoint/signout.php", function(d,s){
		if(d=="success"){
			location.reload();
		}
	})
}