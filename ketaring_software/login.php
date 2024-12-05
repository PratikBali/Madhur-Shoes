<?php
session_start();
require 'conf/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email_id = $_POST['email_id'];
    $password = $_POST['password'];

    // If not an admin, check if the user is a regular user
    $stmt = $conn->prepare("SELECT * FROM users WHERE email_id = :email_id");
    $stmt->bindParam(':email_id', $email_id);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user['email_id'];
        $_SESSION['status'] = "User login successful!";
        header("Location: home.php"); // Redirect to user home page
        exit();
    }

    // Check if the user is an admin
    $stmt = $conn->prepare("SELECT * FROM admin WHERE email_id = :email_id");
    $stmt->bindParam(':email_id', $email_id);
    $stmt->execute();
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin'] = $admin['email_id'];
        $_SESSION['status'] = "Admin login successful!";
        header("Location: admin-dashboard/pages/dashboard.php"); // Redirect to admin home page
        exit();
    }

    // If neither admin nor user
    $_SESSION['errors'] = "Invalid email or password.";
    header("Location: login.php");
    exit();
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: left;
            align-items: left;
            height: 48vh;
            margin-left: 5%;
            margin-top: 20%;
            margin-bottom: 5%;
            background-image: url('images/login1.jpg');
            background-size: contain;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        .login-container {
            background-color: white;
            margin-top: -5%;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 20px 20px 60px black, inset -20px -20px 60px white;
            max-width: 250px;
            width: 100%;
            animation: slideIn 1s ease-out forwards;
            position: relative;
            right: -100%;
            bottom: -100%;
        }

        @keyframes slideIn {
            0% {
                right: -100%;
                bottom: -100%;
            }
            100% {
                right: 0;
                bottom: 0;
            }
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .login-container label {
            display: block;
            margin: 10px 0 5px;
        }

        .login-container input {
            width: 94%;
            padding: 3%;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .password-container {
            position: relative;
        }

        .password-container input {
            width: 80%;
            padding-right: 40px;
        }

        .password-container .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 18px;
        }

        .b1 {
            width: 100%;
            padding: 10px;
            background-color: #3abda0;
            border: none;
            color: black;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .b2 {
            width: 100%;
            padding: 10px;
            background-color: #cab08a;
            border: none;
            color: black;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px; 
        }

        .b3 {
            width: 100%;
            padding: 10px;
            background-color: #cab08a;
            border: none;
            color: black;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .b1:hover {
            background-color: #0f755f;
        }

        .b2:hover {
            background-color: #d39c4e;
        }

        .b3:hover {
            background-color: #d39c4e;
        }

        /* Media Query for Mobile Devices */
        @media (max-width: 768px) {
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
            }

            .login-container {
                background-color: white;
                margin-top: -5%;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 20px 20px 60px black, inset -20px -20px 60px white;
                max-width: 300px;
                width: 100%;
            }

            .login-container h2 {
                text-align: center;
                margin-bottom: 20px;
            }

            .login-container label {
                display: block;
                margin: 10px 0 5px;
            }

            .login-container input {
                width: 94%;
                padding: 3%;
                margin-bottom: 10px;
                border: 1px solid #ccc;
                border-radius: 4px;
            }

            .b1 {
                width: 100%;
                padding: 10px;
                background-color: #28a745;
                border: none;
                color: white;
                border-radius: 4px;
                cursor: pointer;
                font-size: 16px;
            }

            .b2 {
                width: 100%;
                padding: 10px;
                background-color: #215a88;
                border: none;
                color: white;
                border-radius: 4px;
                cursor: pointer;
                font-size: 16px;
                margin-left: 10%;
            }

            .b3 {
                width: 100%;
                padding: 10px;
                background-color: #d3371b;
                border: none;
                color: white;
                border-radius: 4px;
                cursor: pointer;
                font-size: 16px;
            }

            .b1:hover {
                background-color: #218838;
            }

            .b2:hover {
                background-color: #11314b;
            }

            .b3:hover {
                background-color: #631e12;
            }
        }

        .alert {
            padding: 15px;
            margin: 10px 0;
            border-radius: 4px;
            color: white;
        }
        .alert-success {
            background-color: #4caf50;
        }
        .alert-error {
            background-color: #f44336;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #0f755f;
            color: white;
            margin: 0% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 40%;
            height: 5%;
        }

        .close {
            color: white;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        .email-error {
            color: red;
            font-size: 12px;
        }
    </style>

    <script>
        function validateGmail(input) {
            const value = input.value;
            const emailError = document.getElementById('email-error');
            
            // Regular expression for basic email validation
            const emailPattern = /^[a-zA-Z0-9._%+-]+@gmail\.com$/;

            if (!emailPattern.test(value)) {
                emailError.textContent = 'Please enter a valid Gmail address.';
                input.classList.add('error');
            } else {
                emailError.textContent = '';
                input.classList.remove('error');
            }
        }

        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggle-password');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.textContent = '🙈';
            } else {
                passwordInput.type = 'password';
                toggleIcon.textContent = '👁️';
            }
        }
    </script>
</head>
<body class="neonCursor">
   
    <div class="login-container">
        <h2 style="margin-top: -2%;">Login</h2>

        <?php if (isset($_SESSION['errors'])): ?>
            <div class="alert alert-error"><?= $_SESSION['errors'] ?></div>
            <?php unset($_SESSION['errors']); ?>
        <?php endif; ?>
        
        <form action="login.php" method="post">
            <label for="email">Email ID</label>
            <input type="email" id="email_id" name="email_id" oninput="validateGmail(this)" required>
            <div id="email-error" class="email-error"></div>

            <label for="password">Password</label>
            <div class="password-container">
                <input type="password" id="password" name="password" required>
                <span class="toggle-password" id="toggle-password" onclick="togglePasswordVisibility()">👁️</span>
            </div>

            <button class="b1" type="submit" style="margin-top: 3%; margin-bottom: 10%;"><b>LOGIN</b></button>
            <a class="b2" href="register.php"><b>Register</b></a>
            <a class="b3" href="email.php"><b>Reset Password</b></a>
        </form>
    </div>

    <!-- Modal -->
    <div id="statusModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p id="statusMessage"></p>
        </div>
    </div>

    <?php if (isset($_SESSION['status'])): ?>
        <script>
            // Get the modal and the message element
            var modal = document.getElementById("statusModal");
            var statusMessage = document.getElementById("statusMessage");
            var span = document.getElementsByClassName("close")[0];

            // Show modal with the session status message
                statusMessage.textContent = '<?= $_SESSION['status'] ?>';
                modal.style.display = "block";
                <?php unset($_SESSION['status']); ?>

            // Close the modal when the user clicks on <span> (x)
            span.onclick = function() {
                modal.style.display = "none";
            }

            // Close the modal when the user clicks anywhere outside of the modal
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        </script>
    <?php endif; ?>

</body>
</html>