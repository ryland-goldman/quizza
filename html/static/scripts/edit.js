function saveChanges() {
    var terms = document.getElementsByClassName("terms");
    var defs = document.getElementsByClassName("defs");
    for (var l = 0; l < document.getElementsByClassName("terms").length; l++) {
        document.getElementsByClassName("terms")[l].value = document.getElementsByClassName("terms")[l].value.replaceAll('"', "”")
        document.getElementsByClassName("terms")[l].value = document.getElementsByClassName("terms")[l].value.replaceAll('\'', "‘")
        document.getElementsByClassName("defs")[l].value = document.getElementsByClassName("defs")[l].value.replaceAll('"', "”")
        document.getElementsByClassName("defs")[l].value = document.getElementsByClassName("defs")[l].value.replaceAll('\'', "’")
    }
    var request = "";
    for (var i = 0; i < terms.length; i++) {
        request += `"`;
        request += terms[i].value.replaceAll(",", "&comma;");
        request += `","`;
        request += defs[i].value.replaceAll(",", "&comma;");
        request += `"`;
        if (i + 1 != terms.length) {
            request += `\n`;
        }
    }

    var xhttp = new XMLHttpRequest();
    xhttp.open("POST", "/docs/saveChanges.php", true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            location.href = "../";
        }
    }
    xhttp.send(class_and_set + "data=" + encodeURIComponent(request) + "&title=" + encodeURIComponent($("#title").val()));
}

function changeType() {
    $("#toggleBTN").prop('disabled', true).css('cursor', 'wait');
    var terms = document.getElementsByClassName("terms");
    var defs = document.getElementsByClassName("defs");
    for (var l = 0; l < document.getElementsByClassName("terms").length; l++) {
        document.getElementsByClassName("terms")[l].value = document.getElementsByClassName("terms")[l].value.replaceAll('"', "”")
        document.getElementsByClassName("terms")[l].value = document.getElementsByClassName("terms")[l].value.replaceAll('\'', "‘")
        document.getElementsByClassName("defs")[l].value = document.getElementsByClassName("defs")[l].value.replaceAll('"', "”")
        document.getElementsByClassName("defs")[l].value = document.getElementsByClassName("defs")[l].value.replaceAll('\'', "’")
    }
    var request = "";
    for (var i = 0; i < terms.length; i++) {
        request += `"`;
        request += terms[i].value.replaceAll(",", "&comma;");
        request += `","`;
        request += defs[i].value.replaceAll(",", "&comma;");
        request += `"`;
        if (i + 1 != terms.length) {
            request += `\n`;
        }
    }

    var xhttp = new XMLHttpRequest();
    xhttp.open("POST", "/docs/saveChanges.php", true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            location.reload();
        }
    }
    xhttp.send(class_and_set + "switchtype=true&data=" + encodeURIComponent(request) + "&title=" + encodeURIComponent($("#title").val()));
}

function addTerm() {
    var allTerms = [];
    var allDefs = [];
    for (var l = 0; l < document.getElementsByClassName("terms").length; l++) {
        allTerms.push(document.getElementsByClassName("terms")[l].value);
        allDefs.push(document.getElementsByClassName("defs")[l].value);
    }
    i++;
    document.getElementById("allBoxes").innerHTML += `
  <div id='box-` + i + `'>
<div style='box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;background:#FFF;border-radius:8px;'>
<table style='padding:6px 18px;width:100%;'>
  <tr>
    <td>
      <h2><input type='text' class='terms'></h2>
    </td>
    <td>
      <p style='text-align:right;'><input type='text' value='' class='defs'></p>
    </td>
    <td>
      <button style='background-color:red;border-radius:8px;padding:12px;border:none;font-size:16px;' onclick="$('#box-` + i + `').html('');"><i class="fa-solid fa-trash-can"></i></button>
  </tr>
</table>
</div>
<div style='margin-top:1vh;'>&nbsp;</div>
</div>`;
    for (var l = 0; l < document.getElementsByClassName("terms").length - 1; l++) {
        document.getElementsByClassName("terms")[l].value = allTerms[l];
        document.getElementsByClassName("defs")[l].value = allDefs[l];
    }
    location.href = "#pageBottom";
}

MathJax = {
  tex: {
    inlineMath: [['$$$$', '$$$$']]
  }
};


function confirmDeletion(){
  if(prompt("To delete this set, please type DELETE in the field below.").toLowerCase() == "delete"){
    location.href="saveChanges.php?DELETE=TRUE";
  }
}

function convertToBase64(file) {
    const reader = new FileReader();
    reader.readAsDataURL(file);
    var mime = file.type;
    if(mime=="image/jpeg"){ var ext = ".jpg"; }
    else if(mime=="image/png"){ var ext = ".png"; }
    else if(mime=="image/gif"){ var ext = ".gif"; }
    else {alert("Image type not supported."); return; }
    reader.onload = function(e){
    $.ajax({
        url: 'https://www.quizza.org/docs/imageUpload.php',
        type: 'POST',
        data: {file: e.target.result, extension: ext, auth: google_auth},
        success: function(response) {
          $("#resultURL").val(response).show();
          $("#uploadBtn").prop("disabled",false);
          $("#uploadBtn").text("Upload");
          $("#info").text("Copy and paste this URL into the text box to include it in a set.");
        }
      });
    }
  }
  $('#resultURL').click(function() { $(this).select(); }).hide();
  $('#resultURL').focus(function() { document.execCommand('copy'); });
  $("#uploadBtn").click(function (event){
    $("#resultURL").val("");
    $("#uploadBtn").prop("disabled",true);
    $("#uploadBtn").text("Uploading...");
    event.preventDefault();
    const fileInput = document.querySelector('input[type="file"]');
    convertToBase64(fileInput.files[0]);
  });