<?php
session_start();
require 'conf/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = $_POST['full_name'];
    $email_id = $_POST['email_id'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $phone_number = $_POST['phone_number'];
    $current_address = $_POST['current_address'];

    // Check if the email is already taken
    $stmt = $conn->prepare("SELECT * FROM admin WHERE email_id = :email_id");
    $stmt->bindParam(':email_id', $email_id);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $_SESSION['error'] = "Email is already taken.";
        header("Location: register.php");
        exit();
    } else {
        // Insert new user into the database
        $stmt = $conn->prepare("INSERT INTO admin (full_name, email_id, password, phone_number, current_address) 
                                VALUES (:full_name, :email_id, :password, :phone_number, :current_address)");
        $stmt->bindParam(':full_name', $full_name);
        $stmt->bindParam(':email_id', $email_id);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':phone_number', $phone_number);
        $stmt->bindParam(':current_address', $current_address);
        $stmt->execute();

        $_SESSION['status'] = "Registration successful!";
        header("Location: login.php");
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <style>
        body {

            font-family: Arial, sans-serif;
            display: flex;
            height: 100vh;
            margin-top: 5%;
            margin-bottom: 5%;
            margin-left: 50%;
            
            background-image: url('images/back.jpg');
            background-size: contain;
            background-repeat: no-repeat;
            background-attachment: fixed;
        
        }
        .register-container {
            background-color: white;
            margin-top: -5%;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 20px 20px 60px rgb(28, 171, 214)
            ,inset -20px -20px 60px white;
            max-width: 300px;
            width: 100%;
            height: 100%;
        
        }
        .register-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .register-container label {
            display: block;
            margin: 10px 0 5px;
        }
        .register-container input {
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
            width: 84%;
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
            background-color: rgb(28, 171, 214);
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
            background-color: rgb(5, 85, 109);
        }
        .b2:hover {
            background-color: #11314b;
        }
        .b3:hover {
            background-color: #631e12;
        }

        /* Media Query for Mobile Devices */
        @media (max-width: 768px) {

            body {

                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 80vh;
                margin-top: 20%;
                margin-bottom: 0%;
                margin-left: 0%;
            }

            .register-container {
                background-color: white;
                margin-top: -5%;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 20px 20px 60px black
                ,inset -20px -20px 60px white;
                max-width: 300px;
                width: 100%;
            }
            .register-container h2 {
                text-align: center;
                margin-bottom: 20px;
            }
            .register-container label {
                display: block;
                margin: 10px 0 5px;
            }
            .register-container input {
                width: 94%;
                padding: 3%;
                margin-bottom: 10px;
                border: 1px solid #ccc;
                border-radius: 4px;
            }
            .b1 {
            width: 100%;
            padding: 10px;
            background-color: rgb(28, 171, 214);
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
            background-color: rgb(5, 85, 109);
        }
        .b2:hover {
            background-color: #11314b;
        }
        .b3:hover {
            background-color: #631e12;
        }
        }

        /* Add your CSS styles here */
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

        function allowLettersOnly(input) {
            var regex = /[^A-Za-z\s]/g;
            input.value = input.value.replace(regex, '');
        }


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


        function validateNumericInput(input) {
            // Remove non-numeric characters using a regular expression
            var numericValue = input.value.replace(/[^0-9]/g, '');
            
            if (numericValue.length <= 10) {
            // Update the input value with the cleaned numeric value
            input.value = numericValue;
            } else {
                input.value = numericValue.slice(0, 10);
            }
        }
        

        function checkPhoneLength(input) {
            const maxLength = 10;
            const errorMessage = document.getElementById('phone-error');
            if (input.value.length !== maxLength) {
                errorMessage.textContent = 'Phone number must be exactly 10 digits.';
                input.classList.add('error');
                input.setCustomValidity('Phone number must be exactly 10 digits.');
            } else {
                errorMessage.textContent = '';
                input.classList.remove('error');
                input.setCustomValidity('');
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

        function showPopup(message) {
            alert(message); // For simplicity, using alert. You can replace it with a more stylish popup.
        }

        document.querySelector('form').addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent the default form submission

            const form = event.target;
            const formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    showPopup(data.error); // Show popup with the error message
                } else {
                    // Handle success case
                    window.location.href = data.redirect; // Redirect to the desired page after successful registration
                }
            })
            .catch(error => console.error('Error:', error));
        });
        

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
<body>
    <div class="register-container">
        <h2>Register</h2>
        <form action="register.php" method="post">
            
            <label for="name">Full Name</label>
            <input type="text" id="full_name" name="full_name" oninput="allowLettersOnly(this)" required>
            <div id="name-error" class="error-message"></div>

            <label for="email">Email ID</label>
            <input type="email" id="email_id" name="email_id" oninput="validateGmail(this)" required>
            <div id="email-error" class="email-error"></div>

            <div class="password-container">
                <label for="password">Create Password</label>
                <input type="password" id="password" name="password" oninput="validatePassword(event)" required>
                <span class="toggle-password" id="toggle-password" onclick="togglePasswordVisibility()">👁️</span>
                <div id="length-error" class="password-error"></div>
                <div id="letter-error" class="password-error"></div>
                <div id="number-error" class="password-error"></div>
                <div id="special-char-error" class="password-error"></div>
            </div>

            <label for="password_confirmation">Confirm Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" oninput="validateConfirmPassword(this)" required>
            <div id="confirm-password-error" class="confirm-error"></div>

            <label for="phone">Phone Number</label>
            <input type="tel" id="phone_number" name="phone_number" maxlength="10" oninput="validateNumericInput(this)" required>
            <div id="phone-error" class="error-message"></div>

            <label for="address">Current Address</label>
            <input type="text" id="current_address" name="current_address" required>

            <button class="b1" type="submit" style="margin-top: 3%; margin-bottom: 10%;">Register</button>
            
            <a class="b2" href="login.php">Login</a>
            <a class="b3" href="about.php">About</a>
        </form>
    </div>
</body>
</html>