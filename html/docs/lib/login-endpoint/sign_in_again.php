<?php require("/var/www/html/docs/lib/header.php"); ?>
<!DOCTYPE html>
<html>

<head>

	<title>Quizza | Sign In</title>
	<?php require("/var/www/html/docs/lib/imports.php"); ?>
	<?php if($loggedIn==true){ echo "<script>window.opener.postMessage('save');window.close();</script>"; } ?>
	<meta name="robots" content="noindex" />

</head>

<body id='body-404'>
	<div id='outside-404'>
		<div id='inside-404'>
		  <h2>Sign In</h2>
		  <?php if($loggedIn !== true){ ?>
		  	<p>Please sign back in in order to save your study materials.</p>
			<div id='buttonDiv'></div>
		  <?php } else { ?>
		    <p>Hmmm. It looks like you are already signed in.</p>
		  <?php } ?>
		</div>
	</div>
</body>

</html>