function onload_1() {
    if(!mobile){
        document.querySelectorAll("select").forEach(resizeSelect);
    }
}

function onload_2() {

    $("#fav-B").show();

    // attempt to render sign in button if it exists
    try {
        render_gSignIn();
    } catch (e) {}

}

function onload_3() {
    for (var i = 0; i < subjects.length; i++) {
        (function(index) {
            var row = "#" + subjects[index] + "-B";
            $("#" + subjects[index] + "-H").click(function() {
                $(row).toggle(); // toggle it when clicked
            });
        })(i);
    }
}

onload_1();
setTimeout(onload_2, 1000);
onload_3();

$("#search-home").focus(function(event) {
    $(".resultscontainer").show();
});

$("#search-home").blur(function(event) {
    setTimeout(function() {
        $(".resultscontainer").hide();
    }, 100);
});

$('#search-home').keyup(function(event) {
    var val = this.value;
    $.get("/docs/lib/searchClasses.php?query=" + encodeURIComponent(val), function(data, status) {
        try {
            var results = JSON.parse(data);
        } catch {
            $(".resultscontainer").html("");
            return;
        }
        var results_str = "";
        if (mobile) {
            var max = 5;
        } else {
            var max = 10;
        }
        for (var i = 0; i < results.length && i < max; i++) {
            var id = 'resultscontainer-' + i;
            if (i == results.length - 1) {
                id = 'resultscontainer-div-last';
            }
            if (i == max) {
                id = 'resultscontainer-div-last';
            }
            results_str += "<a href='" + results[i][1] + "'><div id='" + id + "'>" + results[i][0] + "</div></a>";
        }
        $(".resultscontainer").html(results_str);
    });
});

function resizeSelect(sel) {
    let tempOption = document.createElement('option');
    tempOption.textContent = sel.selectedOptions[0].textContent;

    let tempSelect = document.createElement('select');
    tempSelect.style.visibility = "hidden";
    tempSelect.style.position = "fixed"
    tempSelect.appendChild(tempOption);

    sel.after(tempSelect);
    sel.style.width = `${+tempSelect.clientWidth + 50}px`;
    tempSelect.remove();
}