<?php
 $req_permission = 1;
 require("/var/www/html/docs/lib/header.php");?>
<!DOCTYPE html>
<html>

<head>
  <title><?php echo $setName; ?> | Quizza</title>
  
  <?php require("/var/www/html/docs/lib/imports.php"); ?>

  <?php if($type=="Set"){ ?><script src="https://www.quizza.org/static/scripts/set.js"></script><?php } ?>
  <?php if($type=="Quiz"){ ?><script src="https://www.quizza.org/static/scripts/setQuiz.js"></script><?php } ?>
  <?php if($private_set) { ?><script src="https://www.quizza.org/static/scripts/share.js"></script><?php } ?>

  <script async>

    var classID = "<?php echo $classID; ?>";
    var setID = "<?php echo $setID; ?>";
    var has_mathjax = <?php echo isset($mathjax); ?>;

    <?php if($type=="Set") { ?>

      var allWords = [<?php $words = $thisClass->query("SELECT * FROM ".$type.$setID); if($words->num_rows > 0){ while($row = $words->fetch_assoc()){ echo '`'.str_replace("\\","\\\\",$row["Term"]).'`,'; }} ?>""];
      var allDefs = [<?php $words = $thisClass->query("SELECT * FROM ".$type.$setID); if($words->num_rows > 0){ while($row = $words->fetch_assoc()){ echo '`'.str_replace("\\","\\\\",$row["Definition"]).'`,'; }} ?>""];
      var questions = [ <?php $words = $thisClass->query("SELECT * FROM ".$type.$setID); if($words->num_rows > 0){ while($row = $words->fetch_assoc()){ echo "['".preg_replace("/'/", "\'",str_replace('\\', '\\\\',$row['Term']))."','".preg_replace("/'/", "\'",str_replace('\\', '\\\\',$row['Definition']))."'],"; }} ?> [] ];

    <?php } else if($type=="Quiz") { ?>

      var questions = [<?php $words = $thisClass->query("SELECT * FROM ".$type.$setID); if($words->num_rows > 0){ while($row = $words->fetch_assoc()){ echo '`'.str_replace("\\","\\\\",$row["Question"]).'`,'; }} ?>""];
      var c1s =  [<?php $words = $thisClass->query("SELECT * FROM ".$type.$setID); if($words->num_rows > 0){ while($row = $words->fetch_assoc()){ echo '`'.str_replace("\\","\\\\",$row["C1"]).'`,'; }} ?>""];
      var ic1s = [<?php $words = $thisClass->query("SELECT * FROM ".$type.$setID); if($words->num_rows > 0){ while($row = $words->fetch_assoc()){ echo '`'.str_replace("\\","\\\\",$row["Ic1"]).'`,'; }} ?>""];
      var ic2s = [<?php $words = $thisClass->query("SELECT * FROM ".$type.$setID); if($words->num_rows > 0){ while($row = $words->fetch_assoc()){ echo '`'.str_replace("\\","\\\\",$row["Ic2"]).'`,'; }} ?>""];
      var ic3s = [<?php $words = $thisClass->query("SELECT * FROM ".$type.$setID); if($words->num_rows > 0){ while($row = $words->fetch_assoc()){ echo '`'.str_replace("\\","\\\\",$row["Ic3"]).'`,'; }} ?>""];

    <?php } ?>

    var terms = [<?php $words = $thisClass->query("SELECT * FROM ".$type.$setID); $z = 0; if($words->num_rows > 0){ while($row = $words->fetch_assoc()){ $z++; echo "[\"".$row[$type=="Set"?"Term":"Question"]."\",".$z."],";  }}?>""];

    var loggedIn = <?php if($loggedIn){echo "true";}else{echo "false";} ?>;

    $(document).ready(function() {

      <?php if($type == "Set") { ?>
        allWords.pop();
        allDefs.pop();
        terms.pop();
        questions.pop();
      <?php } else { ?>
        questions.pop();
        terms.pop();
        c1s.pop();
        ic1s.pop();
        ic2s.pop();
        ic3s.pop();
      <?php } ?>

      load_function();
    });
  </script>

