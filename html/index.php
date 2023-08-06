<?php if($_SERVER['HTTP_HOST']=="www.quizza.org" || $_SERVER['HTTP_HOST'] == "quizza.org"){ require("/var/www/html/main.php"); die(); } ?>
<?php if($_SERVER['HTTP_HOST']=="private.quizza.org"){ header("Location: https://www.quizza.org/private"); die("<script>location.href='https://www.quizza.org/private';</script>"); } ?>
<?php require("/var/www/html/docs/lib/header.php");?>
<!DOCTYPE html>
<html>
<head>
  <title>Quizza | Free Study Tools For <?php echo $school_shortname; ?> Students</title>

  <?php require("/var/www/html/docs/lib/imports.php"); ?>
</head>
<body id='indexphp-body'>

  <?php require("/var/www/html/docs/lib/topBar.php"); ?>
  
  <div id='main-content'>
    <div class="custom-select">
    <h1 id="fontpage-header-large">
      Access Free Study Materials for
      <?php mobileBR(); ?>
      <select id="school-selector">
        <option value="www" selected><?php echo $school_shortname; ?></option>
        <option value="private">Private Sets</option>
        <?php $schools = $schooldb->query("SELECT * FROM main");
        while($curr_school = $schools->fetch_assoc()){ 
          if($curr_school["shortname"] !== $school_shortname){ ?>
            <option value="<?php echo $curr_school["id"]; ?>"><?php echo $curr_school["shortname"]; ?></option>
        <?php } } ?>
      </select>
      <?php mobileBR(); ?>
      Students
    </h1>
  </div>

    <?php if(!isMobileDevice()) { ?>
      <!-- Updates box -->
      <div id="frontpage-alert">
        <span id="frontpage-closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
        <strong>Updates</strong><?php if(isMobileDevice()) { echo "<br>"; } else { echo " • "; } ?>View new Quizza features on our <a href='https://www.quizza.org/blog'>update blog</a>
      </div>
      <br>
    <?php } ?>


    <!-- Search bar -->
    <div id="searchbox-home">
      <input id="search-home" placeholder="Search for classes...">
      <div class="resultscontainer">
      </div>
    </div>
    <br>


    <?php if ($loggedIn) { ?>
      <!-- Favorite classes -->
      <div class='subject-row'>
        <table>
          <tr id='fav-H'>
            <td>
              <h2><i class="fa-solid fa-star"></i> My Classes <i class="fa-solid fa-caret-down"></i></h2>
            </td>
          </tr>
          <tr id='fav-B'>
            <td class='classes'>
              <?php 
              $favorites = $admin->query("SELECT * FROM Favorites WHERE User=\"$email\"");
              if ($favorites->num_rows > 0) {
                 while ($favorite = $favorites->fetch_assoc()) {
                  $classes = $admin->query("SELECT * FROM Classes WHERE ID=\"" . $favorite["ID"] . "\"");
                  if ($classes->num_rows > 0) {
                    while ($row = $classes->fetch_assoc()) { ?>
                      <div>
                        <h3><i class='<?php echo $row["Icon"]; ?>'></i>&nbsp;&nbsp;<?php echo $row["ShortName"]; ?></h3>
                        <a href='<?php echo $row["ID"]; ?>'>
                          <button class="frontpage-studybtn">Study</button>
                        </a>
                      </div><?php 
                    }
                  }
                } ?>
              <?php } ?>
              <div>
                <h3><i class='fa-solid fa-lock'></i>&nbsp;&nbsp;Private Sets</h3>
                <a href='https://www.quizza.org/private'>
                  <button class="frontpage-studybtn">Study</button>
                </a>
              </div>

            </td>
          </tr>
        </table>
      </div>
    <?php } ?>


    <!-- All classes -->
    <?php $subjectlist = $schooldb->query("SELECT * FROM subjects".$school." ORDER BY Name ASC");
        if ($subjectlist->num_rows > 0) { 
          while ($current_subject = $subjectlist->fetch_assoc()) { ?>
            <div class='subject-row'>
              <table>
                <tr id='<?php echo $current_subject["id"]; ?>-H'><td><h2 style='text-align:center;'><i class="<?php echo $current_subject["icon"]; ?>"></i> <?php echo $current_subject["name"]; ?> <i class="fa-solid fa-caret-down"></i></h2></td></tr>
                <tr id='<?php echo $current_subject["id"]; ?>-B' style='display:none;'>
                  <td class='classes'>

                    <?php
                      $classlist = $admin->query("SELECT * FROM Classes WHERE Subject=\"".$current_subject["id"]."\"");
                      if ($classlist->num_rows > 0) {
                          while ($current_class = $classlist->fetch_assoc()) { ?>
                            <div>
                              <h3><?php echo $current_class["ShortName"]; ?></h3>
                              <a href='<?php echo $current_class["ID"]; ?>'>
                                <button class='frontpage-studybtn'>Study</button>
                              </a>
                            </div><?php
                          }
                        }
                      ?>

                    <?php if($current_subject["id"]=="oth"){ ?><div>
                        <!-- Private sets -->
                        <h3>Private Sets</h3>
                        <a href='https://www.quizza.org/private'>
                          <button class='frontpage-studybtn'>Study</button>
                        </a>
                      </div>
                    <?php } ?>

                  </td>
                </tr>
              </table>
            </div>
    <?php } } ?>

    <div>&nbsp;</div>

    <?php require("/var/www/html/docs/lib/footer.php"); ?>

  </div>
  <script defer>
    // list of all subjects
    var subjects = [<?php 
    $subjects = $schooldb->query("SELECT * FROM subjects".$school);
      if ($subjects->num_rows > 0) { 
        while ($subject = $subjects->fetch_assoc()) {
          echo '"'.$subject["id"].'", ';
        }
      } ?>"fav"
    ];

    var mobile = <?php echo isMobileDevice(); ?>;

  </script>
  <script defer src="https://www.quizza.org/static/scripts/index.js"></script>
  <script src="https://www.quizza.org/static/scripts/homepage.js"></script>
</body>

</html>

