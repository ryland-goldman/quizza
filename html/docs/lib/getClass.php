<?php
$ignoreLog = true;
require("/var/www/html/docs/lib/header.php");
$subject = $admin->real_escape_string(filter_var($_GET['subj'],FILTER_SANITIZE_STRING));;
$classlist = $admin->query("SELECT * FROM Classes WHERE Subject=\"".$subject."\"");
if ($classlist->num_rows > 0) {
  while ($current_class = $classlist->fetch_assoc()) { ?>
    <div>
      <h3><?php echo $current_class["ShortName"]; ?></h3>
      <a href='<?php echo $current_class["ID"]; ?>'>
        <button class='frontpage-studybtn'>Study</button>
      </a>
    </div><?php
  }
}
?>