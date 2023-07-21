var current_flashcard = 0;
var start_with_term = true;
var is_flipped = false;
var total = -1;

function init(){
    // Make arrays in a random order
    for (var i=words.length-1; i>=0; i--){
        var j = Math.floor(Math.random()*(i+1));
        [window.words[i], window.words[j], window.defs[i], window.defs[j]] = [words[j], words[i], defs[j], defs[i]];
    }

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
            default:
                console.log(keycode);
        }
    }
}

function reveal(){
    $("#card").flip();
    is_flipped = !is_flipped;
}

function next(){
    if(is_flipped){ is_flipped = false; $("#card").flip(); }

    current_flashcard++;
    if (current_flashcard == words.length){
        // End 
        $("#t0").removeClass("sm");
        $("#t0").html("You've finished studying this set!");
        $("#bottom-btns").html(`<button class='btn-blue' onclick='location.reload()'>Study More&nbsp;&nbsp;<i class="fa-solid fa-rotate"></i></button> <button onclick='location.href="../"'>Return Home&nbsp;&nbsp;<i class="fa-solid fa-house"></i></button>`);
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

/*
var cn = 0;
var toggle = false;
var done = 1;
var total = 0;
var f = false;
var term_or_definition = true; // 1 = show term, 0 = show definition

function swt() {
    term_or_definition = true;
    cn = Math.floor(Math.random() * words.length);
    $("#t").html(words[cn]);
    MathJax.typeset()
    sessionStorage.def = false;
}

function swd() {
    term_or_definition = false;
    cn = Math.floor(Math.random() * words.length);
    $("#t").html(defs[cn]);
    MathJax.typeset()
    sessionStorage.def = true;
}

function reveal() {
    $("#t").fadeTo(100, 0, function() {
        setTimeout(function() {
            if (cn !== -1) {
                if (!toggle) {
                    $("#t").html(defs[cn]);
                    if (defs[cn].length > 50) {
                        $("#t").addClass("sm");
                    } else {
                        $("#t").removeClass("sm");
                    }
                } else {
                    $("#t").html(words[cn]);
                    if (words[cn].length > 50) {
                        $("#t").addClass("sm");
                    } else {
                        $("#t").removeClass("sm");
                    }
                }
            } else {
                if (!toggle) {
                    $("#t").html(cd);
                    if (cd.length > 50) {
                        $("#t").addClass("sm");
                    } else {
                        $("#t").removeClass("sm");
                    }
                } else {
                    $("#t").html(cw);
                    if (cw.length > 50) {
                        $("#t").addClass("sm");
                    } else {
                        $("#t").removeClass("sm");
                    }
                }
            }
            MathJax.typeset()
            toggle = !toggle;
        }, 100);
        $(this).delay(100);
        $("#t").fadeTo(100, 1);
    });
}

function next() {
    toggle = !term_or_definition;
    backW.push(words[cn]);
    backD.push(defs[cn]);
    words.splice(cn, 1);
    defs.splice(cn, 1);
    cn = Math.floor(Math.random() * words.length);
    if (words.length != 0) {
        if (term_or_definition) {
            $("#t").html(words[cn]);
            if (words[cn].length > 50) {
                $("#t").addClass("sm");
            } else {
                $("#t").removeClass("sm");
            }
        } else {
            $("#t").html(defs[cn]);
            if (defs[cn].length > 50) {
                $("#t").addClass("sm");
            } else {
                $("#t").removeClass("sm");
            }
        }
    }
    MathJax.typeset()
    done++;
    $("#complete").html(done + "/" + total);
    if (words.length == 0) {
        $("#t").removeClass("sm");
        $("#t").html("You've finished studying this set!");
        $("#bottom-btns").html(`<button class='btn-blue' onclick='location.reload()'>Study More&nbsp;&nbsp;<i class="fa-solid fa-rotate"></i></button>
            <button onclick='location.href="../"'>Return Home&nbsp;&nbsp;<i class="fa-solid fa-house"></i></button>`);
        f = true;
    }
}

var backW, backD;
var cw = "";
var cd = "";

function back() {
    if (backW.length == 0) {
        return;
    }
    toggle = !term_or_definition;
    cw = backW.pop();
    cd = backD.pop();
    words.push(cw);
    defs.push(cd);
    if (term_or_definition) {
        $("#t").html(cw);
        if (cw.length > 50) {
            $("#t").addClass("sm");
        } else {
            $("#t").removeClass("sm");
        }
    } else {
        $("#t").html(cd);
        if (cd.length > 50) {
            $("#t").addClass("sm");
        } else {
            $("#t").removeClass("sm");
        }
    }
    MathJax.typeset()
    done--;
    $("#complete").html(done + "/" + total);
}

function init() {
    if (localStorage.getItem("disabledTerms") === null) {
        localStorage.setItem("disabledTerms", "[]");
    }
    var dt = JSON.parse(localStorage.getItem("disabledTerms")).slice(0);
    for (var p = 0; p < dt.length; p++) {
        dt[p] = decodeURIComponent(dt[p]).replaceAll("+", " ");
    }
    words = words.filter(function(item, index) {
        if (dt.includes(item)) {
            defs = defs.filter(function(j, k) {
                if (k == index) {
                    return false;
                }
                return true;
            });
            return false;
        } else {
            return true;
        }
    });

    total = words.length;
    $("#complete").html(done + "/" + total);
    if (sessionStorage.def == "true") {
        term_or_definition = false;
    }
    toggle = !term_or_definition;
    cn = Math.floor(Math.random() * words.length);
    if (term_or_definition) {
        $("#t").html(words[cn]);
        if (words[cn].length > 50) {
            $("#t").addClass("sm");
        } else {
            $("#t").removeClass("sm");
        }
    } else {
        $("#t").html(defs[cn]);
        if (defs[cn].length > 50) {
            $("#t").addClass("sm");
        } else {
            $("#t").removeClass("sm");
        }
    }
    MathJax.typeset()
    try { render_gSignIn(); } catch(e) {}
    document.body.onkeydown = function(e) {
        var keycode;
        if (window.event)
            keycode = window.event.keyCode;
        else if (e)
            keycode = e.which;
        switch (keycode) {
            case 39:
                if (f) {
                    location.reload();
                } else {
                    next();
                }
                break;
            case 32:
                reveal();
                break;
            default:
                console.log(keycode);
        }
    }
    window.backW = [];
    window.backD = [];
}
*/