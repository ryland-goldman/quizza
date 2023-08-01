var missedD = [];
var missed = [];
var cn = 0;
var toggle = false;
var a = 0;
var f = false;
var b = 0;
var a1, a2, a3, a4;
document.body.onkeydown = function(e) {
    var keycode;
    if (window.event)
        keycode = window.event.keyCode;
    else if (e)
        keycode = e.which;
    switch (keycode) {
        case 32:
            if (!f && ($("#response1").length == 0 || $("#response1") == null)) {
                next();
            }
            break;
        case 39:
            if (!f && ($("#response1").length == 0 || $("#response1") == null)) {
                next();
            }
            break;
        case 13:
            if (!f && ($("#response1").length == 0 || $("#response1") == null)) {
                next();
            }
            break;
        case 49:
            submit(a1);
            break;
        case 65:
            submit(a1);
            break;
        case 50:
            submit(a2);
            break;
        case 66:
            submit(a2);
            break;
        case 51:
            submit(a3);
            break;
        case 67:
            submit(a3);
            break;
        case 52:
            submit(a4);
            break;
        case 68:
            submit(a4);
            break;
        default:
            console.log(keycode);
    }
}
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

function submit(answer) {
    a++;
    $("#t").fadeTo(100, 0, function() {
        setTimeout(function() {
            if (!toggle) {
                var correct = defs[cn];
                var indx_val_no = words[cn];
            } else {
                var correct = words[cn];
                var indx_val_no = defs[cn];
            }
            toggle = !toggle;
            if (answer == correct) {
                var indx_val = missed.indexOf(indx_val_no);
                if (indx_val !== -1) {
                    missed.splice(indx_val, 1);
                    missedD.splice(indx_val, 1);
                }
                $("#main-td").html(`<h1 id='t'>Correct!</h1>
                        <p><strong>` + words[cn] + `</strong> <i class="fa-solid fa-arrow-right-arrow-left"></i> ` + defs[cn] + `</p>`);
                b++;
                $("#t").css({
                    color: "green"
                });
                MathJax.typeset()
            } else {
                if (missed.indexOf(words[cn]) == -1) {
                    missed.push(words[cn]);
                    missedD.push(defs[cn]);
                }
                $("#main-td").html(`<h1 id='t'>Incorrect.</h1>
                        <p><strong>` + words[cn] + `</strong> <i class="fa-solid fa-arrow-right-arrow-left"></i> ` + defs[cn] + `<br><small>You said "` + answer + `"</p>`);
                $("#t").css({
                    color: "red"
                });
                MathJax.typeset()
            }
            words.splice(cn, 1);
            defs.splice(cn, 1);
            $("#sbtn").show().off("click").html('Next&nbsp;&nbsp;<i class="fa-solid fa-arrow-right"></i>').click(next);
        }, 100);
        $(this).delay(100);
        $("#t").fadeTo(100, 1);
    });
}

function getCW() {
    return [a1, a2, a3, a4];
}

function getWord(not) {
    var i = 0;
    if (!term_or_definition) {
        var word = "";
        while (i < 100) {
            i++;
            word = allWords[Math.floor(Math.random() * allWords.length)]
            if (word !== not && !getCW().includes(word)) {
                break;
            } else {
                console.log(word);
            }
        }
        return word;
    } else {
        var word = "";
        while (i < 100) {
            i++;
            word = allDefs[Math.floor(Math.random() * allDefs.length)]
            if (word !== not && !getCW().includes(word)) {
                break;
            } else {
                console.log(word);
            }
        }
        return word;
    }
}

