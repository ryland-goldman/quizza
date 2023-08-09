<?php header("HTTP 400 Bad Request"); ?>
<!DOCTYPE html>
<html>

<head>

	<title>Quizza | 400</title>
	<meta name="robots" content="noindex" />
	<?php require("/var/www/html/docs/lib/imports.php"); ?>

</head>

<body id='body-404'>
	<div id='outside-404'>
		<div id='inside-404'>
		  <h1 id='title-404'>400</h1>
		  <h2>Bad Request</h2>
		  <p>Your browser made an invalid request.</p>
			<a href='https://www.quizza.org/'>
				<button id='button-404'>Home</button>
			</a>
		</div>
	</div>
</body>

</html>
<?php die(""); ?>