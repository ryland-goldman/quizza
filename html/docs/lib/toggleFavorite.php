<?php require "/var/www/html/docs/lib/header.php";
$admin->query("LOCK TABLES Favorites write");
if ($loggedIn) {
    if ( $admin->query("SELECT * FROM Favorites WHERE ID=\"$classID\" AND User=\"$email\"")->num_rows == 0 ) {
        // Not already in favorites, so add it
        $admin->query("INSERT INTO Favorites Values (\"$email\",\"$classID\",\"Set\")");
    } else {
        // Already in favorites. Remove it.
        $admin->query("DELETE FROM Favorites WHERE ID=\"$classID\" AND User=\"$email\"");
    }
}
$admin->query("UNLOCK TABLES");
?>
