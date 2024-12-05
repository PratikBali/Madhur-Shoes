<?php
session_start();
require 'conf/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email_id = $_POST['email_id'];

    $stmt = $conn->prepare("SELECT * FROM admin WHERE email_id = :email_id");
    $stmt->bindParam(':email_id', $email_id);
    $stmt->execute();

    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin) {
        // Generate a unique reset token
        $token = bin2hex(random_bytes(16));
        $stmt = $conn->prepare("UPDATE admin SET reset_token = :token WHERE email_id = :email_id");
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':email_id', $email_id);
        $stmt->execute();

        // Send reset email
        $resetLink = "http://localhost/ketaring_software/reset.php?token=" . $token;
        mail($email_id, "Password Reset", "Click this link to reset your password: " . $resetLink);

        $_SESSION['status'] = "Password reset link has been sent to your email.";
    } else {
        $_SESSION['error'] = "Email not found.";
    }

    header("Location: email.php");
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
            justify-content: right;
            align-items: right;
            height: 30vh;
            margin-right: 15%;
            margin-top: 25%;
            margin-bottom: 5%;
            background-image: url('reset_material/images/white_back7.jpg');
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
                left: -100%;
                bottom: -100%;
            }
            100% {
                left: 0;
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
                margin-left: 28%;
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

    </script>
</head>
<body class="neonCursor">
   
    <div class="login-container">
        
        <form method="POST" action="email.php">

            <label for="email">Email ID</label>
            <input type="email" id="email_id" name="email_id" oninput="validateGmail(this)" required autocomplete="email" autofocus>
                
                <?php if (isset($errors['error'])): ?>
                    <span class="email-error" role="alert">
                        <strong><?= $errors['error'] ?></strong>
                    </span>
                <?php endif; ?>

            <div id="email-error" class="email-error"></div>

            <button class="b1" type="submit" style="margin-top: 3%; margin-bottom: 10%;"><b>Send Password Reset Link</b></button>
            <a class="b2" style="margin-left: 35%;" href="login.php"><b>Login</b></a>
            
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
