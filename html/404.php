<?php header("HTTP 404 Not Found"); ?>
<!DOCTYPE html>
<html>

<head>

	<title>Quizza | 404</title>
	<?php require("/var/www/html/docs/lib/imports.php"); ?>
	<meta name="robots" content="noindex" />

</head>

<body id='body-404'>
	<div id='outside-404'>
		<div id='inside-404'>
		  <h1 id='title-404'>404</h1>
		  <h2>File not found</h2>
		  <p>Check to make sure you have the correct URL.</p>
			<a href='https://www.quizza.org/'>
				<button id='button-404'>Home</button>
			</a>
		</div>
	</div>
</body>

</html>
<?php die(""); ?>