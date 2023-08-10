<?php
header('Access-Control-Allow-Origin: *');
require("/var/www/html/docs/lib/header.php");
if($loggedIn == false){ die("You are not logged in."); }
$base64 = explode(',',$_POST['file'])[1];
if($_POST['extension']!==".jpg" && $_POST['extension']!==".gif" && $_POST['extension']!==".png"){ die(""); }

date_default_timezone_set("America/Los_Angeles");
$content = hash("fnv1a64",$base64).$_POST['extension'];
$action = "image-upload";
$edittime = date("d M Y (h:i A T)");
$admin->query("LOCK TABLES EditLog write");
$admin->query("INSERT INTO EditLog VALUES ('$email','$content','--','$action','$edittime')");
$admin->query("UNLOCK TABLES");

$imageData = base64_decode($base64);
$filePath = "/var/www/html/static/images/user-media/".hash("fnv1a64",$base64).$_POST['extension'];
$file = fopen($filePath, 'wb');
fwrite($file, $imageData);
fclose($file);
echo "https://www.quizza.org/static/images/user-media/".hash("fnv1a64",$base64).$_POST['extension'];
?>