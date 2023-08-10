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
            location.href = back_url;
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
<div class='item-card'>
<table>
  <tr>
    <td>
      <h2><input type='text' class='terms'></h2>
    </td>
    <td>
      <p style='text-align:right;'><input type='text' value='' class='defs'></p>
    </td>
    <td>
      <button class='delete-btn' onclick="$('#box-` + i + `').html('');"><i class="fa-solid fa-trash-can"></i></button>
  </tr>
</table>
</div>
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
    location.href="saveChanges?DELETE=TRUE";
  }
}

function image_upload(element){
    $("#"+element).click();
    $("#"+element).change(function(){
        $("button").prop("disabled",true);
        const fileInput = document.querySelector('#'+element);
        convertToBase64(fileInput.files[0], "#"+element+"-text");
    });
}

function convertToBase64(file, element) {
    const reader = new FileReader();
    reader.readAsDataURL(file);
    var mime = file.type;
    if(mime=="image/jpeg"){ var ext = ".jpg"; }
    else if(mime=="image/png"){ var ext = ".png"; }
    else if(mime=="image/gif"){ var ext = ".gif"; }
    else {alert("Image type not supported."); $("button").prop("disabled",false); return; }
    reader.onload = function(e){
    $.ajax({
        url: '/docs/imageUpload.php',
        type: 'POST',
        data: {file: e.target.result, extension: ext, auth: google_auth},
        success: function(response) {
            var curr_val = $(element).val();
            $(element).val(curr_val + " "+response);
            $("button").prop("disabled",false);
        }
      });
    }
  }

  var math_elements = [];
  function math_render(element){
    if(math_elements.includes(element)){
        $("#"+element+"-math").hide();
        $("#"+element+"-text").show();
        math_elements.splice(math_elements.indexOf(element),1);
        $("#"+element+"-math-btn").removeClass("mathbtn-clicked");
        return;
    }
    math_elements.push(element);
    $("#"+element+"-text").hide();
    var regex = /(\\\()(.*?)(\\\))/g;
    var m = $("#"+element+"-text").val().match(regex).join(" ").replaceAll("\\(","").replaceAll("\\)","");
    $("#"+element+"-math").html();
    $("#"+element+"-math").show();
    $("#"+element+"-math-btn").addClass("mathbtn-clicked");
    var MQ = MathQuill.getInterface(2);
    var answerSpan = document.getElementById(element+"-math");
    var answerMathField = MQ.MathField(answerSpan, {
        handlers: {
          edit: function() {
            var enteredMath = answerMathField.latex();
            $("#"+element+"-text").val("\\("+enteredMath+"\\)");
          }
        }
    });
  }