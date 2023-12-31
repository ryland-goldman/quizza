var grid = [];
var current = "";
var prevRC = [];
var num_correct = 0;

function select(row, column) {
    $("button").removeClass("wrong").removeClass("selected");
    if (current == "") {
        current = grid[row][column];
        prevRC = [row, column];
        $("#box-" + (4 * prevRC[0] + prevRC[1])).addClass('selected');
    } else if (prevRC[0] == row && prevRC[1] == column) {
        $("#box-" + (4 * prevRC[0] + prevRC[1])).removeClass('selected');
        current = "";
        prevRC = [0, 0];
    } else {
        var correct = false;
        for (var i = 0; i < answers.length; i++) {
            if ((answers[i][0] == current && answers[i][1] == grid[row][column]) || (answers[i][1] == current && answers[i][0] == grid[row][column])) {
                correct = true;
            }
        }
        if (correct) {
            $("#box-" + (4 * row + column)).removeClass('selected').prop("disabled", true).addClass('finished');
            $("#box-" + (4 * prevRC[0] + prevRC[1])).removeClass('selected').prop("disabled", true).addClass('finished');
            num_correct++;
            if (num_correct == 8) {
                $("#content_box").html(`<button class='btn-blue' onclick='location.reload()'>Study More&nbsp;&nbsp;<i class="fa-solid fa-rotate"></i></button> <button onclick='location.href=return_url;'>Return Home&nbsp;&nbsp;<i class="fa-solid fa-house"></i></button>`);
            }
        } else {
            $("#box-" + (4 * row + column)).removeClass("selected").addClass('wrong');
            $("#box-" + (4 * prevRC[0] + prevRC[1])).removeClass("selected").addClass('wrong');
        }
        current = "";
        prevRC = [0, 0];
    }
}

function init() {

    // Disabled terms
    try {
        var disabled_terms = JSON.parse(sessionStorage.disabledTerms);
        var answers_tmp = answers;
        for (var i=0;i<disabled_terms.length;i++){
            for (var j=0;j<answers.length;j++){
                if(answers[j][0] == decodeURIComponent(disabled_terms[i])){
                    answers_tmp.splice(j)
                }
            }
        }
        answers = answers_tmp;
    } catch(e) {}

    answers.sort(() => Math.random() - 0.5);
    var boxes = [answers[0][0], answers[0][1], answers[1][0], answers[1][1], answers[2][0], answers[2][1], answers[3][0], answers[3][1], answers[4][0], answers[4][1], answers[5][0], answers[5][1], answers[6][0], answers[6][1], answers[7][0], answers[7][1]];
    boxes.sort(() => Math.random() - 0.5);
    grid.push([boxes[0], boxes[1], boxes[2], boxes[3]]);
    grid.push([boxes[4], boxes[5], boxes[6], boxes[7]]);
    grid.push([boxes[8], boxes[9], boxes[10], boxes[11]]);
    grid.push([boxes[12], boxes[13], boxes[14], boxes[15]]);
    for (var i = 0; i < 16; i++) {
        $("#box-" + i).html(boxes[i]);
    }
    MathJax.typeset();
    try { render_gSignIn(); } catch(e){}
}