<?php
unset($_COOKIE["google-signin"]);
setcookie("google-signin","",-1,"/");
echo "success";
?>