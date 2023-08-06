
var modal_current = 0;
function share_script_init(){
    $(".sharebtn-wrapper").click(function(event){
        event.stopPropagation();
        modal_current++;
        var permission = parseInt($(this).attr('id').substring(5,6));
        var share_set_no = parseInt($(this).attr('id').substr(7));
        if(permission == 3){
            $(` <div id="share-`+modal_current+`" class="modal"> 
                      <h2>Share Set</h2>
                      <hr>
                      <div id='share-list-`+modal_current+`'></div>
                      <input type='text' id='email-box-`+modal_current+`' class='email-box' placeholder='Email' required>
                      <span id='error-`+modal_current+`' style='color:red;display:none;'><br>Invalid email address. Please try again.<br></span>
                      <button class="submitbtn submitbtn-first" onclick="add(false, `+share_set_no+`)">Add (view only)</button>
                      <button class="submitbtn" onclick="add(true, `+share_set_no+`)">Add (view and edit)</button>
                    </div>`).appendTo('body').modal();
        } else {
            $(` <div id="share-`+modal_current+`" class="modal"><h2>Share Set</h2><hr><p id='share-list-`+modal_current+`'></p></div>`).appendTo('body').modal();
        }
        reload_perms(share_set_no);
    });
}

function add(edit_permission, share_set_no){
    $("#error-"+modal_current).hide();
    $("#share-"+modal_current+" button").prop("disabled", true).css({ "cursor": "not-allowed" });
    var email = $("#email-box-"+modal_current).val();
    if(!email.match(/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/)){
        $("#error-"+modal_current).show();
        return;
    }
    $.get("/docs/lib/share_private_set.php?set="+share_set_no+"&edit_permission="+edit_permission+"&email="+encodeURIComponent(email), function(data,status){
        $("#share-list-"+modal_current).html(data);
        $("#share-"+modal_current+" button").prop("enabled", true).css({ "cursor": "pointer" });
        $("#email-box-"+modal_current).val("");
    });
}

function reload_perms(share_set_no){
    $.get("/docs/lib/get_private_set_permissions.php?set="+share_set_no, function(data,status){
        $("#share-list-"+modal_current).html(data);
    });
}

function remove(number,set_no){
    $.get("/docs/lib/remove_private_set.php?set="+set_no+"&user="+number, function(data,status){
        $("#share-list-"+modal_current).html(data);
    });
}