<?php require("/var/www/html/docs/lib/header.php"); ?>
<!DOCTYPE html>
<html>

<head>
  <title>Match | Quizza</title>
  <?php require("/var/www/html/docs/lib/imports.php"); ?>
  <script src='https://www.quizza.org/static/scripts/match.js'></script>
  <script async>
    var answers = [<?php $words = $thisClass->query("SELECT * FROM ".$type.$setID); if($words->num_rows > 0){ while($row = $words->fetch_assoc()){ echo '[`'.str_replace("\\","\\\\",$row[$type=="Set"?"Term":"Question"]).'`,`'.str_replace("\\","\\\\",$row[$type=="Set"?"Definition":"C1"]).'`],'; } } ?>[]];
    answers.pop();
    if(answers.length < 16){ location.href = "<?php echo $classID."/".$setID; ?>"; }
  </script>
</head>

<body onload="init()">
  <?php require("/var/www/html/docs/lib/topBar.php"); ?>
  <div id='main-content'>

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

    <p id='back-link'>
      <a href='/<?php echo $classID."/".$setID; ?>'>
        <i class="fa-solid fa-arrow-left"></i> Back
      </a>
    </p>

    <div id='content_box'>
    	<table id='match-table'>
    		<tr class='match-tbl-row'>
          <td class='mt-cell'><button onclick='select(0,0)' id='box-0' class='btn-match'></button></td>
          <td class='mt-cell'><button onclick='select(0,1)' id='box-1' class='btn-match'></button></td>
          <td class='mt-cell'><button onclick='select(0,2)' id='box-2' class='btn-match'></button></td>
          <td class='mt-cell'><button onclick='select(0,3)' id='box-3' class='btn-match'></button></td>
      	</tr>
        <tr class='match-tbl-row'>
          <td class='mt-cell'><button onclick='select(1,0)' id='box-4' class='btn-match'></button></td>
          <td class='mt-cell'><button onclick='select(1,1)' id='box-5' class='btn-match'></button></td>
          <td class='mt-cell'><button onclick='select(1,2)' id='box-6' class='btn-match'></button></td>
          <td class='mt-cell'><button onclick='select(1,3)' id='box-7' class='btn-match'></button></td>
  			</tr>
        <tr class='match-tbl-row'>
          <td class='mt-cell'><button onclick='select(2,0)' id='box-8' class='btn-match'></button></td>
          <td class='mt-cell'><button onclick='select(2,1)' id='box-9' class='btn-match'></button></td>
          <td class='mt-cell'><button onclick='select(2,2)' id='box-10' class='btn-match'></button></td>
          <td class='mt-cell'><button onclick='select(2,3)' id='box-11' class='btn-match'></button></td>
  			</tr>
        <tr class='match-tbl-row'>
          <td class='mt-cell'><button onclick='select(3,0)' id='box-12' class='btn-match'></button></td>
          <td class='mt-cell'><button onclick='select(3,1)' id='box-13' class='btn-match'></button></td>
          <td class='mt-cell'><button onclick='select(3,2)' id='box-14' class='btn-match'></button></td>
          <td class='mt-cell'><button onclick='select(3,3)' id='box-15' class='btn-match'></button></td>
    		</tr>
      </table>
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