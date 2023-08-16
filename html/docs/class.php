<?php require("/var/www/html/docs/lib/header.php");?>
<!DOCTYPE html>
<html>
<head>
  <title><?php echo $class_shortname; ?> | Quizza</title>

  <?php require("/var/www/html/docs/lib/imports.php"); ?>

  <!-- Other scripts -->
  <script async>var loggedIn = <?php if($loggedIn==true){echo "true";} else {echo "false";} ?>;</script>
  <script async>var classID = "<?php echo $classID;?>";</script>
  <script src="https://www.quizza.org/static/scripts/class.js"></script>
  <?php if($private_set) { ?><script src="https://www.quizza.org/static/scripts/share.js"></script><?php } ?>

</head>
<body>

  <?php require("/var/www/html/docs/lib/topBar.php"); ?>

  <div id='main-content'>

    <?php if(!$private_set){ ?>
      <p id='back-link'>
        <a href='/'>
          <i class="fa-solid fa-arrow-left"></i> Back
        </a>
      </p>
    <?php } ?>

    <table id='titletable'>
      <tr>
        <td>
          <h1>
            <?php echo $class_icon; ?>&nbsp;&nbsp;
            <?php echo isMobileDevice() ? $class_shortname : $class_longname; ?>
          </h1>
        </td>
      </tr>
    </table>

    <!-- Buttons -->
    <p>
      <!-- Add set -->
      <a rel="modal:open" href='#newSetModal'>
        <button id='title-button-blue'>Add Set&nbsp;&nbsp;<i class="fa-solid fa-plus"></i></button>
      </a>
      <?php mobileBR(); ?>

      <!-- Favorite button -->
      <?php if(!$private_set){ ?>
        <?php if($admin->query("SELECT * FROM Favorites WHERE ID=\"$classID\" AND User=\"$email\"")->num_rows == 0 && $loggedIn == true){ ?><!-- Not favorited, but logged in -->
          <button id='favBtn' class='title-button-white' onclick='save()'>Favorite Class <i class="fa-regular fa-star"></i></button>
        <?php } else if($loggedIn == true) { ?><!-- Logged in, favorited -->
          <button id='favBtn' class='title-button-white' onclick='save()'>Remove Favorite <i class="fa-solid fa-star"></i></button>
        <?php } else { ?><!-- Not logged in -->
          <a rel="modal:open" href="#favLogin"><button id='favBtn' class='title-button-white'>Favorite Class <i class="fa-regular fa-star"></i></button></a>
        <?php } ?>
        <?php mobileBR(); ?>
      <?php } ?>

      <!-- Search bar -->
      <input id='search' type='text' placeholder="Search..">
      <?php mobileBR(); ?>
    </p>


    <!-- List of sets -->
    <?php
    $setLists = $admin->query("SELECT * FROM ".$classID."Sets ORDER BY timestamp DESC, Name");
    $count_sets = 0;
    if ($setLists->num_rows > 0) {
      while($row = $setLists->fetch_assoc()) {

        if($private_set){
          $allowed = base64_decode($row["Shared"]);
          $permission = 0;
          foreach (json_decode($allowed) as $allowed_email => $allowed_permission) {
            if($email == $allowed_email){ $permission = $allowed_permission; }
          }
          if($permission == 0){ continue; }
        }

        $count_sets++;

        // Count number of terms
        $terms_query = $thisClass->query("SELECT COUNT(*) FROM ".$row["Type"].$row["ID"]);
        if($terms_query->num_rows > 0){ 
          while($terms_query_result = $terms_query->fetch_assoc()){
            $terms = $terms_query_result;
          }
        } else {
          $terms = 0;
        } ?>
        
        <!-- List item -->
        <div class='allSets'>
          <a onclick="location.href='/<?php echo $classID."/".$row["ID"]; ?>';">
            <div class='item-card'>
              <table>
                <tr>
                  <td>
                    <h2><?php echo $row["Name"]; ?></h2>
                    <p>
                      <?php echo $terms["COUNT(*)"]; ?> 
                      <?php if($row["Type"]=="Set"){ ?>Terms<?php } else { ?>Questions<?php } ?>
                      <?php if(!isMobileDevice()) { ?> • Last Modified <?php echo $row["Modified"]; } ?>
                    </p>
                  </td>
                  <td>
                    <p class='rightalign'>
                      <?php if($private_set) { ?><span class='sharebtn-wrapper' id='term-<?php echo $permission; ?>-<?php echo $row["ID"]; ?>'><button class='class-sharebtn'>Share</button></span><?php } ?>
                      <button class='class-practicebtn'>Practice</button>
                    </p>
                  </td>
                </tr>
              </table>
            </div>
          </a>
        </div>

      <?php }
    }
    if($count_sets == 0){ ?>

      <!-- No sets available -->
      <div id='no-items-card' class='item-card'>
        <table>
          <tr>
            <td>
              <?php if($private_set){ ?>
                <?php if($loggedIn){ ?>
                  <p>You have not sets. Click 'add set' to get started!</p>
                <?php } else { ?>
                  <p>Sign in with Google to create a private set!</p>
                <?php } ?>
              <?php } else { ?>
                <p>This class has no sets. Click 'add set' to get started!</p>
              <?php } ?>
            </td>
          </tr>
        </table>
      </div>
    <?php } ?>
  </div>

  <!-- New set modal -->
  <div id="newSetModal" class="modal">
    <h2>Create a Study Set</h2>
    <?php if($loggedIn == true) { ?>
      <form action="/<?php echo $classID; ?>/addSet" method="GET">

        <!-- Top row -->
        <input type='text' id='addInputBox' name="title" placeholder='Set Name' required>
        <input class="submitbtn submitbtn-first" value='Create<?php if(!$private_set) { ?> Public<?php } else { ?> Private<?php } ?> Set' name='private' type='Submit'>
        <?php if(!$private_set) { ?><input class="submitbtn" value='Create Protected Set' name='private' type='Submit'><?php } ?>
      </form>
      <hr>

      <!-- Bottom row -->
      <p>
        <small>
        <?php if($private_set) { ?>
          Private sets are only available to people you've shared them with. However, do not save sensitive information in Quizza.
        <?php } else { ?>
          Public sets can be accessed and edited by anyone. Protected sets can be viewed by anyone, but only edited by the creator.
        <?php } ?>
        </small>
        <?php if(!isMobileDevice()) { ?>
          <br><br>
          <small>
              <a href='/docs/upload.php?class=<?php echo $classID; ?>'><i class="fa-solid fa-circle-info"></i> Import from Quizlet or Upload CSV</a>
          </small>
        <?php } ?>
      </p>
    <?php } else { ?>
      <p>Please sign in to create a set.</p>
    <?php } ?>
  </div>

  <?php if($loggedIn == false) { ?>
    <!-- Log in to favorite a set -->
    <div id="favLogin" class="modal">
      <h2>Favorite</h2>
      <p>Please sign in to favorite a set.</p>
    </div>
  <?php } ?>

  <?php require("/var/www/html/docs/lib/footer.php"); ?>

</body>

</html>
