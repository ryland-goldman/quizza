<?php 
$req_permission = 2;
header('Access-Control-Allow-Origin: *');
require("/var/www/html/docs/lib/header.php");
if($loggedIn == false){  require("/var/www/html/403.php"); }
if($email !== $creator && $creator !== ""){ require("/var/www/html/403.php"); }?>
<!DOCTYPE html>
<html>

<head>

  <title>Edit Set | Quizza</title>
  
  <?php require("/var/www/html/docs/lib/imports.php"); ?>
  <meta name="robots" content="noindex" />

  <script src='https://www.quizza.org/static/scripts/edit<?php if($type=="Quiz"){ ?>Quiz<?php } ?>.js'></script>
  <script async>var class_and_set = "class=<?php echo $classID."&set=".$setID;?>&";</script>
  <script async>var google_auth = "<?php echo $gsi_auth; ?>";</script>
  <script async>var back_url = "<?php echo "/".$classID."/".$setID; ?>";</script>

</head>

<body>
  
  <?php require("/var/www/html/docs/lib/topBar.php"); ?>

  <div id='main-content'>

    <p id='back-link'>
      <a href='/<?php echo $classID."/".$setID; ?>'>
        <i class="fa-solid fa-arrow-left"></i> Back
      </a>
    </p>

    <table id='titletable'>
      <tr>
        <td>
          <h1>
            <?php echo $class_icon; ?>&nbsp;&nbsp;
            <input type='text' style=" vertical-align: middle;" id='title' value='<?php echo $setName; ?>'>
          </h1>
        </td>
      </tr>
    </table>

    <p>
        <button id='title-button-blue' onclick="saveChanges()">Save Changes&nbsp;&nbsp;<i class="fa-solid fa-floppy-disk"></i></button>
        <?php mobileBR(); ?>

        <?php if($type == "Set"){ $explanation = "A quiz allows you to specify multiple choice answers"; } else { $explanation = "A set randomizes multiple choice answers from other terms"; } ?>
        <span class='tooltips' tooltip="<?php echo $explanation; ?>"><button class='title-button-white' onclick="changeType()" id='toggleBTN'>Convert to <?php echo $type=="Set" ? "Quiz":"Set"; ?>&nbsp;&nbsp;<i class="fa-solid fa-rotate"></i></button><span></span></span>
        <?php mobileBR(); ?>

        <button class='title-button-white' onclick="addTerm()">Add Term&nbsp;&nbsp;<i class="fa-solid fa-plus"></i></button>
        <?php mobileBR(); ?>

        <?php if(!isMobileDevice()){ ?>
          <a href="#math" rel="modal:open">
            <button class='title-button-white'>Math&nbsp;&nbsp;<i class="fa-solid fa-square-root-variable"></i></button>
          </a>
          <?php mobileBR(); ?>

          <a href="#image" rel="modal:open">
            <button class='title-button-white'>Upload Image&nbsp;&nbsp;<i class="fa-solid fa-image"></i></button>
          </a>
          <?php mobileBR(); ?>
        <?php } ?>

        <button class='title-button-red' onclick="confirmDeletion()">Delete Set&nbsp;&nbsp;<i class="fa-solid fa-trash-can"></i></button>
        <?php mobileBR(); ?>
    </p>

    <div id='allBoxes'>
      <?php $words = $thisClass->query("SELECT * FROM ".$type.$setID);
      $i = 0;
      if($words->num_rows > 0){
        while($row = $words->fetch_assoc()){
          $i++; ?>
          <div id='box-<?php echo $i; ?>'>
        		<div class='item-card'>
              <table>
                <tr>
                  <td>
                    <h2>
                      <input type='text' value='<?php
                      $str2 = str_replace('<br>', '',$row[$type=="Set"?"Term":"Question"]);
                      if (preg_match("/<img[^>]+src\s*=\s*['\"]([^'\"]+)['\"][^>]*>/i", $str2, $matches)) {
                          $imgTag = $matches[0];
                          $url = $matches[1];
                          $str2 = str_replace($imgTag, "", $str2);
                          $str2 .= $url;
                      }
                      echo $str2; ?>' class='terms <?php if($type=="Quiz"){ ?>q<?php } ?>'>
                    </h2>
                  </td>
                  <td>
                    <p style='text-align:right;'><input type='text' value='<?php
                      $str2 = str_replace('<br>', '',$row[$type=="Set"?"Definition":"C1"]);
                      if (preg_match("/<img[^>]+src\s*=\s*['\"]([^'\"]+)['\"][^>]*>/i", $str2, $matches)) {
                          $imgTag = $matches[0];
                          $url = $matches[1];
                          $str2 = str_replace($imgTag, "", $str2);
                          $str2 .= $url;
                      }
                      echo $str2; ?>' class='defs <?php if($type=="Quiz"){ ?>c1<?php } ?>'></p>
                  </td>

                  <?php if($type == "Quiz") { ?>
                    <td>
                      <p style='text-align:right;'><input type='text' value='<?php
                        $str2 = str_replace('<br>', '',$row["Ic1"]);
                        if (preg_match("/<img[^>]+src\s*=\s*['\"]([^'\"]+)['\"][^>]*>/i", $str2, $matches)) {
                            $imgTag = $matches[0];
                            $url = $matches[1];
                            $str2 = str_replace($imgTag, "", $str2);
                            $str2 .= $url;
                        }
                        echo $str2; ?>' class='defs <?php if($type=="Quiz"){ ?>ic1<?php } ?>'></p>
                    </td>
                    <td>
                      <p style='text-align:right;'><input type='text' value='<?php
                        $str2 = str_replace('<br>', '',$row["Ic2"]);
                        if (preg_match("/<img[^>]+src\s*=\s*['\"]([^'\"]+)['\"][^>]*>/i", $str2, $matches)) {
                            $imgTag = $matches[0];
                            $url = $matches[1];
                            $str2 = str_replace($imgTag, "", $str2);
                            $str2 .= $url;
                        }
                        echo $str2; ?>' class='defs <?php if($type=="Quiz"){ ?>ic2<?php } ?>'></p>
                    </td>
                    <td>
                      <p style='text-align:right;'><input type='text' value='<?php
                        $str2 = str_replace('<br>', '',$row["Ic3"]);
                        if (preg_match("/<img[^>]+src\s*=\s*['\"]([^'\"]+)['\"][^>]*>/i", $str2, $matches)) {
                            $imgTag = $matches[0];
                            $url = $matches[1];
                            $str2 = str_replace($imgTag, "", $str2);
                            $str2 .= $url;
                        }
                        echo $str2; ?>' class='defs <?php if($type=="Quiz"){ ?>ic3<?php } ?>'></p>
                    </td>
                  <?php } ?>
                  <td>
                    <button class='delete-btn' onclick="$(`#box-<?php echo $i; ?>`).html(``)"><i class="fa-solid fa-trash-can"></i></button>
                  </td>
                </tr>
              </table>
            </div>
          </div>
        <?php } ?>
      <?php } else { ?>
        <div id='box-1'>
          <div class='item-card'>
            <table>
              <tr>
                <td>
                  <h2><input type='text' class='terms'></h2>
                </td>
                <td>
                  <p style='text-align:right;'><input type='text' class='defs'></p>
                </td>
                <td>
                  <button class='delete-btn' onclick="$('#box-1').html('');"><i class="fa-solid fa-trash-can"></i></button>
                </td>
              </tr>
            </table>
          </div>
        </div>
        <?php $i = 1; ?>
      <?php } ?>
    </div>

    <p>
      <button id='title-button-blue-bottom' onclick="saveChanges()">Save Changes&nbsp;&nbsp;<i class="fa-solid fa-floppy-disk"></i></button>
      <?php mobileBR(); ?>

      <button class='title-button-white' onclick="addTerm()">Add Term&nbsp;&nbsp;<i class="fa-solid fa-plus"></i></button>
      <?php mobileBR(); ?>
    </p>

    <script>var i = <?php echo $i; ?>; </script>
    
    <div id="math" class="modal">
      <h2>Using Math in Quizza</h2>
      <p style='line-height:1.2;'>
        Enclose LaTeX equations in backslashed parentheses <span>\</span><span>(</span> x^2 <span>\</span><span>)</span>. 
        View a LaTeX cheat sheet <a href='https://www.quizza.org/static/files/LaTeX.pdf' target="_blank">here</a>.
        <hr>
        For example, the equation <span>\</span><span>(</span> f(x)=\frac{\sin(x^2)}{2} <span>\</span><span>)</span> renders as $$$$f(x)=\frac{\sin(x^2)}{2}$$$$
      </p>
    </div>

    <div id='image' class='modal'>
      <h2>Image Upload</h2>
      <form action="" method="post" enctype="multipart/form-data">
        <table id='imgmodal-table'>
          <tr>
            <td>
              <input type="file" name="file" id='fileUploader' style='display:flex;float:left;'>
            </td>
            <td>
              <button id='uploadBtn' onclick='uploadBtnClick()' class='image-upload-btn'>Upload</button>
            </td>
          </tr>
        </table>
        <div id='imgmodal-spacer'>&nbsp;</div>
        <input type='text' id='resultURL'>
        <p id='info'></p>
      </form>
    </div>
  <?php require("/var/www/html/docs/lib/footer.php"); ?>

  <script>$(".tooltips").mouseenter(function(){$(this).find('span').empty().append($(this).attr('tooltip'));});</script>

</body>

</html>
