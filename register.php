<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - খাবার দাবার</title>
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
        .register-container {
            max-width: 500px;
            margin: 50px auto;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .register-header {
            background-color: #289A6A;
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 24px;
        }
        .register-body {
            padding: 30px;
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
        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box;
        }
        .btn {
            background-color: #289A6A;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            width: 100%;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #1f7d56;
        }
        .error-message {
            color: #ff4444;
            margin-bottom: 20px;
            padding: 10px;
            background-color: #ffeeee;
            border-radius: 4px;
            text-align: center;
            display: none;
        }
        .footer {
            text-align: center;
            padding: 20px;
            color: #777;
            font-size: 14px;
            background-color: #f1f1f1;
            margin-top: 40px;
        }
        .login-link {
            text-align: center;
            margin-top: 20px;
            color: #555;
        }
        .login-link a {
            color: #289A6A;
            text-decoration: none;
            font-weight: 500;
        }
        .login-link a:hover {
            text-decoration: underline;
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

    <div class="register-container">
        <div class="register-header">Create New Account</div>
        <div class="register-body">
            <div class="error-message" id="errorMessage">
                <!-- Error messages will be displayed here -->
            </div>
            
            <form action="register_process.php" method="POST">
                <div class="form-group">
                    <label for="FullName">Full Name</label>
                    <input type="text" id="FullName" name="FullName" required>
                </div>
                
                <div class="form-group">
                    <label for="Username">Username</label>
                    <input type="text" id="Username" name="Username" required>
                </div>
                
                <div class="form-group">
                    <label for="Password">Password</label>
                    <input type="password" id="Password" name="Password" required>
                </div>
                
                <div class="form-group">
                    <label for="Mobile">Mobile Number</label>
                    <input type="text" id="Mobile" name="Mobile" required>
                </div>
                
                <div class="form-group">
                    <label for="Email">Email (Optional)</label>
                    <input type="email" id="Email" name="Email">
                </div>
                
                <button type="submit" class="btn">Register</button>
            </form>
            
            <div class="login-link">
                Already have an account? <a href="login_page.php">Login here</a>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>&copy; 2025 খাবার দাবার Cafeteria System. All Rights Reserved.</p>
    </div>

    <script>
        // Display error message if present in URL
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const error = urlParams.get('error');
            const errorMessage = document.getElementById('errorMessage');
            
            if (error) {
                let message = '';
                switch(error) {
                    case 'username_taken':
                        message = 'Username already taken. Please choose another.';
                        break;
                    case 'mobile_exists':
                        message = 'Mobile number already registered.';
                        break;
                    case 'password_weak':
                        message = 'Password must be at least 6 characters.';
                        break;
                    case 'missing_fields':
                        message = 'Please fill in all required fields.';
                        break;
                    default:
                        message = 'Registration failed. Please try again.';
                }
                
                errorMessage.textContent = message;
                errorMessage.style.display = 'block';
            }
        });
    </script>
</body>
</html>