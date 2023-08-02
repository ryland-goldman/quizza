<?php function isMobileDevice() { return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]); } ?>
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
      </tr>
    </table>
  </div>

  <!-- Match the height of the above bar -->
  <div><table><tr><td style='padding:13px 20px 5px;'><h1>&nbsp;</h1></td></tr></table></div>

	<div id='homepage-bgimage-1'>&nbsp;</div>
	<?php if(!isMobileDevice()){ ?>
		<div id='sep'>
			<table>
				<tr>
					<td><h1>Choose your school</h1></td>
					<td>
				    	<div class="dropdown">
				        	<div class="select">
				        		<span>Select School</span>
				        		<i class="fa-solid fa-chevron-down"></i>
				        	</div>
				        	<input type="hidden" name="school">
					        <ul class="dropdown-menu">
					        	<li id="lghs">Los Gatos High School</li>
					        	<li id="rjf">R.J. Fisher Middle School</li>
					        	<li id="shs">Saratoga High School</li>
					        	<li id="ucla">University of California, Los Angeles</li>
					        </ul>
				      	</div>
					</td>
				</tr>
			</table>
		</div>
	<? } else { ?>
		<div id='sep'>
			<h1>Choose your school</h1>
			<br>
			<div class="dropdown">
		     	<div class="select">
			        <span>Select School</span>
			       	<i class="fa-solid fa-chevron-down"></i>
			    </div>
			   	<input type="hidden" name="school">
			    <ul class="dropdown-menu">
		        	<li id="lghs">Los Gatos High School</li>
		        	<li id="rjf">R.J. Fisher Middle School</li>
		        	<li id="shs">Saratoga High School</li>
		        	<li id="ucla">University of California, Los Angeles</li>
		        </ul>
	      	</div>
		</div>
	<?php } ?>
	<img src='https://www.quizza.org/static/images/main-2.webp' style='width:100vw;'>
</body>
</head>
