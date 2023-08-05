<?php
$ignoreLog = true;
require("/var/www/html/docs/lib/header.php");
$query = $admin->real_escape_string(filter_var(urldecode($_GET["query"]),FILTER_SANITIZE_STRING));
$result = $admin->query("SELECT * FROM Classes WHERE ShortName LIKE '".$query."%' OR ShortName='".$query."' ASC LIMIT 5");

$first = true;
if($result->num_rows > 0){
	echo "[";
 	while ($class = $result->fetch_assoc()) {
		if(!$first){ echo ","; }
	 	if($first){ $first = false;}
	 	$shortname = $class["ShortName"];
	 	$id = $class["ID"];
	 	echo "[\"$shortname\",\"$id\"]";
 	}
 	echo "]";
} else {
	echo "";
}
?>