<?php
$classID = "private";
$req_permission = 3;
require("/var/www/html/docs/lib/header.php");
if(!$private_set){ header("HTTP 400 Bad Request"); die(); }
$allowed_obj = json_decode($allowed,true);
if(!isset($_GET["email"]) || !isset($_GET["edit_permission"])){ header("HTTP 400 Bad Request"); die(); }
$allowed_obj[$_GET["email"]] = ($_GET["edit_permission"]=="true") ? 2 : 1;
$encoded = base64_encode(json_encode($allowed_obj));
$admin->query("UPDATE privateSets SET Shared=\"".$encoded."\" WHERE ID=\"".$setID."\"");
$to_email = $_GET["email"];
$from_name = $name;
$setname = $setName;
require("/var/www/html/docs/lib/email-endpoint/index.php");
echo "success";
?>
