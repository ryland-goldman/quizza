function disableTerm(term, iconId) {
    if (localStorage.getItem("disabledTerms") === null) {
        localStorage.setItem("disabledTerms", "[]");
    }
    var dt = JSON.parse(localStorage.getItem("disabledTerms")).slice(0);
    for (var p = 0; p < dt.length; p++) {
        dt[p] = decodeURIComponent(dt[p]);
    }
    if (dt.includes(term)) {
        dt = dt.filter(function(t) {
            return t !== term;
        });
        $("#icon-" + iconId).attr("class", "fa-solid fa-eye");
        $("#container-" + iconId).attr("class", "item-card enabled");
    } else {
        dt.push(term);
        $("#icon-" + iconId).attr("class", "fa-solid fa-eye-slash");
        $("#container-" + iconId).attr("class", "item-card disabled");
    }
    for (var p = 0; p < dt.length; p++) {
        dt[p] = encodeURIComponent(dt[p]);
    }
    console.log(dt);
    localStorage.setItem("disabledTerms", JSON.stringify(dt));
}

var pdftext = "Name: __________________________________\tPeriod: _____\tDate: ________________\nPrinted from Quizza.org\n\n";
var a1, a2, a3, a4;

function getCW() {
    return [a1, a2, a3, a4];
}

function prnt() {
    var words = allWords.slice();
    var defs = allDefs.slice();
    var cn = 0;
    while (true) {
        if (words.length == 0) {
            break;
        }
        cn = Math.floor(Math.random() * words.length);
        console.log(cn);
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
        pdftext += words[cn];
        pdftext += "\na. " + a1;
        pdftext += "\nb. " + a2;
        pdftext += "\nc. " + a3;
        pdftext += "\nd. " + a4;
        pdftext += "\n\n";
        words.splice(cn, 1);
        defs.splice(cn, 1);
    }

    var doc = new jsPDF();
    var splitText = doc.splitTextToSize(pdftext, 250);
    var pageHeight = doc.internal.pageSize.height;
    doc.setFontSize(11);
    var y = 20;
    for (var i = 0; i < splitText.length; i++) {
        if (y > 275) {
            y = 20;
            doc.addPage();
        }
        doc.text(20, y, splitText[i]);
        y = y + 5;
    }
    doc.save("download.pdf");
}

function getWord(not) {
    var i = 0;
    var cgwd = "";
    while (i < 100) {
        i++;
        cgwd = allDefs[Math.floor(Math.random() * allDefs.length)]
        if (cgwd !== not && !getCW().includes(cgwd)) {
            break;
        } else {
            console.log(cgwd);
        }
    }
    if (cgwd == "") {
        return getWord(not);
    }
    return cgwd;
}

function load_function() {
    if (localStorage.getItem("disabledTerms") === null) {
        localStorage.setItem("disabledTerms", "[]");
    }
    var dt = JSON.parse(localStorage.getItem("disabledTerms")).slice(0);
    for (var p = 0; p < dt.length; p++) {
        dt[p] = decodeURIComponent(dt[p]).replaceAll("+", " ");
    }
    terms.forEach(function(term, index) {
        if (dt.includes(term[0])) {
            $("#icon-" + term[1]).attr("class", "fa-solid fa-eye-slash");
            $("#container-" + term[1]).attr("class", "item-card disabled");
        } else {
            $("#icon-" + term[1]).attr("class", "fa-solid fa-eye");
            $("#container-" + term[1]).attr("class", "item-card enabled");
        }
    });
    try { render_gSignIn(); } catch (e) {}
    try { share_script_init(); } catch {}
}

MathJax = {
    tex: {
        inlineMath: [
            ['\\(', '\\)']
        ]
    }
};

function flip(array) {
    for (let i = 0; i < array.length; i++) {
        for (let j = 0; j < Math.floor(array[i].length / 2); j++) {
            [array[i][j], array[i][array[i].length - 1 - j]] = [array[i][array[i].length - 1 - j], array[i][j]];
        }
    }
    return array;
}

function multiplayer(reverse) {
    if (reverse) {
        questions = flip(questions);
    }
    for (var i = 0; i < questions.length; i++) {
        var element1 = questions[i][1];
        for (var k = 0; k < 100; k++) {
            var randomElement = questions[Math.floor(Math.random() * questions.length)][1];
            if (randomElement !== element1) {
                questions[i].push(randomElement);
                break;
            }
        }

        for (var k = 0; k < 100; k++) {
            var randomElement = questions[Math.floor(Math.random() * questions.length)][1];
            if (randomElement !== element1 && randomElement !== questions[i][2]) {
                questions[i].push(randomElement);
                break;
            }
        }

        for (var k = 0; k < 100; k++) {
            var randomElement = questions[Math.floor(Math.random() * questions.length)][1];
            if (randomElement !== element1 && randomElement !== questions[i][2] && randomElement !== questions[i][3]) {
                questions[i].push(randomElement);
                break;
            }
        }

    }

    var url = 'https://quizza.org/play/host/'
    var form = $('<form action="' + url + '" method="post">' +
        '<input type="hidden" name="quizzalink" value="' + location.href + '" />' +
        '<input type="hidden" name="questiondata" value="' + encodeURIComponent(JSON.stringify(questions)) + '" />' +
        '</form>');
    $('body').append(form);
    form.submit();
}