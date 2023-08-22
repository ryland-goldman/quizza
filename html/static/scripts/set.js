function disableTerm(term, iconId) {
    if (localStorage.getItem("disabledTerms") === null || localStorage.getItem("disabledTerms") === undefined) {
        localStorage.setItem("disabledTerms", "[]");
    }
    var dt = JSON.parse(localStorage.getItem("disabledTerms")).slice(0);
    if (dt.includes(fixedEncodeURIComponent(term))) {
        dt = dt.filter(function(t) {
            return t !== fixedEncodeURIComponent(term);
        });
        $("#icon-" + iconId).attr("class", "fa-solid fa-eye");
        $("#container-" + iconId).attr("class", "enabled item-card");
    } else {
        dt.push(fixedEncodeURIComponent(term));
        $("#icon-" + iconId).attr("class", "fa-solid fa-eye-slash");
        $("#container-" + iconId).attr("class", "disabled item-card");
    }
    refresh_buttons(dt.length);
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

function refresh_buttons(dt){
    if(dt < 4){
        $("#test-p").show();
        $("#mc-btn").hide();
        $("#learn-btn").hide();
        $("#match-btn").hide();
        $("#test-p").html(`<em>Add more terms to use Multiple Choice, Learn and Match.</em>`);
    } else if(dt < 16){
        $("#test-p").show();
        $("#test-p").html(`<em>Add more terms to use Match.</em>`);
        $("#match-btn").hide();
        $("#mc-btn").show();
        $("#learn-btn").show();
    } else {
        $("#test-p").hide();
        $("#match").show();
        $("#mc-btn").show();
        $("#learn-btn").show();
        $("#match-btn").show();
    }
}

function fixedEncodeURIComponent(str) { return encodeURIComponent(str).replace(/[!'()*]/g, function(c) { return '%' + c.charCodeAt(0).toString(16); }); }

function load_function(dt) {
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
    refresh_buttons(dt.length);
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