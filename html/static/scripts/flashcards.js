var current_flashcard = -1;
var start_with_term = true;
var is_flipped = false;
var total = -1;

function init(){
    current_flashcard = -1;
    is_flipped = false;
    total = -1;

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

    $(".back-side").hide();

    // Make arrays in a random order
    for (var i=words.length-1; i>=0; i--){
        var j = Math.floor(Math.random()*(i+1));
        [window.words[i], window.words[j], window.defs[i], window.defs[j]] = [words[j], words[i], defs[j], defs[i]];
    }

    // Get session storage state
    start_with_term = (sessionStorage.def=="false");

    // First flashcard
    next();

    // Typeset LaTeX
    MathJax.typeset();

    // Render signin button
    try { render_gSignIn(); } catch(e) {}

    // Set key press buttons
    document.body.onkeydown = function(e) {
        var keycode;
        if (window.event) { keycode = window.event.keyCode; } else if (e) { keycode = e.which }; // Get keycode
        
        switch (keycode) {
            case 39:
                if (current_flashcard == words.length) { location.reload(); } else { next(); }
                break;
            case 32:
                reveal();
                break;
            case 37:
                back();
                break;
            default:
                console.log(keycode);
        }
    }
}

function reveal(){
    $("#flashcard").toggleClass("front").toggleClass("back");
    $(".front-side").toggle();
    $(".back-side").toggle();
    is_flipped = !is_flipped;
}

function next(go_back = false){
    if(is_flipped){ reveal(); }

    if(go_back && current_flashcard == 0){ return; }
    if(go_back) { current_flashcard--; } else { current_flashcard++; }

    if (current_flashcard == words.length){
        // End 
        $("#t0").removeClass("sm");
        $("#t0").html("You've finished studying this set!");
        $(".study-btn-bottom").html(`<button class='btn-blue' onclick='location.reload()'>Study More&nbsp;&nbsp;<i class="fa-solid fa-rotate"></i></button> <button onclick='location.href=return_url;'>Return Home&nbsp;&nbsp;<i class="fa-solid fa-house"></i></button>`);
    } else {
        // Next flashcard
        $("#t0").html(start_with_term ? words[current_flashcard] : defs[current_flashcard]);
        $("#t1").html(start_with_term ? defs[current_flashcard] : words[current_flashcard]);

        // Long flashcards need smaller text sizes
        if ($("#t0").html().length > 50) { $("#t0").addClass("sm"); } else { $("#t0").removeClass("sm"); }
        if ($("#t1").html().length > 50) { $("#t1").addClass("sm"); } else { $("#t1").removeClass("sm"); }

        // Update number completed
        $(".complete").html((current_flashcard+1) + "/" + words.length);
    }

    // Typeset LaTeX
    MathJax.typeset();
}

function back(){ next(true); }

// Start with term
function swt(){
    if(is_flipped){ reveal(); }
    var start_with_term = true;
    sessionStorage.def = "false";
    init();
}

// Start with definition
function swd(){
    if(is_flipped){ reveal(); }
    var start_with_term = false;
    sessionStorage.def = "true";
    init();
}