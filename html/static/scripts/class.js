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

var modal_current = 0;
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
        modal_current++;
        var share_set_no = parseInt($(this).attr('id').substr(5));
        $(` <div id="share-`+modal_current+`" class="modal">
              <h2>Share Set</h2>
              <div id='share-list-`+modal_current+`'></div>
              <hr>
              <input type='text' id='email-box-`+modal_current+`' class='email-box' placeholder='Email' required>
              <span id='error-`+modal_current+`' style='color:red;display:none;'><br>Invalid email address. Please try again.<br></span>
              <span id='success-`+modal_current+`' style='color:green;display:none;'><br>Success!<br></span>
              <button class="submitbtn submitbtn-first" onclick="add(false, `+share_set_no+`)">Add (view only)</button>
              <button class="submitbtn" onclick="add(true, `+share_set_no+`)">Add (view and edit)</button>
            </div>`).appendTo('body').modal();
        reload_perms(share_set_no);
    });
});

function add(edit_permission, share_set_no){
    $("#error-"+modal_current).hide();
    $("#success-"+modal_current).hide();
    $("#share-"+modal_current+" button").prop("disabled", true).css({ "cursor": "not-allowed" });
    var email = $("#email-box-"+modal_current).val();
    if(!email.match(/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/)){
        $("#error-"+modal_current).show();
        return;
    }
    $.get("/docs/lib/share_private_set.php?set="+share_set_no+"&edit_permission="+edit_permission+"&email="+encodeURIComponent(email), function(data,status){
        $("#share-list-"+modal_current).html(data);
        $("#share-"+modal_current+" button").prop("disabled", true).css({ "cursor": "not-allowed" });
        $("#success-"+modal_current).show();
        $("#email-box-"+modal_current).val("");
    });
}

function reload_perms(share_set_no){
    $.get("/docs/lib/get_private_set_permissions.php?set="+share_set_no, function(data,status){
        $("#share-list-"+modal_current).html(data);
    });
}

function remove(number,set_no){
    $.get("/docs/lib/remove_private_set.php?set="+share_set_no+"&user="+number, function(data,status){
        $("#share-list-"+modal_current).html(data);
    });
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