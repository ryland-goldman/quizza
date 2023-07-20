<?php require("/var/www/html/docs/lib/header.php"); ?>
<!DOCTYPE html>
<html>

<head>

  <title>Test | Quizza</title>

  <?php require("/var/www/html/docs/lib/imports.php"); ?>

  <script src='https://www.quizza.org/static/scripts/mc<?php if($type=="Quiz"){?>Quiz<?php } ?>.js'></script>

  <?php if($type == "Set") { ?>
    <script>
      <?php if($_GET['learn']=='true'){ ?> var learnmode = true; <?php } else { ?> var learnmode = false; <?php } ?>
      var words = [<?php $words = $thisClass->query("SELECT * FROM Set".$setID); if($words->num_rows > 0){ while($row = $words->fetch_assoc()){ echo '`'.str_replace("\\","\\\\",$row["Term"]).'`,'; }} ?>""];
      var defs = [<?php $words = $thisClass->query("SELECT * FROM Set".$setID); if($words->num_rows > 0){ while($row = $words->fetch_assoc()){ echo '`'.str_replace("\\","\\\\",$row["Definition"]).'`,'; }} ?>""];
      words.pop();
      defs.pop();
    </script>
  <?php } else { ?>
    <script>
      <?php if($_GET['learn']=='true'){ ?> var learnmode = true; <?php } else { ?> var learnmode = false; <?php } ?>
      var questions = [<?php $words = $thisClass->query("SELECT * FROM Quiz".$setID); if($words->num_rows > 0){ while($row = $words->fetch_assoc()){ echo '`'.str_replace("\\","\\\\",$row["Question"]).'`,'; }} ?>""];
      var c1s = [<?php $words = $thisClass->query("SELECT * FROM Quiz".$setID); if($words->num_rows > 0){ while($row = $words->fetch_assoc()){ echo '`'.str_replace("\\","\\\\",$row["C1"]).'`,'; }} ?>""];
      var ic1s = [<?php $words = $thisClass->query("SELECT * FROM Quiz".$setID); if($words->num_rows > 0){ while($row = $words->fetch_assoc()){ echo '`'.str_replace("\\","\\\\",$row["Ic1"]).'`,'; }} ?>""];
      var ic2s = [<?php $words = $thisClass->query("SELECT * FROM Quiz".$setID); if($words->num_rows > 0){ while($row = $words->fetch_assoc()){ echo '`'.str_replace("\\","\\\\",$row["Ic2"]).'`,'; }} ?>""];
      var ic3s = [<?php $words = $thisClass->query("SELECT * FROM Quiz".$setID); if($words->num_rows > 0){ while($row = $words->fetch_assoc()){ echo '`'.str_replace("\\","\\\\",$row["Ic3"]).'`,'; }} ?>""];
      questions.pop();
      c1s.pop();
      ic1s.pop();
      ic2s.pop();
      ic3s.pop();
    </script>
  <?php } ?>

</head>

<body onload="init()">

  <?php require("/var/www/html/docs/lib/topBar.php"); ?>

  <div id='main-content'>
    <table>
      <tr>
        <td>
          <h1>
            <a href='<?php echo $className."/".$setID; ?>'>
              <?php echo $class_icon."&nbsp;&nbsp;".$setName; ?>
            </a>
          </h1>
        </td>
      </tr>
    </table>

    <p id='back-link'>
      <a href='<?php echo $className."/".$setID; ?>'>
        <i class="fa-solid fa-arrow-left"></i> Back
      </a>
    </p>

    <div class='study-box'>

      <table>
        &nbsp;
        <tr>
          <td  style='text-align:center;' id='main-td'></td>
        </tr>
      </table>

      <div id='bottom-btns' class='study-btn-bottom'>
        <button class="btn-blue" id='sbtn'>Submit&nbsp;&nbsp;<i class="fa-solid fa-arrow-right-to-bracket"></i></button>
        <a rel="modal:open" href='#options'>
          <button onclick='options()'>Options&nbsp;&nbsp;<i class="fa-solid fa-sliders"></i></button>
        </a>
      </div>

    </div>

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