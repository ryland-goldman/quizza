<?php
$req_permission = 1;
require("/var/www/html/docs/lib/header.php");
$main_column = $_GET["col"]; // Prompt with secondary_column, respond with main_column
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

	<?php if($_GET['option'] == 'mc'){ 
		$n = 0; 
		$terms = $thisClass->query("SELECT * FROM ".$type.$setID); 
		if($terms->num_rows > 0){ ?>
			<table id='mc'>
				<?php if($type=="Quiz" && $main_column == "C1") { 
					while($term = $terms->fetch_assoc() ){ 
						$answers = [$term["C1"], $term["Ic1"], $term["Ic2"], $term["Ic3"]];
						shuffle($answers);
						$n++;
						?>
						<tr>
							<td class='term'><?php echo $n.". ".$term["Question"]; ?></td>
							<td class='pad'>
								<ol type='A'>
									<li><?php echo $answers[0]; ?></li>
									<li><?php echo $answers[1]; ?></li>
									<li><?php echo $answers[2]; ?></li>
									<li><?php echo $answers[3]; ?></li>
								</ol>
							</td>
						</tr>
						<tr class='sep'><td>&nbsp;</td></tr>
			<?php } } else { 
				$questions_tmp = array();
				$answers_tmp = array();
				while($term = $terms->fetch_assoc() ){ 
					array_push($questions_tmp, $term[$secondary_column]);
					array_push($answers_tmp, $term[$main_column]);
				}

				$shuffledKeys = array_keys($questions_tmp);
				shuffle($shuffledKeys);

				$questions = $questions_tmp;
				$answers = $answers_tmp;
				foreach($shuffledKeys as $key){
					$questions[$key] = $questions_tmp[$key];
					$answers[$key] = $answers_tmp[$key];
				}

				$answers_2 = $answers;
				$answers_3 = $answers;
				$answers_4 = $answers;

				shuffle($answers2);
				shuffle($answers3);
				shuffle($answers4);

				for($i=0;$i<len($questions);$i++){
					$answers_0 = [$answers[$i],$answers2[$i],$answers3[$i],$answers4[$i]];
					shuffle($answers_0);
					?>
					<tr>
						<td class='term'><?php echo $i.". ".$questions[$i]; ?></td>
						<td class='pad'>
							<ol type='A'>
								<li><?php echo $answers_0[0]; ?></li>
								<li><?php echo $answers_0[1]; ?></li>
								<li><?php echo $answers_0[2]; ?></li>
								<li><?php echo $answers_0[3]; ?></li>
							</ol>
						</td>
					</tr>
					<tr class='sep'><td>&nbsp;</td></tr>
			<?php } } ?>
		</table>
	<?php } } ?>

	<?php if($_GET['option'] == 'wb'){ ?>
		<div id='wb'>
			<strong>Word Bank</strong><br>
			<?php
			$terms = $thisClass->query("SELECT * FROM ".$type.$setID);
			if($terms->num_rows > 0){
				while($term = $terms->fetch_assoc()){
					?>
					<span><?php echo $term[$main_column]; ?></span>
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
					<div class='term'><?php echo $n.". ".$term[$secondary_column]; ?></div>
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
						<td class='term'><?php echo $term[$secondary_column]; ?></td>
				    	<td class='def'><?php echo $term[$main_column]; ?></td>
					</tr>
			<?php }  }  ?>
		</table>
	<?php } ?>
</body>
</html>