<?php
if(!isset($ignoreLog)) {
	$apikey = $_GET["key"];
	if($apikey !== trim(file_get_contents("/var/www/logs.privkey"))) { die("Invalid Key"); }
	$sql_db_password =  trim(file_get_contents("/var/www/sql.privkey"));
	$admin = new mysqli("localhost", "quizza", $sql_db_password, "Admin".$_GET["school"]);
	$school = $admin->real_escape_string(filter_var($_GET["school"],FILTER_SANITIZE_STRING));
	$class = $admin->real_escape_string(filter_var($_GET["class"],FILTER_SANITIZE_STRING));
	$data = $admin->query("SELECT * FROM ".$class."Sets");
	if($data->num_rows > 0){
		$data_str = "";
		while($row = $data->fetch_assoc()){
			$type = $row["Type"];
			$secondary_query = $admin->query("SELECT * FROM ".$school.$class.".".$type.$row["ID"]);
			$data_str .= "{\"name\":\"".$row["Name"]."\",\"id\":\"".$row["ID"]."\",\"count\":".$secondary_query->num_rows.",\"type\":\"$type\"},";
		}
		echo "[";
		echo substr($data_str, 0, strlen($data_str)-1);
		echo "]";
	}
}
?>