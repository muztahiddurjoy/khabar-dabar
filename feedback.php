<?php
require_once('connect.php');
session_start();
// Check if the form is submitted
$rating = $_POST['rating'];
$user_id = $_SESSION['user_id'];
$feedback = $_POST['feedback'];
$order_id = $_POST['order_id'];
$order_result;
// if (empty($rating) || empty($user_id) || empty($feedback) || empty($order_id)) {
//     echo "Rating: ".$rating . "<br/> User ID" . $user_id . "<br/>Feedback: " . $feedback . "<br/> Order ID:" . $order_id;
//     echo "All fields are required.";
//     exit;
// }

$query = "SELECT food_item_id FROM add_to_cart WHERE token_id = '$order_id'";
if(mysqli_query($conn, $query)) {
    $order_result = mysqli_fetch_assoc(mysqli_query($conn, $query));
} else {
    echo "Error: " . mysqli_error($conn);
}

$food_item_id = $order_result['food_item_id'];

// Assuming you have a connection to the database in connect.php

$command = "INSERT INTO feedback (user_id, food_item_id, rating, feedback, order_id) VALUES ('$user_id', '$food_item_id', '$rating', '$feedback', '$order_id')";
if (mysqli_query($conn, $command)) {
    header("Location: index.php");
} else {
    echo "Error: " . mysqli_error($conn);
}

?>