var missed = [];
var missedDefs = [];
var cn = 0;
var toggle = false;
var b = 0;
var total = 0;
var done = 0;

var term_or_definition = true; // 1 = show term, 0 = show definition

function swt() {
    term_or_definition = true;
    cn = Math.floor(Math.random() * words.length);
    $("#t").html(words[cn]);
    sessionStorage.def = false;
    location.reload();
}

function swd() {
    term_or_definition = false;
    cn = Math.floor(Math.random() * words.length);
    $("#t").html(defs[cn]);
    sessionStorage.def = true;
    location.reload();
}
var or_string = "";

function submit() {
    $("#t").fadeTo(100, 0, function() {
        setTimeout(function() {
            $(document).on('keypress', function(e) {
                if (e.which === 13 || e.which === 32) {
                    next();
                }
            });
            if (!toggle) {
                var correct = defs[cn];
                var indx_val_no = words[cn];
            } else {
                var correct = words[cn];
                var indx_val_no = defs[cn];
            }
            toggle = !toggle;
            var answer = $("#response").val();
            if (answer.toLowerCase() == correct.toLowerCase()) {
                var indx_val = missed.indexOf(indx_val_no);
                if (indx_val !== -1) {
                    missed.splice(indx_val, 1);
                    missedDefs.splice(indx_val, 1);
                }
                $("#main-td").html(`<h1 id='t'>Correct!</h1>
                                                <p><strong>` + words[cn] + `</strong> <i class="fa-solid fa-arrow-right-arrow-left"></i> ` + defs[cn] + `</p>`);
                $("#t").css({
                    color: "green"
                });
                b++;
                MathJax.typeset()
            } else {
                if (missed.indexOf(words[cn]) == -1) {
                    missed.push(words[cn]);
                    missedDefs.push(defs[cn]);
                }
                or_string = `<strong>` + words[cn] + `</strong> <i class="fa-solid fa-arrow-right-arrow-left"></i> ` + defs[cn];
                $("#main-td").html(`<h1 id='t'>Incorrect.</h1>
                                                <p><strong>` + words[cn] + `</strong> <i class="fa-solid fa-arrow-right-arrow-left"></i> ` + defs[cn] + `<br><small>You said "` + answer + `" <i class="fa-solid fa-arrow-right-arrow-left"></i> <a
href='javascript:or()'>Mark Correct</a></small></p>`);
                $("#t").css({
                    color: "red"
                });
                MathJax.typeset()
            }
            words.splice(cn, 1);
            defs.splice(cn, 1);
            if (learnmode) {
                $("#sbtn").off("click").html('Next&nbsp;&nbsp;<i class="fa-solid fa-arrow-right"></i>').click(next);
            } else {
                $("#sbtn").off("click").html('Next (' + done + '/' + total + ')&nbsp;&nbsp;<i class="fa-solid fa-arrow-right"></i>').click(next);
            }
            done++;
        }, 100);
        $(this).delay(100);
        $("#t").fadeTo(100, 1);
    });
}

function or() {
    if (toggle) {
        var indx_val_no = words[cn];
    } else {
        var indx_val_no = defs[cn];
    }
    var indx_val = missed.indexOf(indx_val_no);
    if (indx_val !== -1) {
        missed.splice(indx_val, 1);
        missedDefs.splice(indx_val, 1);
    }
    b++;
    $("#main-td").html(`<h1 id='t'>Correct!</h1>
                                                <p>` + or_string + `</p>`);
    $("#t").css({
        color: "green"
    });
    MathJax.typeset()
}

