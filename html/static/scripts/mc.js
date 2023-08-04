var current_flashcard = -1;
var start_with_term = true;
var score = 0;
var answers = [];
var missed = [];

function check_arrays(){
    for(var i=0;i<c1s.length;i++){
        if(c1s[i] == ic1s[i] || c1s[i] == ic2s[i] || c1s[i] == ic3s[i] || ic1s[i] == ic2s[i] || ic1s[i] == ic3s[i] || ic2s[i] == ic3s[i]){ return true; }
    }
    return false;
}

function init(){
    // Get session storage state
    if(sessionStorage.def){ start_with_term = (sessionStorage.def=="false"); }
    else { sessionStorage.def = "false"; }

    // Shuffle
    if(!start_with_term && type == "Set"){
        var questions_tmp = JSON.parse(JSON.stringify(questions));
        var questions = JSON.parse(JSON.stringify(c1s));
        var c1s = JSON.parse(JSON.stringify(questions_tmp));
        var ic1s = JSON.parse(JSON.stringify(questions_tmp));
        var ic2s = JSON.parse(JSON.stringify(questions_tmp));
        var ic3s = JSON.parse(JSON.stringify(questions_tmp));
    }


    current_flashcard = -1;
    score = 0;
    missed = [];
    // Make arrays in a random order
    if(type == "Set"){
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
    }

    for (var i=c1s.length-1; i>=0; i--){
        var j = Math.floor(Math.random()*(i+1));
        [window.questions[i], window.questions[j], window.c1s[i], window.ic1s[i], window.ic2s[i], window.ic3s[i], window.c1s[j], window.ic1s[j], window.ic2s[j], window.ic3s[j]] = [questions[j], questions[i], c1s[j], ic1s[j], ic2s[j], ic3s[j], c1s[i], ic1s[i], ic2s[i], ic3s[i]];
    }

    // Typeset LaTeX
    MathJax.typeset();

    // Render signin button
    try { render_gSignIn(); } catch(e) {}

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
        missed.push(question);
    }
    $("#sbtn").show();
    $("#sbtn").html(`Next&nbsp;&nbsp;<i class="fa-solid fa-arrow-right-to-bracket"></i>`);
    $("#sbtn").attr("onclick","next()");
    MathJax.typeset();
}


function next(){
    current_flashcard++;
    if(current_flashcard == questions.length){
        // Done
        $("#sbtn").html(`Study Again&nbsp;&nbsp;<i class="fa-solid fa-rotate-right"></i>`);
        $("#sbtn").attr("onclick","init()");
        if(missed.length > 0){
            var str = `<h1>You've finished studying this set!</h1><p>Missed terms: `;
            for(var i=0;i<missed.length;i++){ str += missed[i]; str += "<br>"; }
            str += "</p>";
            $("#main-td").html(str);
        } else {
            $("#main-td").html(`<h1>You've finished studying this set!</h1>`);
        }
        return;
    }
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
        <div id='mc-div-outer'><div id='mc-div-inner'>
            <button id='response1' onclick='submit(0)'>`+answers[0]+`</button>
            <button id='response2' onclick='submit(1)'>`+answers[1]+`</button>
            <button id='response3' onclick='submit(2)'>`+answers[2]+`</button>
            <button id='response4' onclick='submit(3)'>`+answers[3]+`</button>
        </div></div>`);
    $(".complete").html((current_flashcard+1) + "/" + questions.length);
    $("#sbtn").hide();
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