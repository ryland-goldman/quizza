$("select").last().on('change', function(event) {
    var url = 'https://' + $("select").last().val() + ".quizza.org/";
    if(url !== "https://.quizza.org/" && url !== "https://www.quizza.org/"){ location.href = url; }
});