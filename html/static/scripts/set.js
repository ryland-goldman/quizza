function disableTerm(term, iconId) {
    if (localStorage.getItem("disabledTerms") === null || localStorage.getItem("disabledTerms") === undefined) {
        localStorage.setItem("disabledTerms", "[]");
    }
    var dt = JSON.parse(localStorage.getItem("disabledTerms")).slice(0);
    for (var p = 0; p < dt.length; p++) {
        dt[p] = decodeURIComponent(dt[p]);
    }
    if (dt.includes(term)) {
        dt = dt.filter(function(t) {
            return t !== term;
        });
        $("#icon-" + iconId).attr("class", "fa-solid fa-eye");
        $("#container-" + iconId).attr("class", "enabled item-card");
    } else {
        dt.push(term);
        $("#icon-" + iconId).attr("class", "fa-solid fa-eye-slash");
        $("#container-" + iconId).attr("class", "disabled item-card");
    }
    for (var p = 0; p < dt.length; p++) {
        dt[p] = encodeURIComponent(dt[p]);
    }
    console.log(dt);
    localStorage.setItem("disabledTerms", JSON.stringify(dt));
}


function print_set(col) {
    var type = $('input[name="radio"]:checked').val();
    $('<iframe src="/'+classID+'/'+setID+'/print?option='+type+'&col='+col+'" ></iframe>').appendTo('body').hide();
    if(has_mathjax==1){
        $(".modalbutton").attr("disabled", true);
        $("*").css("cursor", "progress");
        setTimeout(function(){
            $(".modalbutton").attr("disabled", false);
            $("*").css("cursor", "default");
        },2000);
    }
}

function load_function() {
    if (localStorage.getItem("disabledTerms") === null || localStorage.getItem("disabledTerms") === undefined) {
        localStorage.setItem("disabledTerms", "[]");
    }
    var dt = JSON.parse(localStorage.getItem("disabledTerms")).slice(0);
    terms.forEach(function(term, index) {
        if (dt.includes(term[0])) {
            $("#icon-" + term[1]).attr("class", "fa-solid fa-eye-slash");
            $("#container-" + term[1]).attr("class", "item-card disabled");
        } else {
            $("#icon-" + term[1]).attr("class", "fa-solid fa-eye");
            $("#container-" + term[1]).attr("class", "item-card enabled");
        }
    });
    try { render_gSignIn(); } catch (e) {}
    try { share_script_init(); } catch {}
}

MathJax = {
    tex: {
        inlineMath: [
            ['\\(', '\\)']
        ]
    }
};