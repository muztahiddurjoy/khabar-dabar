<?php
require_once('connect.php');
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login_page.php");
    exit();
}
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['username'];
$user_mobile = $_SESSION['mobile'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['buy_now'])) {
        $item_id = $_POST['item_id'];
        $quantity = $_POST['quantity'];
        $token_id = rand(1000,9999);
        $sql = "INSERT INTO add_to_cart (token_id,user_id, food_item_id, quantity,payment_status) VALUES ('$token_id','$user_id', '$item_id', '$quantity','Pending')";
        if (mysqli_query($conn, $sql)) {
            $success_message = "Item added to cart successfully! Your token ID is ".$token_id;
        } else {
            $error_message = "Error: ".mysqli_error($conn);
        }
    } elseif (isset($_POST['book_submit'])) {
        $item_id = $_POST['item_id'];
        $quantity = $_POST['quantity'];
        $booking_date = $_POST['booking_date'];
        $booking_time = $_POST['booking_time'];

        $booking_token = rand(1000,9999);
        $sql = "INSERT INTO advance_booking (user_id, food_item_id, quantity, booking_date, booking_time, booking_token) VALUES ('$user_id', '$item_id', '$quantity', '$booking_date', '$booking_time', '$booking_token')";
        if (mysqli_query($conn, $sql)) {
            $success_message = "Booking confirmed for ".date('F j, Y', strtotime($booking_date))." at ".date('g:i A', strtotime($booking_time))."! Your reservation #".$booking_token." is ready.";
        } else {
            $error_message = "Error: ".mysqli_error($conn);
        }
        
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Booking - খাবার দাবার</title>
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
        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }
        .page-title {
            font-size: 24px;
            color: #289A6A;
            margin-bottom: 20px;
            font-weight: bold;
        }
        .food-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }
        .food-card {
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .food-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .food-img-container {
            height: 180px;
            overflow: hidden;
        }
        .food-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s;
        }
        .food-card:hover .food-img {
            transform: scale(1.05);
        }
        .food-info {
            padding: 20px;
        }
        .food-name {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 8px;
            color: #222;
        }
        .food-price {
            color: #289A6A;
            font-weight: bold;
            font-size: 20px;
            margin-bottom: 10px;
        }
        .food-rating {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        .stars {
            color: #FFB800;
            margin-right: 8px;
        }
        .rating-count {
            color: #777;
            font-size: 14px;
        }
        .food-category {
            display: inline-block;
            background-color: #f0f0f0;
            color: #555;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            margin-bottom: 15px;
        }
        .quantity-control {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        .quantity-btn {
            background-color: #e0e0e0;
            border: none;
            width: 30px;
            height: 30px;
            font-size: 16px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 4px;
        }
        .quantity-input {
            width: 50px;
            text-align: center;
            margin: 0 10px;
            padding: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .action-buttons {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }
        .btn {
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }
        .btn-buy {
            background-color: #289A6A;
            color: white;
        }
        .btn-buy:hover {
            background-color: #1f7d56;
        }
        .btn-book {
            background-color: #FFB800;
            color: #333;
        }
        .btn-book:hover {
            background-color: #e6a600;
        }
        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
            display: <?php echo isset($success_message) ? 'block' : 'none'; ?>;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }
        .modal-content {
            background-color: white;
            margin: 10% auto;
            padding: 30px;
            border-radius: 8px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            animation: modalopen 0.3s;
        }
        @keyframes modalopen {
            from {opacity: 0; transform: translateY(-50px);}
            to {opacity: 1; transform: translateY(0);}
        }
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }
        .modal-title {
            font-size: 20px;
            font-weight: bold;
            color: #289A6A;
        }
        .close-btn {
            font-size: 24px;
            font-weight: bold;
            color: #777;
            cursor: pointer;
            background: none;
            border: none;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #555;
        }
        .form-group input, .form-group textarea, .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 15px;
        }
        .form-group textarea {
            min-height: 80px;
            resize: vertical;
        }
        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid #eee;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">
            <img src="images.jpg.jpg" alt="খাবার দাবার Logo">
        </div>
        <div class="brand">খাবার দাবার</div>
    </div>

    <div class="container">
        <div class="page-title">Order Food Items</div>
        
        <?php if (isset($success_message)): ?>
            <div class="success-message"><?php echo $success_message; ?></div>
        <?php endif; ?>
        
        <div class="food-grid">
            <?php
            $sql = "SELECT * FROM food_items";
            $result = mysqli_query($conn, $sql);
            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="food-card">';
                    echo '<div class="food-img-container">';
                    echo '<img src="https://placehold.co/600x400?text='.$row['name'].'" alt="'.$row['name'].'" class="food-img">';
                    echo '</div>';
                    echo '<div class="food-info">';
                    echo '<div class="food-name">'.$row['name'].'</div>';
                    echo '<div class="food-price">৳'.$row['amount'].'</div>';
                    
                    echo '<div class="food-rating">';
                    echo '<div class="stars">';
                    $full_stars = floor($row['rating']);
                    $half_star = ($row['rating'] - $full_stars) >= 0.5 ? 1 : 0;
                    for ($i = 0; $i < 5; $i++) {
                        if ($i < $full_stars) {
                            echo '★';
                        } elseif ($i == $full_stars && $half_star) {
                            echo '½';
                        } else {
                            echo '☆';
                        }
                    }
                    echo '</div>';
                    echo '<div class="rating-count">('.$row['rating'].')</div>';
                    echo '</div>';
                    
                    echo '<div class="food-category">'.$row['category'].'</div>';
                    
                    echo '<form method="POST" action="" class="food-form" data-itemid="'.$row['food_item_id'].'">';
                    echo '<input type="hidden" name="item_id" value="'.$row['food_item_id'].'">';
                    echo '<div class="quantity-control">';
                    echo '<button type="button" class="quantity-btn minus" onclick="this.nextElementSibling.stepDown()">-</button>';
                    echo '<input type="number" name="quantity" class="quantity-input" min="1" max="10" value="1">';
                    echo '<button type="button" class="quantity-btn plus" onclick="this.previousElementSibling.stepUp()">+</button>';
                    echo '</div>';
                    
                    echo '<div class="action-buttons">';
                    echo '<button type="submit" name="buy_now" class="btn btn-buy">';
                    echo '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>';
                    echo 'Buy Now';
                    echo '</button>';
                    echo '<button type="button" class="btn btn-book book-btn">';
                    echo '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>';
                    echo 'Book';
                    echo '</button>';
                    echo '</div>';
                    echo '</form>';
                    
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p>No food items available.</p>';
            }
            ?>
        </div>
    </div>

    <div id="bookingModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">Book Your Meal</div>
                <button class="close-btn">&times;</button>
            </div>
            <form id="bookingForm" method="POST">
                <input type="hidden" id="modal_item_id" name="item_id">
                <input type="hidden" id="modal_quantity" name="quantity">
                
                <div class="form-group">
                    <label for="booking_date">Booking Date</label>
                    <input type="date" id="booking_date" name="booking_date" required min="<?php echo date('Y-m-d'); ?>">
                </div>
                
                <div class="form-group">
                    <label for="booking_time">Booking Time</label>
                    <select id="booking_time" name="booking_time" required>
                        <option value="">Select a time</option>
                        <?php
                        $start = strtotime('10:00');
                        $end = strtotime('22:00');
                        for ($i = $start; $i <= $end; $i += 1800) {
                            echo '<option value="'.date('H:i', $i).'">'.date('g:i A', $i).'</option>';
                        }
                        ?>
                    </select>
                </div>
                
            
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-btn">Cancel</button>
                    <button type="submit" name="book_submit" class="btn btn-book">Confirm Booking</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const modal = document.getElementById('bookingModal');
        const bookBtns = document.querySelectorAll('.book-btn');
        const closeBtns = document.querySelectorAll('.close-btn');
        const bookingForm = document.getElementById('bookingForm');
        
        bookBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const form = this.closest('.food-form');
                const itemId = form.getAttribute('data-itemid');
                const quantity = form.querySelector('input[name="quantity"]').value;
                
                document.getElementById('modal_item_id').value = itemId;
                document.getElementById('modal_quantity').value = quantity;
                
                modal.style.display = 'block';
            });
        });
        
        closeBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                modal.style.display = 'none';
            });
        });
        
        window.addEventListener('click', function(event) {
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        });
        
        document.getElementById('booking_date').addEventListener('change', function() {
            const today = new Date().toISOString().split('T')[0];
            const timeSelect = document.getElementById('booking_time');
            
            if (this.value === today) {
                const now = new Date();
                const currentHour = now.getHours();
                const currentMinutes = now.getMinutes();
                
                Array.from(timeSelect.options).forEach(option => {
                    if (option.value) {
                        const [hours, minutes] = option.value.split(':').map(Number);
                        option.disabled = (hours < currentHour || 
                                         (hours === currentHour && minutes < currentMinutes));
                    }
                });
            } else {
                
                Array.from(timeSelect.options).forEach(option => {
                    option.disabled = false;
                });
            }
        });
    </script>
</body>
</html>