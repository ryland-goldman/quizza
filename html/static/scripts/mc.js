var current_flashcard = -1;
var start_with_term = true;
var score = 0;
var answers = [];
var missed = [];
var repeated = false;
var answer_pending = false;

function shuffleArray(arr) {
    for (var i = arr.length - 1; i > 0; i--) {
        var j = Math.floor(Math.random() * (i + 1));
        [arr[i], arr[j]] = [arr[j], arr[i]];
    }
}

function check_arrays() {
    for (var i = 0; i < c1s.length; i++) {
        if (c1s[i] == ic1s[i] || c1s[i] == ic2s[i] || c1s[i] == ic3s[i] || ic1s[i] == ic2s[i] || ic1s[i] == ic3s[i] || ic2s[i] == ic3s[i]) {
            shuffleArray(ic1s); // Shuffle ic1s
            shuffleArray(ic2s); // Shuffle ic2s
            shuffleArray(ic3s); // Shuffle ic3s
            return true;
        }
    }
    return false;
}

function init(){
    $("#optionsBtn").show();
    // Get session storage state
    if(sessionStorage.def){ start_with_term = (sessionStorage.def=="false"); }
    else { sessionStorage.def = "false"; }

    // Disabled terms
    try {
        var disabled_terms = JSON.parse(sessionStorage.disabledTerms);
        for (var i=0;i<disabled_terms.length;i++){
            if(questions.includes(decodeURIComponent(disabled_terms[i]))){
                c1s.splice(questions.indexOf(disabled_terms[i]));
                ic1s.splice(questions.indexOf(disabled_terms[i]));
                ic2s.splice(questions.indexOf(disabled_terms[i]));
                ic3s.splice(questions.indexOf(disabled_terms[i]));
                questions.splice(questions.indexOf(disabled_terms[i]));
            }
        }
    } catch(e) {}

    // Shuffle
    if(!start_with_term && type == "Set" && !repeated){
        var questions_tmp = JSON.parse(JSON.stringify(questions));
        questions = JSON.parse(JSON.stringify(c1s));
        c1s = JSON.parse(JSON.stringify(questions_tmp));
        ic1s = JSON.parse(JSON.stringify(questions_tmp));
        ic2s = JSON.parse(JSON.stringify(questions_tmp));
        ic3s = JSON.parse(JSON.stringify(questions_tmp));
    }


    current_flashcard = -1;
    score = 0;
    missed = [];
    // Make arrays in a random order
    if(type == "Set"){
        var check_n = 0;
        var max_iters = 1000;
        if(questions.length == 10){ max_iters = 2000;}
        if(questions.length == 9){ max_iters = 3000;}
        if(questions.length == 8){ max_iters = 4500;}
        if(questions.length == 7){ max_iters = 6000;}
        if(questions.length == 6){ max_iters = 7500;}
        if(questions.length == 5){ max_iters = 9000;}
        if(questions.length == 4){ max_iters = 11000;}
        while(check_arrays()){
            check_n++;
            if(check_n == max_iters){ break; }
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

    document.body.onkeydown = function(e) {
        var keycode;
        if (window.event) { keycode = window.event.keyCode; } else if (e) { keycode = e.which }; // Get keycode
        
        switch (keycode) {
            case 13:
                if (!answer_pending && current_flashcard !== questions.length) { next(); } else if (!answer_pending){ location.reload(); }
                break;
            case 49:
                if(answer_pending){submit(0);}
                break;
            case 50:
                if(answer_pending){submit(1);}
                break;
            case 51:
                if(answer_pending){submit(2);}
                break;
            case 53:
                if(answer_pending){submit(3);}
                break;
            default:
                console.log(keycode);
        }
    }
}

function submit(answer){
    answer_pending = false;
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
        $("#optionsBtn").hide();
        if(missed.length > 0){
            if(learnmode){ again(); return; }
            var str = `<h1>You've finished studying this set!</h1><p>Missed terms: (<a href="javascript:again();" id='tryagain'>try again with missed</a>)<br>`;
            for(var i=0;i<missed.length;i++){ str += missed[i]; str += "<br>"; }
            str += "</p>";
            $("#main-td").html(str);
        } else {
            if(learnmode){ location.href = 'fr?learn=true'; return; }
            $("#main-td").html(`<h1>You've finished studying this set!</h1>`);
        }
        return;
    }
    answer_pending = true;
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

function again(){
    repeated = true;
    if(type == "Set"){
        shuffleArray(ic1s);
        shuffleArray(ic2s);
        shuffleArray(ic3s);
        var new_c1s = [];
        for(var i=0;i<missed.length;i++){
            for(var j=0;j<questions.length;j++){
                if(missed[i] == questions[j]){ new_c1s.push(c1s[j]); }
            }
        }
        questions = JSON.parse(JSON.stringify(missed));
        c1s = JSON.parse(JSON.stringify(new_c1s));
    } else {
        var new_c1s = [];
        var new_ic1s = [];
        var new_ic2s = [];
        var new_ic3s = [];
        for(var i=0;i<missed.length;i++){
            for(var j=0;j<questions.length;j++){
                if(missed[i] == questions[j]){
                    new_c1s.push(c1s[j]);
                    new_ic1s.push(ic1s[j]);
                    new_ic2s.push(ic2s[j]);
                    new_ic3s.push(ic3s[j]);
                }
            }
        }
        questions = JSON.parse(JSON.stringify(missed));
        c1s = JSON.parse(JSON.stringify(new_c1s));
        ic1s = JSON.parse(JSON.stringify(new_ic1s));
        ic2s = JSON.parse(JSON.stringify(new_ic2s));
        ic3s = JSON.parse(JSON.stringify(new_ic3s));
    }
    init();
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