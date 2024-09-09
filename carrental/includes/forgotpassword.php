<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require ("PHPMailer/PHPMailer.php");
require ("PHPMailer/SMTP.php");
require ("PHPMailer/Exception.php");

// Function to generate random OTP
function generateOTP()
{
    return rand(1000, 9999);
}

if (isset($_POST['update'])) {
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $newpassword = md5($_POST['newpassword']);

    // Check if email and mobile exist in the database
    $sql = "SELECT EmailId FROM tblusers WHERE EmailId=:email AND ContactNo=:mobile";
    $query = $dbh->prepare($sql);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':mobile', $mobile, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);

    if ($query->rowCount() > 0) {
        // Generate OTP
        $otp = generateOTP();

        // Send OTP via email
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPAuth = true;
        $mail->Username = 'a85113062@gmail.com'; // Replace with your Gmail email
        $mail->Password = 'qiroxhqgwfrzdqbi'; // Replace with your Gmail password
        $mail->setFrom('a85113062@gmail.com', 'AJAY'); // Replace with your name and email
        $mail->addAddress($email); // Recipient email
        $mail->Subject = 'Password Reset OTP';
        $mail->Body = "Your OTP for password reset is: $otp";

        if ($mail->send()) {
            // Save OTP and other details to the session for verification
            session_start();
            $_SESSION['password_reset_data'] = [
                'email' => $email,
                'mobile' => $mobile,
                'newpassword' => $newpassword,
                'otp' => $otp,
            ];

            // Redirect to OTP verification page
            header("Location: otp_verification.php");
            exit();
        } else {
            echo "<script>alert('Error sending email: {$mail->ErrorInfo}');</script>";
        }
    } else {
        echo "<script>alert('Email id or Mobile no is invalid');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Recovery</title>
    <!-- Add your CSS styles here -->
</head>

<body>
    <div class="modal fade" id="forgotpassword">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h3 class="modal-title">Password Recovery</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="forgotpassword_wrap">
                            <div class="col-md-12">
                                <form name="chngpwd" method="post" action="otp_verification.php"
                                    onSubmit="return valid();">
                                    <div class="form-group">
                                        <input type="email" name="email" class="form-control"
                                            placeholder="Your Email address*" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="mobile" class="form-control"
                                            placeholder="Your Reg. Mobile*" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="newpassword" class="form-control"
                                            placeholder="New Password*" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="confirmpassword" class="form-control"
                                            placeholder="Confirm Password*" required>
                                    </div>
                                    <input type="hidden" name="redirect_url" value="otp_verification.php">
                                    <div class="form-group">
                                        <input type="submit" value="Reset My Password" name="update"
                                            class="btn btn-block">
                                    </div>
                                </form>

                                <div class="text-center">
                                    <p class="gray_text">For security reasons we don't store your password. Your
                                        password will be reset and a new one will be send.</p>
                                    <p><a href="#loginform" data-toggle="modal" data-dismiss="modal"><i
                                                class="fa fa-angle-double-left" aria-hidden="true"></i> Back to
                                            Login</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>