var current_flashcard = -1;
var start_with_term = true;
var score = 0;

function init(){
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
    start_with_term = (sessionStorage.def=="false");

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
        $("#main-td").html("<h1 style='color:red'>Incorrect</h1><p>"+words[current_flashcard]+": "+defs[current_flashcard]+"<br>You said: <span color='#777'>"+answer+"</span> (<a href='javascript:override();'>override</a>)</p>");
    }
    $("#sbtn").html(`Next&nbsp;&nbsp;<i class="fa-solid fa-arrow-right-to-bracket"></i>`);
    $("#sbtn").attr("onclick","next()");
    MathJax.typeset();
}

function override(){
    $("#main-td").html("<h1 style='color:green'>Correct</h1><p>"+words[current_flashcard]+": "+defs[current_flashcard]+"</p>");
    MathJax.typeset();
}

function next(){
    current_flashcard++;
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
    current_flashcard = -1;
    score = 0;
    next();
}

// Start with definition
function swd(){
    start_with_term = false;
    sessionStorage.def = "true";
    current_flashcard = -1;
    score = 0;
    next();
}