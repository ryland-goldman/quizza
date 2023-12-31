<?php require("/var/www/html/docs/lib/header.php"); ?>
<?php if(!isset($_GET["class"])) { require("/var/www/html/400.php");} ?>
<?php if(!$loggedIn) { require("/var/www/html/403.php"); } ?>
<!DOCTYPE html>
<html>
<head>
	<title>Upload Set | Quizza</title>
	<?php require("/var/www/html/docs/lib/imports.php"); ?>
	<script async>var classID = "<?php echo $classID;?>";</script>
	<script src='https://www.quizza.org/static/scripts/upload.js' defer async></script>
	<link href="https://fonts.googleapis.com/css2?family=Inconsolata&display=swap" rel="stylesheet">
	<style>textarea{font-family:"Inconsolata",monospace,sans-serif;}</style>
	<meta name="robots" content="noindex" />
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
	            <?php echo $class_icon; ?>&nbsp;&nbsp;
	            <?php echo isMobileDevice() ? $class_shortname : $class_longname; ?>
	          </h1>
	        </td>
	      </tr>
	    </table>

		<p>
		   <button onclick="uploadSet('&private=Create Public Set')" id='title-button-blue'>Upload <?php if(!$private_set) { ?> (Public)&nbsp;&nbsp;<i class="fa-solid fa-lock-open"></i><?php } else { ?> (Private)&nbsp;&nbsp;<i class="fa-solid fa-lock"></i><?php } ?></button>
      	   <?php if(!$private_set) { ?><button onclick="uploadSet('&private=Create Protected Set')" class='title-button-white'>Upload (Protected) <i class="fa-solid fa-lock"></i></button><?php } ?>
	       
	       <a href='#csv-upload' rel='modal:open'>
	       	<button class='title-button-white'>From File&nbsp;&nbsp;<i class="fa-solid fa-file-import"></i></button>
	       </a>

	       <a>
	       	<button class='title-button-white' onclick="window.open('https://docs.google.com/document/d/1samqfZMICdEw0wR8lvPAQK99_NRim7suAjRhuz-SXLE/edit');">Help&nbsp;&nbsp;<i class="fa-solid fa-circle-info"></i></button>
	       </a>
	  	</p>

	  	<br><br>

	  	<p><strong>Set Title</strong></p>
	  	<input type='text' id='set-title' />

	  	<br><br>
	  	
	  	<p><strong>Enter comma-separated values</strong></p>
	  	<textarea id='set-content'></textarea>

	  	<br><br>

	</div>

  	<p>

  	<div class='modal' id='csv-upload'>
		<p><strong>Upload a CSV</strong></p>
    	<input id="file-to-read" type="file" accept=".csv" /><br>
    	<span id='uploadingg' style='display:none;'><br>No file uploaded. Please try again<br></span>
      	<span id='nofileuploaded' style='color:red;display:none;'><br>No file uploaded. Please try again<br></span>
      	<input type="button" onclick="readFileAsText()" class='uploadBtn uploadBtn-first' value='Upload File'>
    </div>


	<?php require("/var/www/html/docs/lib/footer.php"); ?>
</body>
