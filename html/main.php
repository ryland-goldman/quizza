<!DOCTYPE html>
<html>
<head>
	<title>Quizza</title>
	<?php require("/var/www/html/docs/lib/imports.php"); ?>
	<link rel='stylesheet' href='https://www.quizza.org/static/stylesheets/homepage.css'>
	<script src='https://www.quizza.org/static/scripts/homepage.js' defer></script>
</head>
<body>
	<img src='https://www.quizza.org/static/images/main-1.webp' style='width:100vw;'>
	<div style='margin-left:10vw;margin-right:10vw;border-radius:36px;background-color:#0fbd9d;color:white;'>
		<table>
			<tr>
				<td><h1>Choose your school</h1></td>
				<td>
			    	<div class="dropdown">
			        	<div class="select">
			        		<span>Select School</span>
			        	</div>
			        	<input type="hidden" name="school">
				        <ul class="dropdown-menu">
				        	<li id="lghs">Los Gatos High School</li>
				        	<li id="lgusd">Los Gatos Union School District</li>
				        	<li id="shs">Saratoga High School</li>
				        	<li id="ucla">University of California, Los Angeles</li>
				        </ul>
			      	</div>
				</td>
			</tr>
		</table>
	</div>
	<img src='https://www.quizza.org/static/images/main-2.webp' style='width:100vw;'>
</body>
</head>
