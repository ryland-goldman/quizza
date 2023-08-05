function save(isLoggedIn) {
    $("#favBtn").prop("disabled", true);
    var xhttp = new XMLHttpRequest();
    xhttp.open("POST", "/docs/lib/login-endpoint/toggleFavorite.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            if ($("#favBtn").html() == `Remove Favorite <i class="fa-solid fa-star"></i>`) {
                $("#favBtn").html(`Favorite Class <i class="fa-regular fa-star"></i>`);
            } else {
                $("#favBtn").html(`Remove Favorite <i class="fa-solid fa-star"></i>`);
            }
            $("#favBtn").prop("disabled", false);
        }
    }
    xhttp.send("class=" + classID);
}

var modal_current = 1;
$(document).ready(function() {
    if (!loggedIn) {
        render_gSignIn(true);
    }
    $("#search").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $(".allSets").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
    $(".sharebtn-wrapper").click(function(event){
        event.stopPropagation();
        var share_set_no = parseInt($(this).attr('id').substr(5));
        $(` <div id="share-`+modal_current+`" class="modal">
              <h2>Share Set</h2>
              <div id='share-list'></div>
              <hr>
              <input type='text' id='email-box' placeholder='Email' required>
              <button class="submitbtn submitbtn-first" onclick="add(false, `+share_set_no+`)">Add (view only)</button>
              <button class="submitbtn" onclick="add(true, `+share_set_no+`)">Add (view and edit)</button>
            </div>`).appendTo('body').modal();
        reload_perms(share_set_no);
        modal_current++;
    });
});

function add(edit_permission, share_set_no){
    var email = $("#email-box").val();
    console.log(email+edit_permission);
    reload_perms(share_set_no);
}

function reload_perms(share_set_no){

}

const readFileAsText = function(isPrivate) {
    $("#nofileuploaded").hide();
    $(".uploadBtn:nth-of-type(1)").prop("disabled", true).css({
        "cursor": "not-allowed"
    });
    $(".uploadBtn:nth-of-type(2)").prop("disabled", true).css({
        "cursor": "not-allowed"
    });
    const fileToRead = document.getElementById('file-to-read').files[0]
    const fileReader = new FileReader()
    fileReader.addEventListener('load', function(fileLoadedEvent) {
        var title = document.getElementById("file-to-read").files[0].name;
        var content = fileLoadedEvent.target.result;
        var xhttp = new XMLHttpRequest();
        xhttp.open("GET", "/"+classID+"/addSet?giveId=true&title=" + encodeURIComponent(title) + isPrivate + "&class=" + classID, true);
        xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var xhttp2 = new XMLHttpRequest();
                var setID = this.responseText.trim();
                console.log(this);
                xhttp2.open("POST", "/"+classID+"/"+setID+"/saveChanges", true);
                xhttp2.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhttp2.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        location.href = "/"+classID+"/"+setID;
                    }
                }
                xhttp2.send("data=" + encodeURIComponent(content.replaceAll('"', "”")) + "&title=" + encodeURIComponent(title)) + "&set=" + setID;
            }
        }
        xhttp.send();
    })
    try {
        fileReader.readAsText(fileToRead, 'UTF-8');
    } catch (e) {
        $(".uploadBtn:nth-of-type(1)").prop("disabled", false).css({
            "cursor": "pointer"
        });
        $(".uploadBtn:nth-of-type(2)").prop("disabled", false).css({
            "cursor": "pointer"
        });
        $("#nofileuploaded").show();
    }
}