$("select").on('change', function(event) {var url = 'https://' + $("select").val() + ".quizza.org/";
    if(url !== "https://.quizza.org"){ location.href = url; } });