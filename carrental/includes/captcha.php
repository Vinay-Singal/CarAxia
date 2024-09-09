<?php
session_start();

// Set the content type
header('Content-type: image/jpeg');

// Create a blank image
$image = imagecreatetruecolor(100, 50);

// Allocate some colors
$white = imagecolorallocate($image, 255, 255, 255);
$black = imagecolorallocate($image, 0, 0, 0);

// Generate random captcha text
$captcha_text = $_SESSION['captcha_code'];

// Write the string at the top left
imagestring($image, 5, 20, 15, $captcha_text, $black);

// Output the image
imagejpeg($image);

// Free up memory
imagedestroy($image);
?>
