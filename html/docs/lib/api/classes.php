<?php
if(!isset($ignoreLog)) {
	$apikey = $_GET["key"];
	if($apikey !== trim(file_get_contents("/var/www/logs.privkey"))) { die("Invalid Key"); }
	$sql_db_password =  trim(file_get_contents("/var/www/sql.privkey"));
	$admin = new mysqli("localhost", "quizza", $sql_db_password, "Admin".$_GET["school"]);
	$subject = $admin->real_escape_string(filter_var($_GET["subject"],FILTER_SANITIZE_STRING));
	$data = $admin->query("SELECT * FROM Classes WHERE Subject=".$subject);
	if($data->num_rows > 0){
		$data_str = "";
		while($row = $data->fetch_assoc()){
			$data_str .= "{\"name\":\"".$row["ShortName"]."\",\"shortName\":\"".$row["ID"]."\"},";
		}
		echo "[";
		echo substr($data_str, 0, strlen($data_str)-1);
		echo "]";
	}
}
?>