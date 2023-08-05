<?php
$classID = "private";
$req_permission = 3;
require("/var/www/html/docs/lib/header.php");
if(!$private_set){ header("HTTP 400 Bad Request"); die(); }
echo $allowed;
$allowed_obj = json_decode($allowed,true);
echo json_encode($allowed_obj);
?>
