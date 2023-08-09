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
	       <a href='#csv-upload' rel='modal:open'>
	       	<button id='title-button-blue'>From File&nbsp;&nbsp;<i class="fa-solid fa-file-import"></i></button>
	       </a>

	       <a href='https://www.youtube.com/watch?v=dQw4w9WgXcQ' target="_blank">
	       	<button class='title-button-white'>Help&nbsp;&nbsp;<i class="fa-solid fa-circle-info"></i></button>
	       </a>
	  	</p>

	  	<br><br>

	  	<p><strong>Set Title</strong></p>
	  	<input type='text' id='set-title' />

	  	<br><br>
	  	
	  	<p><strong>Enter comma-seperated values</strong></p>
	  	<textarea id='set-content'></textarea>

	  	<br><br>

      	<input type="button" onclick="uploadSet('&private=Create Public Set')" class='uploadBtn uploadBtn-first' value='Create<?php if(!$private_set) { ?> Public<?php } else { ?> Private<?php } ?> Set'>
      	<?php if(!$private_set) { ?><input type="button" onclick="uploadSet('&private=Create Protected Set')" class='uploadBtn' value='Create Protected Set'><?php } ?>

	</div>

  	<p>

  	<div class='modal' id='csv-upload'>
		<p><strong>Upload a CSV</strong></p>
    	<input id="file-to-read" type="file" accept=".csv" /><br>
    	<span id='uploadingg' style='display:none;'><br>No file uploaded. Please try again<br></span>
      	<span id='nofileuploaded' style='color:red;display:none;'><br>No file uploaded. Please try again<br></span>
      	<input type="button" onclick="readFileAsText()" class='uploadBtn uploadBtn-first' value='Upload File'>
    </div>

    <div class='modal' id='help'>
    	<p><strong>Help Uploading</strong></p>
    </div>

	<?php require("/var/www/html/docs/lib/footer.php"); ?>
</body>