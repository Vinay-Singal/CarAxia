<?php
// otp_verification.php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_otp = isset($_POST["otp"]) ? $_POST["otp"] : '';
    $stored_otp = isset($_SESSION['forgotpassword_data']['otp']) ? $_SESSION['forgotpassword_data']['otp'] : '';

    if ($user_otp == $stored_otp) {
        // Correct OTP, allow the user to reset the password
        header("Location: reset_password.php");
        exit();
    } else {
        // Invalid OTP, show an error message
        echo "<script>
            alert('Invalid OTP. Please try again.');
            window.location.href = 'fotp_verification.php';
        </script>";
        exit();
    }
} else {
    // Display the OTP verification form
    $mail = isset($_SESSION['forgotpassword_data']['EmailId']) ? $_SESSION['forgotpassword_data']['EmailId'] : '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 16px;
            box-sizing: border-box;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px 50px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        .error {
            color: #ff0000;
            margin-bottom: 16px;
        }
    </style>
</head>
<body>
    <form action="" method="post">
        <h2>OTP Verification</h2>
        <p>Enter the OTP sent to <?php echo $mail; ?></p>
        <label for="otp">OTP:</label>
        <input type="text" name="otp" required><br>

        <button type="submit">Verify OTP</button><br>
        <a href="login.php">Back to Login</a>
    </form>
</body>
</html>
