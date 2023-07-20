function shuffleArray(array) {
    for (var i = array.length - 1; i > 0; i--) {
        var j = Math.floor(Math.random() * (i + 1));
        var temp = array[i];
        array[i] = array[j];
        array[j] = temp;
    }
    return array;
}

function prnt() {
    questions.pop();
    c1s.pop();
    ic1s.pop();
    ic2s.pop();
    ic3s.pop();
    var qs = questions.slice();
    var c1 = c1s.slice();
    var ic1 = ic1s.slice();
    var ic2 = ic2s.slice();
    var ic3 = ic3s.slice();
    var cn = 0;
    while (true) {
        if (qs.length == 0) {
            break;
        }
        cn = Math.floor(Math.random() * qs.length);
        var answers = shuffleArray([c1[cn], ic1[cn], ic2[cn], ic3[cn]]);
        pdftext += qs[cn];
        pdftext += "\na. " + answers[0];
        pdftext += "\nb. " + answers[1];
        pdftext += "\nc. " + answers[2];
        pdftext += "\nd. " + answers[3];
        pdftext += "\n\n";
        qs.splice(cn, 1);
        c1.splice(cn, 1);
        ic1.splice(cn, 1);
        ic2.splice(cn, 1);
        ic3.splice(cn, 1);
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
            $("#container-" + term[1]).attr("class", "disabled item-card");
        } else {
            $("#icon-" + term[1]).attr("class", "fa-solid fa-eye");
            $("#container-" + term[1]).attr("class", "enabled item-card");
        }
    });
    try {
        render_gSignIn();
    } catch (e) {}
}

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
        $("#container-" + iconId).attr("class", "enabled item-card");
    } else {
        dt.push(term);
        $("#icon-" + iconId).attr("class", "fa-solid fa-eye-slash");
        $("#container-" + iconId).attr("class", "disabled item-card");
    }
    for (var p = 0; p < dt.length; p++) {
        dt[p] = encodeURIComponent(dt[p]);
    }
    console.log(dt);
    localStorage.setItem("disabledTerms", JSON.stringify(dt));
}
MathJax = {
    tex: {
        inlineMath: [
            ['\\(', '\\)']
        ]
    }
};
function multiplayer(blank){      
      var url = 'https://quizza.org/play/host/'
      var form = $('<form action="' + url + '" method="post">' +
        '<input type="hidden" name="quizzalink" value="' + location.href + '" />' +
        '<input type="hidden" name="questiondata" value="' + encodeURIComponent(JSON.stringify(questions)) + '" />' +
        '</form>');
      $('body').append(form);
      form.submit();
    }