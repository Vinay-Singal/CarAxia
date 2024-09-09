<?php
session_start(); // Start the session

// Check if form is submitted
if(isset($_POST['submit'])) {
    // Retrieve form data
    $fromDate = $_POST['fromdate'];
    $toDate = $_POST['todate'];
    $message = $_POST['message'];
    $paymod = $_POST['paymod'];

    // Process form based on payment mode
    if($paymod == 'cards') {
        // Process payment with credit/debit cards
        // Add your code here for credit/debit card payment
        echo "Payment processed successfully with credit/debit cards.";
    } elseif($paymod == 'upi') {
        // Process payment with UPI
        $upiId = $_POST['upiId'];
        // Add your code here for UPI payment
        echo "Payment processed successfully with UPI. UPI ID: $upiId";
    }
}
?>
