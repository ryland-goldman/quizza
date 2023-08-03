<?php
$log_access_key = $_GET["key"];
if($log_access_key !== trim(file_get_contents("/var/www/logs.privkey"))) { die("Invalid Key"); }
$sql_db_password =  trim(file_get_contents("/var/www/sql.privkey"));
$admin = new mysqli("localhost", "quizza", $sql_db_password, "AccessLog");
$logData = $admin->query("SELECT * FROM AccessLog");
if($logData->num_rows > 0){
	while($row = $logData->fetch_assoc()){
		echo $row["timestamp"].",".$row["school"].",".$row["class"].",".$row["setn"].",".$row["section"].",".$row["user"].",".$row["ref"]."\n";
	}
}
?>