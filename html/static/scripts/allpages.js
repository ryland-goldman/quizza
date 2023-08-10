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

$("select").on('change', function(event) {
    var url = 'https://' + $("select").last().val() + ".quizza.org/";
    if(url !== "https://.quizza.org/" && url !== "https://www.quizza.org/"){ location.href = url; }
});