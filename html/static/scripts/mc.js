var current_flashcard = -1;
var start_with_term = true;
var score = 0;
var answers = [];

function check_arrays(){
    for(var i=0;i<c1s.length;i++){
        if(c1s[i] == ic1s[i] || c1s[i] == ic2s[i] || c1s[i] == ic3s[i] || ic1s[i] == ic2s[i] || ic1s[i] == ic3s[i] || ic2s[i] == ic3s[i]){ return true; }
    }
    return false;
}

function init(){
    // Make arrays in a random order
    var check_n = 0;
    while(check_arrays()){
        check_n++;
        if(check_n == 10){ break; }
        for (var i=c1s.length-1; i>=0; i--){
            var j = Math.floor(Math.random()*(i+1));
            [window.ic1s[i], window.ic1s[j]] = [ic1s[j],ic1s[i]];
        }
        for (var i=c1s.length-1; i>=0; i--){
            var j = Math.floor(Math.random()*(i+1));
            [window.ic2s[i], window.ic2s[j]] = [ic2s[j],ic2s[i]];
        }
        for (var i=c1s.length-1; i>=0; i--){
            var j = Math.floor(Math.random()*(i+1));
            [window.ic3s[i], window.ic3s[j]] = [ic3s[j],ic3s[i]];
        }
    }
    console.log(check_n);

    for (var i=c1s.length-1; i>=0; i--){
        var j = Math.floor(Math.random()*(i+1));
        [window.c1s[i], window.ic1s[i], window.ic2s[i], window.ic3s[i], window.c1s[j], window.ic1s[j], window.ic2s[j], window.ic3s[j]] = [c1s[j], ic1s[j], ic2s[j], ic3s[j], c1s[i], ic1s[i], ic2s[i], ic3s[i]];
    }

    // Typeset LaTeX
    MathJax.typeset();

    // Render signin button
    try { render_gSignIn(); } catch(e) {}

    // Get session storage state
    start_with_term = (sessionStorage.def=="false");

    next();
}

function submit(answer){
    var answer = answers[answer];
    var correct = c1s[current_flashcard];
    var question = questions[current_flashcard];
    if(answer == correct){
        score++;
        $("#main-td").html("<h1 style='color:green'>Correct</h1><p>"+questions[current_flashcard]+": "+c1s[current_flashcard]+"</p>");
    } else {
        $("#main-td").html("<h1 style='color:red'>Incorrect</h1><p>"+questions[current_flashcard]+": "+c1s[current_flashcard]+"<br>You said: <span color='#777'>"+answer+"</span></p>");
    }
    $("#sbtn").show();
    $("#sbtn").html(`Next&nbsp;&nbsp;<i class="fa-solid fa-arrow-right-to-bracket"></i>`);
    $("#sbtn").attr("onclick","next()");
    MathJax.typeset();
}


function next(){
    current_flashcard++;
    var question = questions[current_flashcard];
    answers = [
        c1s[current_flashcard],
        ic1s[current_flashcard],
        ic2s[current_flashcard],
        ic3s[current_flashcard]
    ];
    for (var i=answers.length-1; i>=0; i--){
        var j = Math.floor(Math.random()*(i+1));
        [window.answers[i], window.answers[j]] = [answers[j], answers[i]];
    }
    $("#main-td").html("<h1>"+question+`</h1>
        <button id='response1'>`+answers[0]+`</button>
        <button id='response2'>`+answers[1]+`</button>
        <button id='response3'>`+answers[2]+`</button>
        <button id='response4'>`+answers[3]+`</button>`);
    $(".complete").html((current_flashcard+1) + "/" + questions.length);
    $("#sbtn").hide();
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