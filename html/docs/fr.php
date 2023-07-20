<?php require("/var/www/html/docs/lib/header.php");
 if($type == "Set"){ ?>
 <!DOCTYPE html>
<html>

<head>
  <title>Test | Quizza</title>
  <link rel='icon' href='https://www.quizza.org/static/images/favicon.png'>
    <meta charset="utf-8">
    <meta name="theme-color" content="#0668FD" />
    <meta name="viewport" content="width=device-width">
    <script src="https://kit.fontawesome.com/9e91fc9fc4.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js">
    </script>
    <!-- Cloudflare Web Analytics --><script defer src='https://static.cloudflareinsights.com/beacon.min.js' data-cf-beacon='{"token": "0cf68ae422c04e55829a73929506b257"}'></script><!-- End Cloudflare Web Analytics -->
<!-- Cloudflare Web Analytics --><script defer src='https://static.cloudflareinsights.com/beacon.min.js' data-cf-beacon='{"token": "de14f379a11445ada5285bb32a54af97"}'></script><!-- End Cloudflare Web Analytics -->
    <!--https://jquerymodal.com-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
    <?php if($loggedIn == false){ ?>
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <meta content="117895756240-ujiuojlsbtruthgqnghnu215d2hn7flp.apps.googleusercontent.com" name="google-signin-client_id" />
    <script>
    function handleCredentialResponse(response) {
              var xhttp = new XMLHttpRequest();
              xhttp.open("POST", "/login-endpoint/index.php", true);
              xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
              xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                  location.reload();
                }
              }
              xhttp.send("credential="+encodeURIComponent(response.credential));
          }
          window.onload = function () {
            google.accounts.id.initialize({
              client_id: "117895756240-ujiuojlsbtruthgqnghnu215d2hn7flp.apps.googleusercontent.com",
              callback: handleCredentialResponse
            });
            google.accounts.id.renderButton(
              document.getElementById("buttonDiv"),
              { theme: "outline", size: "large" }  // customization attributes
            );
            google.accounts.id.prompt(); // also display the One Tap dialog
          }

    </script><?php } ?>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
    <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3.0.1/es5/tex-mml-chtml.js"></script>

    <style>
    <?php if (isMobileDevice()){ ?>
    #bottom-btns button {
      width: 100%;
    } #t {font-size:1.2em; }<?php } ?>
        html,
        body {
          height: 100%;
          width: 100%;
        }

        .sm{font-size:1.2em;}

        a,
        button {
          cursor: pointer;
        }

        * {
          font-family: "Gotham";
    			transition: 0.2s;
        }
        #response {
					text-align:center;
          transition: width 0.4s ease-in-out;
          min-width: 30vw;
          box-sizing: border-box;
          border: 2px solid #ccc;
          border-radius: 8px;
          font-size: 16px;
          font-weight: 400;
          padding: 12px 20px 12px 20px;
        }

        @font-face {
          font-family: "Gotham";
          font-weight: 400;
          src: url("https://www.quizza.org/static/fonts/gotham-reg.ttf") format("truetype");
        }

        @font-face {
          font-family: "Gotham";
          font-weight: 700;
          src: url("https://www.quizza.org/static/fonts/gotham-bold.ttf") format("truetype");
        }
    </style>
    <script>
      <?php if($_GET['learn']=='true'){ ?> var learnmode = true; <?php } else { ?> var learnmode = false; <?php } ?>
var words = [<?php $words = $thisClass->query("SELECT * FROM Set".$setID);
if($words->num_rows > 0){
  while($row = $words->fetch_assoc()){ echo '`'.str_replace("\\","\\\\",$row["Term"]).'`,'; }} ?>""];
var defs = [<?php $words = $thisClass->query("SELECT * FROM Set".$setID);
if($words->num_rows > 0){
  while($row = $words->fetch_assoc()){ echo '`'.str_replace("\\","\\\\",$row["Definition"]).'`,'; }} ?>""];
words.pop();
defs.pop();
    </script>
</head>

