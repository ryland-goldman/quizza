<?php
unset($_COOKIE["google-signin"]);
setcookie("google-signin", "", time() - 3600, "/",".quizza.org");
echo "success";
?>