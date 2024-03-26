function curly_replace(text) {
  const curlyText = text
    .replace(/(['"])(.*?)\1/g, (_, quoteType, content) => {
      const openQuote = quoteType === '"' ? '“' : '‘';
      const closeQuote = quoteType === '"' ? '”' : '’';
      return `${openQuote}${content}${closeQuote}`;
    });

  return curlyText.replaceAll('"', "”").replaceAll('\'', "’");
}

function saveChanges() {
    window.addEventListener("message",(e)=>{if(e.data=="save"){saveChanges();}});
    $.get("/docs/lib/login-endpoint/get_login_status.php", function(data, status){
        if(data.contains("1")){ saveChanges_main(); } else { $("#save_page_signout_modal").modal(); }
    });
}

function saveChanges_main() {
    var terms = document.getElementsByClassName("terms");
    var defs = document.getElementsByClassName("defs");
    for (var l = 0; l < document.getElementsByClassName("terms").length; l++) {
        document.getElementsByClassName("terms")[l].value = curly_replace(document.getElementsByClassName("terms")[l].value);
        document.getElementsByClassName("defs")[l].value = curly_replace(document.getElementsByClassName("defs")[l].value);
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
    xhttp.send(class_and_set + "data=" + encodeURIComponent(request) + "&title=" + encodeURIComponent($("#title").val()) + "&save_token=" + save_token);
}

function changeType() {
    $("#toggleBTN").prop('disabled', true).css('cursor', 'wait');
    var terms = document.getElementsByClassName("terms");
    var defs = document.getElementsByClassName("defs");
    for (var l = 0; l < document.getElementsByClassName("terms").length; l++) {
        document.getElementsByClassName("terms")[l].value = curly_replace(document.getElementsByClassName("terms")[l].value);
        document.getElementsByClassName("defs")[l].value = curly_replace(document.getElementsByClassName("defs")[l].value);
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
    var sep = mobile=="true" ? "</tr><tr>" : "<td style='width:8px;''>&nbsp;</td>";
    document.getElementById("allBoxes").innerHTML += `
  <div id='box-` + i + `'>
<div class='item-card edit-card'>
            <table>
              <tr>
                <td class='edit-td'>
                  <p><input type='text' class='terms' placeholder="Term" id="file-`+i+`-0-text">
                      <span id='file-`+i+`-0-math' class='math'></span>
                      <button class='edit-inline-btns file-`+i+`-0-mathbtn' style='border-right:none;border-left:none' onclick="math_render('file-`+i+`-0')"><i class="fa-solid fa-square-root-variable"></i></button>
                      <button class='edit-inline-btns' style="border-radius:0px 8px 8px 0px" onclick="image_upload('file-`+i+`-0')"><i class="fa-solid fa-image"></i></button>
                      <input type="file" id="file-`+i+`-0" style="display:none;" /></p>
                </td>
                `+sep+`
                <td class='edit-td'>
                  <p><input type='text' class='defs' placeholder="Definition" id="file-`+i+`-1-text">
                      <span id='file-`+i+`-1-math' class='math'></span>
                      <button class='edit-inline-btns file-`+i+`-1-mathbtn' style='border-right:none;border-left:none' onclick="math_render('file-`+i+`-1')"><i class="fa-solid fa-square-root-variable"></i></button>
                      <button class='edit-inline-btns' style="border-radius:0px 8px 8px 0px" onclick="image_upload('file-`+i+`-1')"><i class="fa-solid fa-image"></i></button>
                      <input type="file" id="file-`+i+`-1" style="display:none;" /></p>
                </td>
                `+sep+`
                <td class='delete-btn-td'>
                  <button class='delete-btn' onclick="$('#box-`+i+`').html('')"><i class="fa-solid fa-trash-can"></i></button>
                </td>
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
            if(!curr_val.includes(response)){
                $(element).val(curr_val + " "+response);
            }
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
        $("."+element+"-mathbtn").removeClass("mathbtn-clicked");
        return;
    }
    math_elements.push(element);
    $("#"+element+"-text").hide();
    var regex = /(\\\()(.*?)(\\\))/g;
    try {
        var m = $("#"+element+"-text").val().match(regex).join(" ").replaceAll("\\(","").replaceAll("\\)","");
        $("#"+element+"-math").html(m);
    } catch {$("#"+element+"-math").html('');}
    $("#"+element+"-math").show();
    $("."+element+"-mathbtn").addClass("mathbtn-clicked");
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