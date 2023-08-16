function save(isLoggedIn) {
    $("#favBtn").prop("disabled", true);
    var xhttp = new XMLHttpRequest();
    xhttp.open("POST", "/docs/lib/toggleFavorite.php", true);
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

    try { share_script_init(); } catch {}
});
