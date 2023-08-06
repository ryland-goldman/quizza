<?php function isMobileDevice() { return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]); } ?>
<?php require("/var/www/html/docs/lib/accessLogAppend.php"); ?>
<?php require("/var/www/html/docs/lib/login-endpoint/header.php"); ?>
<!DOCTYPE html>
<html>
<head>
	<title>Quizza</title>
	<?php require("/var/www/html/docs/lib/imports.php"); ?>
	<link rel='stylesheet' href='https://www.quizza.org/static/stylesheets/homepage.css'>
	<script src='https://www.quizza.org/static/scripts/homepage.js' defer></script>
</head>
<body>

  <div id='top-bar'>
    <table id='top-bar-table'>
      <tr>
        <td id='top-bar-table-logo'>
          <a href='/'>
            <h1><img style='height:1em;' id='logo'></h1>
          </a>
        </td>
        <?php if (!isMobileDevice() && !$loggedIn) { ?><td>&nbsp;</td>
	        <td id="top-bar-upper-icon">
	          <table style='float:right;'>
	            <tr>
	              <td>&nbsp;</td>
	              <td><div id="buttonDiv"></div></td>
	            </tr>
	          </table>
	        </td>
	      <?php } ?>
      </tr>
    </table>
  </div>

  <!-- Match the height of the above bar -->
  <div><table><tr><td style='padding:13px 20px 5px;'><h1>&nbsp;</h1></td></tr></table></div>

	<div id='homepage-bgimage-1'>&nbsp;</div>
		<div id='sep'>
			<table>
				<tr>
					<td><h1>Choose your school</h1></td>
					<td>
						<div class='select'>
					    <select>
					      <option value="www" selected>Select a School</option>
					      <option value="private">Private Sets (No School Needed)</option>
					      <?php $schooldb = new mysqli("localhost","quizza", trim(file_get_contents("/var/www/sql.privkey")), "Schools");
					      $schools = $schooldb->query("SELECT * FROM main ORDER BY longname ASC;");
				        while($curr_school = $schools->fetch_assoc()){ 
				          if($curr_school["shortname"] !== $school_shortname){ ?>
				            <option value="<?php echo $curr_school["id"]; ?>"><?php echo $curr_school["longname"]; ?></option>
				        <?php } } ?>
					    </select>
							<div class="select-after">
								<i class="fa-solid fa-caret-down"></i>&nbsp;
							</div>
					  </div>
					</td>
				</tr>
			</table>
		</div>
	<img src='https://www.quizza.org/static/images/<?php if(isMobileDevice()){ ?>mobile<?php } else { ?>main<?php } ?>-2.png' style='width:100vw;'>
	<?php $bmac = false; require("/var/www/html/docs/lib/footer.php"); ?>

	<?php if(!$loggedIn && !isMobileDevice()){ ?><script>$(document).ready(function(){render_gSignIn();});</script><?php } ?>
</body>
</head>