<body style='margin:0;padding:0;background-image:url("https://www.quizza.org/static/images/diag.jpeg");background-position: center;background-repeat: no-repeat;background-size: cover;background-attachment: fixed;'
onload="init()">
<div style="top:0;width:100%;position:fixed;">
  <table style='height:3vh;/*box-shadow: 0px 0px 12px #999;*/background-color:rgba(255,255,255,1);'>
    <tr>
      <td style='width:60%;padding:13px 20px 5px;'>
        <a href='/'><h1><img src='/logo.svg' style='height:1em;'></h1></a>
      </td>
      <td>&nbsp;</td>
      <td style="width:40%;text-align:right;padding:13px 20px 5px;">
        <table style='float:right;'>
          <tr>
            <td>&nbsp;</td>
            <?php if($loggedIn == false){ ?>
            <td>
<div id="buttonDiv">
    </div>
  </td> <?php } else { ?>
<td><a href='https://www.quizza.org/private' style='color: currentcolor;text-decoration:none;'>Welcome, <?php echo $name; ?>.</a></td>
<td><img src='<?php echo $pic; ?>' style='height:16pt;border-radius:8pt;'></td>
  <?php } ?>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</div>
    <div style="top:0;width:100%;">
        <table style='height:3vh;/*box-shadow: 0px 0px 12px #999;*/background-color:rgba(0,0,0,0);'>
            <tr>
                <td style='width:80%;padding:13px 20px 5px;'>
                    <h1>&nbsp;</h1>
                </td>
                <td>&nbsp;</td>
                <td style="width:20%;text-align:right;padding:13px 20px 5px;">
                    <table>
                        <tr>
                            <td>
                                <p style='font-size:1em;'><a href='/createAccount' style='text-decoration:none;color:black;'>&nbsp;</a>
                                </p>
                            </td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td><a href='/login' style='text-decoration:none;color:black;'><button
                    style='background-color:rgba(0,0,0,0);border-radius:8px;border:none;padding:12px;color:white;font-size:1em;'>&nbsp;</button></a>
                                <td>
                        </tr>
                    </table>
                    </td>
            </tr>
        </table>
    </div>
    <div style='margin-left:32px;margin-right:32px;'>
      <table>
        <tr>
          <?php if(!isMobileDevice()){ ?>
          <td>
            <h1><a href='../' style='color:black;text-decoration:none;'><?php echo "<i class='".$admin->query("SELECT * FROM Classes WHERE ID=\"$classID\"")->fetch_assoc()["Icon"]."'></i>&nbsp;&nbsp;"; echo $admin->query("SELECT * FROM ".$classID."Sets WHERE ID=$setID")->fetch_assoc()["Name"]; ?></a></h1>
          </td>
        <?php } else { ?>
          <td style='text-align:center;width:100%;'>
            <h1><a href='../' style='color:black;text-decoration:none;'><?php echo "<i class='".$admin->query("SELECT * FROM Classes WHERE ID=\"$classID\"")->fetch_assoc()["Icon"]."'></i>&nbsp;&nbsp;"; echo $admin->query("SELECT * FROM ".$classID."Sets WHERE ID=$setID")->fetch_assoc()["Name"]; ?></a></h1>
          </td>
        <?php } ?>
        </tr>
      </table>
      <p<?php if(isMobileDevice()) { ?> style='text-align:center;'<?php } ?>><a style='color:#0668FD;text-decoration:none;' href='../'><i class="fa-solid fa-arrow-left"></i> Back</a></p>

      <div style='<?php if(!isMobileDevice()) { ?>margin-left:15vw;margin-right:15vw;<?php } else { ?>margin-left:5vw;margin-right:5vw;padding:16px;<?php } ?>box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;background:#FFF;border-radius:8px;'>
            <table style='width:100%;<?php if(!isMobileDevice()) { ?>min-height:50vh;<?php } else { ?>min-height:20vh;<?php } ?>'>
                &nbsp;
                <tr>
                    <td  style='text-align:center;' id='main-td'>

                    </td>
                </tr>
            </table>
            <div style='text-align:center;' id='bottom-btns'>
                <button style='background-color:#0668FD;border-radius:8px;border:2px solid #0668FD;padding:12px 36px;color:white;font-size:1em;' id='sbtn'>Submit (--/--)&nbsp;&nbsp;<i
class="fa-solid fa-arrow-right-to-bracket"></i></button>
                <a rel="modal:open" href='#options'><button style='background-color:#FFF;border-radius:8px;border:2px solid #0668FD;padding:12px
36px;color:black;font-size:1em;margin-bottom:12px;' onclick='options()'>Options&nbsp;&nbsp;<i class="fa-solid fa-sliders"></i></button></a>
            </div>
        </div>

        <div style='height:5vh;'>&nbsp;</div>

        <div id="options" class="modal">
            <h2>Options</h2>
            <a rel="modal:close">
                <button style='padding:8px;border:1px solid black;background:white;border-radius:8px;' onclick='swt()'>Start with Term</button>
                <button style='padding:8px;border:1px solid black;background:white;border-radius:8px;' onclick='swd()'>Start with Definition</button></a>
        </div>

    </div>
    <script src='https://www.quizza.org/static/scripts/fr.js'></script>
</body>

