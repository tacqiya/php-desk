<?php
session_start();
$servername   = "localhost";
$database = "otp_db";
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_POST['otp']) {
    $otp = $_POST['otp'];
    $email = $_SESSION['email'];
    $sql = "SELECT * FROM email_id_check where otp=$otp AND email='$email'";
    $check = mysqli_query($conn, $sql);
    // echo "<pre>"; print_r($check);exit;
    if (mysqli_num_rows($check) > 0) {
        echo json_encode(['error' => true, 'msg' => 'Success', 'url' => 'profile.php']);
    } else {
        echo json_encode(['error' => true, 'msg' => 'Failed']);
    }
}