function next() {
    $("#response1").html("");
    $("#response2").html("");
    $("#response3").html("");
    $("#response4").html("");
    $("#main-td").html(`<h1 id='t'></h1>
                        <div id='mc-div-outer'><div id='mc-div-inner'><button id='response1' onclick='submit(a1)'></button><button id='response2' onclick='submit(a2)'></button><button id='response3' onclick='submit(a3)'></button><button id='response4' onclick='submit(a4)'></button></div></div>`);
    $("#sbtn").hide();
    $("#t").css({
        color: "black"
    });
    if (words.length !== 0) {
        toggle = !term_or_definition;
        cn = Math.floor(Math.random() * words.length);

        if (!term_or_definition) {
            $("#t").html(defs[cn]);
            var cnp = Math.floor(Math.random() * 4);
            if (cnp == 1) {
                a1 = words[cn];
                a2 = getWord(words[cn]);
                a3 = getWord(words[cn]);
                a4 = getWord(words[cn]);
            } else if (cnp == 2) {
                a2 = words[cn];
                a1 = getWord(words[cn]);
                a3 = getWord(words[cn]);
                a4 = getWord(words[cn]);
            } else if (cnp == 3) {
                a3 = words[cn];
                a2 = getWord(words[cn]);
                a1 = getWord(words[cn]);
                a4 = getWord(words[cn]);
            } else {
                a4 = words[cn];
                a2 = getWord(words[cn]);
                a3 = getWord(words[cn]);
                a1 = getWord(words[cn]);
            }
            $("#response1").html(a1);
            $("#response2").html(a2);
            $("#response3").html(a3);
            $("#response4").html(a4);
        } else {
            $("#t").html(words[cn]);
            var cnp = Math.floor(Math.random() * 4);
            if (cnp == 1) {
                a1 = defs[cn];
                a2 = getWord(defs[cn]);
                a3 = getWord(defs[cn]);
                a4 = getWord(defs[cn]);
            } else if (cnp == 2) {
                a2 = defs[cn];
                a1 = getWord(defs[cn]);
                a3 = getWord(defs[cn]);
                a4 = getWord(defs[cn]);
            } else if (cnp == 3) {
                a3 = defs[cn];
                a2 = getWord(defs[cn]);
                a1 = getWord(defs[cn]);
                a4 = getWord(defs[cn]);
            } else {
                a4 = defs[cn];
                a2 = getWord(defs[cn]);
                a3 = getWord(defs[cn]);
                a1 = getWord(defs[cn]);
            }
            $("#response1").html(a1);
            $("#response2").html(a2);
            $("#response3").html(a3);
            $("#response4").html(a4);
        }
    } else {
        if (learnmode) {
            if (missed.length == 0) {
                location.href = "../fr?learn=true";
            } else {
                window.words = missed.slice();
                window.defs = missedD.slice();
                if (words.length !== 0) {
                    next();
                } else {}
            }
        } else {
            $("#main-td").html(`<h1 id='t'></h1><p id='missed'><strong>You missed:</strong><br></p>`);
            $("#t").html("You've finished studying this set!<br>Score: " + b + "/" + a);
            for (var i = 0; i < missed.length; i++) {
                document.getElementById("missed").innerHTML += missed[i] + "<br>";
            }
            $("#bottom-btns").html(`<button style='background-color:#0668FD;border-radius:8px;border:2px solid #0668FD;padding:12px 36px;color:white;font-size:1em;'
onclick='location.reload()'>Study More&nbsp;&nbsp;<i class="fa-solid fa-rotate"></i></button>
      <button style='background-color:#FFF;border-radius:8px;border:2px solid #0668FD;padding:12px 36px;color:black;font-size:1em;margin-bottom:12px;'
onclick='location.href="../"'>Return Home&nbsp;&nbsp;<i class="fa-solid fa-house"></i></button>`);
            f = true;
        }
    }
    MathJax.typeset()
}

function init() {
    allWords = words.slice(0);
    allDefs = defs.slice(0);
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
    $("#main-td").html(`<h1 id='t'></h1>
  <div id='mc-div-outer'><div id='mc-div-inner'><button id='response1' onclick='submit(a1)'></button><button id='response2' onclick='submit(a2)'></button><button id='response3' onclick='submit(a3)'></button><button id='response4' onclick='submit(a4)'></button></div></div>`);
    $("#sbtn").hide();
    if (sessionStorage.def == "true") {
        term_or_definition = false;
    }
    toggle = !term_or_definition;
    cn = Math.floor(Math.random() * words.length);
    if (!term_or_definition) {
        $("#t").html(defs[cn]);
        var cnp = Math.floor(Math.random() * 4);
        if (cnp == 1) {
            a1 = words[cn];
            a2 = getWord(words[cn]);
            a3 = getWord(words[cn]);
            a4 = getWord(words[cn]);
        } else if (cnp == 2) {
            a2 = words[cn];
            a1 = getWord(words[cn]);
            a3 = getWord(words[cn]);
            a4 = getWord(words[cn]);
        } else if (cnp == 3) {
            a3 = words[cn];
            a2 = getWord(words[cn]);
            a1 = getWord(words[cn]);
            a4 = getWord(words[cn]);
        } else {
            a4 = words[cn];
            a2 = getWord(words[cn]);
            a3 = getWord(words[cn]);
            a1 = getWord(words[cn]);
        }
        $("#response1").html(a1);
        $("#response2").html(a2);
        $("#response3").html(a3);
        $("#response4").html(a4);
    } else {
        $("#t").html(words[cn]);
        var cnp = Math.floor(Math.random() * 4);
        if (cnp == 1) {
            a1 = defs[cn];
            a2 = getWord(defs[cn]);
            a3 = getWord(defs[cn]);
            a4 = getWord(defs[cn]);
        } else if (cnp == 2) {
            a2 = defs[cn];
            a1 = getWord(defs[cn]);
            a3 = getWord(defs[cn]);
            a4 = getWord(defs[cn]);
        } else if (cnp == 3) {
            a3 = defs[cn];
            a2 = getWord(defs[cn]);
            a1 = getWord(defs[cn]);
            a4 = getWord(defs[cn]);
        } else {
            a4 = defs[cn];
            a2 = getWord(defs[cn]);
            a3 = getWord(defs[cn]);
            a1 = getWord(defs[cn]);
        }
        $("#response1").html(a1);
        $("#response2").html(a2);
        $("#response3").html(a3);
        $("#response4").html(a4);
    }
    MathJax.typeset()
}