$("select").on('change', function() {var url = 'https://' + $(this).attr('id') + ".quizza.org/";
    if(url !== "https://.quizza.org"){ location.href = url; } });