<?php require("/var/www/html/docs/lib/header.php");?>
 <!DOCTYPE html>
<html>

<head>
  <title>Flashcards | Quizza</title>
  
  <?php require("/var/www/html/docs/lib/imports.php"); ?>

  <script src='https://www.quizza.org/static/scripts/flashcards.js'></script>  
  <script async>
    var words = [<?php $words = $thisClass->query("SELECT * FROM ".$type.$setID); if($words->num_rows > 0){ while($row = $words->fetch_assoc()){ echo '`'.str_replace("\\","\\\\",$row[$type=="Set"?"Term":"Question"]).'`,'; }} ?>""];
    var defs = [<?php $words = $thisClass->query("SELECT * FROM ".$type.$setID); if($words->num_rows > 0){ while($row = $words->fetch_assoc()){ echo '`'.str_replace("\\","\\\\",$row[$type=="Set"?"Definition":"C1"]).'`,'; }} ?>""];
    words.pop();
    defs.pop();
  </script>

</head>

<body onload="init()">

  <?php require("/var/www/html/docs/lib/topBar.php"); ?>

  <div id='main-content'>

    <table id='titletable'>
      <tr>
        <td>
          <h1>
            <a href='/<?php echo $className."/".$setID; ?>'>
              <?php echo $class_icon."&nbsp;&nbsp;".$setName; ?>
            </a>
          </h1>
        </td>
      </tr>
    </table>

    <p>
      <a href='<?php echo $className."/".$setID; ?>' id='back-link'>
        <i class="fa-solid fa-arrow-left"></i> Back
      </a>
    </p>

    <div class='study-box'>
      <table>
        &nbsp;
        <tr>
          <td>
            <h1 id='t'></h1>
          </td>
        </tr>
      </table>

      <div id='bottom-btns' class='study-btn-bottom'>
        <button onclick='reveal()' class='btn-blue'>Flip&nbsp;&nbsp;<i class="fa-solid fa-repeat"></i></button>
        <button onclick='back()'>Back&nbsp;&nbsp;<i class="fa-solid fa-arrow-left"></i></button>
        <button onclick='next()'>Next (<span id='complete'>--/--</span>)&nbsp;&nbsp;<i class="fa-solid fa-arrow-right"></i></button>

        <a rel="modal:open" href='#options'>
          <button  onclick='options()'>Options&nbsp;&nbsp;<i class="fa-solid fa-sliders"></i></button>
        </a>
      </div>
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