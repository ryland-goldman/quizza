<?php
if(!isset($ignoreLog)) {
	$apikey = $_GET["key"];
	if($apikey !== trim(file_get_contents("/var/www/logs.privkey"))) { die("Invalid Key"); }
	$sql_db_password =  trim(file_get_contents("/var/www/sql.privkey"));
	$admin = new mysqli("localhost", "quizza", $sql_db_password, "Schools");
	$data = $admin->query("SELECT * FROM main");
	if($data->num_rows > 0){
		$data_str = "";
		while($row = $data->fetch_assoc()){
			$data_str .= "{\"longName\":\"".$row["longname"]."\",\"shortName\":\"".$row["id"]."\"},";
		}
		echo "[";
		echo substr($data_str, 0, strlen($data_str)-1);
		echo "]";
	}
}
?>