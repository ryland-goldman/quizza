<?php require("/var/www/html/docs/lib/header.php"); ?>
<!DOCTYPE html>
<html>

<head>

  <title>Test | Quizza</title>

  <?php require("/var/www/html/docs/lib/imports.php"); ?>

  <?php if($type == "Set") { ?>
    <script async>
      var type = "Set";
      <?php if($_GET['learn']=='true'){ ?> var learnmode = true; <?php } else { ?> var learnmode = false; <?php } ?>
      var questions = [<?php $words = $thisClass->query("SELECT * FROM Set".$setID); if($words->num_rows > 0){ while($row = $words->fetch_assoc()){ echo '`'.str_replace("\\","\\\\",$row["Term"]).'`,'; }} ?>""];
      var c1s = [<?php $words = $thisClass->query("SELECT * FROM Set".$setID); if($words->num_rows > 0){ while($row = $words->fetch_assoc()){ echo '`'.str_replace("\\","\\\\",$row["Definition"]).'`,'; }} ?>""];
      var ic1s = [<?php $words = $thisClass->query("SELECT * FROM Set".$setID); if($words->num_rows > 0){ while($row = $words->fetch_assoc()){ echo '`'.str_replace("\\","\\\\",$row["Definition"]).'`,'; }} ?>""];
      var ic2s = [<?php $words = $thisClass->query("SELECT * FROM Set".$setID); if($words->num_rows > 0){ while($row = $words->fetch_assoc()){ echo '`'.str_replace("\\","\\\\",$row["Definition"]).'`,'; }} ?>""];
      var ic3s = [<?php $words = $thisClass->query("SELECT * FROM Set".$setID); if($words->num_rows > 0){ while($row = $words->fetch_assoc()){ echo '`'.str_replace("\\","\\\\",$row["Definition"]).'`,'; }} ?>""];
      questions.pop();
      c1s.pop();
      ic1s.pop();
      ic2s.pop();
      ic3s.pop();
    </script>
  <?php } else { ?>
    <script async>
      var type = "Quiz";
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

    <p id='back-link'>
      <a href='/<?php echo $classID."/".$setID; ?>'>
        <i class="fa-solid fa-arrow-left"></i> Back
      </a>
    </p>
    
    <table>
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
        <button class="btn-blue" id='sbtn'>Submit&nbsp;&nbsp;<i class="fa-solid fa-arrow-right-to-bracket"></i></button>
        <a rel="modal:open" href='#options'>
          <?php if($type=="Set" || !isset($_GET["learn"]) || $_GET["learn"]=="false"){ ?>
            <button onclick='options()'>Options&nbsp;&nbsp;<i class="fa-solid fa-sliders"></i></button>
          <?php } ?>
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

  <script src='https://www.quizza.org/static/scripts/mc.js' defer></script>

</body>

</html>