function saveChanges() {
    var qs = document.getElementsByClassName("q");
    var c1s = document.getElementsByClassName("c1");
    var ic1s = document.getElementsByClassName("ic1");
    var ic2s = document.getElementsByClassName("ic2");
    var ic3s = document.getElementsByClassName("ic3");
    for (var l = 0; l < document.getElementsByClassName("q").length; l++) {
        document.getElementsByClassName("q")[l].value = document.getElementsByClassName("q")[l].value.replaceAll('"', "”")
        document.getElementsByClassName("q")[l].value = document.getElementsByClassName("q")[l].value.replaceAll('\'', "‘")
        document.getElementsByClassName("c1")[l].value = document.getElementsByClassName("c1")[l].value.replaceAll('"', "”")
        document.getElementsByClassName("c1")[l].value = document.getElementsByClassName("c1")[l].value.replaceAll('\'', "‘")
        document.getElementsByClassName("ic1")[l].value = document.getElementsByClassName("ic1")[l].value.replaceAll('"', "”")
        document.getElementsByClassName("ic1")[l].value = document.getElementsByClassName("ic1")[l].value.replaceAll('\'', "‘")
        document.getElementsByClassName("ic2")[l].value = document.getElementsByClassName("ic2")[l].value.replaceAll('"', "”")
        document.getElementsByClassName("ic2")[l].value = document.getElementsByClassName("ic2")[l].value.replaceAll('\'', "‘")
        document.getElementsByClassName("ic3")[l].value = document.getElementsByClassName("ic3")[l].value.replaceAll('"', "”")
        document.getElementsByClassName("ic3")[l].value = document.getElementsByClassName("ic3")[l].value.replaceAll('\'', "‘")
    }
    var request = "";
    for (var n = 0; n < qs.length; n++) {
        request += `"`;
        request += qs[n].value.replaceAll(",", "&comma;");
        request += `","`;
        request += c1s[n].value.replaceAll(",", "&comma;");
        request += `","`;
        request += ic1s[n].value.replaceAll(",", "&comma;");
        request += `","`;
        request += ic2s[n].value.replaceAll(",", "&comma;");
        request += `","`;
        request += ic3s[n].value.replaceAll(",", "&comma;");
        request += `"`;
        if (i + 1 != qs.length) {
            request += `\n`;
        }
    }

    var xhttp = new XMLHttpRequest();
    xhttp.open("POST", "/docs/saveChanges.php", true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            location.href = back_url;
        }
    }
    if (qs.length == 0) {
        xhttp.send(class_and_set + "data=empty&title=" + encodeURIComponent($("#title").val()));
    } else {
        xhttp.send(class_and_set + "data=" + encodeURIComponent(request) + "&title=" + encodeURIComponent($("#title").val()));
    }
}

function changeType() {
    $("#toggleBTN").prop('disabled', true).css('cursor', 'wait');
    var qs = document.getElementsByClassName("q");
    var c1s = document.getElementsByClassName("c1");
    var ic1s = document.getElementsByClassName("ic1");
    var ic2s = document.getElementsByClassName("ic2");
    var ic3s = document.getElementsByClassName("ic3");
    for (var l = 0; l < document.getElementsByClassName("q").length; l++) {
        document.getElementsByClassName("q")[l].value = document.getElementsByClassName("q")[l].value.replaceAll('"', "”")
        document.getElementsByClassName("q")[l].value = document.getElementsByClassName("q")[l].value.replaceAll('\'', "‘")
        document.getElementsByClassName("c1")[l].value = document.getElementsByClassName("c1")[l].value.replaceAll('"', "”")
        document.getElementsByClassName("c1")[l].value = document.getElementsByClassName("c1")[l].value.replaceAll('\'', "‘")
        document.getElementsByClassName("ic1")[l].value = document.getElementsByClassName("ic1")[l].value.replaceAll('"', "”")
        document.getElementsByClassName("ic1")[l].value = document.getElementsByClassName("ic1")[l].value.replaceAll('\'', "‘")
        document.getElementsByClassName("ic2")[l].value = document.getElementsByClassName("ic2")[l].value.replaceAll('"', "”")
        document.getElementsByClassName("ic2")[l].value = document.getElementsByClassName("ic2")[l].value.replaceAll('\'', "‘")
        document.getElementsByClassName("ic3")[l].value = document.getElementsByClassName("ic3")[l].value.replaceAll('"', "”")
        document.getElementsByClassName("ic3")[l].value = document.getElementsByClassName("ic3")[l].value.replaceAll('\'', "‘")
    }
    var request = "";
    for (var n = 0; n < qs.length; n++) {
        request += `"`;
        request += qs[n].value.replaceAll(",", "&comma;");
        request += `","`;
        request += c1s[n].value.replaceAll(",", "&comma;");
        request += `","`;
        request += ic1s[n].value.replaceAll(",", "&comma;");
        request += `","`;
        request += ic2s[n].value.replaceAll(",", "&comma;");
        request += `","`;
        request += ic3s[n].value.replaceAll(",", "&comma;");
        request += `"`;
        if (i + 1 != qs.length) {
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

// window.addEventListener('beforeunload', function (e) { e.preventDefault(); e.returnValue = ''; });


function addTerm() {
    var allqs = [];
    var allc1s = [];
    var allic1s = [];
    var allic2s = [];
    var allic3s = [];
    for (var l = 0; l < document.getElementsByClassName("q").length; l++) {
        allqs.push(document.getElementsByClassName("q")[l].value);
        allc1s.push(document.getElementsByClassName("c1")[l].value);
        allic1s.push(document.getElementsByClassName("ic1")[l].value);
        allic2s.push(document.getElementsByClassName("ic2")[l].value);
        allic3s.push(document.getElementsByClassName("ic3")[l].value);
    }
    i++;
    document.getElementById("allBoxes").innerHTML += `
  <div id='box-` + i + `'>
<div class='item-card'>
<table>
<tr>
  <td>
    <h2><input type='text' value='' class='terms q' placeholder='Question'></h2>
  </td>
  <td>
    <p style='text-align:center;'><input type='text' value='' class='defs c1' placeholder='Correct Answer'></p>
  </td>
  <td>
    <p style='text-align:center;'><input type='text' value='' class='defs ic1' placeholder='Incorrect Answer'></p>
  </td>
  <td>
    <p style='text-align:center;'><input type='text' value='' class='defs ic2' placeholder='Incorrect Answer'></p>
  </td>
  <td>
    <p style='text-align:center;'><input type='text' value='' class='defs ic3' placeholder='Incorrect Answer'></p>
  </td>
  <td>
    <button class='delete-btn' onclick="$('#box-` + i + `').html('');"><i class="fa-solid fa-trash-can"></i></button>
</tr>
</table>
</div>
</div>`;
    for (var l = 0; l < document.getElementsByClassName("q").length - 1; l++) {
        document.getElementsByClassName("q")[l].value = allqs[l];
        document.getElementsByClassName("c1")[l].value = allc1s[l];
        document.getElementsByClassName("ic1")[l].value = allic1s[l];
        document.getElementsByClassName("ic2")[l].value = allic2s[l];
        document.getElementsByClassName("ic3")[l].value = allic3s[l];
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
    location.href="saveChanges?DELETE=TRUE";
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
        url: '/docs/imageUpload.php',
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
  function uploadBtnClick(){
    $("#resultURL").val("");
    $("#uploadBtn").prop("disabled",true);
    $("#uploadBtn").text("Uploading...");
    event.preventDefault();
    const fileInput = document.querySelector('input[type="file"]');
    convertToBase64(fileInput.files[0]);
  }