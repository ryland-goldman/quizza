<?php
require "/var/www/html/docs/lib/login-endpoint/header.php";
$sql_db_password =  trim(file_get_contents("/var/www/sql.privkey"));
$school = 			array_shift((explode('.', $_SERVER['HTTP_HOST'])));
try { $admin = 			new mysqli("localhost", "quizza", $sql_db_password, "Admin".$school); }
catch (Exception $e) { require("/var/www/html/404.php"); }
$schooldb = 		new mysqli("localhost","quizza", $sql_db_password, "Schools");
$school_shortname = $schooldb->query("SELECT * FROM main WHERE id=\"$school\"")->fetch_assoc()["shortname"];

function isMobileDevice() { return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]); }
function mobileBR() { if(isMobileDevice()) { echo "<br><br>"; } }

// Define current class, if exists in request
if(isset($_GET["class"]))		{ $classID = $admin->real_escape_string(filter_var($_GET["class"],FILTER_SANITIZE_STRING));  }
else if(isset($_POST["class"]))	{ $classID = $admin->real_escape_string(filter_var($_POST["class"],FILTER_SANITIZE_STRING)); }

// Get set information
if(isset($classID)){
	try { $thisClass = new mysqli("localhost","quizza",$sql_db_password,$school.$classID); }
	catch (Exception $e) { require("/var/www/html/404.php"); }

	$class_shortname = 	$admin->query("SELECT * FROM Classes WHERE ID='$classID'")->fetch_assoc()["ShortName"];
	$class_longname = 	$admin->query("SELECT * FROM Classes WHERE ID='$classID'")->fetch_assoc()["LongName"];
	$class_icon = 		"<i class='".$admin->query("SELECT * FROM Classes WHERE ID=\"$classID\"")->fetch_assoc()["Icon"]."'></i>";
}


// Define current set, if exists in request
if(isset($_GET["set"])){ $setID = $admin->real_escape_string(filter_var($_GET["set"],FILTER_SANITIZE_STRING)); }
else if(isset($_POST["set"])){ $setID = $admin->real_escape_string(filter_var($_POST["set"],FILTER_SANITIZE_STRING)); }

// Leave if adding new set
if($setID == "addSet"){ require("/var/www/html/docs/addSet.php"); die(); }

// Get set information
if(isset($setID)) {
	try { $type = $admin->query("SELECT * FROM ".$classID."Sets WHERE ID=\"$setID\"")->fetch_assoc()["Type"]; }
	catch (Exception $e) { require("/var/www/html/404.php"); }

	$creator = 			$admin->query("SELECT * FROM ".$classID."Sets WHERE ID=\"$setID\"")->fetch_assoc()["Creator"];
	$setName = 			$admin->query("SELECT * FROM ".$classID."Sets WHERE ID=\"$setID\"")->fetch_assoc()["Name"];

	$type = $admin->real_escape_string(filter_var($type,FILTER_SANITIZE_STRING));
	$creator = $admin->real_escape_string(filter_var($creator,FILTER_SANITIZE_STRING));
	$setName = $admin->real_escape_string(filter_var($setName,FILTER_SANITIZE_STRING));

	$editable = $loggedIn;
	if($loggedIn){
		// Check for edit permissions. When $creator is blank, it is a public set.
		if($email !== $creator && $creator !== ""){ $editable = false; }
	}

    $empty_set = $thisClass->query("SELECT * FROM ".$type.$setID)->num_rows == 0;
}

// Add to access log
require("/var/www/html/docs/lib/accessLogAppend.php");
?>