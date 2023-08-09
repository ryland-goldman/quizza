const readFileAsText = function() {
    $("#nofileuploaded").hide();
    $("#uploading").show();
    const fileToRead = document.getElementById('file-to-read').files[0]
    const fileReader = new FileReader()
    fileReader.addEventListener('load', function(fileLoadedEvent) {
        var title = document.getElementById("file-to-read").files[0].name;
        var content = fileLoadedEvent.target.result;
        $("#set-title").val(title);
        $("#set-content").val(content);
        $.modal.close();
    })
    try {
        fileReader.readAsText(fileToRead, 'UTF-8');
    } catch (e) {
        $("#nofileuploaded").show();
    }
    $("#uploading").hide();
}


function uploadSet(isPrivate){
    var title = $("#set-title").val();
    var content = $("#set-content").val();
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
                if (this.readyState == 4 && this.status == 200) { location.href = "/"+classID+"/"+setID; }
            }
            xhttp2.send("data=" + encodeURIComponent(content.replaceAll('"', "”")) + "&title=" + encodeURIComponent(title)) + "&set=" + setID;
        }
    }
    xhttp.send();
}