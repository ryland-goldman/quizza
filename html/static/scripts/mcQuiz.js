var missed = [];
var missedC1 = [];
var missedIC1 = [];
var missedIC2 = [];
var missedIC3 = [];
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


function submit(answer) {
    a++;
    $("#t").fadeTo(100, 0, function() {
        setTimeout(function() {
            var correct = c1s[cn];
            if (answer == correct) {
                $("#main-td").html(`<h1 id='t'>Correct!</h1>
                        <p><strong>` + questions[cn] + `</strong> • ` + c1s[cn] + `</p>`);
                b++;
                $("#t").css({
                    color: "green"
                });
                MathJax.typeset()
            } else {
                missed.push(questions[cn]);
                missedC1.push(c1s[cn]);
                missedIC1.push(ic1s[cn]);
                missedIC2.push(ic2s[cn]);
                missedIC3.push(ic3s[cn]);
                $("#main-td").html(`<h1 id='t'>Incorrect.</h1>
                        <p><strong>` + questions[cn] + `</strong> • ` + c1s[cn] + `<br><small>You said "` + answer + `"</p>`);
                $("#t").css({
                    color: "red"
                });
                MathJax.typeset()
            }
            $("#sbtn").show().off("click").html('Next&nbsp;&nbsp;<i class="fa-solid fa-arrow-right"></i>').click(next);
            questions.splice(cn, 1);
            c1s.splice(cn, 1);
            ic1s.splice(cn, 1);
            ic2s.splice(cn, 1);
            ic3s.splice(cn, 1);
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
    var word = "";
    while (i < 1000) {
        i++;
        word = questions[Math.floor(Math.random() * questions.length)]
        if (word !== not && !getCW().includes(word)) {
            break;
        } else {
            console.log(word);
        }
    }
    return word;
}

function next() {
    $("#response1").html("");
    $("#response2").html("");
    $("#response3").html("");
    $("#response4").html("");
    $("#main-td").html(`<h1 id='t'></h1>
                        <div id='mc-div-outer'><div id='mc-div-inner'><button id='response1' onclick='submit(a1)'></button><br><button id='response2' onclick='submit(a2)'></button><br><button id='response3' onclick='submit(a3)'></button><br><button id='response4' onclick='submit(a4)'></button></div></div>`);
    $("#sbtn").hide();
    $("#t").css({
        color: "black"
    });
    cn = Math.floor(Math.random() * questions.length);

    if (questions.length !== 0) {
        $("#t").html(questions[cn]);
        var qas = shuffle([c1s[cn], ic1s[cn], ic2s[cn], ic3s[cn]]);
        a1 = qas[0];
        a2 = qas[1];
        a3 = qas[2];
        a4 = qas[3];
        $("#response1").html(a1);
        $("#response2").html(a2);
        $("#response3").html(a3);
        $("#response4").html(a4);
    }
    if (questions.length == 0) {
        if (learnmode) {
            if (missed.length == 0) {
                location.href = "../fr?learn=true";
            } else {
                questions = missed;
                c1s = missedC1;
                ic1s = missedIC1;
                ic2s = missedIC2;
                ic3s = missedIC3;
                next();
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

function shuffle(a) {
    for (let i = a.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [a[i], a[j]] = [a[j], a[i]];
    }
    return a;
}

function init() {
    allWords = questions.slice(0);
    if (localStorage.getItem("disabledTerms") === null) {
        localStorage.setItem("disabledTerms", "[]");
    }
    var dt = JSON.parse(localStorage.getItem("disabledTerms")).slice(0);
    for (var p = 0; p < dt.length; p++) {
        dt[p] = decodeURIComponent(dt[p]).replaceAll("+", " ");
    }
    questions = questions.filter(function(item, index) {
        if (dt.includes(item)) {
            c1 = c1.filter(function(j, k) {
                if (k == index) {
                    return false;
                }
                return true;
            });
            ic1 = ic1.filter(function(j, k) {
                if (k == index) {
                    return false;
                }
                return true;
            });
            ic2 = ic2.filter(function(j, k) {
                if (k == index) {
                    return false;
                }
                return true;
            });
            ic3 = ic3.filter(function(j, k) {
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
  <div id='mc-div-outer'><div id='mc-div-inner'><button id='response1' onclick='submit(a1)'></button><br><button id='response2' onclick='submit(a2)'></button><br><button id='response3' onclick='submit(a3)'></button><br><button id='response4' onclick='submit(a4)'></button></div></div>`);
    $("#sbtn").hide();
    cn = Math.floor(Math.random() * questions.length);
    if (true) {
        $("#t").html(questions[cn]);
        var qas = shuffle([c1s[cn], ic1s[cn], ic2s[cn], ic3s[cn]]);
        a1 = qas[0];
        a2 = qas[1];
        a3 = qas[2];
        a4 = qas[3];
        $("#response1").html(a1);
        $("#response2").html(a2);
        $("#response3").html(a3);
        $("#response4").html(a4);
    }
    MathJax.typeset()
}