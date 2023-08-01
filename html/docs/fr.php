<?php require("/var/www/html/docs/lib/header.php"); ?>
<!DOCTYPE html>
<html>

<head>

  <title>Test | Quizza</title>

  <?php require("/var/www/html/docs/lib/imports.php"); ?>

  <script src='https://www.quizza.org/static/scripts/fr.js'></script>
 
  <script async>
    <?php if($_GET['learn']=='true'){ ?> var learnmode = true; <?php } else { ?> var learnmode = false; <?php } ?>
    var words = [<?php $words = $thisClass->query("SELECT * FROM ".$type.$setID); if($words->num_rows > 0){ while($row = $words->fetch_assoc()){ echo '`'.str_replace("\\","\\\\",$row[$type=="Set"?"Term":"Question"]).'`,'; }} ?>""];
    var defs = [<?php $words = $thisClass->query("SELECT * FROM ".$type.$setID); if($words->num_rows > 0){ while($row = $words->fetch_assoc()){ echo '`'.str_replace("\\","\\\\",$row[$type=="Set"?"Definition":"C1"]).'`,'; }} ?>""];
    words.pop();
    defs.pop();
  </script>

</head>

<body onload="init()">

  <?php require("/var/www/html/docs/lib/topBar.php"); ?>

  <div id='main-content'>

    <p id="back-link">
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

    <div class='study-box'>

      <table>
        &nbsp;
        <tr>
          <td  style='text-align:center;' id='main-td'></td>
        </tr>
      </table>

      <div id='bottom-btns' class='study-btn-bottom'>
        <button class='btn-blue' id='sbtn'>Submit (--/--)&nbsp;&nbsp;<i class="fa-solid fa-arrow-right-to-bracket"></i></button>
        <a rel="modal:open" href='#options'>
          <button onclick='options()'>Options&nbsp;&nbsp;<i class="fa-solid fa-sliders"></i></button>
        </a>
      </div>
    </div>
  </div>

  <div id="options" class="modal">
    <h2>Options</h2>
    <a rel="modal:close">
      <button class='modalbtn' onclick='swt()'>Start with Term</button>
      <button class='modalbtn' onclick='swd()'>Start with Definition</button>
    </a>
  </div>

  <?php require("/var/www/html/docs/lib/footer.php"); ?>

</body>

</html>