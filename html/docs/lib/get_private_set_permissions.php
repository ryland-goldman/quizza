<?php
$classID = "private";
$req_permission = 3;
try { require("/var/www/html/docs/lib/header.php"); }
catch (Exception $e){ }
if(!$private_set){ header("HTTP 400 Bad Request"); die(); }
echo "<ul>";
$isfirst = true;
$i = 0;
foreach (json_decode($allowed) as $allowed_email => $allowed_permission) {
	if($allowed_email === $email || $allowed_permission == 0){continue;}
	echo "<li>".$allowed_email." - ".($allowed_permission == 1 ? "View only" : "View and edit")." - <a href='javascript:remove($i, $setID)'>Remove</a></li>";
	$i++;
}
echo "</ul>";
?>
