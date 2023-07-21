<?php require("/var/www/html/docs/lib/header.php");?>
<!DOCTYPE html>
<html>
<head>
  <title>Quizza | Free Study Tools For <?php echo $school_shortname; ?> Students</title>

  <?php require("/var/www/html/docs/lib/imports.php"); ?>

  <!-- Inline scripts -->
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

    // runs on page load
    function onload() {
        for (var i = 0; i < subjects.length; i++) { // loop over each item

            (function(index) {
                var row = "#" + subjects[index] + "-B";
                $(row).hide(); // hide the row
                $("#" + subjects[index] + "-H").click(function() {
                    $(row).toggle(); // toggle it when clicked
                });
            })(i);

        }

        $("#fav-B").show();

        // attempt to render sign in button if it exists
        try {
            render_gSignIn();
        } catch (e) {}

    }
  </script>
</head>
<body onload="onload()" style='background-image:url("https://www.quizza.org/static/images/diag-2.svg");'>

  <?php require("/var/www/html/docs/lib/topBar.php"); ?>
  
  <div id='main-content'>
    <h1 id='frontpage-header-large'>Access Free Study Materials for <?php echo $school_shortname; ?> Students</h1>
    <p id='frontpage-header-small'>Just select your class to view study sets made by your peers, or to create your own!</p>

    <?php if(!isMobileDevice()) { ?>
      <!-- Updates box -->
      <div id="frontpage-alert">
        <span id="frontpage-closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
        <strong>Updates</strong><?php if(isMobileDevice()) { echo "<br>"; } else { echo " • "; } ?>View new Quizza features on our <a href='https://www.quizza.org/blog'>update blog</a>
      </div>
      <br>
    <?php } ?>


    <?php if ($loggedIn) {
      $favorites = $admin->query("SELECT * FROM Favorites WHERE User=\"$email\"");
      if ($favorites->num_rows > 0) { ?>
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
                <?php while ($favorite = $favorites->fetch_assoc()) {
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
    <?php } } ?>


    <!-- All classes -->
    <?php $subjectlist = $schooldb->query("SELECT * FROM subjects".$school." ORDER BY Name ASC");
        if ($subjectlist->num_rows > 0) { 
          while ($current_subject = $subjectlist->fetch_assoc()) { ?>
            <div class='subject-row'>
              <table>
                <tr id='<?php echo $current_subject["id"]; ?>-H'><td><h2 style='text-align:center;'><i class="<?php echo $current_subject["icon"]; ?>"></i> <?php echo $current_subject["name"]; ?> <i class="fa-solid fa-caret-down"></i></h2></td></tr>
                <tr id='<?php echo $current_subject["id"]; ?>-B'>
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
</body>

</html>