</html>
<?php } else { ?>
  <!DOCTYPE html>
 <html>

 <head>
   <title>Test | Quizza</title>
   <link rel='icon' href='https://www.quizza.org/static/images/favicon.png'>
     <meta charset="utf-8">
     <meta name="theme-color" content="#0668FD" />
     <meta name="viewport" content="width=device-width">
     <script src="https://kit.fontawesome.com/9e91fc9fc4.js" crossorigin="anonymous"></script>
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js">
     </script>
     <!-- Cloudflare Web Analytics --><script defer src='https://static.cloudflareinsights.com/beacon.min.js' data-cf-beacon='{"token": "0cf68ae422c04e55829a73929506b257"}'></script><!-- End Cloudflare Web Analytics -->
 <!-- Cloudflare Web Analytics --><script defer src='https://static.cloudflareinsights.com/beacon.min.js' data-cf-beacon='{"token": "de14f379a11445ada5285bb32a54af97"}'></script><!-- End Cloudflare Web Analytics -->
     <!--https://jquerymodal.com-->
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
     <?php if($loggedIn == false){ ?>
     <script src="https://accounts.google.com/gsi/client" async defer></script>
     <meta content="117895756240-ujiuojlsbtruthgqnghnu215d2hn7flp.apps.googleusercontent.com" name="google-signin-client_id" />
     <script>
     function handleCredentialResponse(response) {
               var xhttp = new XMLHttpRequest();
               xhttp.open("POST", "/login-endpoint/index.php", true);
               xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
               xhttp.onreadystatechange = function() {
                 if (this.readyState == 4 && this.status == 200) {
                   location.reload();
                 }
               }
               xhttp.send("credential="+encodeURIComponent(response.credential));
           }
           window.onload = function () {
             google.accounts.id.initialize({
               client_id: "117895756240-ujiuojlsbtruthgqnghnu215d2hn7flp.apps.googleusercontent.com",
               callback: handleCredentialResponse
             });
             google.accounts.id.renderButton(
               document.getElementById("buttonDiv"),
               { theme: "outline", size: "large" }  // customization attributes
             );
             google.accounts.id.prompt(); // also display the One Tap dialog
           }

     </script><?php } ?>
     <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
     <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3.0.1/es5/tex-mml-chtml.js"></script>

     <style>
     <?php if (isMobileDevice()){ ?>
     #bottom-btns button {
       width: 100%;
     } #t {font-size:1.2em; }<?php } ?>
         html,
         body {
           height: 100%;
           width: 100%;
         }

         .sm{font-size:1.2em;}

         a,
         button {
           cursor: pointer;
         }

         * {
           font-family: "Gotham";
     			transition: 0.2s;
         }
         #response {
 					text-align:center;
           transition: width 0.4s ease-in-out;
           min-width: 30vw;
           box-sizing: border-box;
           border: 2px solid #ccc;
           border-radius: 8px;
           font-size: 16px;
           font-weight: 400;
           padding: 12px 20px 12px 20px;
         }

         @font-face {
           font-family: "Gotham";
           font-weight: 400;
           src: url("https://www.quizza.org/static/fonts/gotham-reg.ttf") format("truetype");
         }

         @font-face {
           font-family: "Gotham";
           font-weight: 700;
           src: url("https://www.quizza.org/static/fonts/gotham-bold.ttf") format("truetype");
         }
     </style>
     <script>
      <?php if($_GET['learn']=='true'){ ?> var learnmode = true; <?php } else { ?> var learnmode = false; <?php } ?>
 var words = [<?php $words = $thisClass->query("SELECT * FROM Quiz".$setID);
 if($words->num_rows > 0){
   while($row = $words->fetch_assoc()){ echo '`'.str_replace("\\","\\\\",$row["Question"]).'`,'; }} ?>""];
 var defs = [<?php $words = $thisClass->query("SELECT * FROM Quiz".$setID);
 if($words->num_rows > 0){
   while($row = $words->fetch_assoc()){ echo '`'.str_replace("\\","\\\\",$row["C1"]).'`,'; }} ?>""];
 words.pop();
 defs.pop();
     </script>
 </head>

 <body style='margin:0;padding:0;background-image:url("https://www.quizza.org/static/images/diag.jpeg");background-position: center;background-repeat: no-repeat;background-size: cover;background-attachment: fixed;'
 onload="init()">
 <div style="top:0;width:100%;position:fixed;">
   <table style='height:3vh;/*box-shadow: 0px 0px 12px #999;*/background-color:rgba(255,255,255,1);'>
     <tr>
       <td style='width:60%;padding:13px 20px 5px;'>
         <a href='/'><h1><img src='https://www.quizza.org/static/images/logo.svg' style='height:1em;'></h1></a>
       </td>
       <td>&nbsp;</td>
       <td style="width:40%;text-align:right;padding:13px 20px 5px;">
         <table style='float:right;'>
           <tr>
             <td>&nbsp;</td>
             <?php if($loggedIn == false){ ?>
             <td>
 <div id="buttonDiv">
     </div>
   </td> <?php } else { ?>
 <td><a href='https://www.quizza.org/private' style='color: currentcolor;text-decoration:none;'>Welcome, <?php echo $name; ?>.</a></td>
 <td><img src='<?php echo $pic; ?>' style='height:16pt;border-radius:8pt;'></td></a>
   <?php } ?>
           </tr>
         </table>
       </td>
     </tr>
   </table>
 </div>
     <div style="top:0;width:100%;">
         <table style='height:3vh;/*box-shadow: 0px 0px 12px #999;*/background-color:rgba(0,0,0,0);'>
             <tr>
                 <td style='width:80%;padding:13px 20px 5px;'>
                     <h1>&nbsp;</h1>
                 </td>
                 <td>&nbsp;</td>
                 <td style="width:20%;text-align:right;padding:13px 20px 5px;">
                     <table>
                         <tr>
                             <td>
                                 <p style='font-size:1em;'><a href='/createAccount' style='text-decoration:none;color:black;'>&nbsp;</a>
                                 </p>
                             </td>
                             <td>&nbsp;</td>
                             <td>&nbsp;</td>
                             <td><a href='/login' style='text-decoration:none;color:black;'><button
                     style='background-color:rgba(0,0,0,0);border-radius:8px;border:none;padding:12px;color:white;font-size:1em;'>&nbsp;</button></a>
                                 <td>
                         </tr>
                     </table>
                     </td>
             </tr>
         </table>
     </div>
     <div style='margin-left:32px;margin-right:32px;'>
       <table>
         <tr>
           <?php if(!isMobileDevice()){ ?>
           <td>
             <h1><a href='../' style='color:black;text-decoration:none;'><?php echo "<i class='".$admin->query("SELECT * FROM Classes WHERE ID=\"$classID\"")->fetch_assoc()["Icon"]."'></i>&nbsp;&nbsp;"; echo $admin->query("SELECT * FROM ".$classID."Sets WHERE ID=$setID")->fetch_assoc()["Name"]; ?></a></h1>
           </td>
         <?php } else { ?>
           <td style='text-align:center;width:100%;'>
             <h1><a href='../' style='color:black;text-decoration:none;'><?php echo "<i class='".$admin->query("SELECT * FROM Classes WHERE ID=\"$classID\"")->fetch_assoc()["Icon"]."'></i>&nbsp;&nbsp;"; echo $admin->query("SELECT * FROM ".$classID."Sets WHERE ID=$setID")->fetch_assoc()["Name"]; ?></a></h1>
           </td>
         <?php } ?>
         </tr>
       </table>
       <p<?php if(isMobileDevice()) { ?> style='text-align:center;'<?php } ?>><a style='color:#0668FD;text-decoration:none;' href='../'><i class="fa-solid fa-arrow-left"></i> Back</a></p>

       <div style='<?php if(!isMobileDevice()) { ?>margin-left:15vw;margin-right:15vw;<?php } else { ?>margin-left:5vw;margin-right:5vw;padding:16px;<?php } ?>box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;background:#FFF;border-radius:8px;'>
             <table style='width:100%;<?php if(!isMobileDevice()) { ?>min-height:50vh;<?php } else { ?>min-height:20vh;<?php } ?>'>
                 &nbsp;
                 <tr>
                     <td  style='text-align:center;' id='main-td'>

                     </td>
                 </tr>
             </table>
             <div style='text-align:center;' id='bottom-btns'>
                 <button style='background-color:#0668FD;border-radius:8px;border:2px solid #0668FD;padding:12px 36px;color:white;font-size:1em;' id='sbtn'>Submit (--/--)&nbsp;&nbsp;<i
 class="fa-solid fa-arrow-right-to-bracket"></i></button>
                 <a rel="modal:open" href='#options'><button style='background-color:#FFF;border-radius:8px;border:2px solid #0668FD;padding:12px
 36px;color:black;font-size:1em;margin-bottom:12px;' onclick='options()'>Options&nbsp;&nbsp;<i class="fa-solid fa-sliders"></i></button></a>
             </div>
         </div>

         <div style='height:5vh;'>&nbsp;</div>

         <div id="options" class="modal">
             <h2>Options</h2>
             <a rel="modal:close">
                 <button style='padding:8px;border:1px solid black;background:white;border-radius:8px;' onclick='swt()'>Start with Question</button>
                 <button style='padding:8px;border:1px solid black;background:white;border-radius:8px;' onclick='swd()'>Start with Answer</button></a>
         </div>

     </div>
     <script src='https://www.quizza.org/static/scripts/fr.js'></script>
 </body>

 </html>
<?php } ?>
