<?php
// first of all, we need to connect to the database
require_once('connect.php');

// we need to check if the input in the form textfields are not empty
if (isset($_POST['Username']) && isset($_POST['Password']) && isset($_POST['Mobile'])) {
    // Get the form data
    $username = $_POST['Username'];
    $password = $_POST['Password'];
    $mobile = $_POST['Mobile'];

    // Write the query to check if this username, password and mobile exists in our database
    $sql = "SELECT * FROM users WHERE username = '$username' AND password= '$password' AND mobile_number='$mobile'";
    
    // Execute the query
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) != 0) {
        if (mysqli_num_rows($result) > 0) {
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            while ($row = mysqli_fetch_assoc($result)) {
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['mobile'] = $row['Mobile'];
            }
            
            // Login successful, redirect to home page
            header("Location: index.php");
            exit();
        }
       
    } else {
        // Check which credential is wrong
        // First check username
        $checkUsername = "SELECT * FROM client WHERE Username = '$username'";
        $usernameResult = mysqli_query($conn, $checkUsername);

        if (!$usernameResult || mysqli_num_rows($usernameResult) == 0) {
            // Username doesn't exist
            header("Location: login_page.php?error=invalid_username");
            exit();
        }

        // Check password for this username
        $checkPassword = "SELECT * FROM client WHERE Username = '$username' AND Password = '$password'";
        $passwordResult = mysqli_query($conn, $checkPassword);

        if (!$passwordResult || mysqli_num_rows($passwordResult) == 0) {
            // Password is incorrect
            header("Location: login_page.php?error=invalid_password");
            exit();
        }

        // If we reached here, the mobile must be wrong
        header("Location: login_page.php?error=invalid_mobile");
        exit();
    }
} else {
    // If any of the fields are missing
    header("Location: login_page.php?error=missing_fields");
    exit();
}
?>