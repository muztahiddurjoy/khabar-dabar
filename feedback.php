<?php
require_once('connect.php');
// Check if the form is submitted
$user = $_POST['id'];
$item = $_POST['item_id'];
$rating = $_POST['rating'];
$feedback = $_POST['feedback'];

$command = "INSERT INTO feedback (user_id, food_item_id, rating, feedback) VALUES ('$user', '$item', '$rating', '$feedback')";

?>