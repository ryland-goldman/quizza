<?php
if($_GET["js_upload"]=="true"){ require("/var/www/html/docs/lib/header.php"); }
if($loggedIn == false){ require("/var/www/html/403.php"); }

date_default_timezone_set("America/Los_Angeles");
$lastModified = date("d M Y (h:i A T)")." by ".$name;

$admin->query("LOCK TABLES ".$classID."Sets write");
$admin->query("ALTER TABLE ".$classID."Sets MODIFY ID INTEGER;");
$setID = intval($admin->query("SELECT MAX(ID) FROM ".$classID."Sets")->fetch_assoc()["MAX(ID)"])+1;

$thisClass->query("CREATE TABLE Set".$setID." (Term text, Definition text)");
$title = $admin->real_escape_string(filter_var($_GET["title"],FILTER_SANITIZE_STRING));

$admin->query("LOCK TABLES Set".$setID." write");

if($private_set){
    $shared = base64_encode(json_encode(array("$email" => 3)));
    $admin->query("INSERT INTO privateSets VALUES(\"$title\", \"$lastModified\", \"$setID\", \"Set\", \"$shared\")");
} else {
    if(urldecode($_GET["private"]) !== "Create Protected Set") { $email = ""; }
    $admin->query("INSERT INTO ".$classID."Sets VALUES(\"$title\", \"$lastModified\", \"$setID\", \"$email\", \"Set\")");
}

$admin->query("UNLOCK TABLES");

if($_GET['giveId']=="true"){ echo $setID; } else { echo "<script>location.href='/".$classID."/".$setID."';</script>"; }
 ?>
