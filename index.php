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
                                <th>Date</th>
                                <th>Items</th>
                                <th>Total Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>#ORD-5723</td>
                                <td>Apr 27, 2025</td>
                                <td>Chicken Biryani, Borhani</td>
                                <td>৳280</td>
                                <td class="status-completed">Completed</td>
                            </tr>
                            <tr>
                                <td>#ORD-5694</td>
                                <td>Apr 24, 2025</td>
                                <td>Beef Kala Bhuna, Paratha (2)</td>
                                <td>৳350</td>
                                <td class="status-completed">Completed</td>
                            </tr>
                            <tr>
                                <td>#ORD-5650</td>
                                <td>Apr 20, 2025</td>
                                <td>Kacchi Mutton Biryani, Firni</td>
                                <td>৳450</td>
                                <td class="status-completed">Completed</td>
                            </tr>
                            <tr>
                                <td>#ORD-5601</td>
                                <td>Apr 15, 2025</td>
                                <td>Mixed Vegetable Curry, Plain Rice</td>
                                <td>৳180</td>
                                <td class="status-completed">Completed</td>
                            </tr>
                            <tr>
                                <td>#ORD-5532</td>
                                <td>Apr 10, 2025</td>
                                <td>Shorshe Ilish, Plain Rice</td>
                                <td>৳380</td>
                                <td class="status-completed">Completed</td>
                            </tr>
                            <tr>
                                <td>#ORD-5489</td>
                                <td>Apr 05, 2025</td>
                                <td>Chicken Jhal Fry, Naan (3)</td>
                                <td>৳320</td>
                                <td class="status-cancelled">Cancelled</td>
                            </tr>
                            <tr>
                                <td>#ORD-5432</td>
                                <td>Mar 30, 2025</td>
                                <td>Special Thali Meal</td>
                                <td>৳500</td>
                                <td class="status-completed">Completed</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <div id="feedback" class="tab-content">
            <div class="card">
                <div class="card-header">My Feedback</div>
                <div class="card-body">
                    <div class="feedback-item">
                        <div class="feedback-header">
                            <div class="feedback-food">Chicken Biryani</div>
                            <div class="feedback-date">Apr 27, 2025</div>
                        </div>
                        <div class="feedback-rating">
                            <div class="stars">
                                <span class="star filled">★</span>
                                <span class="star filled">★</span>
                                <span class="star filled">★</span>
                                <span class="star filled">★</span>
                                <span class="star">★</span>
                            </div>
                            <div class="rating-count">4.0</div>
                        </div>
                        <div class="feedback-comment">
                            The Chicken Biryani was delicious! The rice was perfectly cooked and the chicken was tender. I would recommend adding a bit more spice to enhance the flavor.
                        </div>
                    </div>
                    
                    <div class="feedback-item">
                        <div class="feedback-header">
                            <div class="feedback-food">Beef Kala Bhuna</div>
                            <div class="feedback-date">Apr 24, 2025</div>
                        </div>
                        <div class="feedback-rating">
                            <div class="stars">
                                <span class="star filled">★</span>
                                <span class="star filled">★</span>
                                <span class="star filled">★</span>
                                <span class="star filled">★</span>
                                <span class="star filled">★</span>
                            </div>
                            <div class="rating-count">5.0</div>
                        </div>
                        <div class="feedback-comment">
                            One of the best Beef Kala Bhuna I've had! The meat was tender and the gravy was rich and flavorful. Will definitely order again.
                        </div>
                    </div>
                    
                    <div class="feedback-item">
                        <div class="feedback-header">
                            <div class="feedback-food">Kacchi Mutton Biryani</div>
                            <div class="feedback-date">Apr 20, 2025</div>
                        </div>
                        <div class="feedback-rating">
                            <div class="stars">
                                <span class="star filled">★</span>
                                <span class="star filled">★</span>
                                <span class="star filled">★</span>
                                <span class="star">★</span>
                                <span class="star">★</span>
                            </div>
                            <div class="rating-count">3.0</div>
                        </div>
                        <div class="feedback-comment">
                            The Kacchi Mutton Biryani was average. The mutton was a bit too tough and the rice wasn't as flavorful as I expected. The portion size was good though.
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div id="add-feedback" class="tab-content">
            <div class="card">
                <div class="card-header">Give Feedback</div>
                <div class="card-body">
                    <div class="add-feedback">
                        <form>
                            <div>
                                <label for="food-item">Select Food Item:</label>
                                <select id="food-item">
                                    <option value="">-- Select an item --</option>
                                    <option value="chicken-biryani">Chicken Biryani</option>
                                    <option value="beef-kala-bhuna">Beef Kala Bhuna</option>
                                    <option value="mutton-biryani">Kacchi Mutton Biryani</option>
                                    <option value="shorshe-ilish">Shorshe Ilish</option>
                                    <option value="mixed-vegetable">Mixed Vegetable Curry</option>
                                    <option value="chicken-jhal-fry">Chicken Jhal Fry</option>
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
                                </div>
                            </div>
                            
                            <div>
                                <label for="comment">Your Comments:</label>
                                <textarea id="comment" placeholder="Share your experience with this food item..."></textarea>
                            </div>
                            
                            <button type="submit" class="btn">Submit Feedback</button>
                        </form>
                    </div>
                    
                    <div class="page-title">Example: How ratings appear on food items</div>
                    <div class="food-grid">
                        <div class="food-card">
                            <img src="/api/placeholder/400/320" alt="Chicken Biryani" class="food-img">
                            <div class="food-info">
                                <div class="food-name">Chicken Biryani</div>
                                <div class="food-price">৳180</div>
                                <div class="food-rating">
                                    <div class="stars">
                                        <span class="star filled">★</span>
                                        <span class="star filled">★</span>
                                        <span class="star filled">★</span>
                                        <span class="star filled">★</span>
                                        <span class="star">★</span>
                                    </div>
                                    <div class="rating-count">(4.0) 28 reviews</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="food-card">
                            <img src="/api/placeholder/400/320" alt="Beef Kala Bhuna" class="food-img">
                            <div class="food-info">
                                <div class="food-name">Beef Kala Bhuna</div>
                                <div class="food-price">৳250</div>
                                <div class="food-rating">
                                    <div class="stars">
                                        <span class="star filled">★</span>
                                        <span class="star filled">★</span>
                                        <span class="star filled">★</span>
                                        <span class="star filled">★</span>
                                        <span class="star filled">★</span>
                                    </div>
                                    <div class="rating-count">(4.😎 36 reviews</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="food-card">
                            <img src="/api/placeholder/400/320" alt="Kacchi Mutton Biryani" class="food-img">
                            <div class="food-info">
                                <div class="food-name">Kacchi Mutton Biryani</div>
                                <div class="food-price">৳320</div>
                                <div class="food-rating">
                                    <div class="stars">
                                        <span class="star filled">★</span>
                                        <span class="star filled">★</span>
                                        <span class="star filled">★</span>
                                        <span class="star half-filled">★</span>
                                        <span class="star">★</span>
                                    </div>
                                    <div class="rating-count">(3.5) 42 reviews</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="food-card">
                            <img src="/api/placeholder/400/320" alt="Shorshe Ilish" class="food-img">
                            <div class="food-info">
                                <div class="food-name">Shorshe Ilish</div>
                                <div class="food-price">৳380</div>
                                <div class="food-rating">
                                    <div class="stars">
                                        <span class="star filled">★</span>
                                        <span class="star filled">★</span>
                                        <span class="star filled">★</span>
                                        <span class="star filled">★</span>
                                        <span class="star">★</span>
                                    </div>
                                    <div class="rating-count">(4.2) 18 reviews</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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