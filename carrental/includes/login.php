<?php
// Start the session if it's not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database connection setup (replace with your actual database connection code)
$host = 'localhost';
$dbname = 'carrental';
$username = 'root';
$password = '';

try {
    $dbh = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set PDO error mode to exception
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

// Check if login form is submitted
if(isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $sql = "SELECT EmailId,Password,FullName FROM tblusers WHERE EmailId=:email and Password=:password";
    $query = $dbh->prepare($sql);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    if($query->rowCount() > 0) {
        $_SESSION['login'] = $_POST['email'];
        $_SESSION['fname'] = $results[0]->FullName;
        $currentpage = $_SERVER['REQUEST_URI'];
        echo "<script type='text/javascript'> document.location = '$currentpage'; </script>";
        exit; // Exit after redirecting
    } else {
        echo "<script>alert('Invalid Details');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login Form with Captcha</title>
</head>
<body>

<div class="modal fade" id="loginform">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">Login</h3>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="login_wrap">
            <div class="col-md-12 col-sm-6">
              <form method="post" onsubmit="return validateForm()">
                <div class="form-group">
                  <input type="email" class="form-control" name="email" placeholder="Email address*" required>
                </div>
                <div class="form-group">
                  <input type="password" class="form-control" name="password" placeholder="Password*" required>
                </div>
                <div style="text-align: center; margin-top: 50px; text-decoration: line-through;" class="captcha-container">
                  <div id="captcha" style="font-size: 24px; font-weight: bold; margin-bottom: 10px;"></div>
                  <input type="text" id="captchaInput" placeholder="Enter Captcha" style="margin-bottom: 10px; padding: 5px;" oninput="validateCaptcha()">
                  <button style="padding: 8px 16px; background-color: white; color: white; border: none; cursor: pointer;" onclick="refreshCaptcha()">
                    <img src="assets\images\icons8-refresh.gif" alt="Refresh" style="width: 50px; height: 30px;">
                  </button>

                </div>
                <div class="form-group checkbox">
                  <input type="checkbox" id="remember">
                </div>
                <div class="form-group">
                  <input type="submit" name="login" value="Login" class="btn btn-block">
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer text-center">
        <p>Don't have an account? <a href="#signupform" data-toggle="modal" data-dismiss="modal">Signup Here</a></p>
        <p><a href="#forgotpassword" data-toggle="modal" data-dismiss="modal">Forgot Password ?</a></p>
      </div>
    </div>
  </div>
</div>

<script>
    // Generate random captcha string
    function generateCaptcha() {
      var chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
      var captcha = "";
      for (var i = 0; i < 6; i++) {
        captcha += chars.charAt(Math.floor(Math.random() * chars.length));
      }
      return captcha;
    }

    // Display random captcha
    function displayCaptcha() {
      var captchaText = generateCaptcha();
      document.getElementById('captcha').innerText = captchaText;
    }

    // Refresh captcha
    function refreshCaptcha() {
      displayCaptcha(); // Generate and display new captcha
      document.getElementById('captchaInput').value = ''; // Clear input field
      // Simulate click on the "Login" link to open the modal
      document.getElementById('loginTrigger').click()
    }

    // Validate captcha
    function validateCaptcha() {
      var userInput = document.getElementById('captchaInput').value;
      var captchaText = document.getElementById('captcha').innerText;
      
      if (userInput.toLowerCase() === captchaText.toLowerCase()) {
        return true; // Captcha matched
      } else {
        return false; // Captcha doesn't match
      }
    }

    // Validate form before submission
    function validateForm() {
      if (validateCaptcha()) {
        return true; // Form submission allowed
      } else {
        alert('Captcha does not match. Please try again.');
        refreshCaptcha(); // Refresh captcha
        return false; // Prevent form submission
      }
    }

    // Initial call to display captcha when the page loads
    window.onload = function() {
      displayCaptcha();
      document.getElementById('captchaInput').value = ''; // Clear input field
    };
</script>
</body>
</html>