</head>
<body>

  <?php require("/var/www/html/docs/lib/topBar.php"); ?>

  <div id='main-content'>

    <p id='back-link'>
      <a href='/<?php echo $classID; ?>'>
        <i class="fa-solid fa-arrow-left"></i> Back
      </a>
    </p>

    <table id='titletable'>
      <tr>
        <td>
          <h1>
            <?php echo $class_icon . "&nbsp;&nbsp;" . $setName; ?>
          </h1>
        </td>
      </tr>
    </table>

    <p>
        <a <?php if($editable) { ?> href='/<?php echo $classID."/".$setID; ?>/edit' <?php } else { ?> href='#noedit' rel='modal:open'<?php } ?>>
          <button id='title-button-blue'>Edit Set&nbsp;&nbsp;
            <?php if($editable){ ?><i class="fa-regular fa-pen-to-square"></i><?php } ?>
            <?php if(!$editable){ ?><i class="fa-solid fa-lock"></i><?php } ?>
          </button>
        </a>

        <?php mobileBR(); ?>

        <?php if(!$empty_set){ ?>
          <a href='/<?php echo $classID."/".$setID; ?>/flashcards'>
            <button class='title-button-white'>Flashcards&nbsp;&nbsp;<i class="fa-solid fa-layer-group"></i></button>
          </a>
          
          <?php mobileBR(); ?>

          <a rel='modal:open' href="#test">
            <button class='title-button-white'>Study&nbsp;&nbsp;<i class="fa-regular fa-file-lines"></i></button>
          </a>
          
          <?php mobileBR(); ?>

        <?php } ?>

        <?php if($private_set) { ?><button id='term-<?php echo $permission; ?>-<?php echo $setID; ?>' class='sharebtn-wrapper title-button-white right'>Share&nbsp;&nbsp;<i class="fa-solid fa-share"></i></button><?php } ?>

        <?php mobileBR(); ?>

        <?php if(!$empty_set){ ?>

          <a href='#print' rel='modal:open'>
            <button class='title-button-white right'>Print&nbsp;&nbsp;<i class="fa-solid fa-print"></i></button>
          </a>

          <?php mobileBR(); ?>

        <?php } ?>
    </p>

    <?php 
    $all_terms = $thisClass->query("SELECT * FROM ".$type.$setID);
    $term_number = 0;
    if($all_terms->num_rows > 0){
      while($current_term = $all_terms->fetch_assoc()){ ?>
        <?php $term_number++; ?>
        <a href='javascript:disableTerm("<?php echo urlencode($current_term[$type=="Set"?'Term':'Question']); ?>",<?php echo $term_number; ?>)'>
          <div class='item-card' id='container-<?php echo $term_number; ?>'>
            <table>
              <tr>
                <td>
                  <h2><?php echo $current_term[$type=="Set"?'Term':'Question']; ?></h2>
                </td>
                <td>
                  <p class='rightalign'>
                    <?php echo $current_term[$type=="Set"?'Definition':'C1']; ?>&nbsp;&nbsp;<i id='icon-<?php echo $term_number; ?>'></i>
                  </p>
                </td>
              </tr>
            </table>
          </div>
        </a>
      <?php } ?>
    <?php } else { ?>
      <div class='item-card' id='no-items-card'>
        <table>
          <tr>
            <td>
              <p>This set is empty. Click 'edit set' to add some terms!</p>
            </td>
          </tr>
        </table>
      </div>
    <?php } ?>
  </div>

  <div id="test" class="modal">
    <h2>Test Yourself</h2>
    <a rel="modal:close">
      <button class='modalbtn modalbtn-first' onclick='location.href="/<?php echo $classID."/".$setID; ?>/mc"'>Multiple Choice</button>
      <button class='modalbtn' onclick='location.href="/<?php echo $classID."/".$setID; ?>/fr"'>Free Response</button>
      <button class='modalbtn' onclick='location.href="/<?php echo $classID."/".$setID; ?>/mc?learn=true"'>Learn</button>
      <?php if($term_number >= 16) { ?><button class='modalbtn' onclick='location.href="/<?php echo $classID."/".$setID; ?>/match"'>Match</button><?php } ?>
    </a>
  </div>

  <div id="noedit" class="modal">
    <h2>You cannot edit this set</h2>
    <p>
      <?php if(!$private_set && $loggedIn) { ?>Your account does not have access to this page. Only the original owner may edit this set.<?php } ?>
      <?php if(!$private_set && !$loggedIn) { ?>You must be logged in to edit this set.<?php } ?>
      <?php if($private_set) { ?>Your account does not have access to this page. Contact the set's owner to get edit access.<?php } ?>
    </p>
  </div>

  <div id='print' class='modal'>
    <h2>Print</h2>
    <label class="container">Free Response
      <input type="radio" checked="checked" name="radio" value='fr'>
      <span class="checkmark"></span>
    </label>
    <label class="container">Multiple Choice
      <input type="radio" name="radio" value='mc'>
      <span class="checkmark"></span>
    </label>
    <label class="container">Word Bank
      <input type="radio" name="radio" value='wb'>
      <span class="checkmark"></span>
    </label>
    <label class="container">Flashcards
      <input type="radio" name="radio" value='tc'>
      <span class="checkmark"></span>
    </label>
    <hr>
    <p>
      Answer with...<br><br>
      <button class='modalbtn' onclick="print_set('<?php echo $type=="Set"?"Term":"Question"; ?>')">Terms</button>
      <button class='modalbtn' onclick="print_set('<?php echo $type=="Set"?"Definition":"C1"; ?>')">Definitions</button>
    </p>
  </div>

  <?php require("/var/www/html/docs/lib/footer.php"); ?>

</body>

</html>