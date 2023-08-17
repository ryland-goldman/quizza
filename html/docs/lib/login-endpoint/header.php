<?php
$loggedIn = false;
$session_expiry = 60*60*4; // expire after four hours
if (session_status() !== PHP_SESSION_NONE) {
  if(isset($_SESSION["loggedIn"])){

    do {

      if($_SESSION["age"] < time() - $session_expiry){
        session_unset();
        session_destroy();
        break;
      }

      $loggedIn = $_SESSION["loggedIn"];
      $name = $_SESSION["name"];
      $email = $_SESSION["email"];
      $pic = $_SESSION["pic"];
      $_SESSION["age"] = time();
    } while(0);
  }
}
?>
