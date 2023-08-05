<?php
$classID = "private";
$req_permission = 3;
require("/var/www/html/docs/lib/header.php");
if(!$private_set){ header("HTTP 400 Bad Request"); die(); }
echo "<ul>";
$isfirst = true;
$i = 0;
$allowed_obj = json_decode($allowed,true);
foreach (json_decode($allowed) as $allowed_email => $allowed_permission) {
	if($allowed_email === $email || $allowed_permission == 0){continue;}
	if($i == parseInt($_GET["user"])){
		$allowed_obj[$allowed_email] = 0;
	}
	$i++;
}

$encoded = base64_encode(json_encode($allowed_obj));
$admin->query("UPDATE privateSets SET Shared=\"".$encoded."\" WHERE ID=\"".$setID."\"");

require("/var/www/html/docs/lib/get_private_set_permissions.php");
?>
