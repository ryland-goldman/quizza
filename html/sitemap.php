<?php 

header("Content-Type: text/plain");

$readcache = false;
$cached_classes = "/var/www/sitemap.cache"; 
if(file_exists($cached_classes)){
	if(!isset($_GET['reload_cache'])){
		if(filemtime($cached_classes) + $max_age > time()){
			$readcache = true;
		}
	}
}

if($readcache) {
	readfile($cached_classes);
} else {
	$cache_data_append = "https://www.quizza.org/\nhttps://www.quizza.org/private\n";
	$schooldb = new mysqli("localhost","quizza", trim(file_get_contents("/var/www/sql.privkey")), "Schools");
	$schools = $schooldb->query("SELECT * FROM main ORDER BY longname ASC;");
	while($curr_school = $schools->fetch_assoc()){ 
		if($curr_school["id"] !== "private"){ continue; }
		$cache_data_append .= "https://";
		$cache_data_append .= $curr_school["id"];
		$cache_data_append .= ".quizza.org/\n";
		$classes = $schooldb->query("SELECT * FROM Admin".$curr_school["id"].".Classes");
		if($classes->num_rows > 0){
			while($curr_class = $classes->fetch_assoc()){
				$cache_data_append .= "https://";
				$cache_data_append .= $curr_school["id"];
				$cache_data_append .= ".quizza.org/";
				$cache_data_append .= $curr_class["ID"];
				$cache_data_append .= "\n";
				$sets = $schooldb->query("SELECT * FROM Admin".$curr_school["id"].".".$curr_class["ID"]."Sets");
				if($sets->num_rows > 0){
					while($curr_set = $sets->fetch_assoc()){
						$cache_data_append .= "https://"
						$cache_data_append .= $curr_school["id"];
						$cache_data_append .= ".quizza.org/";
						$cache_data_append .= $curr_class["ID"];
						$cache_data_append .= "/";
						$cache_data_append .= $curr_set["ID"];
						$cache_data_append .= "\n";
					}
				}
			}
		}
	}
	file_put_contents($cached_classes, $cache_data_append);
	echo $cache_data_append;
}

?>