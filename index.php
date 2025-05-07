<?php
require_once('connect.php');
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login_page.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>খাবার দাবার - Cafeteria Management</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f8f8;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .header {
            background-color: #289A6A;
            color: white;
            padding: 15px 0;
            display: flex;
            align-items: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }
        .logo {
            width: 70px;
            height: 70px;
            margin-left: 70px;
            margin-right: 20px;
        }
        .logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .brand {
            font-size: 28px;
            font-weight: bold;
            color: white;
        }
        .search-container {
            flex: 1;
            margin: 0 20px;
            display: flex;
            max-width: 800px;
        }
        .search-box {
            flex: 1;
            padding: 8px 15px;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            width: 100%;
        }
        .search-button {
            background-color: white;
            border: none;
            border-radius: 0 4px 4px 0;
            padding: 0 15px;
            margin-left: -40px;
            cursor: pointer;
            position: relative;
        }
        .filter-button {
            background-color: white;
            color: #289A6A;
            border: none;
            border-radius: 4px;
            padding: 8px 15px;
            margin-right: 70px;
            font-weight: bold;
            cursor: pointer;
            display: flex;
            align-items: center;
        }
        .filter-button i {
            margin-right: 5px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px 70px;
        }
        .page-title {
            font-size: 1.5rem;
            color: #333;
            margin: 20px 0;
            font-weight: bold;
        }
        .card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            margin-bottom: 20px;
            overflow: hidden;
        }
        .card-header {
            background-color: #289A6A;
            color: white;
            padding: 15px 20px;
            font-size: 18px;
            font-weight: bold;
        }
        .card-body {
            padding: 20px;
        }
        .info-row {
            display: flex;
            margin-bottom: 15px;
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
        }
        .info-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        .info-label {
            font-weight: bold;
            width: 150px;
            color: #555;
        }
        .info-value {
            flex: 1;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th {
            background-color: #289A6A;
            color: white;
            padding: 12px 15px;
            text-align: left;
            font-weight: normal;
        }
        td {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
        }
        tr:last-child td {
            border-bottom: none;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .status-completed {
            color: #289A6A;
            font-weight: bold;
        }
        .status-pending {
            color: #ff9800;
            font-weight: bold;
        }
        .status-cancelled {
            color: #ff4444;
            font-weight: bold;
        }
        
        /* Feedback System Styles */
        .tabs {
            display: flex;
            border-bottom: 1px solid #eee;
            margin-bottom: 20px;
        }
        .tab {
            padding: 10px 20px;
            cursor: pointer;
            border-bottom: 3px solid transparent;
            font-weight: bold;
            color: #777;
        }
        .tab.active {
            color: #289A6A;
            border-bottom-color: #289A6A;
        }
        .tab-content {
            display: none;
        }
        .tab-content.active {
            display: block;
        }
        .rating {
            display: flex;
            margin-right: 15px;
            align-items: center;
        }
        .stars {
            display: flex;
            margin-right: 10px;
        }
        .star {
            color: #ddd;
            cursor: pointer;
            font-size: 24px;
        }
        .star.filled {
            color: #ffb800;
        }
        .rating-count {
            color: #777;
            font-size: 14px;
        }
        .feedback-item {
            border-bottom: 1px solid #eee;
            padding: 15px 0;
        }
        .feedback-item:last-child {
            border-bottom: none;
        }
        .feedback-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .feedback-food {
            font-weight: bold;
            font-size: 16px;
        }
        .feedback-date {
            color: #777;
            font-size: 14px;
        }
        .feedback-rating {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        .feedback-comment {
            margin-top: 10px;
            color: #555;
        }
        .add-feedback {
            background-color: #f9f9f9;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 15px;
            font-size: 15px;
        }
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 15px;
            font-size: 15px;
            min-height: 100px;
            resize: vertical;
        }
        .btn {
            background-color: #289A6A;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
        }
        .btn:hover {
            background-color: #1f7d56;
        }
        
        /* Food Item Styles (for demonstration) */
        .food-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }
        .food-card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            overflow: hidden;
        }
        .food-img {
            height: 180px;
            width: 100%;
            object-fit: cover;
        }
        .food-info {
            padding: 15px;
        }
        .food-name {
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 5px;
        }
        .food-price {
            color: #289A6A;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .food-rating {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        .footer {
            text-align: center;
            padding: 20px;
            color: #777;
            font-size: 14px;
            background-color: #f1f1f1;
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">
            <img src="images.jpg.jpg" alt="খাবার দাবার Logo">
        </div>
        <div class="brand">খাবার দাবার</div>
        <form action="search.php" method="get" class="search-container">
                <input type="text" name="query" class="search-box" placeholder="Search for food items">
                <button class="search-button" type="submit">
                <svg xmlns="http://www.w3.org/2000/svg
" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#289A6A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
            </button>
                
    </form>
        <button class="filter-button">
            <svg xmlns="http://www.w3.org/2000/svg
" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#289A6A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
            </svg>
            Filter
        </button>
    </div>

    <div class="container">
        <div class="page-title">Account Information</div>
        
        <div class="tabs">
            <div class="tab active" onclick="openTab('profile')">Profile</div>
            <div class="tab" onclick="openTab('orders')">Order History</div>
            <div class="tab" onclick="openTab('booking')">My Reservations</div>
            <div class="tab" onclick="openTab('feedback')">My Feedback</div>
            <div class="tab" onclick="openTab('add-feedback')">Give Feedback</div>
        </div>
        
        <?php
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
                                <div class="info-label">Account Type:</div>
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

<div id="orders" class="tab-content">
                    <div class="card">
                        <div class="card-header">Order History</div>
                        <div class="card-body">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Item</th>
                                        <th>Total Cost</th>
                                        <th>Qauntity</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
<?php
        $user_id = $_SESSION['user_id'];
        // Fetch user profile data
        $sql = "SELECT * FROM add_to_cart WHERE user_id = '$user_id'";
        $result = mysqli_query($conn, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $sql2 = 'SELECT * FROM food_items WHERE food_item_id= "'.$row["food_item_id"].'"';
                                        $result2 = mysqli_query($conn, $sql2);
                                        if ($result2 && mysqli_num_rows($result2) > 0) {
                                            while ($row2 = mysqli_fetch_assoc($result2)) {
                                                echo '<tr>
                                                
                                                <td>#ORD-'.$row["token_id"].'</td>
                                                <td>'.$row2["name"].'</td>
                                                <td>'.$row2["amount"]*$row['quantity'].' BDT</td>
                                                            <td>'.$row['quantity'].'</td>
                                                <td class="status-completed">'.$row["payment_status"].'</td>
                                                
                                                </tr>
                                                ';
                                            }
                                        } else {    
                                            echo "No results found.";
                                        }
                    
                }
            } else {
                echo "No results found.";
            }
        }
        else {
            echo "Error fetching user data.";
        }
            ?>
              </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="tab-content" id="booking">
        <div class="card">
                <div class="card-header">My Reservations</div>
                <div class="card-body">
    <?php
        $user_id = $_SESSION['user_id'];
        // Fetch user profile data  
        $sql = "SELECT * FROM advance_booking WHERE user_id = '$user_id'";
        $result = mysqli_query($conn, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $sql2 = 'SELECT * FROM food_items WHERE food_item_id= "'.$row["food_item_id"].'"';
                                        $result2 = mysqli_query($conn, $sql2);
                                        if ($result2 && mysqli_num_rows($result2) > 0) {
                                            while ($row2 = mysqli_fetch_assoc($result2)) {
                                                echo '<div class="info-row">
                                                        <div class="info-label">Booking ID:</div>
                                                        <div class="info-value">#BOOK-'.$row["booking_token"].'</div>
                                                    </div>
                                                    <div class="info-row">
                                                        <div class="info-label">Booking Date:</div>
                                                        <div class="info-value">'.$row["booking_date"].'</div>
                                                    </div>
                                                    <div class="info-row">
                                                        <div class="info-label">Booking Time:</div>
                                                        <div class="info-value">'.$row["booking_time"].'</div>
                                                    </div>
                                                    <div class="info-row">
                                                        <div class="info-label">Item:</div>
                                                        <div class="info-value">'.$row2["name"].'</div>
                                                    </div>
                                                    <div class="info-row">
                                                        <div class="info-label">Total Cost:</div>
                                                        <div class="info-value">'.$row2["amount"]*$row["quantity"].' BDT</div>
                                                    </div>
                                                    <div class="info-row">
                                                        <div class="info-label">Qauntity:</div>
                                                        <div class="info-value">'.$row["quantity"].'</div>
                                                    </div>
                                                    ';
                                            }
                                        } else {
                                            echo "No results found.";
                                        }
                }
            } else {
                echo "No results found.";
            }
        }
        ?>

                </div>
    
            </div>
        </div>

        
      
        <div id="feedback" class="tab-content">
            <div class="card">
            <div class="card-header">My Feedback</div>
            <div class="card-body">
                <?php
                $user_id = $_SESSION['user_id'];
                $sql = "SELECT f.*, fi.name AS food_name FROM feedback f 
                    JOIN food_items fi ON f.food_item_id = fi.food_item_id 
                    WHERE f.user_id = '$user_id'";
                $result = mysqli_query($conn, $sql);
                if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="feedback-item">
                        <div class="feedback-header">
                        <div class="feedback-food">' . htmlspecialchars($row["food_name"]) . '</div>
                        <div class="feedback-date">' . date("M d, Y", strtotime($row["created_at"])) . '</div>
                        </div>
                        <div class="feedback-rating">
                        <div class="stars">';
                    for ($i = 1; $i <= 5; $i++) {
                    echo '<span class="star' . ($i <= $row["rating"] ? ' filled' : '') . '">★</span>';
                    }
                    echo '      </div>
                        <div class="rating-count">' . htmlspecialchars($row["rating"]) . '.0</div>
                        </div>
                        <div class="feedback-comment">
                        ' . htmlspecialchars($row["comment"]) . '
                        </div>
                    </div>';
                }
                } else {
                echo '<p>No feedback found.</p>';
                }
                ?>
            </div>
            </div>
        </div>
        
        <div id="add-feedback" class="tab-content">
            <div class="card">
                <div class="card-header">Give Feedback</div>
                <div class="card-body">
                    <div class="add-feedback">
                        <form action="feedback.php" method="POST">
                            <div>
                                <label for="food-item">Select Food Item:</label>
                                <select id="food-item" name="order_id" required>
                                    <option value="">-- Select an item --</option>
                                    <?php
                                    $user_id = $_SESSION['user_id'];
                                    $sql = "SELECT *
                                            FROM add_to_cart atc 
                                            JOIN food_items fi ON atc.food_item_id = fi.food_item_id 
                                            LEFT JOIN feedback fb ON atc.food_item_id = fb.food_item_id AND atc.user_id = fb.user_id 
                                            WHERE atc.user_id = '$user_id' AND fb.food_item_id IS NULL";
                                    $result = mysqli_query($conn, $sql);
                                    if ($result && mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo '<option value="' . htmlspecialchars($row["token_id"]) . '">' . htmlspecialchars($row["name"]). '</option>';
                                        }
                                    } else {
                                        echo '<option value="">No items available for feedback</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            
                            <div>
                                <label>Your Rating:</label>
                                <div class="rating">
                                    <div class="stars">
                                        <span class="star" onclick="setRating(1)">★</span>
                                        <span class="star" onclick="setRating(2)">★</span>
                                        <span class="star" onclick="setRating(3)">★</span>
                                        <span class="star" onclick="setRating(4)">★</span>
                                        <span class="star" onclick="setRating(5)">★</span>
                                    </div>
                                    <input type="hidden" name="rating" id="rating" value="0" required>
                                </div>
                            </div>
                            
                            <div>
                                <label for="comment">Your Comments:</label>
                                <textarea id="comment" name="feedback" placeholder="Share your experience with this food item..." required></textarea>
                            </div>
                            
                            <button type="submit" class="btn">Submit Feedback</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function setRating(rating) {
                var stars = document.querySelectorAll("#add-feedback .stars .star");
                for (var i = 0; i < stars.length; i++) {
                    if (i < rating) {
                        stars[i].classList.add("filled");
                    } else {
                        stars[i].classList.remove("filled");
                    }
                }
                document.getElementById("rating").value = rating;
            }
        </script>
    
    </div>

    <div class="footer">
        <p>&copy; 2025 খাবার দাবার Cafeteria System. All Rights Reserved.</p>
    </div>
    
    <script>
        function openTab(tabName) {
            // Hide all tab content
            var tabContents = document.getElementsByClassName("tab-content");
            for (var i = 0; i < tabContents.length; i++) {
                tabContents[i].classList.remove("active");
            }
            
            // Remove active class from all tabs
            var tabs = document.getElementsByClassName("tab");
            for (var i = 0; i < tabs.length; i++) {
                tabs[i].classList.remove("active");
            }
            
            // Show the selected tab content and mark the button as active
            document.getElementById(tabName).classList.add("active");
            
            // Find and activate the tab button
            var tabButtons = document.getElementsByClassName("tab");
            for (var i = 0; i < tabButtons.length; i++) {
                if (tabButtons[i].getAttribute("onclick").includes(tabName)) {
                    tabButtons[i].classList.add("active");
                }
            }
        }
        
        function setRating(rating) {
            var stars = document.querySelectorAll("#add-feedback .stars .star");
            for (var i = 0; i < stars.length; i++) {
                if (i < rating) {
                    stars[i].classList.add("filled");
                } else {
                    stars[i].classList.remove("filled");
                }
            }
        }
    </script>
</body>
</html>