function next() {
    $("#t").css({
        color: "black"
    });
    $("#main-td").html(`<h1 id='t'></h1>
                                                <input id='response' autocomplete='off'>`);
    $(document).off("keypress");
    $('#response').on('keypress', function(e) {
        if (e.which === 13) {
            submit();
        }
    }).select();
    $("#sbtn").off("click").html('Submit (' + done + '/' + total + ')&nbsp;&nbsp;<i class="fa-solid fa-arrow-right-to-bracket"></i>').click(submit);
    toggle = !term_or_definition;
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
    } else {
        if (learnmode) {
            if (missed.length == 0) {
                $("#main-td").html(`<h1>You've finished learn mode!</h1>`);
                $("#bottom-btns").html(`<button style='background-color:#0668FD;border-radius:8px;border:2px solid #0668FD;padding:12px 36px;color:white;font-size:1em;'
    }
onclick='location.href="../mc/?learn=true"'>Study More&nbsp;&nbsp;<i class="fa-solid fa-rotate"></i></button>
<button style='background-color:#FFF;border-radius:8px;border:2px solid #0668FD;padding:12px 36px;color:black;font-size:1em;margin-bottom:12px;'
onclick='location.href="../"'>Return Home&nbsp;&nbsp;<i class="fa-solid fa-house"></i></button>`);
            } else {
                window.words = missed.slice();
                window.defs = missedDefs.slice();
                if (words.length !== 0) {
                    next();
                } else {}
            }
        } else {
            $("#main-td").html(`<h1 id='t'></h1><p id='missed'><strong>You missed:</strong><br></p>`);
            $("#t").html("You've finished studying this set!<br>Score: " + b + "/" + total);
            for (var i = 0; i < missed.length; i++) {
                document.getElementById("missed").innerHTML += missed[i] + "<br>";
            }
            allowreview = !missed.length;
            console.log(allowreview);
            if (!allowreview) {
                $("#bottom-btns").html(`<button style='background-color:#0668FD;border-radius:8px;border:2px solid #0668FD;padding:12px 36px;color:white;font-size:1em;'
onclick='location.reload()'>Study More&nbsp;&nbsp;<i class="fa-solid fa-rotate"></i></button>
            <button style='background-color:#FFF;border-radius:8px;border:2px solid #0668FD;padding:12px 36px;color:black;font-size:1em;margin-bottom:12px;'
onclick='location.href="../"'>Return Home&nbsp;&nbsp;<i class="fa-solid fa-house"></i></button> <button style='background-color:#FFF;border-radius:8px;border:2px solid #0668FD;padding:12px 36px;color:black;font-size:1em;margin-bottom:12px;'
onclick='reviewMissed()'>Review Missed Questions&nbsp;&nbsp;<i class="fa-solid fa-rotate-right"></i></button>`);
            } else {
                $("#bottom-btns").html(`<button style='background-color:#0668FD;border-radius:8px;border:2px solid #0668FD;padding:12px 36px;color:white;font-size:1em;'
onclick='location.reload()'>Study More&nbsp;&nbsp;<i class="fa-solid fa-rotate"></i></button>
<button style='background-color:#FFF;border-radius:8px;border:2px solid #0668FD;padding:12px 36px;color:black;font-size:1em;margin-bottom:12px;'
onclick='location.href="../"'>Return Home&nbsp;&nbsp;<i class="fa-solid fa-house"></i></button>`);
            }
        }
    }
    MathJax.typeset()
}

function reviewMissed() {
    words = missed;
    defs = missedDefs;
    missed = [];
    missedDefs = [];
    cn = 0;
    toggle = false;
    b = 0;
    total = 0;
    done = 0;
    $("#bottom-btns").html(`<button style='background-color:#0668FD;border-radius:8px;border:2px solid #0668FD;padding:12px 36px;color:white;font-size:1em;' id='sbtn'>Submit (--/--)&nbsp;&nbsp;<i
class="fa-solid fa-arrow-right-to-bracket"></i></button>
  <a rel="modal:open" href='#options'><button style='background-color:#FFF;border-radius:8px;border:2px solid #0668FD;padding:12px
36px;color:black;font-size:1em;margin-bottom:12px;' onclick='options()'>Options&nbsp;&nbsp;<i class="fa-solid fa-sliders"></i></button></a>`);
    init();
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
    done = 1;
    $("#main-td").html(`<h1 id='t'></h1>
                                                <input id='response' autocomplete='off'>`);
    $('#response').on('keypress', function(e) {
        if (e.which === 13) {
            submit();
        }
    }).select();
    $("#sbtn").html('Submit (' + done + '/' + total + ')&nbsp;&nbsp;<i class="fa-solid fa-arrow-right-to-bracket"></i>').off("click").click(submit);
    if (sessionStorage.def == "true") {
        term_or_definition = false;
    }
    toggle = !term_or_definition;
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

}