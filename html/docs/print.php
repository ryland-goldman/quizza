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
	<?php if(isset($mathjax)) { ?><script defer id="MathJax-script" src="https://cdn.jsdelivr.net/npm/mathjax@3.0.1/es5/tex-mml-chtml.js"></script><script defer>MathJax.startup.promise.then(() => {window.print();});</script><?php } else {?><script defer>window.print();</script><?php } ?>
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
		?><table class='mc'><?php
		$n = 0; 
		$terms = $thisClass->query("SELECT * FROM ".$type.$setID." ORDER BY RAND()"); 
		if($terms->num_rows > 0){
				if($type=="Quiz" && $main_column == "C1") { 
					while($term = $terms->fetch_assoc() ){ 
						$answers = [$term["C1"], $term["Ic1"], $term["Ic2"], $term["Ic3"]];
						shuffle($answers);
						$n++;
						?>
							<tr class='pb'>
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
				$questions = array();
				$answers = array();
				while($term = $terms->fetch_assoc() ){ 
					array_push($questions, $term[$secondary_column]);
					array_push($answers, $term[$main_column]);
				}

				for($i=0;$i<100;$i++){
					$answers2 = $answers;
					$answers3 = $answers;
					$answers4 = $answers;

					shuffle($answers2);
					shuffle($answers3);
					shuffle($answers4);

					$ok = true;
					for($j=0;$j<count($answers);$j++){
						if($answers[$j] == $answers2[$j] ||$answers[$j] == $answers3[$j] || $answers[$j] == $answers4[$j] || $answers2[$j] == $answers3[$j] || $answers2[$j] == $answers4[$j] || $answers3[$j] == $answers4[$j]){ $ok = false; }
					}

					if($ok) { break; }
				}

				for($i=0;$i<count($questions);$i++){
					$answers_0 = [$answers[$i],$answers2[$i],$answers3[$i],$answers4[$i]];
					shuffle($answers_0);
					?>
						<tr class='pb'>
							<td class='term'><?php echo ($i+1).". ".$questions[$i]; ?></td>
							<td class='pad'></td>
							<td class='def'>
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
		<?php } ?>
	</table><?php } ?>

	<?php if($_GET['option'] == 'wb'){ ?>
		<div class='wb'>
			<strong>Word Bank</strong><br>
			<?php
			$terms = $thisClass->query("SELECT * FROM ".$type.$setID." ORDER BY RAND()");
			if($terms->num_rows > 0){
				while($term = $terms->fetch_assoc()){
					?>
					<span><?php echo $term[$main_column]; ?></span>
			<?php } } ?>
		</div>
	<?php } ?>

	<?php if($_GET['option'] == 'fr' || $_GET['option'] == 'wb'){
		$terms = $thisClass->query("SELECT * FROM ".$type.$setID." ORDER BY RAND()");
		if($terms->num_rows > 0){
			$n = 1;
			while($term = $terms->fetch_assoc()){ 
				$n++; ?>
				<div class='fr pb'>
					<div class='term'><?php echo $n.". ".$term[$secondary_column]; ?></div>
			    	<div class='pad'>&nbsp;</div>
			    	<div class='def'>&nbsp;</div>
				</div>
				<div class='sep'>&nbsp;</div>
	<?php } } } ?>

	<?php if($_GET['option'] == 'tc'){ ?>
		<table class='two-column'>
			<?php $terms = $thisClass->query("SELECT * FROM ".$type.$setID." ORDER BY RAND()");
			if($terms->num_rows > 0){
				while($term = $terms->fetch_assoc()){ ?>
						<tr class='pb'>
							<td class='term'><?php echo $term[$secondary_column]; ?></td>
					    	<td class='def'><?php echo $term[$main_column]; ?></td>
						</tr>
			<?php }  }  ?>
		</table>
	<?php } ?>
</body>
</html>