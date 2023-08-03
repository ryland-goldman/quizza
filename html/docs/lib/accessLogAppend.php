<?php
$sql_db_password =  trim(file_get_contents("/var/www/sql.privkey"));
$admin1 = new mysqli("localhost", "quizza", $sql_db_password, "AccessLog");
$timestamp = time();
$school1 = "";
$class1 = "";
$set1 = "";
$section1 = "";
$user1 = "";
$ref1 = "";
if(isset($school)) { $school1 = $admin1->real_escape_string(filter_var($school,FILTER_SANITIZE_STRING)); }
if(isset($classID)){ $class1 = $admin1->real_escape_string(filter_var($classID,FILTER_SANITIZE_STRING)); }
if(isset($setID)){ $class1 = $admin1->real_escape_string(filter_var($setID,FILTER_SANITIZE_STRING)); }
if(isset($setID)){ $section1 = basename($_SERVER['PHP_SELF']); }
if(isset($email)){ $user1 = $admin1->real_escape_string(filter_var($email,FILTER_SANITIZE_STRING)); }
if(isset($_GET["ref"])){ $ref1 = $_GET["ref"]; }
$admin->query("INSERT INTO AccessLog VALUES (\"$timestamp\",\"$school1\",\"$class1\",\"$set1\",\"$section1\",\"$user1\",\"$ref1\"");
addToLog();
?>