<?php if($_SERVER['HTTP_HOST']=="www.quizza.org" || $_SERVER['HTTP_HOST'] == "quizza.org"){ require("/var/www/html/main.php"); die(); } ?>
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


    <!-- Search bar -->
    <div id="searchbox-home">
      <input id="search-home" placeholder="Search for classes...">
      <div class="resultscontainer">
      </div>
    </div>


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
                <tr id='<?php echo $current_subject["id"]; ?>-B'>
                  <td class='classes'>

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

    // runs on page load
    function onload_1() {
      for (var i = 0; i < subjects.length-1; i++) { // loop over each item
        (function(index) {
          $("#"+subjects[index]+"-B").hide(); // hide the row

          // get classes through AJAX
          $.get("/docs/lib/getClass.php?subj="+subjects[index], function(d,s){
            $("#"+subjects[index]+"-B .classes").html(d);
          });
        })(i);

      }
    }
    function onload_2(){

      $("#fav-B").show();

      // attempt to render sign in button if it exists
      try {
          render_gSignIn();
      } catch (e) {}

    }
    function onload_3(){
      for(var i=0;i<subjects.length;i++){
        (function(index) {
          var row = "#" + subjects[index] + "-B";
            $("#" + subjects[index] + "-H").click(function() {
              $(row).toggle(); // toggle it when clicked
            });
        })(i);
      }
    }

    onload_1();
    setTimeout(onload_2, 1000);
    onload_3();

    $("#search").focus(function(event){
      $(".resultscontainer").show();
    });

    $("#search").blur(function(event){
      $(".resultscontainer").hide();
    });

    $('#search').keypress(function(event) {
      $.get("/docs/lib/searchClasses.php?query="+encodeURIComponent($("#search").val()), function(data, status){
        try {var results = JSON.parse(data);}
        catch {
          $(".resultscontainer").html("");
          return;
        }
        var results_str = "";
        for(var i=0;i<results.length && i<5;i++){
          var id = 'resultscontainer-'+i;
          if(results.length >= 2 && i==0){ id = 'resultscontainer-div-first'; }
          if(results.length >= 2 && i==results.length-1){ id = 'resultscontainer-div-last'; }
          if(results.length >= 2 && i==4){ id = 'resultscontainer-div-last'; }
          results_str += "<a href='"+results[i][1]+"'><div id='"+id+"'>"+results[i][0]+"</div></a>";
        }
        $(".resultscontainer").html(results_str);
      });
    });
  </script>
</body>

</html>

