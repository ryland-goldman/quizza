<?php
$req_permission = 2;
require("/var/www/html/docs/lib/header.php");
if($loggedIn == false){  require("/var/www/html/403.php"); }
if($email !== $creator && $creator !== ""){ require("/var/www/html/403.php"); }

// Set time zone to PST/PDT by default
date_default_timezone_set("America/Los_Angeles");
$lastModified = date("d M Y (h:i A T)")." by ".$name;

// Encode the change and push to edit log
$data = $_POST["data"];
$content = base64_encode($data);
$title = $admin->real_escape_string(filter_var($_POST["title"],FILTER_SANITIZE_STRING));
$action = ($_GET["DELETE"] == "TRUE") ? "Delete" : "Edit";
$edittime = date("d M Y (h:i A T)");
$admin->query("LOCK TABLES EditLog");
$admin->query("INSERT INTO EditLog VALUES ('$email','$content','$classID $setID $title','$action','$edittime')");
$admin->query("UNLOCK TABLES");

if($_GET["DELETE"]=="TRUE"){ // Deleting a set
  $admin->query("LOCK TABLES ".$classID."Sets");
  $admin->query("DELETE FROM ".$classID."Sets WHERE ID=\"$setID\"");
  $admin->query("UNLOCK TABLES");
  $thisClass->query("DROP TABLE IF EXISTS Archive".$type.$setID);
  $thisClass->query("ALTER TABLE ".$type.$setID." RENAME Archive".$type.$setID);
  die("<script>location.href='/".$classID."';</script>");
} else {
  if($type == "Set"){
    $admin->query("LOCK TABLES ".$classID."Sets");
    $admin->query("LOCK TABLES Set".$setID);
    $thisClass->query("DELETE FROM Set".$setID);
    $d = str_getcsv($data, "\n"); //parse the rows
    foreach ($d as &$row) {
        $row = str_replace("&comma;",",",str_getcsv($row, ",")); //parse the items in rows
        $term = $thisClass->real_escape_string(filter_var($row[0],FILTER_SANITIZE_STRING));
        $def = $thisClass->real_escape_string(filter_var($row[1],FILTER_SANITIZE_STRING));

        $str1 = $term;
        $str2 = "";
        if (preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $str1, $matches)) {
          $url = $matches[0];
          $str2 .= "<img src='$url' style='max-width:256px;'><br>";
          $str1 = str_replace($url, "", $str1);
        }
        $str2 .= $str1;
        $term = $str2;

        $str1b = $def;
        $str2b = "";
        if (preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $str1b, $matches)) {
          $url = $matches[0];
          $str2b .= "<img src='$url' style='max-width:256px;'><br>";
          $str1b = str_replace($url, "", $str1b);
        }
        $str2b .= $str1b;
        $def = $str2b;


        if($term !== "" || $def !== "") {
          $thisClass->query("INSERT INTO Set".$setID." VALUES (\"$term\", \"$def\")");
        }
        var_dump($row);
    }
    $admin->query("UPDATE ".$classID."Sets SET Name=\"$title\" WHERE ID=\"$setID\"");
    $admin->query("UPDATE ".$classID."Sets SET Modified=\"$lastModified\" WHERE ID=\"$setID\"");
    if($_POST['switchtype']=='true'){
      $thisClass->query("ALTER TABLE Set".$setID." ADD COLUMN Ic1 text");
      $thisClass->query("ALTER TABLE Set".$setID." ADD COLUMN Ic2 text");
      $thisClass->query("ALTER TABLE Set".$setID." ADD COLUMN Ic3 text");
      $thisClass->query("ALTER TABLE Set".$setID." RENAME COLUMN Term to Question");
      $thisClass->query("ALTER TABLE Set".$setID." RENAME COLUMN Definition to C1");
      $thisClass->query("RENAME TABLE Set".$setID." TO Quiz".$setID);
      $admin->query("UPDATE ".$classID."Sets SET Type=\"Quiz\" WHERE ID=".$setID);
    }
    $admin->query("UNLOCK TABLES");
  } else {
    $admin->query("LOCK TABLES ".$classID."Sets");
    $admin->query("LOCK TABLES Quiz".$setID);
    $thisClass->query("DELETE FROM Quiz".$setID);
    if($data !== "empty"){
      $d = str_getcsv($data, "\n"); //parse the rows
      foreach ($d as &$row) {
          $row = str_replace("&comma;",",",str_getcsv($row, ",")); //parse the items in rows
          $q = $thisClass->real_escape_string(filter_var($row[0],FILTER_SANITIZE_STRING));
          $c1 = $thisClass->real_escape_string(filter_var($row[1],FILTER_SANITIZE_STRING));
          $ic1 = $thisClass->real_escape_string(filter_var($row[2],FILTER_SANITIZE_STRING));
          $ic2 = $thisClass->real_escape_string(filter_var($row[3],FILTER_SANITIZE_STRING));
          $ic3 = $thisClass->real_escape_string(filter_var($row[4],FILTER_SANITIZE_STRING));


          $str1 = $q;
          $str2 = "";
          if (preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $str1, $matches)) {
            $url = $matches[0];
            $str2 .= "<img src='$url' style='max-width:256px;'><br>";
            $str1 = str_replace($url, "", $str1);
          }
          $str2 .= $str1;
          $q = $str2;

          $str1 = $c1;
          $str2 = "";
          if (preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $str1, $matches)) {
            $url = $matches[0];
            $str2 .= "<img src='$url' style='max-width:256px;'><br>";
            $str1 = str_replace($url, "", $str1);
          }
          $str2 .= $str1;
          $c1 = $str2;

          $str1 = $ic1;
          $str2 = "";
          if (preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $str1, $matches)) {
            $url = $matches[0];
            $str2 .= "<img src='$url' style='max-width:256px;'><br>";
            $str1 = str_replace($url, "", $str1);
          }
          $str2 .= $str1;
          $ic1 = $str2;

          $str1 = $ic2;
          $str2 = "";
          if (preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $str1, $matches)) {
            $url = $matches[0];
            $str2 .= "<img src='$url' style='max-width:256px;'><br>";
            $str1 = str_replace($url, "", $str1);
          }
          $str2 .= $str1;
          $ic2 = $str2;

          $str1 = $ic3;
          $str2 = "";
          if (preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $str1, $matches)) {
            $url = $matches[0];
            $str2 .= "<img src='$url' style='max-width:256px;'><br>";
            $str1 = str_replace($url, "", $str1);
          }
          $str2 .= $str1;
          $ic3 = $str2;


          if($term !== "" || $def !== "") {
            $thisClass->query("INSERT INTO Quiz".$setID." VALUES (\"$q\", \"$c1\",\"$ic1\",\"$ic2\",\"$ic3\")");
          }
          var_dump($row);
      }
      $admin->query("UPDATE ".$classID."Sets SET Name=\"$title\" WHERE ID=\"$setID\"");
      $admin->query("UPDATE ".$classID."Sets SET Modified=\"$lastModified\" WHERE ID=\"$setID\"");
      if($_POST['switchtype']=='true'){
        $thisClass->query("ALTER TABLE Quiz".$setID." DROP COLUMN Ic1");
        $thisClass->query("ALTER TABLE Quiz".$setID." DROP COLUMN Ic2");
        $thisClass->query("ALTER TABLE Quiz".$setID." DROP COLUMN Ic3");
        $thisClass->query("ALTER TABLE Quiz".$setID." RENAME COLUMN Question to Term");
        $thisClass->query("ALTER TABLE Quiz".$setID." RENAME COLUMN C1 to Definition");
        $thisClass->query("RENAME TABLE Quiz".$setID." TO Set".$setID);
        $admin->query("UPDATE ".$classID."Sets SET Type=\"Set\" WHERE ID=".$setID);
      }
    }
    $admin->query("UNLOCK TABLES");
  }
  
  echo "success";
}
 ?>
