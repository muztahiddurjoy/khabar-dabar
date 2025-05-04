<?php
require_once('connect.php');
// Check if the form is submitted
$sql  = "SELECT * FROM `users` WHERE `user_id` = 1";    
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "ID: " . $row["user_id"] . " - Name: " . $row["username"] . "<br>";
    }
} else {
    echo "No results found.";
}
?>