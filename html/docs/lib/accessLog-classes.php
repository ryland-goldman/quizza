<?php
$log_access_key = $_GET["key"];
if($log_access_key !== trim(file_get_contents("/var/www/logs.privkey"))) { die("Invalid Key"); }

$sql_db_password = trim(file_get_contents("/var/www/sql.privkey"));
$schools_db = new mysqli("localhost","quizza", $sql_db_password, "Schools");
$schools = $schools_db->query("SELECT * FROM main");
if($schools->num_rows > 0){
	while($school = $schools->fetch_assoc()){
		
		$school_db = new mysqli("localhost","quizza",$sql_db_password,"Admin".$school["id"]);
		$classes = $school_db->query("SELECT * FROM Classes");
		if($classes->num_rows > 0){
			while($class = $classes->fetch_assoc()){
				
				$sets = $school_db->query("SELECT COUNT(*) FROM ".$class["ID"]."Sets")->fetch_assoc()["COUNT(*)"];
				echo $school["id"].",".$class["ID"].",".$sets;

			}
		}

	}
}
?>