<?php
session_start();
require 'conf/db.php';

$email = '';

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    
    // Fetch the email associated with the reset token
    $stmt = $conn->prepare("SELECT email_id FROM admin WHERE reset_token = :token");
    $stmt->bindParam(':token', $token);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $email_id = $row['email_id'];
    } else {
        $_SESSION['error'] = "Invalid token.";
        header("Location: email.php");
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $token = $_GET['token'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $stmt = $conn->prepare("UPDATE admin SET password = :password, reset_token = NULL WHERE reset_token = :token");
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':token', $token);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $_SESSION['status'] = "Password reset successful!";
        header("Location: login.php");
        exit();
    } else {
        $_SESSION['error'] = "Invalid token.";
        header("Location: reset.php?token=$token");
        exit();
    }
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
            height: 48vh;
            margin-right: 10%;
            margin-top: 28%; 
            background-image: url('reset_material/images/12.jpg');
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
            background-color: #f05a46;
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
            margin-left: 20%;
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
            background-color: #e68579;
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
            color: red;
            font-size: 15px; 
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
        .error {
            border: 2px solid red;
        }
        .error-message {
            color: red;
            font-size: 12px;
        }
        .email-error {
            color: red;
            font-size: 12px;
        }
        .confirm-error {
            color: red;
            font-size: 12px;
        }
        /* Add styles for individual password errors */
        .password-error {
            color: red;
            font-size: 12px;
        }
        .success {
            border: 2px solid green;
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

        function validatePassword(event) {
            const input = event.target;
            const password = input.value;
            const minLength = 8;
            const hasLetter = /[A-Z]/.test(password);
            const hasNumber = /[0-9]/.test(password);
            const hasSpecialChar = /[@$!%*?&]/.test(password);

            const lengthError = document.getElementById('length-error');
            const letterError = document.getElementById('letter-error');
            const numberError = document.getElementById('number-error');
            const specialCharError = document.getElementById('special-char-error');

            if (password.length < minLength) {
                lengthError.textContent = 'at least 8 characters long.';
                input.classList.add('error');
            } else {
                lengthError.textContent = '';
            }

            if (!hasLetter) {
                letterError.textContent = 'at least one Capital letters.';
                input.classList.add('error');
            } else {
                letterError.textContent = '';
            }

            if (!hasNumber) {
                numberError.textContent = 'at least one number.';
                input.classList.add('error');
            } else {
                numberError.textContent = '';
            }

            if (!hasSpecialChar) {
                specialCharError.textContent = 'at least one special character(@$!%*?&).';
                input.classList.add('error');
            } else {
                specialCharError.textContent = '';
            }

            if (password.length >= minLength && hasLetter && hasNumber && hasSpecialChar) {
                input.classList.remove('error');
                input.classList.add('success');
            } else {
                input.classList.remove('success');
            }

            // Validate confirm password when create password is being validated
            const confirmPassword = document.getElementById('password_confirmation');
            validateConfirmPassword(confirmPassword);
        }

        function validateConfirmPassword(input) {
            const password = document.getElementById('password').value;
            const errorMessage = document.getElementById('confirm-password-error');

            if (input.value !== password) {
                input.classList.add('error');
                errorMessage.textContent = 'Passwords do not match.';
                input.setCustomValidity('Passwords do not match.');
            } else {
                input.classList.remove('error');
                errorMessage.textContent = '';
                input.setCustomValidity('');
            }
        }
    </script>
</head>
<body class="neonCursor">
   
    <div class="login-container">
        <h2 style="margin-top: -2%;">Reset Password</h2>
        
        <form method="POST"> 

            <div class="row mb-3">
                <label for="email" class="col-md-4 col-form-label text-md-end">Email ID</label>

                <div class="col-md-6">
                    <input id="email_id" type="email" class="form-control" name="email_id" value="<?= htmlspecialchars($email_id ?? ''); ?>" readonly autocomplete="email" autofocus>
                </div>
            </div>

            <div class="row mb-3">
                <label for="password" class="col-md-4 col-form-label text-md-end">Password</label>

                <div class="password-container">
                    <span class="toggle-password" id="toggle-password" onclick="togglePasswordVisibility()">👁️</span>
                    <input id="password" type="password" name="password" oninput="validatePassword(event)" required>
                    
                    <div id="length-error" class="password-error"></div>
                    <div id="letter-error" class="password-error"></div>
                    <div id="number-error" class="password-error"></div>
                    <div id="special-char-error" class="password-error"></div>
                    
                </div>
            </div>

            <div class="row mb-3">
                <label for="password-confirm" class="col-md-4 col-form-label text-md-end">Confirm Password</label>

                <div class="col-md-6">
                    <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" oninput="validateConfirmPassword(this)" required autocomplete="new-password">
                    <div id="confirm-password-error" class="confirm-error"></div>
                </div>
            </div>

            <button type="submit" class="b1">
                <B>Reset Password</B>
            </button>
        </form>
        
    </div>

    <!-- Modal -->
    <div id="statusModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p id="statusMessage"></p>
        </div>
    </div>

    <?php if (isset($_SESSION['status1'])): ?>
        <script>
            // Get the modal and the message element
            var modal = document.getElementById("statusModal");
            var statusMessage = document.getElementById("statusMessage");
            var span = document.getElementsByClassName("close")[0];

            // Show modal with the session status message
                statusMessage.textContent = '<?= $_SESSION['status1'] ?>';
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
