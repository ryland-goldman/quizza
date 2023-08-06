<?php
$ignoreLog = true;
require("/var/www/html/docs/lib/header.php");
$query = strtolower($admin->real_escape_string(filter_var(urldecode($_GET["query"]),FILTER_SANITIZE_STRING)));
$result1 = $admin->query("SELECT * FROM Classes WHERE LOWER(ShortName) REGEXP \"^".$query."\" OR LOWER(ShortName)=\"".$query."\" ORDER BY SUBSTRING(ShortName, 1, LOCATE(' ', ShortName)), CAST(SUBSTRING(ShortName, LOCATE(' ', ShortName) + 1) AS UNSIGNED) ASC LIMIT 10;");
$result2 = $admin->query("SELECT * FROM Classes WHERE LOWER(LongName) REGEXP \"^".$query."\" OR LOWER(LongName)=\"".$query."\"  ORDER BY SUBSTRING(ShortName, 1, LOCATE(' ', ShortName)), CAST(SUBSTRING(ShortName, LOCATE(' ', ShortName) + 1) AS UNSIGNED) ASC LIMIT 10;");
$result3 = $admin->query("SELECT * FROM Classes WHERE LOWER(ShortName) REGEXP \"".$query."\" ORDER BY SUBSTRING(ShortName, 1, LOCATE(' ', ShortName)), CAST(SUBSTRING(ShortName, LOCATE(' ', ShortName) + 1) AS UNSIGNED) ASC LIMIT 10;");
$result4 = $admin->query("SELECT * FROM Classes WHERE LOWER(LongName) REGEXP \"".$query."\"  ORDER BY SUBSTRING(ShortName, 1, LOCATE(' ', ShortName)), CAST(SUBSTRING(ShortName, LOCATE(' ', ShortName) + 1) AS UNSIGNED) ASC LIMIT 10;");

$stack = array();
$first = true;
if($result1->num_rows !== 0 || $result2->num_rows !== 0 || $result3->num_rows !== 0 || $result4->num_rows !== 0){
	echo "[";
	$results = [$result1, $result2, $result3, $result4];
	foreach($results as $result){
		if($result->num_rows > 0){
		 	while ($class = $result->fetch_assoc()) {
			 	$shortname = $class["ShortName"];
			 	$id = $class["ID"];
			 	if(in_array($id,$stack)){ continue; }
				if(!$first){ echo ","; }
			 	if($first){ $first = false;}
			 	echo "[\"$shortname\",\"$id\"]";
			 	array_push($stack, $id);
		 	}
		}
	}
 	echo "]";
} else {
	echo "";
}
?>
