<?php
 $req_permission = 1;
 require("/var/www/html/docs/lib/header.php");?>
 <!DOCTYPE html>
<html>

<head>
  <title>Flashcards | Quizza</title>
  
  <?php require("/var/www/html/docs/lib/imports.php"); ?>
  <meta name="robots" content="noindex" />

  <script src='https://www.quizza.org/static/scripts/flashcards.js'></script>  
  <script async>
    var words = [<?php $words = $thisClass->query("SELECT * FROM ".$type.$setID); if($words->num_rows > 0){ while($row = $words->fetch_assoc()){ echo '`'.str_replace("\\","\\\\",$row[$type=="Set"?"Term":"Question"]).'`,'; }} ?>""];
    var defs = [<?php $words = $thisClass->query("SELECT * FROM ".$type.$setID); if($words->num_rows > 0){ while($row = $words->fetch_assoc()){ echo '`'.str_replace("\\","\\\\",$row[$type=="Set"?"Definition":"C1"]).'`,'; }} ?>""];
    var return_url = "/<?php echo $classID."/".$setID; ?>";
    words.pop();
    defs.pop();
  </script>

</head>

<body onload="init()">

  <?php require("/var/www/html/docs/lib/topBar.php"); ?>

  <div id='main-content'>

    <p id='back-link'>
      <a href='/<?php echo $classID."/".$setID; ?>'>
        <i class="fa-solid fa-arrow-left"></i> Back
      </a>
    </p>

    <table id='titletable'>
      <tr>
        <td>
          <h1>
            <a href='/<?php echo $classID."/".$setID; ?>'>
              <?php echo $class_icon."&nbsp;&nbsp;".$setName; ?>
            </a>
          </h1>
        </td>
      </tr>
    </table>

    <div id='flashcard' class='front' style='transition: transform 0.6s;'>
      <?php for ($i = 0; $i < 2; $i++) { ?>
        <div class="<?php echo $i==0 ? "front" : "back"; ?>-side study-box">
          <p class='complete-parent'><span class="complete">--/--</span></p>
          <table>
            &nbsp;
            <tr>
              <td>
                <h1 id='t<?php echo $i; ?>'></h1>
              </td>
            </tr>
          </table>

          <div class='study-btn-bottom'>
            <button onclick='reveal()' class='btn-blue'>Flip&nbsp;&nbsp;<i class="fa-solid fa-repeat"></i></button>
            <?php mobileBR(); ?>
            <button onclick='back()'>Back&nbsp;&nbsp;<i class="fa-solid fa-arrow-left"></i></button>
            <?php mobileBR(); ?>
            <button onclick='next()'>Next&nbsp;&nbsp;<i class="fa-solid fa-arrow-right"></i></button>
            <?php mobileBR(); ?>
            <a rel="modal:open" href='#options'>
              <button>Options&nbsp;&nbsp;<i class="fa-solid fa-sliders"></i></button>
            </a>
          </div>
        </div>
      <?php } ?>
    </div>

    <div style='height:5vh;'>&nbsp;</div>

    <div id="options" class="modal">
      <h2>Options</h2>
      <a rel="modal:close">
        <button class='modalbtn' onclick='swt()'>Start with Term</button>
        <button class='modalbtn' onclick='swd()'>Start with Definition</button>
      </a>
    </div>
  </div>

  <?php require("/var/www/html/docs/lib/footer.php"); ?>

</body>

</html>