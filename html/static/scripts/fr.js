var current_flashcard = -1;
var start_with_term = true;
var score = 0;
var missed = [];

function init(){
    current_flashcard = -1;
    score = 0;
    missed = [];

    // Disabled terms
    try {
        var disabled_terms = JSON.parse(sessionStorage.disabledTerms);
        for (var i=0;i<disabled_terms.length;i++){
            if(words.includes(decodeURIComponent(disabled_terms[i]))){
                defs.splice(words.indexOf(disabled_terms[i]));
                words.splice(words.indexOf(disabled_terms[i]));
            }
        }
    } catch(e) {}

    // Make arrays in a random order
    for (var i=words.length-1; i>=0; i--){
        var j = Math.floor(Math.random()*(i+1));
        [window.words[i], window.words[j], window.defs[i], window.defs[j]] = [words[j], words[i], defs[j], defs[i]];
    }

    // Typeset LaTeX
    MathJax.typeset();

    // Render signin button
    try { render_gSignIn(); } catch(e) {}

    // Get session storage state
    if(sessionStorage.def){ start_with_term = (sessionStorage.def=="false"); }
    else { sessionStorage.def = "false"; }

    next();
}

function submit(){
    var answer = $("#response").val();
    var correct = (start_with_term ? defs[current_flashcard] : words[current_flashcard]);
    var question = (start_with_term ? words[current_flashcard] : defs[current_flashcard]);
    if(answer == correct){
        score++;
        $("#main-td").html("<h1 style='color:green'>Correct</h1><p>"+words[current_flashcard]+": "+defs[current_flashcard]+"</p>");
    } else {
        $("#main-td").html("<h1 style='color:red'>Incorrect</h1><p>"+words[current_flashcard]+": "+defs[current_flashcard]+"<br>You said: <span color='#777'>"+answer+"</span><br><br><a href='javascript:override();' id='mark-correct'>Mark Correct</a></p>");
        missed.push(question);
    }
    $("#sbtn").html(`Next&nbsp;&nbsp;<i class="fa-solid fa-arrow-right-to-bracket"></i>`);
    $("#sbtn").attr("onclick","next()");
    MathJax.typeset();
}

function override(){
    $("#main-td").html("<h1 style='color:green'>Correct</h1><p>"+words[current_flashcard]+": "+defs[current_flashcard]+"</p>");
    MathJax.typeset();
    missed.pop();
}

function again(){
    var missed_defs = [];
    for(var i=0;i<missed.length;i++){
        for(var j=0;j<words.length;j++){
            if(words[j] == missed[i] && start_with_term){
                missed_defs.push(defs[j]);
                break;
            }
            if(defs[j] == missed[i] && !start_with_term){
                missed_defs.push(words[j]);
            }
        }
    }
    if( start_with_term ){
        window.words = JSON.parse(JSON.stringify(missed));
        window.defs = JSON.parse(JSON.stringify(missed_defs));
    } else {
        window.defs = JSON.parse(JSON.stringify(missed));
        window.words = JSON.parse(JSON.stringify(missed_defs));
    }
    init();
}

function next(){
    current_flashcard++;
    if(current_flashcard == words.length){
        // Done
        $("#sbtn").html(`Study Again&nbsp;&nbsp;<i class="fa-solid fa-rotate-right"></i>`);
        $("#sbtn").attr("onclick","location.reload();");
        if(missed.length > 0){
            if( learnmode ){ again(); return; }
            var str = `<h1>You've finished studying this set!</h1><p>Missed terms: (<a href="javascript:again();" id='tryagain'>try again with missed</a>)<br>`;
            for(var i=0;i<missed.length;i++){ str += missed[i]; str += "<br>"; }
            str += "</p>";
            $("#main-td").html(str);
        } else {
            if(learnmode){ $("#sbtn").attr("onclick","location.href='mc?learn=true;'"); }
            $("#main-td").html(`<h1>You've finished studying this set!</h1>`);
        }
        return;
    }
    var question = (start_with_term ? words[current_flashcard] : defs[current_flashcard]);
    $("#main-td").html("<h1>"+question+"</h1><input type='text' id='response'>");
    $("#sbtn").html(`Submit&nbsp;&nbsp;<i class="fa-solid fa-arrow-right-to-bracket"></i>`);
    $("#sbtn").attr("onclick","submit()");
    $(".complete").html((current_flashcard+1) + "/" + words.length);
    MathJax.typeset();
}

// Start with term
function swt(){
    start_with_term = true;
    sessionStorage.def = "false";
    init();
}

// Start with definition
function swd(){
    start_with_term = false;
    sessionStorage.def = "true";
    init();
}