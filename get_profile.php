<?php
require_once('connect.php');
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login_page.php");
    exit();
}
$user_id = $_SESSION['user_id'];
// Fetch user profile data
$sql = "SELECT * FROM users WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $sql);
if ($result && mysqli_num_rows($result) > 0) {
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div id="profile" class="tab-content active">
            <div class="card">
                <div class="card-header">User Details</div>
                <div class="card-body">
                    <div class="info-row">
                        <div class="info-label">User ID:</div>
                        <div class="info-value">'.$user_id.'</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Username:</div>
                        <div class="info-value">'.$row["username"].'</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Mobile:</div>
                        <div class="info-value">'.$row["mobile_number"].'</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Client Type:</div>
                        <div class="info-value">'.$row["user_type"].'</div>
                    </div>
                </div>
            </div>
        </div>';
        }
    } else {
        echo "No results found.";
    }

   
    
} else {
    echo "Error fetching user data.";
    exit();
}
?>