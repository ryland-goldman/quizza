<?php
$classID = "private";
$req_permission = 1;
if(!isset($loggedIn)){
	require("/var/www/html/docs/lib/header.php");
	$allowed = json_decode($allowed);
} else {
	$allowed = $allowed_obj;
}
if(!$private_set){ header("HTTP 400 Bad Request"); die(); }
if($permission == 3){
	echo "<ul>";
	$isfirst = true;
	$i = 0;
	foreach ($allowed as $allowed_email => $allowed_permission) {
		if($allowed_email === $email || $allowed_permission == 0){continue;}
		echo "<li>".$allowed_email." - ".($allowed_permission == 1 ? "View only" : "View and edit")." - <a href='javascript:remove($i, $setID)' style='text-decoration:underline!important;'>Remove</a></li>";
		$i++;
	}
	echo "</ul>";
} else {
	foreach ($allowed as $allowed_email => $allowed_permission) {
		if($allowed_permission == 3){ 
			echo "This set was shared with you by ".$allowed_email.".<br>You have <strong>".($permission == 1 ? "view only" : "view and edit")."</strong> access.";
			break;
		}
	}
}
?>
