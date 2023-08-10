<?php
$req_permission = 1;
require("/var/www/html/docs/lib/header.php");
$main_column = $_GET["col"]; // Prompt with main_column, respond with secondary_column
if($type == "Set"){ $secondary_column = $main_column=="Term" ? "Definition":"Term"; }
else { $secondary_column = $main_column=="Question" ? "C1":"Question"; }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Print | Quizza</title>
	<meta name="robots" content="noindex">
	<meta charset="utf-8">
	<link rel='stylesheet' href='https://www.quizza.org/static/stylesheets/print.css'>
</head>
<body>
	<div id='name'>
		<div>Name:</div>
	    <div id='name-name'>&nbsp;</div>
	    <div>&nbsp;</div>
	    <div>Period:</div>
	    <div id='name-period'>&nbsp;</div>
	    <div>&nbsp;</div>
	    <div>Date:</div>
	    <div id='name-date'>&nbsp;</div>
	</div>

	<?php if($_GET['option'] == 'mc'){ ?>
		<table id='mc'>
			<tr>
				<td class='term'>1. Question</td>
				<td class='pad'>
					<ol type='A'>
						<li>Answer</li>
						<li>Answer</li>
						<li>Answer</li>
						<li>Answer</li>
					</ol>
				</td>
			</tr>
			<tr class='sep'><td>&nbsp;</td></tr>
		</table>
	<?php } ?>

	<?php if($_GET['option'] == 'wb'){ ?>
		<div id='wb'>
			<strong>Word Bank</strong><br>
			<?php
			$terms = $thisClass->query("SELECT * FROM ".$type.$setID);
			if($terms->num_rows > 0){
				while($term = $terms->fetch_assoc()){
					?>
					<span><?php echo $term[$secondary_column]; ?></span>
			<?php } } ?>
		</div>
	<?php } ?>

	<?php if($_GET['option'] == 'fr' || $_GET['option'] == 'wb'){
		$terms = $thisClass->query("SELECT * FROM ".$type.$setID);
		if($terms->num_rows > 0){
			$n = 1;
			while($term = $terms->fetch_assoc()){ 
				$n++; ?>
				<div class='fr'>
					<div class='term'><?php echo $n.". ".$term[$main_column]; ?></div>
			    	<div class='pad'>&nbsp;</div>
			    	<div class='def'>&nbsp;</div>
				</div>
				<div class='sep'>&nbsp;</div>
	<?php } } } ?>

	<?php if($_GET['option'] == 'tc'){ ?>
		<table id='two-column'>
			<?php $terms = $thisClass->query("SELECT * FROM ".$type.$setID);
			if($terms->num_rows > 0){
				while($term = $terms->fetch_assoc()){ ?>
					<tr>
						<td class='term'><?php echo $term[$main_column]; ?></td>
				    	<td class='def'><?php echo $term[$secondary_column]; ?></td>
					</tr>
			<?php }  }  ?>
		</table>
	<?php } ?>
</body>
</html>