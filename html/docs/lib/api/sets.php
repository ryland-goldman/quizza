<?php
if(!isset($ignoreLog)) {
	$apikey = $_GET["key"];
	if($apikey !== trim(file_get_contents("/var/www/logs.privkey"))) { die("Invalid Key"); }
	$sql_db_password =  trim(file_get_contents("/var/www/sql.privkey"));
	$admin = new mysqli("localhost", "quizza", $sql_db_password, "Admin".$_GET["school"]);
	$school = $admin->real_escape_string(filter_var($_GET["school"],FILTER_SANITIZE_STRING));
	if($school == "private") { die(); }
	$class = $admin->real_escape_string(filter_var($_GET["class"],FILTER_SANITIZE_STRING));
	$data = $admin->query("SELECT * FROM ".$class."Sets");
	if($data->num_rows > 0){
		$data_str = "";
		while($row = $data->fetch_assoc()){
			$type = $row["Type"];
			$secondary_query = $admin->query("SELECT * FROM ".$school.$class.".".$type.$row["ID"]);
			$terms = "";
			$defs = "";
			if($secondary_query->num_rows > 0){
				while($secondary_row = $secondary_query->fetch_assoc()){
					$terms .= '"'.$secondary_row[$type=="Set"?"Term":"Question"].'",';
					$defs .= '"'.$secondary_row[$type=="Set"?"Definition":"C1"].'",';
				}
				$data_str .= "{\"name\":\"".$row["Name"]."\",\"id\":".$row["ID"].",\"terms\":[".substr($terms, 0, strlen($terms)-1)."],\"defs\":[".substr($defs,0,strlen($defs)-1)."],\"type\":\"$type\"},";
			} else {
				$data_str .= "{\"name\":\"".$row["Name"]."\",\"id\":".$row["ID"].",\"terms\":[],\"defs\":[],\"type\":\"$type\"},";
			}
		}
		echo "[";
		echo substr($data_str, 0, strlen($data_str)-1);
		echo "]";
	}
}
?>