<?php header("HTTP 403 Forbidden"); ?>
<!DOCTYPE html>
<html>

<head>

	<title>Quizza | 403</title>
	<?php require("/var/www/html/docs/lib/imports.php"); ?>

</head>

<body id='body-404'>
	<div id='outside-404'>
		<div id='inside-404'>
		  <h1 id='title-404'>403</h1>
		  <h2>Access Forbidden</h2>
		  <p>You may be signed out, or signed into an account without access to this page.</p>
			<a href='https://www.quizza.org/'>
				<button id='button-404'>Home</button>
			</a>
		</div>
	</div>
</body>

</html>
<?php die(""); ?>